<?php
include_once "utils/connectBD.php";
include_once "utils/calculMoyenne.php";



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="data.csv"');
header('Cache-Control: max-age=0');


$dateDebut=$_GET["dateDebut"];
$dateFin=$_GET["dateFin"];
$dateFin=date("d-m-Y H:i:s", mktime(23, 0, 0, date("m",strtotime($dateFin)), date("d",strtotime($dateFin)),date("Y",strtotime($dateFin))));
$capteurChoisi=explode(",",$_GET["capteurChoisi"]);


$fp = fopen('php://output', 'a');

$head = array('Temps');
foreach ($capteurChoisi as $uncapteur){
   array_push($head,$uncapteur);
}
fputcsv($fp, $head);

// count
$cnt = 0;
//afficher 100000 ligne sur buffer chaque fois
$limit = 100000;

$dateActuelle=$dateDebut;
while(strtotime($dateActuelle)<=strtotime($dateFin)){
	unset($row);
	$row=array();
	array_push($row,date("d-m-Y H\H",strtotime($dateActuelle)));
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
		fputcsv($fp, $row);
	}

?>