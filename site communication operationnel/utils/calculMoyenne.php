<?php
//Permet la récupération et le calcul des données sur la consommation électrique

include_once "connectBD.php";

$debug = 0; //variable de debuggage global - 0 => pas de debuggage / 1 => debuggage

//Retourne la consommation électrique actuelle en W (dernier relevé sur les capteurs)
function consommationActuelle(){
	$condition = "1 ORDER BY `Annee` DESC , `Mois` DESC , `Jour` DESC, `Heure` DESC, `Minute` DESC LIMIT 0 , 1";
	$res1 = recupData("serveur_est", $condition)->fetch();
	$res2 = recupData("extension_ouest",$condition)->fetch();
	$consommation = 0;
	for($i = 1; $i < 7 ; $i++){
		$consommation += $res1["Capteur".$i]+$res2["Capteur".$i];
	}
	return $consommation;
}

//Retourne la moyenne horaire a la date $date du capteur $capteur de la table $table.
//S'il n'y a pas de capteur passé en paramètre, retourne la moyenne horaire des 6 capteurs de la table $table
function moyenneHeure($table,$date,$capteur=null){
	global $debug;
	
	//on récupère la consommation du dernier relevé de l'heure précédente
	$dateMoinsUneHeure=date("d-m-Y H:i:s",strtotime($date."-1 hour"));
	$dateMoinsUneHeureDecomposee=getdate(strtotime($dateMoinsUneHeure));
    $condition2="Annee=".$dateMoinsUneHeureDecomposee['year']." AND Mois=".$dateMoinsUneHeureDecomposee['mon']." AND Jour=".$dateMoinsUneHeureDecomposee['mday']." AND Heure=".$dateMoinsUneHeureDecomposee['hours']." order by minute DESC";
	$res2 = recupData($table,$condition2);
	$donneePrecedente=0;
	if($ligneResultat = $res2->fetch()){
		if(!empty($capteur)){
			$donneePrecedente=$ligneResultat[$capteur];
		}else{
			for($i=1;$i<=6;$i++){
				$donneePrecedente+=$ligneResultat["Capteur".$i];
			}
		}
	}else{
		//pas de valeur sur l'heure précédente, on considereras que c'est 0
	}
	
	//on récupère les relevés de l'heure demandée
	$dateDecomposee=getdate(strtotime($date));
	$condition="Annee=".$dateDecomposee['year']." AND Mois=".$dateDecomposee['mon']." AND Jour=".$dateDecomposee['mday']." AND Heure=".$dateDecomposee['hours'];
	$res = recupData($table,$condition);
	$dateAvant=strtotime($date);
	$dateActuelle;
	$somme=0;
	
	//pour chaque valeur, on calcule l'écart de temps entre les relevés afin d'en faire une moyenne plus précise
	while ($ligneResultat = $res->fetch()){
		$dateActuelle=mktime($ligneResultat["Heure"],$ligneResultat["Minute"],$ligneResultat["Seconde"],$ligneResultat["Mois"],$ligneResultat["Jour"],$ligneResultat["Annee"]);
		$ecart = $dateActuelle - $dateAvant;
		$somme+=$ecart * $donneePrecedente;
		$dateAvant=$dateActuelle;
		
		if(!empty($capteur)){
			$donneePrecedente=$ligneResultat[$capteur];
		}else{
			$donneePrecedente=0;
			for($i=1;$i<=6;$i++){
				$donneePrecedente+=$ligneResultat["Capteur".$i];
			}
		}
	}
	
	//on calcule le "dernier écart" qui se trouve entre le dernier relevé de l'heure demandé et la fin de l'heure demandé
	$dateFin=strtotime($date."+1 hour");
	if(isset($dateActuelle)){
		$ecart=$dateFin-$dateActuelle;
		$somme+=$ecart*$donneePrecedente;
	}
	$moyenneHoraire=$somme/3600;
	
	if($debug) echo "<p> Moyenne horaire -- Le : ".ecritureDate($date)." moyenne horaire : ".$moyenneHoraire." W</p>";
	return $moyenneHoraire;
}

