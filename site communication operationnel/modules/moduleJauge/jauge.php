<?php
	include_once "../../utils/calculMoyenne.php";
	include_once "../../utils/fonctions.php";
	
	echo json_encode (array(
							"valeur" => consommationActuelle(),
							"date" => ecritureDate(date('d-M-Y')).' '.date('H:i:s')
							));
?>