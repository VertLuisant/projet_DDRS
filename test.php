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
			
			$dateHeure=date("d-m-Y",strtotime("21-04-2014 09:00:00"));
			moyenneHeur($bdd,"serveur_est",$dateHeure,"Capteur1");
		?>
	</body>
</html>