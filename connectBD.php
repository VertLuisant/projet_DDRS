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
	$donnees = $res2->fetch();
	$donneeAvant=$donnees[$capteur];
	
	$condition="Annee=".$dateHeure['year']." AND Mois=".$dateHeure['mon']." AND Jour=".$dateHeure['mday']." AND Heure=".$dateHeure['hours'];
	$res = recupData($bdd,$table,$condition);
	$dateAvant=strtotime($date);
	$dateMnt;
	$somme=0;
	echo '<table border="1"><tr><th> date  </th> <th> releve </th></tr>';
	while ($donnees = $res->fetch()){
			echo "<tr><td>".$donnees['Jour']."/".$donnees['Mois']."/".$donnees['Annee']." ".$donnees['Heure'].":".$donnees['Minute'].":".$donnees['Seconde']."</td><td>".$donnees[$capteur]."</td></tr>";
			$dateMnt=mktime($donnees["Heure"],$donnees["Minute"],$donnees["Seconde"],$donnees["Mois"],$donnees["Jour"],$donnees["Annee"]);
			$ecart = $dateMnt - $dateAvant;
			$somme+=$ecart * $donneeAvant;
			$dateAvant=$dateMnt;
			$donneeAvant=$donnees[$capteur];
			
		}
	$dateAvant=strtotime($date."+1 hour");
	$ecart=$dateAvant-$dateMnt;
	$somme+=$ecart*$donneeAvant;
	
	echo "</table>";
	$moyenne=$somme/3600;
	echo "<p> Moyenne horaire : ".$moyenne." W</p>"; 
	return $moyenne;
}

function moyenneJour($bdd,$table,$date,$capteur){
	$somme=0;
	for($i=0;$i<24;$i++){
		$dateJour=date("d-m-Y H:i:s",strtotime($date."+".$i." hour"));
		$somme+=moyenneHeur($bdd,$table,$dateJour,$capteur);
	}
	$moyenneJour=$somme/24;
	echo "<p>".$moyenneJour."</p>"; 
}

function moyenneSemaine($bdd,$table,$date,$capteur){
	$somme=0;
	for($i=0;$i<7;$i++){
		echo "<p> Dans la semaine ".$i."</p>"; 
		$dateSemaine=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		$somme+=moyenneJour($bdd,$table,$dateSemaine,$capteur);
	}
	$moyenneSemaine=$somme/7;
	echo "<p>".$moyenneSemaine."</p>"; 
	return $moyenneSemaine;
}

function moyenneMois($bdd,$table,$date,$capteur){
	$nbday = date('t',strtotime($date));
	echo $nbday;
	$somme=0;
	for($i=0;$i<$nbday;$i++){ 
		$dateMois=date("d-m-Y H:i:s",strtotime($date."+".$i." days"));
		$somme+=moyenneJour($bdd,$table,$dateMois,$capteur);
	}
	$moyenneMois=$somme/$nbday;
	return $moyenneMois;
}

?>