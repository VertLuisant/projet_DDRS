<?php
	include_once "../connectBD.php";
	
	$bdd = connectBD();
	$res = recupData($bdd, "serveur_est", "1 ORDER BY `Annee` DESC , `Mois` DESC , `Jour` DESC, `Heure` DESC, `Minute` DESC
LIMIT 0 , 1");
	$donnee = $res->fetch();
	echo json_encode (array(
							"valeur" => $donnee['Capteur1'],
							"date" => date('d/m/Y H:i:s')
							));
?>