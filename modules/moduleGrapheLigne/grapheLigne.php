<?php
	include_once "../../utils/calculMoyenne.php";
	include_once "../../utils/fonctions.php";
	
	$numeroJour=date("N");
	$ecart=7-$numeroJour;
	
	//on calcule le dernier jour de la semaine actuelle et de la semaine précedente
	$dateSemaineActuelle=date("d-m-Y H:i:s",mktime(24,0,0,date('m'),date('d')+$ecart,date('Y')));
	$dateSemainePrecedent=date("d-m-Y H:i:s",strtotime($dateSemaineActuelle.'-1 week'));
	
	//on calcule le premier jour de la semaine actuelle et de la semaine precedente
	$dateActuelleDebut=date("d-m-Y",strtotime($dateSemaineActuelle.'-1 week'));
	$datePrecedentDebut=date("d-m-Y",strtotime($dateActuelleDebut.'-1 week'));
	
	
	// on calcule les moyennes de consommation par deux heures
	$resultatMoyenne=calculeMoyenneDeConsommation($dateSemaineActuelle,$dateSemainePrecedent);
	
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
		"valeurMax" => (round($resultatMoyenne['valeurMax'], -3)+1000)
	);
	echo json_encode ($donneesGrapheLigne);
	
	
	//Calcule les moyennes de consommation (par deux heures) pour la semaine actuelle et la semaine précédente (passées en paramètres)
	function calculeMoyenneDeConsommation($dateSemaineActuelle,$dateSemainePrecedent){
		$listLabel = array();
		$consommationSemaineActuelle=array();
		$consommationSemainePrecedente=array();
	
		$valeurMax = 0;
		
		//ATTENTION : le calcul se fait depuis le dimanche 24h, jusqu'au lundi 00h
		//pour chaque jour
		for($j=0;$j<7;$j++){
			//pour chaque paire d'heures
			for($i=0;$i<12;$i++){
				//on calcule en même temps la consommationMoyenne par deux heures de la semaine actuelle et de la semaine précédente
				$consommationMoyennePourSemaineActuelle = round(moyenneParDeuxHeure("extension_ouest",$dateSemaineActuelle));
				$consommationMoyennePourSemainePrecedente = round(moyenneParDeuxHeure("extension_ouest",$dateSemainePrecedent));
				
				//on les rajoute dans les tableaux correspondants
				array_unshift($consommationSemaineActuelle, $consommationMoyennePourSemaineActuelle);
				array_unshift($consommationSemainePrecedente, $consommationMoyennePourSemainePrecedente);
				
				//on met à jour la valeur maximale si besoin
				if($consommationMoyennePourSemaineActuelle > $valeurMax){
					$valeurMax = $consommationMoyennePourSemaineActuelle;
				}
				if($consommationMoyennePourSemainePrecedente > $valeurMax){
					$valeurMax = $consommationMoyennePourSemainePrecedente;
				}
				
				//on passe à la paire d'heure "précédentes"
				$dateSemaineActuelle=date("d-m-Y H:i:s",strtotime($dateSemaineActuelle."-2 hour"));
				$dateSemainePrecedent=date("d-m-Y H:i:s",strtotime($dateSemainePrecedent."-2 hour"));
				array_push($listLabel, "");
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
				array_push($listLabel, "Lundi ".date("d", strtotime($dateActuelle)));
				break;
			//mardi
			case 2:
				array_push($listLabel, "Mardi ".date("d", strtotime($dateActuelle)));
				break;
			//mercredi
			case 3:
				array_push($listLabel, "Mercredi ".date("d", strtotime($dateActuelle)));
				break;
			//jeudi
			case 4:
				array_push($listLabel, "Jeudi ".date("d", strtotime($dateActuelle)));
				break;
			//vendredi
			case 5:
				array_push($listLabel, "Vendredi ".date("d", strtotime($dateActuelle)));
				break;
			//samedi
			case 6:
				array_push($listLabel, "Samedi ".date("d", strtotime($dateActuelle)));
				break;
			//dimanche
			case 7:
				array_push($listLabel, "Dimanche ".date("d", strtotime($dateActuelle)));
				break;
			}
			$dateActuelle = date("d-m-Y", strtotime($dateActuelle."+1 day"));
		}
		return $listLabel;
	}
?>
