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
		array_push($listDonneesAnneePrecedente, moyenneMois($bdd,"serveur_est",$dateMoisAnneePrecedente,"Capteur1"));
		array_push($listDonneesAnneeActuelle, moyenneMois($bdd,"serveur_est",$dateMoisAnneeActuelle,"Capteur1"));
		$texteLabel = date("Y", strtotime($dateMoisAnneePrecedente))." ".date("F", strtotime($dateMoisAnneePrecedente))." ".date("Y", strtotime($dateMoisAnneeActuelle));
		array_push($listLabel, $texteLabel);
		$dateMoisAnneePrecedente = date("d-m-Y", strtotime($dateMoisAnneePrecedente."+1 month"));
		$dateMoisAnneeActuelle = date("d-m-Y", strtotime($dateMoisAnneeActuelle."+1 month"));
	}
	
	$donneesHistogramme = array(
		"labels" => $listLabel,
		"datasets" => array(
			array(
				"fillColor" => "rgba(220,220,220,0.5)",
				"strokeColor" => "rgba(220,220,220,1)",
				"data" => $listDonneesAnneePrecedente
			),
			array(
				"fillColor" => "rgba(151,187,205,0.5)",
				"strokeColor" => "rgba(151,187,205,1)",
				"data" => $listDonneesAnneeActuelle
			)
		)	
	);
	echo json_encode ($donneesHistogramme);
?>