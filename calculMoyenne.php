<?php
//Permet le calcul moyenne par heure, jour, semaine ou mois
include_once "connectBD.php";

$debug = 0;

//Retourne la moyenne horaire a la date $date du $capteur
function moyenneHeure($bdd,$table,$date,$capteur){
	global $debug;
	$dateDecomposee=getdate(strtotime($date));
	$dateMoinsUneHeure=date("d-m-Y H:i:s",strtotime($date."-1 hour"));
	$dateMoinsUneHeureDecomposee=getdate(strtotime($dateMoinsUneHeure));

    $condition2="Annee=".$dateMoinsUneHeureDecomposee['year']." AND Mois=".$dateMoinsUneHeureDecomposee['mon']." AND Jour=".$dateMoinsUneHeureDecomposee['mday']." AND Heure=".$dateMoinsUneHeureDecomposee['hours']." order by minute DESC";
	$res2 = recupData($bdd,$table,$condition2);
	$donneeAvant=0;
	if($debug) echo '<p>Consommation horaire le '.$date.'</p><table border="1"><tr><th> date </th> <th> releve '.$capteur.'</th></tr>';
	if($ligneResultat = $res2->fetch()){
		if($debug) echo "<tr><td>".$ligneResultat['Jour']."-".$ligneResultat['Mois']."-".$ligneResultat['Annee']." ".$ligneResultat['Heure'].":".$ligneResultat['Minute'].":".$ligneResultat['Seconde']."</td><td>".$ligneResultat[$capteur]."</td></tr>";
		$donneeAvant=$ligneResultat[$capteur];
	}else{
		if($debug) echo "<tr><td> NULL </td><td> 0 </td><tr>";
	}
	$condition="Annee=".$dateDecomposee['year']." AND Mois=".$dateDecomposee['mon']." AND Jour=".$dateDecomposee['mday']." AND Heure=".$dateDecomposee['hours'];
	$res = recupData($bdd,$table,$condition);
	$dateAvant=strtotime($date);
	$dateActuelle;
	$somme=0;
	
	while ($ligneResultat = $res->fetch()){
			if($debug) echo "<tr><td>".$ligneResultat['Jour']."-".$ligneResultat['Mois']."-".$ligneResultat['Annee']." ".$ligneResultat['Heure'].":".$ligneResultat['Minute'].":".$ligneResultat['Seconde']."</td><td>".$ligneResultat[$capteur]."</td></tr>";
			$dateActuelle=mktime($ligneResultat["Heure"],$ligneResultat["Minute"],$ligneResultat["Seconde"],$ligneResultat["Mois"],$ligneResultat["Jour"],$ligneResultat["Annee"]);
			$ecart = $dateActuelle - $dateAvant;
			$somme+=$ecart * $donneeAvant;
			$dateAvant=$dateActuelle;
			$donneeAvant=$ligneResultat[$capteur];
		}
	$dateFin=strtotime($date."+1 hour");
	if(isset($dateActuelle)){
		$ecart=$dateFin-$dateActuelle;
		$somme+=$ecart*$donneeAvant;
	}
	$moyenne=$somme/3600;
	if($debug) echo "</table><p>Moyenne horaire : ".$moyenne." W</p>"; 
	return $moyenne;
}

//Retourne la moyenne journaliere a la date $date du $capteur
function moyenneJour($bdd,$table,$date,$capteur){
	global $debug;
	$somme=0;
	if($debug) echo '<p>Consommation journaliere le '.date("d-m-Y", strtotime($date)).'</p><table border="1"><tr><th> Heure </th><th> Calcul </th></tr>';
	for($i=0;$i<24;$i++){
		$dateJour=date("d-m-Y H:i:s",strtotime($date."+".$i." hour"));
		if($debug) echo "<tr><td>".$dateJour."</td><td>";
		$somme+=moyenneHeure($bdd,$table,$dateJour,$capteur);
		if($debug) echo "</td></tr>";
	}
	$moyenneJour=$somme/24;
	if($debug) echo "</table><p>Moyenne journaliere : ".$moyenneJour." W</p>"; 
	
	return $moyenneJour;
}

//Retourne la moyenne hebdomadaire a la semaine debutant au $date du $capteur
function moyenneSemaine($bdd,$table,$date,$capteur){
	global $debug;
	$somme=0;
	if($debug) echo '<p>Consommation hebdomadaire, semaine du '.date("d-m-Y", strtotime($date)).'</p><table border="1"><tr><th> Jour </th><th> Calcul </th></tr>';
	for($i=0;$i<7;$i++){
		$dateSemaine=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		if($debug) echo "<tr><td>".$dateSemaine."</td><td>";
		$somme+=moyenneJour($bdd,$table,$dateSemaine,$capteur);
		if($debug) echo "</td></tr>";
	}
	$moyenneSemaine=$somme/7;
	if($debug) echo "</table><p>Moyenne hebdomadaire : ".$moyenneSemaine." W</p>";
	return $moyenneSemaine;
}

//Retourne la moyenne mensuelle du mois $date du $capteur
function moyenneMois($bdd,$table,$date,$capteur){
	global $debug;
	$nbday = date('t',strtotime($date));
	if($debug) echo '<p>Consommation mensuelle du '.date("d-m-Y", strtotime($date)).'</p><table border="1"><tr><th> Jour </th><th> Calcul </th></tr>';
	$somme=0;
	for($i=0;$i<$nbday;$i++){ 
		$dateMois=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		if($debug) echo "<tr><td>".$dateMois."</td><td>";
		$somme+=moyenneJour($bdd,$table,$dateMois,$capteur);
		if($debug) echo "</td></tr>";
	}
	$moyenneMois=$somme/$nbday;
	if($debug) echo "</table><p>Moyenne mensuelle : ".$moyenneMois." W</p>";
	return $moyenneMois;
}
?>