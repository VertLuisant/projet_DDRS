<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="design/style.css"/>
		<title>Page de Test php</title>
		
		<!-- librairie pour fonction générique-->
		<script type="text/javascript" src="js/fonctions.js"></script>
		
		<!-- les modules-->
		<script type="text/javascript" src="modules/moduleJauge/jauge.js"></script>
		<script type="text/javascript" src="modules/moduleHistogramme/histogramme.js"></script>
		<script type="text/javascript" src="modules/moduleGrapheLigne/grapheLigne.js"></script>
		
		<!-- librairie jquery -->
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		
		<!-- librairie javascript graphique -->
		<script type="text/javascript" src="js/raphael.2.1.0.min.js"></script>
		<script type="text/javascript" src="js/justgage.1.0.1.min.js"></script>
		<script type="text/javascript" src="js/Chart.min.js"></script>
	</head>
	
	<body>
		<!--  div module est l'endoit ou s'afficheront les graphiques générés par le javascript -->
		<div id="module"></div>
		
		
		<!-- Script permettant le changement de module -->
		<script type="text/javascript">
			$.getJSON("modules.json.php", function(json) {
				changerModule(json.modules[1].nomFichierPhp, json.modules[1].nomFonctionJs);
			});
		</script>
	</body>
</html>