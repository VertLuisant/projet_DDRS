<html>
	<head>
		<title>Page de Test php</title>
	</head>
	
	<body>
		<?php
			include "connectBD.php";
			
			$bdd = connectBD();
			/*
			$res = recupData($bdd, "serveur_est");
			while ($donnees = $res->fetch())
			{
				echo "<p>".$donnees["Annee"]." ".$donnees["Mois"]." ".$donnees['Jour']." ".$donnees['Heure']." ".$donnees['Minute']." ".$donnees['Capteur1']."</p>";
				//echo "<p>".$donnees["date"]."  ".$donnees["measure"]."</p>";
			}
			
			*/
			
			//$nbday = date('t',mktime($heure,0,0,$mois,$jour,$year));
			//echo $nbday;
			$dateHeure=date("d-m-Y",strtotime("20-04-2014"));
			moyenneJour($bdd,"serveur_est",$dateHeure,"Capteur1");
		?>
	</body>
</html>