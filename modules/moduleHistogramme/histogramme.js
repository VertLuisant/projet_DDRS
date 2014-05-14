function affichageHistogramme(fichierPhp){
	$.ajax({
		url: "modules/moduleHistogramme/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			//On initialise le contenu de la balise div module
			$('#module').html('');
			$('#module').append('<div id="consommationParMois" class="title"></div>'
								+'<div class="typeOrdonneHistogramme">W</div>'
								+'<canvas id="histogramme" width="1300" height="600"></canvas>');
								
			//on affiche l'histogramme dans la balise canvas histogramme
			var ctx = $('#histogramme').get(0).getContext("2d");
			var myNewChart = new Chart(ctx);
			var options ={
				scaleOverlay : true,
				scaleOverride : true,
				scaleSteps : 10,
				scaleStepWidth : data.echelle,
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 15,
				animation : false
			}
			new Chart(ctx).Bar(data.donnees,options);
			
			//on affiche le titre
			$('#consommationParMois').html('Consommation électrique du bâtiment 31 par mois');
		}
		
	});
}