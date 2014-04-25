function affichageGrapheLigne(fichierPhp){
	$('#module').html(''); //Supprime le contenu de la balise div module
	$('#module').append('<div id="titleSemainePrecedent"></div><canvas id="grapheSemainePrecedente" width="1360" height="300" ></canvas><div id="titleSemaineActuelle"></div><canvas id="grapheSemaineActuelle" width="1360" height="300" ></canvas>');
	
	$.ajax({
		url: "modules/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			//affiche la grahpe Ligne
			var ctx2 = $('#grapheSemainePrecedente').get(0).getContext("2d");
			var chartSemainePrecedent = new Chart(ctx2);
			new Chart(ctx2).Line(data.dateSemainePrecedent);
			
			var ctx = $('#grapheSemaineActuelle').get(0).getContext("2d");
			var chart = new Chart(ctx);
			new Chart(ctx).Line(data.dateSemaineActuelle);
			
			$('#titleSemainePrecedent').html('Semaine du: '+data.datePrecedentDe);
			$('#titleSemaineActuelle').html('Semaine du: '+data.dateActuelleDe);
		}
		
	});
}