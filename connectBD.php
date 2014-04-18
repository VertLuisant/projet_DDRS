<?php

$bdd;

// Connexion à la base de données
function connectBd(){
	$hote='ouebe.polytech.univ-montp2.fr';
	$user='polytech_energy0';
	$pwd='NRJ_ReadOnly';
	$bd='polytech_energy'; 
	$bdd = new PDO("mysql:host=".$hote.";dbname=".$bd, $user, $pwd);
}

// Récupération des informations sur la table $table suivant les conditions $condition
function recupData($table, $condition){
  	$data = $bdd->query("SELECT * FROM ".$table." WHERE ".$condition);
	return $data;
}   
?>