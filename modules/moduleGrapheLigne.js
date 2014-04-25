function affichageGrapheLigne(fichierPhp){
	$('#module').html(''); //Supprime le contenu de la balise div module
	$('#module').append('<div id="titleSemainePrecedant"></div><canvas id="graphe2" width="1360" height="300" ></canvas><div id="title"></div><canvas id="graphe" width="1360" height="300" ></canvas>');
	
	$.ajax({
		url: "modules/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			//affiche la grahpe Ligne
			var ctx = $('#graphe').get(0).getContext("2d");
			var chart = new Chart(ctx);
			var donnees=data;
			new Chart(ctx).Line(donnees.dateActuelle);
			
			var ctx2 = $('#graphe2').get(0).getContext("2d");
			var chartSemainePrecedant = new Chart(ctx2);
			new Chart(ctx2).Line(donnees.dateSemainePrecedant);
			
			$('#titleSemainePrecedant').html('Semaine du: '+donnees.datePrecedantDe);
			$('#title').html('Semaine du: '+donnees.dateActuelleDe);
		}
		
	});
}