<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html>
	<head>
		<title>Page de Test php</title>
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
	</head>
	
	<body>
		<?php
			include_once "connectBD.php";
			include_once "calculMoyenne.php";
			$bdd = connectBD();
			/*
			$res = recupData($bdd, "serveur_est");
			while ($donnees = $res->fetch())
			{
				echo "<p>".$donnees["Annee"]." ".$donnees["Mois"]." ".$donnees['Jour']." ".$donnees['Heure']." ".$donnees['Minute']." ".$donnees['Capteur1']."</p>";
				//echo "<p>".$donnees["date"]."  ".$donnees["measure"]."</p>";
			}
			
			*/
			
			/*
			$dateHeure=date("d-m-Y",strtotime("21-04-2014"));
			moyenneJour($bdd,"extension_ouest",$dateHeure,"Capteur1");
			*/
			
		?>
		
		<div id=module>
			Hello World !
		</div>
		
		<script type="text/javascript">
			$.getJSON( "modules.json", function(json) {
				var i = 0;
				
				setInterval(function(){
					changerModule(json.modules[i].nom, json.modules[i].fonction);
					i = i + 1;
					if(i >= json.modules.length){
						i = 0;
					}
				}, 5000);
			});
		</script>
	</body>
</html>