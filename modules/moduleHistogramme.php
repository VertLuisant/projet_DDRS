<?php
	include_once "../calculMoyenne.php";
	include_once "../connectBD.php";
	
	$bdd = connectBd();
	
	$listLabel = array();
	$listDonneesAnneePrecedente = array();
	$listDonneesAnneeActuelle = array();
	
	//on commence 5 mois en arriere,au premier du mois
	$dateMoisAnneePrecedente = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")-1));
	$dateMoisAnneeActuelle = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")));
	/*for($i = 0; $i < 6; $i++){
		array_push($listDonneesAnneePrecedente, moyenneMois($bdd,"serveur_est",$dateMoisAnneePrecedente));
		array_push($listDonneesAnneeActuelle, moyenneMois($bdd,"serveur_est",$dateMoisAnneeActuelle));
		$texteLabel = date("Y", strtotime($dateMoisAnneePrecedente))." ".date("F", strtotime($dateMoisAnneePrecedente))." ".date("Y", strtotime($dateMoisAnneeActuelle));
		array_push($listLabel, $texteLabel);
		$dateMoisAnneePrecedente = date("d-m-Y", strtotime($dateMoisAnneePrecedente."+1 month"));
		$dateMoisAnneeActuelle = date("d-m-Y", strtotime($dateMoisAnneeActuelle."+1 month"));
	}*/
	
	$donneesHistogramme = array(
		//"labels" => $listLabel,
		"labels" => array("1","2","3","4","5","6"),
		"datasets" => array(
			array(
				"fillColor" => "rgba(0,156,221,0.5)",
				"strokeColor" => "rgba(0,156,221,0.5)",
				//"data" => $listDonneesAnneePrecedente
				"data"=> array(70,60,50,40,30,20)
			),
			array(
				"fillColor" => "rgba(0,90,150,0.7)",
				"strokeColor" => "rgba(0,90,150,0.7)",
				//"data" => $listDonneesAnneeActuelle
				"data"=> array(20,30,40,50,60,70)
			)
		)	
	);
	echo json_encode ($donneesHistogramme);
?>