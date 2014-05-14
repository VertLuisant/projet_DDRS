<?php
	include_once "utils/calculMoyenne.php";
	include_once "utils/fonctions.php";
	
	$dateDebut=$_POST["dateDebut"];	
	$dateFin=$_POST["dateFin"];
	$capteur=$_POST["capteur"];
	$moyenne=$_POST["moyenne"];

	if($moyenne=="Heure"){
		$resultatMoyenne=calculeParHeure($dateDebut,$dateFin,$capteur);
	}elseif($moyenne=="Jour"){
		$resultatMoyenne=calculeParJour($dateDebut,$dateFin,$capteur);
	}else if($moyenne=="Semaine"){
	    $numeroJour=date("N",strtotime($dateDebut));
		$dateDebut=date("d-m-Y",mktime(0,0,0,date('m',strtotime($dateDebut)),date('d',strtotime($dateDebut))-$numeroJour+1,date('Y',strtotime($dateDebut))));	
		$numeroJour=date("N",strtotime($dateFin));
		$dateFin=date("d-m-Y",mktime(0,0,0,date('m',strtotime($dateFin)),date('d',strtotime($dateFin))-$numeroJour+1,date('Y',strtotime($dateFin))));
         echo "<p>".$dateDebut."</p>";
		 echo "<p>".$dateFin."</p>";
		$resultatMoyenne=calculeParSemaine($dateDebut,$dateFin,$capteur);
	}else if($moyenne=="Mois"){
		$dateDebut=date("d-m-Y", mktime(0, 0, 0, date("m",strtotime($dateDebut)), 1,date("Y",strtotime($dateDebut))));
		$dateFin=date("d-m-Y", mktime(0, 0, 0, date("m",strtotime($dateFin)), 1,date("Y",strtotime($dateFin))));
		
		$resultatMoyenne=calculeParMois($dateDebut,$dateFin,$capteur);
	}

	//on construit le tableau des données que l'on va passé au javascript				
	$donneesGrapheLigne = array(
	   "donnees"=> array (
			"labels"=> $resultatMoyenne['listLabel'],
			"datasets" => array(
				array(
					"fillColor" => "rgba(0,156,221,0.5)",
					"strokeColor" => "rgba(0,156,221,1)",
					"pointColor" => "rgba(0,166,214,0.5)",
					"pointStrokeColor" => "#fff",
					"data" =>$resultatMoyenne['consommation']
				)
			 )	
			)
	);
	echo json_encode($donneesGrapheLigne);
	
	
	//Calcule les moyennes de consommation (par deux heures) pour la semaine actuelle et la semaine précédente (passées en paramètres)
	function calculeParHeure($dateDebut,$dateFin,$capteur){
		$dateActuelle=$dateDebut;
		$consommation=array();
		$listLabel=array();
		foreach ($capteur as $uncapteur)
		{
		    switch($uncapteur){
			 case "total":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extension_ouest",$dateActuelle))+round(moyenneHeure("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				break;
				
			case "batiment_est":
			case "serveur_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
			break;
			
			case "extention_ouest":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extention_ouest",$dateActuelle)));
					array_push($listLabel,date("d-m H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
			break;
			
			case "ouest_capteur1":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extention_ouest","Capteur1"$dateActuelle)));
					array_push($listLabel,date("d-m H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
			break;
			
			case "ouest_capteur2":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extention_ouest","Capteur2"$dateActuelle)));
					array_push($listLabel,date("d-m H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
			break;
			
			case "ouest_capteur3":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extention_ouest","Capteur3"$dateActuelle)));
					array_push($listLabel,date("d-m H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
			break;
			}
		}
		
	$resultatMoyenne=array(
				"listLabel"=>$listLabel,
				"consommation"=>$consommation
				);
	 return $resultatMoyenne;
}

	function calculeParJour($dateDebut,$dateFin,$capteur){
		$dateActuelle=$dateDebut;
		$consommation=array();
		$listLabel=array();
		foreach ($capteur as $uncapteur)
		{
		    switch($uncapteur){
			 case "total":
				 while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("extension_ouest",$dateActuelle))+round(moyenneJour("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y",strtotime($dateActuelle.'+1 day'));
					}
			break;
				
			case "batiment_est":
			break;
			case "serveur_est":
			break;
			case "extention_ouest":
			break;
			case "ouest_capteur1":
			break;
			case "ouest_capteur2":
			break;
			case "ouest_capteur3":
			break;
			}
		}
		
	$resultatMoyenne=array(
				"listLabel"=>$listLabel,
				"consommation"=>$consommation
				);
	 return $resultatMoyenne;
}

	function calculeParSemaine($dateDebut,$dateFin,$capteur){
		$dateActuelle=$dateDebut;
		$consommation=array();
		$listLabel=array();
		foreach ($capteur as $uncapteur)
		{
		    switch($uncapteur){
			case "total":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("extension_ouest",$dateActuelle))+round(moyenneSemaine("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y",strtotime($dateActuelle.'+1 week'));
					}
			break;
				
			case "batiment_est":
			break;
			case "serveur_est":
			break;
			case "extention_ouest":
			break;
			case "ouest_capteur1":
			break;
			case "ouest_capteur2":
			break;
			case "ouest_capteur3":
			break;
			}
		}
		
	$resultatMoyenne=array(
				"listLabel"=>$listLabel,
				"consommation"=>$consommation
				);
	 return $resultatMoyenne;
}
	function calculeParMois($dateDebut,$dateFin,$capteur){
		$dateActuelle=$dateDebut;
		$consommation=array();
		$listLabel=array();
		foreach ($capteur as $uncapteur)
		{
		    switch($uncapteur){
			 case "total":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("extension_ouest",$dateActuelle))+round(moyenneMois("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y",strtotime($dateActuelle.'+1 month'));
				}
			break;
			
			case "batiment_est":
			break;
			case "serveur_est":
			break;
			case "extention_ouest":
			break;
			case "ouest_capteur1":
			break;
			case "ouest_capteur2":
			break;
			case "ouest_capteur3":
			break;
			}
		}
		
	$resultatMoyenne=array(
				"listLabel"=>$listLabel,
				"consommation"=>$consommation
				);
	 return $resultatMoyenne;
}

?>
