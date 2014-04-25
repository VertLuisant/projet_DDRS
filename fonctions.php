<?php

function editLabelSemaine($dateDebutSemaine){
	$listLabel = array();
	$dateActuelle = $dateDebutSemaine;
	for($i = 1; $i<8; $i++){
		switch ($i){
		//lundi
		case 1:
			array_push($listLabel, "","","L","U","N","D","I","",date("d", strtotime($dateActuelle)),"","","|");
			break;
		//mardi
		case 2:
			array_push($listLabel, "","","M","A","R","D","I","",date("d", strtotime($dateActuelle)),"","","|");
			break;
		//mercredi
		case 3:
			array_push($listLabel, "M","E","R","C","R","E","D","I","",date("d", strtotime($dateActuelle)),"","|");
			break;
		//jeudi
		case 4:
			array_push($listLabel, "","","J","E","U","D","I","",date("d", strtotime($dateActuelle)),"","","|");
			break;
		//vendredi
		case 5:
			array_push($listLabel, "V","E","N","D","R","E","D","I","",date("d", strtotime($dateActuelle)),"","|");
			break;
		//samedi
		case 6:
			array_push($listLabel, "","","S","A","M","E","D","I","",date("d", strtotime($dateActuelle)),"","|");
			break;
		//dimanche
		case 7:
			array_push($listLabel, "D","I","M","A","N","C","H","E","",date("d", strtotime($dateActuelle)),"","|");
			break;
		}
		$dateActuelle = date("d-m-Y", strtotime($dateActuelle."+1 day"));
	}
	return $listLabel;
}

function traduction($motAnglais){
	switch ($motAnglais) {
		//traduction des jours
		case "Monday":
			$motFrancais = "Lundi";
			break;
		case "Tuesday":
			$motFrancais = "Mardi";
			break;
		case "Wednesday":
			$motFrancais = "Mercredi";
			break;
		case "Thursday":
			$motFrancais = "Jeudi";
			break;
		case "Friday":
			$motFrancais = "Vendredi";
			break;
		case "Saturday":
			$motFrancais = "Samedi";
			break;
		case "Sunday":
			$motFrancais = "Dimanche";
			break;
		//traduction des mois
		case "January":
			$motFrancais = "Janvier";
			break;
		case "February":
			$motFrancais = "Février";
			break;
		case "March":
			$motFrancais = "Mars";
			break;
		case "April":
			$motFrancais = "Avril";
			break;
		case "May":
			$motFrancais = "Mai";
			break;
		case "June":
			$motFrancais = "Juin";
			break;
		case "July":
			$motFrancais = "Juillet";
			break;
		case "August":
			$motFrancais = "Août";
			break;
		case "September":
			$motFrancais = "Septembre";
			break;
		case "October":
			$motFrancais = "Octobre";
			break;
		case "November":
			$motFrancais = "Novembre";
			break;
		case "December":
			$motFrancais = "Decembre";
			break;
		default:
			$motFrancais = $motAnglais;
	}
	return $motFrancais;
}

?>