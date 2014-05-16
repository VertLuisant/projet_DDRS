<?php

include_once "utils/calculMoyenne.php";

header('Content-Type: application/vnd.ms-excel');
// data.csv :nom de file exporté
header('Content-Disposition: attachment;filename="data.csv"');
header('Cache-Control: max-age=0');

//recuperer les paramètres 
$dateDebut=$_GET["dateDebut"];
$dateFin=date("d-m-Y H:i:s", mktime(23, 0, 0, date("m",strtotime($_GET["dateFin"])), date("d",strtotime($_GET["dateFin"])),date("Y",strtotime($_GET["dateFin"]))));
$capteurChoisi=explode(",",$_GET["capteurChoisi"]);

//afficher les données sur navigateur
$fp = fopen('php://output', 'a');

//en-tête du fichier csv
$head = array('Temps');
foreach ($capteurChoisi as $uncapteur){
   array_push($head,$uncapteur);
}
fputcsv($fp, $head);

// count
$cnt = 0;
//on limite que chaque fois, il y a que 100000 lignes dans le buffer
$limit = 100000;

// on calcule les sommes de consommation selon les capteurs choisies et les écrit sur le fichier 
$dateActuelle=$dateDebut;
while(strtotime($dateActuelle)<=strtotime($dateFin)){
	
	// une ligne dans le ficher
	unset($row);
	$row=array();
	
	// le temps de la ligne de donnée
	array_push($row,date("d-m-Y H\H",strtotime($dateActuelle)));
	
	// Pour chaque capteur choisi, push la somme de consommation dans la ligne
	foreach ($capteurChoisi as $uncapteur)
		{
		    switch($uncapteur){
		    case "total":
					array_push($row,round(moyenneHeure("extension_ouest",$dateActuelle))+round(moyenneHeure("serveur_est",$dateActuelle)));
				break;
				
			case "batiment_est":
					array_push($row,round(moyenneHeure("serveur_est",$dateActuelle)));			
			break;
			
			case "serveur_est":
					array_push($row,round(moyenneHeure("serveur_est",$dateActuelle)));	
			break;
			
			case "extension_ouest":
					array_push($row,round(moyenneHeure("extension_ouest",$dateActuelle)));
			break;
			
			case "ouest_capteur1":
					array_push($row,round(moyenneHeure("extension_ouest",$dateActuelle,"Capteur1")));
			break;
			
			case "ouest_capteur2":
					array_push($row,round(moyenneHeure("extension_ouest",$dateActuelle,"Capteur2")));
			break;
			
			case "ouest_capteur3":
					array_push($row,round(moyenneHeure("extension_ouest",$dateActuelle,"Capteur3")));

			break;
		}
	}
	
	$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
	
	// count le ligne, si les lignes dans le buffer est 100000, on rafraîchit le buffer
	$cnt ++;
    if ($limit == $cnt) { 
        ob_flush();
        flush();
        $cnt = 0;
    }
	
	fputcsv($fp, $row);
}

?>