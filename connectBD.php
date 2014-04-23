<?php
// Connexion à la base de données
function connectBd(){
	$hote='ouebe.polytech.univ-montp2.fr';
	$user='polytech_energy0';
	$pwd='NRJ_ReadOnly';
	$bd='polytech_energy'; 
	$bdd = new PDO("mysql:host=".$hote.";dbname=".$bd, $user, $pwd);
	return $bdd;
}

// Récupération des informations sur la table $table suivant les conditions $condition
function recupData($bdd, $table, $condition="1"){
  	$data = $bdd->query("SELECT * FROM ".$table." WHERE ".$condition);
	return $data;
}   
function moyenneHeur($bdd,$table,$date,$capteur){
    $dateHeure=getdate(strtotime($date));
	$avant=date("d-m-Y H:i:s",strtotime($date."-1 hour"));
	$dateHeureAvant=getdate(strtotime($avant));

    $condition2="Annee=".$dateHeureAvant['year']." AND Mois=".$dateHeureAvant['mon']." AND Jour=".$dateHeureAvant['mday']." AND Heure=".$dateHeureAvant['hours']." order by minute DESC";
	$res2 = recupData($bdd,$table,$condition2);
	$donneeAvant;
	echo "<p>Consommation horaire le ".$date."</p>";
	echo '<table border="1"><tr><th> date </th> <th> releve </th></tr>';
	if($donnees = $res2->fetch()){
		echo "<tr><td>".$donnees['Jour']."-".$donnees['Mois']."-".$donnees['Annee']." ".$donnees['Heure'].":".$donnees['Minute'].":".$donnees['Seconde']."</td><td>".$donnees[$capteur]."</td></tr>";
		$donneeAvant=$donnees[$capteur];
	}else{
		echo "<tr> <td> NULL </td><td> 0 </td> <tr>";
	}
	$condition="Annee=".$dateHeure['year']." AND Mois=".$dateHeure['mon']." AND Jour=".$dateHeure['mday']." AND Heure=".$dateHeure['hours'];
	$res = recupData($bdd,$table,$condition);
	$dateAvant=strtotime($date);
	$dateMnt;
	$somme=0;
	
	while ($donnees = $res->fetch()){
			echo "<tr><td>".$donnees['Jour']."-".$donnees['Mois']."-".$donnees['Annee']." ".$donnees['Heure'].":".$donnees['Minute'].":".$donnees['Seconde']."</td><td>".$donnees[$capteur]."</td></tr>";
			$dateMnt=mktime($donnees["Heure"],$donnees["Minute"],$donnees["Seconde"],$donnees["Mois"],$donnees["Jour"],$donnees["Annee"]);
			$ecart = $dateMnt - $dateAvant;
			$somme+=$ecart * $donneeAvant;
			$dateAvant=$dateMnt;
			$donneeAvant=$donnees[$capteur];
		}
	$dateAvant=strtotime($date."+1 hour");
	if(isset($dateMnt)){
		$ecart=$dateAvant-$dateMnt;
		$somme+=$ecart*$donneeAvant;
	}
	
	echo "</table>";
	$moyenne=$somme/3600;
	echo "<p>Moyenne horaire : ".$moyenne." W</p>"; 
	return $moyenne;
}

function moyenneJour($bdd,$table,$date,$capteur){
	$somme=0;
	echo "<p>Consommation journaliere le ".$date."</p>";
	echo '<table border="1"><tr><th> Heure </th><th> Calcul </th></tr>';
	for($i=0;$i<24;$i++){
		$dateJour=date("d-m-Y H:i:s",strtotime($date."+".$i." hour"));
		echo "<td>".$dateJour."</td><td>";
		$somme+=moyenneHeur($bdd,$table,$dateJour,$capteur);
		echo "</td></tr>";
	}
	echo "</table>";
	$moyenneJour=$somme/24;
	echo "<p>Moyenne journaliere : ".$moyenneJour." W</p>"; 
	
	return $moyenneJour;
}

function moyenneSemaine($bdd,$table,$date,$capteur){
	$somme=0;
	echo "<p>Consommation hebdomadaire, semaine du ".$date."</p>";
	echo '<table border="1"><tr><th> Jour </th><th> Calcul </th></tr>';
	for($i=0;$i<7;$i++){
		$dateSemaine=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		echo "<td>".$dateSemaine."</td><td>";
		$somme+=moyenneJour($bdd,$table,$dateSemaine,$capteur);
		echo "</td></tr>";
	}
	echo "</table>";
	$moyenneSemaine=$somme/7;
	echo "<p>Moyenne hebdomadaire : ".$moyenneSemaine." W</p>";
	return $moyenneSemaine;
}

function moyenneMois($bdd,$table,$date,$capteur){
	$nbday = date('t',strtotime($date));
	echo "<p>Consommation mensuelle du ".$date."</p>";
	echo '<table border="1"><tr><th> Jour </th><th> Calcul </th></tr>';
	$somme=0;
	for($i=0;$i<$nbday;$i++){ 
		$dateMois=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		echo "<td>".$dateMois."</td><td>";
		$somme+=moyenneJour($bdd,$table,$dateMois,$capteur);
		echo "</td></tr>";
	}
	echo "</table>";
	$moyenneMois=$somme/$nbday;
	echo "<p>Moyenne mensuelle : ".$moyenneMois." W</p>";
	return $moyenneMois;
}

?>