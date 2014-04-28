<?php
	include_once "../calculMoyenne.php";
	include_once "../connectBD.php";
	
	$bdd = connectBD();
	echo json_encode (array(
							"valeur" => consommationActuelle($bdd),
							"date" => date('d/m/Y H:i:s')
							));
?>