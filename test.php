<html>
	<head>
		<title>Page de Test php</title>
	</head>
	
	<body>
		<?php
			include "connectBD.php";
			
			$bdd = connectBD();
			$res = recupData($bdd, "serveur_est");
			while ($donnees = $res->fetch())
			{
				echo "<p>".$donnees["Annee"]." ".$donnees["Mois"]." ".$donnees['Jour']." ".$donnees['Heure']." ".$donnees['Minute']." ".$donnees['Capteur1']."</p>";
				//echo "<p>".$donnees["date"]."  ".$donnees["measure"]."</p>";
			}
			
			// retourner combien de jour par moi
			$year = 2012;
			$moi = 2;
			$nbday = date('t',mktime(0,0,0,$moi,1,$year));
			echo $nbday;
			echo date("d-m-Y",strtotime(gmdate("d-m-Y",mktime(0,0,0,$moi,1,$year)). "+1 hour"));
		?>
	</body>
</html>