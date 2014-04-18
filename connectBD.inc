<?php

  $connexion;
  connect_bd();
  
  // Connexion à la base  
  function connect_bd()
  {
		$hote='ouebe.polytech.univ-montp2.fr';
		$user='polytech_energy0';
		$pwd='NRJ_ReadOnly';
		$bd='polytech_energy'; 
		global $connexion;
 		$connexion=mysql_connect($hote,$user,$pwd);

	$db=mysql_select_db($bd, $connexion);
  	mysql_query("SET NAMES UTF8");
  }
  
function recup_affichage()
  {
  	global $connexion;
  	$resultat_sql = mysql_query("select measure from arduino1_measurement_table ORDER BY date DESC LIMIT 1 ",$connexion);
	if (! $resultat_sql ) die("Erreur fatale dans recup_affichage".mysql_error() );
    	while ($row = mysql_fetch_row($resultat_sql) )
     	{
	        $res = $row[0];
        }
         return $res;
  } 
  
function recup_date()
  {
  	global $connexion;
  	$resultat_sql = mysql_query("select date from arduino1_measurement_table ORDER BY date DESC LIMIT 1 ",$connexion);
	if (! $resultat_sql ) die("Erreur fatale dans recup_date".mysql_error() );
    	while ($row = mysql_fetch_row($resultat_sql) )
     	{
	        $res = $row[0];
        }
         return $res;
  }    

     
?>