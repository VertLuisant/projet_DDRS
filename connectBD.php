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
	while ($donnees = $res->fetch())
			{
			echo "<p>".$donnees["Annee"]." ".$donnees["Mois"]." ".$donnees['Jour']." ".$donnees['Heure']." ".$donnees[$capteur]."</p>";
			$dateMnt=mktime($donnees["Heure"],$donnees["Minute"],$donnees["Seconde"],$donnees["Mois"],$donnees["Jour"],$donnees["Annee"]);
			echo "<p>".$dateMnt."</p>";
			$ecart = $dateMnt - $dateAvant;
			$somme+=$ecart * $donneeAvant;
			echo "<p>".$ecart."</p>";
			$dateAvant=$dateMnt;
			$donneeAvant=$donnees[$capteur];
		}
	$dateAvant=strtotime($date."+1 hour");
	$ecart=$dateAvant-$dateMnt;
	$somme+=$ecart*$donneeAvant;
	echo "<p>".$somme."</p>";
	$moyenne=$somme /3600;
	echo "<p>".$moyenne."</p>"; 
	return $moyenne;
}
?>