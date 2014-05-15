<?php
	include_once "../../utils/calculMoyenne.php";
	include_once "../../utils/fonctions.php";
	
	echo json_encode (array(
							"valeur" => round(consommationActuelle()/1000,2),
							"date" => ecritureDate(date('d-M-Y')).' '.date('H:i:s')
							));
?>