<?php
	include_once "../connectBD.php";
	include_once "../calculMoyenne.php";
	
	$bdd = connectBD();
	$dateActuelle=date("d-m-Y H:i:s",mktime(24,0,0,date('m'),date('d'),date('Y')));
	$dateSemainePrecedant=date("d-m-Y H:i:s",strtotime($dateActuelle.'-1 week'));
	$dataConsomme=[];
	$dataConsommePrecedant=[];
	$weekarray=[];
	$weekarraySemainePrecedant=[];
	
	// on calclue le moyenne de consomation par deux heure
	
	for($j=0;$j<7;$j++){
		  for($i=0;$i<12;$i++){
		    array_unshift($dataConsomme,round(moyenneParDeuxHeure($bdd,"serveur_est",$dateActuelle,"Capteur1")));
		    array_unshift($dataConsommePrecedant,round(moyenneParDeuxHeure($bdd,"serveur_est",$dateSemainePrecedant,"Capteur1")));
			if(date('H',strtotime($dateActuelle))==0){
				array_unshift($weekarray,date('d-m',strtotime($dateActuelle)));
				array_unshift($weekarraySemainePrecedant,date('d-m',strtotime($dateSemainePrecedant)));
				}else {
				array_unshift($weekarray,"");
				array_unshift($weekarraySemainePrecedant,"");
			}
		    $dateActuelle=date("d-m-Y H:i:s",strtotime($dateActuelle."-2 hour"));
		    $dateSemainePrecedant=date("d-m-Y H:i:s",strtotime($dateSemainePrecedant."-2 hour"));
		}
	}
					
	$donneesGrapheLigne = array(
	   "dateActuelle"=> array (
			"labels" => $weekarray,
			"labels" => array("","","l","u","n","d","i","","00","", "","|",
							"","","m","a","r","d","i","","0","0", "","|",
							"m","e","r","c","r","e","d","i","","0","0","|",
							"","","j","e","u","d","i","","0","0", "","|",
							"v","e","n","d","r","e","d","i","","0","0","|",
							"","s","a","m","e","d","i","","0","0", "","|",
							"d","i","m","a","n","c","h","e","","0","0","|"),
							
			"datasets" => array(
				array(
					"fillColor" => "rgba(220,220,220,0.5)",
					"strokeColor" => "rgba(220,220,220,1)",
					"pointColor" => "rgba(220,220,220,1)",
					"pointStrokeColor" => "#fff",
					"data" => $dataConsomme
				)
			 )	
			),
		"dateSemainePrecedant"=> array (
			"labels" => $weekarraySemainePrecedant,
			"datasets" => array(
				array(
					"fillColor" => "rgba(151,187,205,0.5)",
					"strokeColor" =>"rgba(151,187,205,1)",
					"pointColor" => "rgba(151,187,205,1)",
					"pointStrokeColor" => "#fff",
					"data" => $dataConsommePrecedant
					)
				)	
			)
	);
	echo json_encode ($donneesGrapheLigne);
?>
