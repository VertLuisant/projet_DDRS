<?php
//Permet la connexion a la base de donnees ainsi que la recuperation d'informations.

// Connexion à la base de donnees
function connectBd(){
	$hote='ouebe.polytech.univ-montp2.fr';
	$user='polytech_energy0';
	$pwd='NRJ_ReadOnly';
	$bd='polytech_energy'; 
	$bdd = new PDO("mysql:host=".$hote.";dbname=".$bd, $user, $pwd);
	return $bdd;
}

// Recuperation des informations sur la table $table suivant les conditions $condition
function recupData($bdd, $table, $condition="1"){
  	$data = $bdd->query("SELECT * FROM ".$table." WHERE ".$condition);
	return $data;
}
?>