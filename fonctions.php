<?php

function traduction($motAnglais){
	$motFrancais = $motAnglais;
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
	}
	return $motFrancais;
}

?>