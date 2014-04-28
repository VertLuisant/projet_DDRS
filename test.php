<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css"/>
		<title>Page de Test php</title>
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="modules/moduleJauge.js"></script>
		<script type="text/javascript" src="modules/moduleHistogramme.js"></script>
		<script type="text/javascript" src="modules/moduleGrapheLigne.js"></script>
		<script type="text/javascript" src="js/raphael.2.1.0.min.js"></script>
		<script type="text/javascript" src="js/justgage.1.0.1.min.js"></script>
		<script type="text/javascript" src="js/Chart.min.js"></script>
	</head>
	
	<body>
		<!--  div module est l'endoit ou s'afficheront les graphiques generes par le javascript -->
		<div id="module"></div>
		
		
		<!-- Script permettant le changement de module -->
		<script type="text/javascript">
	
		
			$.getJSON( "modules.json", function(json) {
				var i = 0;
				changerModule(json.modules[i].nomFichierPhp, json.modules[i].nomFonctionJs);
				setInterval(function(){
					i = i + 1;
					if(i >= json.modules.length){
						i = 0;
					}
					changerModule(json.modules[i].nomFichierPhp, json.modules[i].nomFonctionJs);
				}, 10000);
				//changerModule(json.modules[1].nomFichierPhp, json.modules[1].nomFonctionJs);
			});
		</script>
	</body>
</html>