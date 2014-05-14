<?php
//Contient toutes les fonctions générique php

//Retourne la valeur de l'échelle pour un graphique ayant la valeur maximale $valeurMax et un nombre de pas $nombreDePas
//L'échelle est forcément un multiple de 500, pour des soucis de lisibilités des graphiques
//Exemple : calculEchelle(20000, 10) retournera 2000 car il faut une échelle de 2000 pour 10 pas afin d'afficher le graphique sans perte
function calculEchelle($valeurMax, $nombreDePas){
	$echelle = 500;
	$nombreDePas = $valeurMax / $echelle;
	while($nombreDePas > 10){
		$echelle = $echelle + 500;
		$nombreDePas = $valeurMax / $echelle;
	}
	return $echelle;
}

//Permet de récupérer une chaine de caractere contenant la date passe en paramètre de façon "écrite"
function ecritureDate($date){
	return date("d", strtotime($date))." ".traduction(date("F", strtotime($date)))." ".date("Y", strtotime($date));
}

//Permet la traduction de mot anglais en mot français.
//Si la traduction n'existe pas, retourne le mot anglais
function traduction($motAnglais){
	switch ($motAnglais) {
		//traduction des jours
		case "Monday":
			$motFrancais = "lundi";
			break;
		case "Tuesday":
			$motFrancais = "mardi";
			break;
		case "Wednesday":
			$motFrancais = "mercredi";
			break;
		case "Thursday":
			$motFrancais = "jeudi";
			break;
		case "Friday":
			$motFrancais = "vendredi";
			break;
		case "Saturday":
			$motFrancais = "samedi";
			break;
		case "Sunday":
			$motFrancais = "dimanche";
			break;
		//traduction des mois
		case "January":
			$motFrancais = "janvier";
			break;
		case "February":
			$motFrancais = "février";
			break;
		case "March":
			$motFrancais = "mars";
			break;
		case "April":
			$motFrancais = "avril";
			break;
		case "May":
			$motFrancais = "mai";
			break;
		case "June":
			$motFrancais = "juin";
			break;
		case "July":
			$motFrancais = "juillet";
			break;
		case "August":
			$motFrancais = "août";
			break;
		case "September":
			$motFrancais = "septembre";
			break;
		case "October":
			$motFrancais = "octobre";
			break;
		case "November":
			$motFrancais = "novembre";
			break;
		case "December":
			$motFrancais = "décembre";
			break;
		default:
			$motFrancais = $motAnglais;
	}
	return $motFrancais;
}

?>