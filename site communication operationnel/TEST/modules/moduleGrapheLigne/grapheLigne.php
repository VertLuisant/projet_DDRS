<?php
	include_once "../../utils/calculMoyenne.php";
	include_once "../../utils/fonctions.php";
	
	$numeroJour=date("N");
	$ecart=$numeroJour-1;
	
	//on calcule le premier jour de la semaine actuelle et de la semaine precedente
	$dateActuelleDebut=date("d-m-Y H:i:s",mktime(0,0,0,date('m'),date('d')-$ecart,date('Y')));
	$datePrecedentDebut=date("d-m-Y",strtotime($dateActuelleDebut.'-1 week'));
	
	
	// on calcule les moyennes de consommation par deux heures
	$resultatMoyenne=calculeMoyenneDeConsommation($dateActuelleDebut,$datePrecedentDebut);
	
	//on construit le tableau des données que l'on va passé au javascript				
	$donneesGrapheLigne = array(
	   "dateSemainePrecedent"=> array (
			"labels"=> $resultatMoyenne['listLabel'],
			"datasets" => array(
				array(
					"fillColor" => "rgba(0,156,221,0.5)",
					"strokeColor" => "rgba(0,156,221,1)",
					"pointColor" => "rgba(0,166,214,0.5)",
					"pointStrokeColor" => "#fff",
					"data" => $resultatMoyenne['consommationSemainePrecedente']
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
					"data" => $resultatMoyenne['consommationSemaineActuelle']
					)
				)	
			),
		"listJourSemaineActuelle" => editlabelSemaine($dateActuelleDebut),
		"listJourSemainePrecedente" => editlabelSemaine($datePrecedentDebut),
		"dateDebutSemaineActuelle"=> ecritureDate($dateActuelleDebut),
		"dateDebutSemainePrecedente"=> ecritureDate($datePrecedentDebut),
		"echelle" => calculEchelle($resultatMoyenne['valeurMax'], 10)
	);
	echo json_encode ($donneesGrapheLigne);
	
	
	//Calcule les moyennes de consommation (par deux heures) pour la semaine actuelle et la semaine précédente (passées en paramètres)
	function calculeMoyenneDeConsommation($dateSemaineActuelle,$dateSemainePrecedent){
		$listLabel = array();
		$consommationSemaineActuelle=array();
		$consommationSemainePrecedente=array();
	
		$valeurMax = 0;
		
		//ATTENTION : le calcul se fait depuis le lundi 00h, jusqu'au dimanche 10h
		//pour chaque jour
		for($j=0;$j<7;$j++){
			//pour chaque paire d'heures
			for($i=0;$i<12;$i++){
				//on calcule en même temps la consommationMoyenne par deux heures de la semaine actuelle et de la semaine précédente
				$consommationMoyennePourSemaineActuelle = round(moyenneParDeuxHeure("extension_ouest",$dateSemaineActuelle));
				$consommationMoyennePourSemainePrecedente = round(moyenneParDeuxHeure("extension_ouest",$dateSemainePrecedent));
				
				//on les rajoute dans les tableaux correspondants
				array_push($consommationSemaineActuelle, $consommationMoyennePourSemaineActuelle);
				array_push($consommationSemainePrecedente, $consommationMoyennePourSemainePrecedente);
				
				//on met à jour la valeur maximale si besoin
				if($consommationMoyennePourSemaineActuelle > $valeurMax){
					$valeurMax = $consommationMoyennePourSemaineActuelle;
				}
				if($consommationMoyennePourSemainePrecedente > $valeurMax){
					$valeurMax = $consommationMoyennePourSemainePrecedente;
				}
				
				//on passe à la paire d'heure "précédentes"
				array_push($listLabel, "");
				$dateSemaineActuelle=date("d-m-Y H:i:s",strtotime($dateSemaineActuelle."+2 hour"));
				$dateSemainePrecedent=date("d-m-Y H:i:s",strtotime($dateSemainePrecedent."+2 hour"));
				
		}
	 }
	
	 $resultatMoyenne=array(
				"listLabel"=>$listLabel,
				"consommationSemaineActuelle"=>$consommationSemaineActuelle,
				"consommationSemainePrecedente"=>$consommationSemainePrecedente,
				"valeurMax" => $valeurMax
				);
	
	 return $resultatMoyenne;
	}
	
	//Edite la liste de label pour la semaine commenceant à la date passée en paramètre
	function editLabelSemaine($dateDebutSemaine){
		$listLabel = array();
		$dateActuelle = $dateDebutSemaine;
		for($i = 1; $i<8; $i++){
			switch ($i){
			//lundi
			case 1:
				array_push($listLabel, "lundi ".date("d", strtotime($dateActuelle)));
				break;
			//mardi
			case 2:
				array_push($listLabel, "mardi ".date("d", strtotime($dateActuelle)));
				break;
			//mercredi
			case 3:
				array_push($listLabel, "mercredi ".date("d", strtotime($dateActuelle)));
				break;
			//jeudi
			case 4:
				array_push($listLabel, "jeudi ".date("d", strtotime($dateActuelle)));
				break;
			//vendredi
			case 5:
				array_push($listLabel, "vendredi ".date("d", strtotime($dateActuelle)));
				break;
			//samedi
			case 6:
				array_push($listLabel, "samedi ".date("d", strtotime($dateActuelle)));
				break;
			//dimanche
			case 7:
				array_push($listLabel, "dimanche ".date("d", strtotime($dateActuelle)));
				break;
			}
			$dateActuelle = date("d-m-Y", strtotime($dateActuelle."+1 day"));
		}
		return $listLabel;
	}
?>
