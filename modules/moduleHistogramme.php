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
	for($i = 0; $i < 6; $i++){
		array_push($listDonneesAnneePrecedente, moyenneMois($bdd,"serveur_est",$dateMoisAnneePrecedente));
		array_push($listDonneesAnneeActuelle, moyenneMois($bdd,"serveur_est",$dateMoisAnneeActuelle));
		$texteLabel = date("Y", strtotime($dateMoisAnneePrecedente))." ".date("F", strtotime($dateMoisAnneePrecedente))." ".date("Y", strtotime($dateMoisAnneeActuelle));
		array_push($listLabel, $texteLabel);
		$dateMoisAnneePrecedente = date("d-m-Y", strtotime($dateMoisAnneePrecedente."+1 month"));
		$dateMoisAnneeActuelle = date("d-m-Y", strtotime($dateMoisAnneeActuelle."+1 month"));
	}
	
	$donneesHistogramme = array(
		"labels" => $listLabel,
		"datasets" => array(
			array(
				"fillColor" => "rgba(0,90,150,0.7)",
				"strokeColor" => "rgba(0,90,150,0.7)",
				"data" => $listDonneesAnneePrecedente
			),
			array(
				"fillColor" => "rgba(0,156,221,0.5)",
				"strokeColor" => "rgba(0,156,221,0.5)",
				"data" => $listDonneesAnneeActuelle
			)
		)	
	);
	echo json_encode ($donneesHistogramme);
?>