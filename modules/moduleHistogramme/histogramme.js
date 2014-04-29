function affichageHistogramme(fichierPhp){
	$.ajax({
		url: "modules/moduleHistogramme/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			//On initialise le contenu de la balise div module
			$('#module').html('');
			$('#module').append('<div id="consommationParMois" class="title">'
								+'</div><canvas id="histogramme" width="1300" height="600"></canvas>');
								
			//on affiche l'histogramme dans la balise canvas histogramme
			var ctx = $('#histogramme').get(0).getContext("2d");
			var myNewChart = new Chart(ctx);
			var options ={
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 15
			}
			new Chart(ctx).Bar(data,options);
			
			//on affiche le titre
			$('#consommationParMois').html('Consommation électrique par mois');
		}
		
	});
}