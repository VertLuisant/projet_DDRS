<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css"/>
		<title>Page de Test php</title>
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="modules/moduleJauge.js"></script>
		<script type="text/javascript" src="js/raphael.2.1.0.min.js"></script>
		<script type="text/javascript" src="js/justgage.1.0.1.min.js"></script>
		<script type="text/javascript" src="js/Chart.min.js"></script>
	</head>
	
	<body>
		<!--  div module est l'endoit ou s'afficheront les graphiques generes par le javascript -->
		<div id="module"><canvas id="graphe" height="600px" width="1300px"></canvas></div>
		
		
		<!-- Script permettant le changement de module -->
		<script type="text/javascript">
			//Get context with jQuery - using jQuery's .get() method.
			var ctx = $('#graphe').get(0).getContext("2d");
			//This will get the first returned node in the jQuery collection.
			
			var myNewChart = new Chart(ctx);
			
			/*var data = {
				labels : ["January","February","March","April","May","June","July"],
				datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : [28,48,40,19,96,27,100]
				}
				]
			}
			new Chart(ctx).Line(data);*/
			
			/*var data = {
	labels : ["January","February","March","April","May","June","July"],
	datasets : [
		{
			fillColor : "rgba(220,220,220,0.5)",
			strokeColor : "rgba(220,220,220,1)",
			data : [65,59,90,81,56,55,40]
		},
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			data : [28,48,40,19,96,27,100]
		}
	]
}
			new Chart(ctx).Bar(data);*/
			
		/*
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
			});*/
		</script>
	</body>
</html>