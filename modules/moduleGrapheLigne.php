<?php
	include_once "../connectBD.php";
	include_once "../calculMoyenne.php";
	include_once "../fonctions.php";
	
	$bdd = connectBD();
	$numeroJour=date("N");
	$ecart=7-$numeroJour;
	
	//calcule le dernier jour de la semaine et la semaine precedente
	$dateActuelle=date("d-m-Y H:i:s",mktime(24,0,0,date('m'),date('d')+$ecart,date('Y')));
	$dateSemainePrecedent=date("d-m-Y H:i:s",strtotime($dateActuelle.'-1 week'));
	$dataConsomme=array();
	$dataConsommePrecedent=array();
	
	//calcule le premier jour de la semaine et la semaine precedente
	$dateActuelleDe=date("d-m-Y",strtotime($dateActuelle.'-1 week'));
	$datePrecedentDe=date("d-m-Y",strtotime($dateActuelleDe.'-1 week'));
	$listLabelSemaineActuelle = editLabelSemaine($dateActuelleDe);
	$listLabelSemainePrecedente = editLabelSemaine($datePrecedentDe);
	
	// on calclue le moyenne de consomation par deux heure
	for($j=0;$j<7;$j++){
		  for($i=0;$i<12;$i++){
		    array_unshift($dataConsomme,round(moyenneParDeuxHeure($bdd,"serveur_est",$dateActuelle)));
		    array_unshift($dataConsommePrecedent,round(moyenneParDeuxHeure($bdd,"serveur_est",$dateSemainePrecedent)));
		    $dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle."-2 hour"));
		    $dateSemainePrecedent=date("d-m-Y H:i:s",strtotime($dateSemainePrecedent."-2 hour"));
		}
	}
	
	// le donnee pour le graphe ligne				
	$donneesGrapheLigne = array(
	   "dateSemainePrecedent"=> array (
			"labels" => $listLabelSemainePrecedente,
			"datasets" => array(
				array(
					"fillColor" => "rgba(0,156,221,0.5)",
					"strokeColor" => "rgba(0,156,221,1)",
					"pointColor" => "rgba(0,166,214,0.5)",
					"pointStrokeColor" => "#fff",
					"data" => $dataConsommePrecedent
				)
			 )	
			),
		"dateSemaineActuelle"=> array (
			"labels" => $listLabelSemaineActuelle,
			"datasets" => array(
				array(
					"fillColor" => "rgba(0,156,221,0.5)",
					"strokeColor" => "rgba(0,156,221,1)",
					"pointColor" => "rgba(0,166,214,0.5)",
					"pointStrokeColor" => "#fff",
					"data" => $dataConsomme
					)
				)	
			),
		"dateActuelleDe"=> $dateActuelleDe,
		"datePrecedentDe"=> $datePrecedentDe
	);
	echo json_encode ($donneesGrapheLigne);
?>
