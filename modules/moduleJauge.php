<?php
	include_once "../calculMoyenne.php";
	
	echo json_encode (array(
							"valeur" => consommationActuelle(),
							"date" => date('d/m/Y H:i:s')
							));
?>