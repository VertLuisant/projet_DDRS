function affichageHistogramme(fichierPhp){
	$('#module').html(''); //Supprime le contenu de la balise div module
	$('#module').append('<canvas id="histogramme" width="1300" height="600"></canvas>');
	
	$.ajax({
		url: "modules/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			var ctx = $('#histogramme').get(0).getContext("2d");
			var myNewChart = new Chart(ctx);
			
			var donneesHistogramme = data;
			
			new Chart(ctx).Bar(data);
		}
		
	});
}