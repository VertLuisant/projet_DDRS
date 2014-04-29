<?php
//Permet la connexion a la base de donnees ainsi que la recuperation d'informations.

// Connexion à la base de donnees

$bdd;

function connectBd(){
	global $bdd;
	$hote='ouebe.polytech.univ-montp2.fr';
	$user='polytech_energy0';
	$pwd='NRJ_ReadOnly';
	$bd='polytech_energy'; 
	$bdd = new PDO("mysql:host=".$hote.";dbname=".$bd, $user, $pwd);
}

// Recuperation des informations sur la table $table suivant les conditions $condition
function recupData($table, $condition="1"){
	global $bdd;
	if(! isset($bdd)){
		connectBd();
	}
  	$data = $bdd->query("SELECT * FROM ".$table." WHERE ".$condition);
	return $data;
}
?>