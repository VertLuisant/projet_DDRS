<?php
	include_once "../calculMoyenne.php";
			
	//ouvert le fichier moduleHistogramme.json pour recuperer les donnees
	$donnees=recupereLesDonnees("moduleHistogramme.json");
	$date=date("d-m-Y",strtotime($donnees->dateDerniereMAJ));
	
	//si le date est différent que le date actuel, on recalcule les moyennes 
	if(strtotime($date)!=strtotime(date("d-m-Y"))){
	
	   recalculeMoyenneParMois();
	   $donnees=recupereLesDonnees("moduleHistogramme.json");
	   
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
	
	
	//recuperer les donnees dans le fichier
	function recupereLesDonnees($filename){
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		fclose($handle);
		return json_decode($contents);
	}
	//ecrire les donnees dans le fichier 
	function ecrirelesDonnees($filename,$data){	
			$handle = fopen($filename, "w");
			fwrite($handle,$data);
			fclose($handle); 
	}
	
	// recalculer les moyennes par mois et les stocker dans le fichier moduleHistogramme.json
	function recalculeMoyenneParMois(){
	
		$listLabel = array();
		$listDonneesAnneePrecedente = array();
		$listDonneesAnneeActuelle = array();
		
		//on commence 5 mois en arriere,au premier du mois
	    $dateMoisAnneePrecedente = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")-1));
	    $dateMoisAnneeActuelle = date("d-m-Y", mktime(0, 0, 0, date("m")-5, 1, date("Y")));
		
		  for($i = 0; $i < 6; $i++){
			array_push($listDonneesAnneePrecedente, moyenneMois("serveur_est",$dateMoisAnneePrecedente));
			array_push($listDonneesAnneeActuelle, moyenneMois("serveur_est",$dateMoisAnneeActuelle));
			$texteLabel = date("Y", strtotime($dateMoisAnneePrecedente))." ".date("F", strtotime($dateMoisAnneePrecedente))." ".date("Y", strtotime($dateMoisAnneeActuelle));
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
					
		//stocker les donnees dans le fichier
		ecrirelesDonnees("moduleHistogramme.json",json_encode($data));
	}
?>