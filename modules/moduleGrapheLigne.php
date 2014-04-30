<?php
	include_once "../calculMoyenne.php";
	include_once "../fonctions.php";
	
	$numeroJour=date("N");
	$ecart=7-$numeroJour;
	
	//calcule le dernier jour de la semaine et la semaine precedente
	$dateActuelle=date("d-m-Y H:i:s",mktime(24,0,0,date('m'),date('d')+$ecart,date('Y')));
	$dateSemainePrecedent=date("d-m-Y H:i:s",strtotime($dateActuelle.'-1 week'));
	
	//calcule le premier jour de la semaine et la semaine precedente
	$dateActuelleDe=date("d-m-Y",strtotime($dateActuelle.'-1 week'));
	$datePrecedentDe=date("d-m-Y",strtotime($dateActuelleDe.'-1 week'));
	
	
	// on calclue le moyenne de consomation par deux heure
	$resultatMoyenne=calculeMoyenneDeConsomation($dateActuelle,$dateSemainePrecedent);
	
	// le donnee pour le graphe ligne				
	$donneesGrapheLigne = array(
	   "dateSemainePrecedent"=> array (
			"labels"=> $resultatMoyenne['listLabel'],
			"datasets" => array(
				array(
					"fillColor" => "rgba(0,156,221,0.5)",
					"strokeColor" => "rgba(0,156,221,1)",
					"pointColor" => "rgba(0,166,214,0.5)",
					"pointStrokeColor" => "#fff",
					"data" => $resultatMoyenne['dataConsommePrecedent']
				)
			 )	
			),
		"dateSemaineActuelle"=> array (
			"labels" => $resultatMoyenne['listLabel'],
			"datasets" => array(
				array(
					"fillColor" => "rgba(0,156,221,0.5)",
					"strokeColor" => "rgba(0,156,221,1)",
					"pointColor" => "rgba(0,166,214,0.5)",
					"pointStrokeColor" => "#fff",
					"data" => $resultatMoyenne['dataConsomme']
					)
				)	
			),
		"listJourSemaineActuelle" => editlabelSemaine($dateActuelleDe),
		"listJourSemainePrecedente" => editlabelSemaine($datePrecedentDe),
		"dateDebutSemaineActuelle"=> ecritureDate($dateActuelleDe),
		"dateDebutSemainePrecedente"=> ecritureDate($datePrecedentDe),
	);
	echo json_encode ($donneesGrapheLigne);
	
	function calculeMoyenneDeConsomation($dateActuelle,$dateSemainePrecedent){
		$listLabel = array();
		$dataConsomme=array();
		$dataConsommePrecedent=array();
		
		for($j=0;$j<7;$j++){
		  for($i=0;$i<12;$i++){
		    array_unshift($dataConsomme,round(moyenneParDeuxHeure("extension_ouest",$dateActuelle)));
		    array_unshift($dataConsommePrecedent,round(moyenneParDeuxHeure("extension_ouest",$dateSemainePrecedent)));
		    $dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle."-2 hour"));
		    $dateSemainePrecedent=date("d-m-Y H:i:s",strtotime($dateSemainePrecedent."-2 hour"));
			array_push($listLabel, "");
		}
	 }
	
	 $resultatMoyenne=array(
				"listLabel"=>$listLabel,
				"dataConsomme"=>$dataConsomme,
				"dataConsommePrecedent"=>$dataConsommePrecedent
				);
	
	 return $resultatMoyenne;
	}
?>