//Retourne la moyenne sur deux heures a partir de la date $date du capteur $capteur de la table $table.
//S'il n'y a pas de capteur passé en paramètre, retourne la moyenne sur deux heures des 6 capteurs de la table $table
function moyenneParDeuxHeure($table,$date,$capteur=null){
	global $debug;
	
	//on calcule la moyenne de chaque heure, et on divise par 2
	$somme=0;
	for($i=0;$i<2;$i++){
		$dateJour=date("d-m-Y H:i:s",strtotime($date."-".$i." hour"));
		$somme+=moyenneHeure($table,$dateJour,$capteur);
	}
	$moyenneParDeuxHeure=$somme/2;
	
	if($debug) echo "<p> Moyenne sur deux heures -- Le : ".ecritureDate($date)." moyenne sur deux heures : ".$moyenneParDeuxHeure." W</p>";
	return $moyenneParDeuxHeure;
}

//Retourne la moyenne journalière a la date $date du capteur $capteur de la table $table.
//S'il n'y a pas de capteur passé en paramètre, retourne la moyenne journalière des 6 capteurs de la table $table
function moyenneJour($table,$date,$capteur=null){
	global $debug;
	
	
	//on calcule la moyenne de chaque heure, et on divise par 24
	$somme=0;
	for($i=0;$i<24;$i++){
		$dateJour=date("d-m-Y H:i:s",strtotime($date."+".$i." hour"));
		$somme+=moyenneHeure($table,$dateJour,$capteur);
	}
	$moyenneJour=$somme/24;
	
	if($debug) echo "<p> Moyenne journalière -- Le : ".ecritureDate($date)." moyenne journalière : ".$moyenneJour." W</p>";
	return $moyenneJour;
}

//Retourne la moyenne hebdomadaire a la date $date du capteur $capteur de la table $table.
//S'il n'y a pas de capteur passé en paramètre, retourne la moyenne hebdomadaire des 6 capteurs de la table $table
//Si la date passée en paramètre n'est pas un lundi, on calcule quand même à partir du lundi de la semaine
function moyenneSemaine($table,$date,$capteur=null){
	global $debug;
	
	//on passe au début de la semaine, si ce n'est pas le cas
	while(date("N", strtotime($date) > 1)){//tant qu'on est pas au lundi 
		$date=date("d-m-Y",strtotime($date."-1 day")); //on enlève un jour
	}
	
	//on calcule la moyenne de chaque jour, et on divise par 7
	$somme=0;
	for($i=0;$i<7;$i++){
		$dateSemaine=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		$somme+=moyenneJour($table,$dateSemaine,$capteur);
	}
	$moyenneSemaine=$somme/7;
	if($debug) echo "<p> Moyenne hebdomadaire -- Le : ".ecritureDate($date)." moyenne hebdomadaire : ".$moyenneSemaine." W</p>";
	return $moyenneSemaine;
}

//Retourne la moyenne mensuelle a la date $date du capteur $capteur de la table $table.
//S'il n'y a pas de capteur passé en paramètre, retourne la moyenne mensuelle des 6 capteurs de la table $table
//Si la date passée en paramètre n'est pas le 1er du mois, on calcule quand même à partir du 1er du mois
function moyenneMois($table,$date,$capteur=null){
	global $debug;
	
	//on commence au premier du mois
	$date = date("d-m-Y", mktime(0,0,0,date("m", strtotime($date)),1,date("Y", strtotime($date)))); 
	
	//on calcule la moyenne de chaque jour, et on divise par le nombre de jour du mois
	$somme=0;
	$nbday = date('t',strtotime($date));
	for($i=0;$i<$nbday;$i++){ 
		$dateMois=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		if($debug) echo "<tr><td>".$dateMois."</td><td>";
		$somme+=moyenneJour($table,$dateMois,$capteur);
		if($debug) echo "</td></tr>";
	}
	$moyenneMois=$somme/$nbday;
	if($debug) echo "<p> Moyenne mensuelle -- Le : ".ecritureDate($date)." moyenne mensuelle : ".$moyenneMois." W</p>";
	return $moyenneMois;
}
?>