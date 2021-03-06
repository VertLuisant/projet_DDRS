<?php
	include_once "utils/calculMoyenne.php";
	include_once "utils/fonctions.php";
	
	//
	$dateDebut=$_POST["dateDebut"];	
	$dateFin=$_POST["dateFin"];
	$capteur=$_POST["capteur"];
	$moyenne=$_POST["moyenne"];
	// col
	$color = array(
	   "colortotal"=>array(
					"fillColor" => "rgba(255, 0, 51, 0.5)",
					"strokeColor" => "rgba(255, 0, 51, 1)",
	   ),
	   "colorbatiment_est"=>array(
					"fillColor" => "rgba(255, 102, 0, 0.5);",
					"strokeColor" => "rgba(255, 102, 0, 1);"
	   ),
	   "colorserveur_est"=>array(
					"fillColor" => "rgba(255,255,0,0.5)",
					"strokeColor" => "rgba(255,255,0,1)"
	   ),
	   "colorextension_ouest"=>array(
					"fillColor" => "rgba(0,204,0,0.5)",
					"strokeColor" => "rgba(0,204,0,1)",
	   ),
	   "colorouest_capteur1"=>array(
					"fillColor" => "rgba(0,51,255,0.5)",
					"strokeColor" => "rgba(0,51,255,1)"
	   ),
	   "colorouest_capteur2"=>array(
					"fillColor" => "rgba(102,51,153,0.5)",
					"strokeColor" => "rgba(102,51,153,1)"
	   ),
	   "colorouest_capteur3"=>array(
					"fillColor" => "rgba(153,0,153,0.5)",
					"strokeColor" => "rgba(153,0,153,1)"
	   ),
	);
	
	

	if($moyenne=="Heure"){
		$dateFin=date("d-m-Y H:i:s", mktime(23, 0, 0, date("m",strtotime($dateFin)), date("d",strtotime($dateFin)),date("Y",strtotime($dateFin))));
		$donneesGrapheLigne=calculeParHeure($dateDebut,$dateFin,$capteur);
	}elseif($moyenne=="Jour"){
		$donneesGrapheLigne=calculeParJour($dateDebut,$dateFin,$capteur);
	}else if($moyenne=="Semaine"){
	    $numeroJour=date("N",strtotime($dateDebut));
		$dateDebut=date("d-m-Y",mktime(0,0,0,date('m',strtotime($dateDebut)),date('d',strtotime($dateDebut))-$numeroJour+1,date('Y',strtotime($dateDebut))));	
		$numeroJour=date("N",strtotime($dateFin));
		$dateFin=date("d-m-Y",mktime(0,0,0,date('m',strtotime($dateFin)),date('d',strtotime($dateFin))-$numeroJour+1,date('Y',strtotime($dateFin))));
		$donneesGrapheLigne=calculeParSemaine($dateDebut,$dateFin,$capteur);
	}else if($moyenne=="Mois"){
		$dateDebut=date("d-m-Y", mktime(0, 0, 0, date("m",strtotime($dateDebut)), 1,date("Y",strtotime($dateDebut))));
		$dateFin=date("d-m-Y", mktime(0, 0, 0, date("m",strtotime($dateFin)), 1,date("Y",strtotime($dateFin))));
		
		$donneesGrapheLigne=calculeParMois($dateDebut,$dateFin,$capteur);
	}
     
	//on construit le tableau des données que l'on va passé au javascript				
	
	echo json_encode($donneesGrapheLigne);
	
	
	//Calcule les moyennes de consommation (par deux heures) pour la semaine actuelle et la semaine précédente (passées en paramètres)
	function calculeParHeure($dateDebut,$dateFin,$capteur){
		global $color;
		$datasets=array();
		foreach ($capteur as $uncapteur)
		{
			$dateActuelle=$dateDebut;
			unset($consommation);
			$consommation=array();
			unset($listLabel);
			$listLabel=array();
		    switch($uncapteur){
			 case "total":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extension_ouest",$dateActuelle))+round(moyenneHeure("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m H\H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colortotal"]["fillColor"],
								"strokeColor" => $color["colortotal"]["strokeColor"],
								"data" =>$consommation
							));
				break;
				
			case "batiment_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m H\H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorbatiment_est"]["fillColor"],
								"strokeColor" => $color["colorbatiment_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "serveur_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m H\H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorserveur_est"]["fillColor"],
								"strokeColor" => $color["colorserveur_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "extension_ouest":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extension_ouest",$dateActuelle)));
					array_push($listLabel,date("d-m H\H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorextension_ouest"]["fillColor"],
								"strokeColor" => $color["colorextension_ouest"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur1":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extension_ouest",$dateActuelle,"Capteur1")));
					array_push($listLabel,date("d-m H\H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur1"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur1"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur2":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extension_ouest",$dateActuelle,"Capteur2")));
					array_push($listLabel,date("d-m H\H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur2"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur2"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur3":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneHeure("extension_ouest",$dateActuelle,"Capteur3")));
					array_push($listLabel,date("d-m H\H",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 hour'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur3"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur3"]["strokeColor"],
								"data" =>$consommation
							));
			break;
		}
	}
    $donneesGrapheLigne=array(
			"labels" => $listLabel,
			"datasets" =>$datasets
	);
	 return $donneesGrapheLigne;
}

	function calculeParJour($dateDebut,$dateFin,$capteur){
		global $color;
		$datasets=array();
		foreach ($capteur as $uncapteur)
		{
			$dateActuelle=$dateDebut;
			unset($consommation);
			$consommation=array();
			unset($listLabel);
			$listLabel=array();
		    switch($uncapteur){
			 case "total":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("extension_ouest",$dateActuelle))+round(moyenneJour("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 day'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colortotal"]["fillColor"],
								"strokeColor" => $color["colortotal"]["strokeColor"],
								"data" =>$consommation
							));
				break;
				
			case "batiment_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 day'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorbatiment_est"]["fillColor"],
								"strokeColor" => $color["colorbatiment_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "serveur_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 day'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorserveur_est"]["fillColor"],
								"strokeColor" => $color["colorserveur_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "extension_ouest":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("extension_ouest",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 day'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorextension_ouest"]["fillColor"],
								"strokeColor" => $color["colorextension_ouest"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur1":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("extension_ouest",$dateActuelle,"Capteur1")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 day'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur1"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur1"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur2":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("extension_ouest",$dateActuelle,"Capteur2")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 day'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur2"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur2"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur3":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneJour("extension_ouest",$dateActuelle,"Capteur3")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 day'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur3"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur3"]["strokeColor"],
								"data" =>$consommation
							));
			break;
		}
	}
    $donneesGrapheLigne=array(
			"labels" => $listLabel,
			"datasets" =>$datasets
	);
	 return $donneesGrapheLigne;
}

	function calculeParSemaine($dateDebut,$dateFin,$capteur){
		global $color;
		$datasets=array();
		foreach ($capteur as $uncapteur)
		{
			$dateActuelle=$dateDebut;
			unset($consommation);
			$consommation=array();
			unset($listLabel);
			$listLabel=array();
		    switch($uncapteur){
			 case "total":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("extension_ouest",$dateActuelle))+round(moyenneSemaine("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 week'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colortotal"]["fillColor"],
								"strokeColor" => $color["colortotal"]["strokeColor"],
								"data" =>$consommation
							));
				break;
				
			case "batiment_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 week'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorbatiment_est"]["fillColor"],
								"strokeColor" => $color["colorbatiment_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "serveur_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 week'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorserveur_est"]["fillColor"],
								"strokeColor" => $color["colorserveur_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "extension_ouest":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("extension_ouest",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 week'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorextension_ouest"]["fillColor"],
								"strokeColor" => $color["colorextension_ouest"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur1":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("extension_ouest",$dateActuelle,"Capteur1")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 week'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur1"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur1"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur2":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("extension_ouest",$dateActuelle,"Capteur2")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 week'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur2"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur2"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur3":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneSemaine("extension_ouest",$dateActuelle,"Capteur3")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 week'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur3"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur3"]["strokeColor"],
								"data" =>$consommation
							));
			break;
		}
	}
    $donneesGrapheLigne=array(
			"labels" => $listLabel,
			"datasets" =>$datasets
	);
	 return $donneesGrapheLigne;
}
	
	function calculeParMois($dateDebut,$dateFin,$capteur){
		global $color;
		$datasets=array();
		foreach ($capteur as $uncapteur)
		{
			$dateActuelle=$dateDebut;
			unset($consommation);
			$consommation=array();
			unset($listLabel);
			$listLabel=array();
		    switch($uncapteur){
			 case "total":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("extension_ouest",$dateActuelle))+round(moyenneMois("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 month'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colortotal"]["fillColor"],
								"strokeColor" => $color["colortotal"]["strokeColor"],
								"data" =>$consommation
							));
				break;
				
			case "batiment_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 month'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorbatiment_est"]["fillColor"],
								"strokeColor" => $color["colorbatiment_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "serveur_est":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("serveur_est",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 month'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorserveur_est"]["fillColor"],
								"strokeColor" => $color["colorserveur_est"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "extension_ouest":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("extension_ouest",$dateActuelle)));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 month'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorextension_ouest"]["fillColor"],
								"strokeColor" => $color["colorextension_ouest"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur1":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("extension_ouest",$dateActuelle,"Capteur1")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 month'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur1"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur1"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur2":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("extension_ouest",$dateActuelle,"Capteur2")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 month'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur2"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur2"]["strokeColor"],
								"data" =>$consommation
							));
			break;
			
			case "ouest_capteur3":
				while(strtotime($dateActuelle)<=strtotime($dateFin)){
					array_push($consommation,round(moyenneMois("extension_ouest",$dateActuelle,"Capteur3")));
					array_push($listLabel,date("d-m",strtotime($dateActuelle)));
			
					$dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle.'+1 month'));
				}
				array_push($datasets,array(
								"fillColor" => $color["colorouest_capteur3"]["fillColor"],
								"strokeColor" => $color["colorouest_capteur3"]["strokeColor"],
								"data" =>$consommation
							));
			break;
		}
	}
    $donneesGrapheLigne=array(
			"labels" => $listLabel,
			"datasets" =>$datasets
	);
	 return $donneesGrapheLigne;
}

    
?>
