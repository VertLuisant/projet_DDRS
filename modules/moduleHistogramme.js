function affichageHistogramme(fichierPhp){
	$('#module').html(''); //Supprime le contenu de la balise div module
	$('#module').append('<div id="consommationParMois" class="title"></div><canvas id="histogramme" width="1300" height="600"></canvas>');
	
	$.ajax({
		url: "modules/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			var ctx = $('#histogramme').get(0).getContext("2d");
			var myNewChart = new Chart(ctx);
			var options ={
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 15
			}
			
			new Chart(ctx).Bar(data,options);
			
			$('#consommationParMois').html('Consommation électrique par mois');
		}
		
	});
}