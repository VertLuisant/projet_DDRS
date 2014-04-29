<?php
	include_once "../calculMoyenne.php";
		
	$listLabel = array();
	$listDonneesAnneePrecedente = array();
	$listDonneesAnneeActuelle = array();
	
	//on commence 5 mois en arriere,au premier du mois
	$dateMoisAnneePrecedente = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")-1));
	$dateMoisAnneeActuelle = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")));

	//ouvert le fichier moduleHistogramme.json pour recuperer les donnees
	$filename = "moduleHistogramme.json";
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$obj=json_decode($contents);
	$date=date("d-m-Y",strtotime($obj->date));
	
	//si le date est inférieur que le date actuel, on recalcule les donnees
	if(strtotime($date)!=strtotime(date("d-m-Y"))){
	  
	  for($i = 0; $i < 6; $i++){
		array_push($listDonneesAnneePrecedente, moyenneMois("serveur_est",$dateMoisAnneePrecedente));
		array_push($listDonneesAnneeActuelle, moyenneMois("serveur_est",$dateMoisAnneeActuelle));
		$texteLabel = date("Y", strtotime($dateMoisAnneePrecedente))." ".date("F", strtotime($dateMoisAnneePrecedente))." ".date("Y", strtotime($dateMoisAnneeActuelle));
		array_push($listLabel, $texteLabel);
		$dateMoisAnneePrecedente = date("d-m-Y", strtotime($dateMoisAnneePrecedente."+1 month"));
		$dateMoisAnneeActuelle = date("d-m-Y", strtotime($dateMoisAnneeActuelle."+1 month"));
		}
		$data=array(
				"date"=>date("d-m-Y"),
				"listLabel"=>$listLabel,
				"listDonneesAnneePrecedente"=>$listDonneesAnneePrecedente,
				"listDonneesAnneeActuelle"=>$listDonneesAnneeActuelle
				);
		//ecrire les donnees dans le fichier moduleHistogramme.json		
		$handle = fopen($filename, "w");
		fwrite($handle,json_encode($data));
		fclose($handle);  
	}else{
		$listLabel=$obj->listLabel;
		$listDonneesAnneePrecedente=$obj->listDonneesAnneePrecedente;
		$listDonneesAnneeActuelle=$obj->listDonneesAnneeActuelle;
	}
	
	$donneesHistogramme = array(
		"labels" => $listLabel,
		"datasets" => array(
			array(
				"fillColor" => "rgba(0,156,221,0.5)",
				"strokeColor" => "rgba(0,156,221,0.5)",
				"data" => $listDonneesAnneePrecedente,
			),
			array(
				"fillColor" => "rgba(0,90,150,0.7)",
				"strokeColor" => "rgba(0,90,150,0.7)",
				"data" => $listDonneesAnneeActuelle
			)
		)	
	);
	echo json_encode ($donneesHistogramme);
?>