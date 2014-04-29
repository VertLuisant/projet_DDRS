<?php
	include_once "../../utils/calculMoyenne.php";
	include_once "../../utils/fonctions.php";
	
	//On ouvre le fichier donneesHistogramme.json pour récupérer les données
	$donnees=recupereLesDonnees("donneesHistogramme.json");
	$date=date("d-m-Y",strtotime($donnees->dateDerniereMAJ));
	
	//si la date récupéré dans le fichier est différente de la date actuelle, on recalcule les moyennes 
	if(strtotime($date)!=strtotime(date("d-m-Y"))){
	   recalculeMoyenneParMois();
	   $donnees=recupereLesDonnees("donneesHistogramme.json");
	}
		
	$donneesHistogramme = array(
		"labels" => $donnees->listLabel,
		"datasets" => array(
			array(
				"fillColor" => "rgba(0,156,221,0.5)",
				"strokeColor" => "rgba(0,156,221,0.5)",
				"data" => $donnees->listDonneesAnneePrecedente,
			),
			array(
				"fillColor" => "rgba(0,90,150,0.7)",
				"strokeColor" => "rgba(0,90,150,0.7)",
				"data" => $donnees->listDonneesAnneeActuelle
			)
		)	
	);
	echo json_encode ($donneesHistogramme);
	
	
	//Permet de récupérer les données du fichier passé en paramètre
	function recupereLesDonnees($filename){
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		return json_decode($contents);
	}
	
	//Permet d'écrire les données $data au format JSON dans le fichier au nom $filename passé en paramètre
	function ecrirelesDonnees($filename,$data){	
			$handle = fopen($filename, "w");
			fwrite($handle,json_encode($data));
			fclose($handle); 
	}
	
	// Recalcule les moyennes mensuelles du mois actuel et des 5 derniers mois, pour l'année actuelle et l'année précédente
	//ATTENTION : prend beaucoup de temps pour s'éxécuter (30s~1mn)
	function recalculeMoyenneParMois(){
		$listLabel = array();
		$listDonneesAnneePrecedente = array();
		$listDonneesAnneeActuelle = array();
		
		//on commence 5 mois en arrière, au premier du mois
	    $dateMoisAnneePrecedente = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")-1));
	    $dateMoisAnneeActuelle = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")));
		
		//pour chaque mois on calcule la moyenne mensuelle pour l'année actuelle et l'année précédente
		for($i = 0; $i < 6; $i++){
			array_push($listDonneesAnneePrecedente, moyenneMois("serveur_est",$dateMoisAnneePrecedente));
			array_push($listDonneesAnneeActuelle, moyenneMois("serveur_est",$dateMoisAnneeActuelle));
			$texteLabel = date("Y", strtotime($dateMoisAnneePrecedente))." ".traduction(date("F", strtotime($dateMoisAnneePrecedente)))." ".date("Y", strtotime($dateMoisAnneeActuelle));
			array_push($listLabel, $texteLabel);
			$dateMoisAnneePrecedente = date("d-m-Y", strtotime($dateMoisAnneePrecedente."+1 month"));
			$dateMoisAnneeActuelle = date("d-m-Y", strtotime($dateMoisAnneeActuelle."+1 month"));
		}
			
		$data=array(
				"dateDerniereMAJ"=>date("d-m-Y"),
				"listLabel"=>$listLabel,
				"listDonneesAnneePrecedente"=>$listDonneesAnneePrecedente,
				"listDonneesAnneeActuelle"=>$listDonneesAnneeActuelle
				);
					
		//On stocke les données dans un fichier
		ecrirelesDonnees("donneesHistogramme.json",$data);
	}
?>