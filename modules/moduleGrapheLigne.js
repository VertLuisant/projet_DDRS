function affichageGrapheLigne(fichierPhp){
	$('#module').html(''); //Supprime le contenu de la balise div module
	$('#module').append('<div id="titleGraphe" class="title"></div>'
					+ '<canvas id="grapheSemainePrecedente" width="1360" height="300" ></canvas>'
					+ '<div id="semainePrecedente"></div>'
					+ '<div id="titleSemainePrecedent" class="nomSemaine"></div>'
					+ '<canvas id="grapheSemaineActuelle" width="1360" height="300"></canvas>'
					+ '<div id="semaineActuelle"></div>'
					+ '<div id="titleSemaineActuelle" class="nomSemaine"></div>'
					);
	
	$.ajax({
		url: "modules/"+fichierPhp,
		dataType:'JSON',
		success:function(data){
			//options graphique pour le graphe
			var options ={
				scaleOverlay : true,
				scaleOverride : true,
				scaleSteps : 10,
				scaleStepWidth : 1300,
				scaleStartValue : 6000,
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 13
			}
			
			//affiche la grahpe Ligne
			var ctx2 = $('#grapheSemainePrecedente').get(0).getContext("2d");
			var chartSemainePrecedent = new Chart(ctx2);
			new Chart(ctx2).Line(data.dateSemainePrecedent,options);
			
			var ctx = $('#grapheSemaineActuelle').get(0).getContext("2d");
			var chart = new Chart(ctx);
			new Chart(ctx).Line(data.dateSemaineActuelle,options);
			
			$('#titleGraphe').html('Consommation électrique de la semaine');
			$('#titleSemainePrecedent').html('Semaine du '+data.dateDebutSemainePrecedente);
			$('#titleSemaineActuelle').html('Semaine du '+data.dateDebutSemaineActuelle);
			
			var tailleDivJour = ($('#grapheSemainePrecedente').width()-70)/7;
			
			for (i = 0; i < 7; i++){
				var contenuLabelSemainePrecedente = '<div class="labelJour" style="width:'+tailleDivJour+'px; ';
				var contenuLabelSemaineActuelle = '<div class="labelJour" style="width:'+tailleDivJour+'px; ';
				if(i == 6){
					contenuLabelSemainePrecedente += 'border-right:3px solid rgba(0, 59, 11, 0.5);';
					contenuLabelSemaineActuelle += 'border-right:3px solid rgba(0, 59, 11, 0.5);';
				}
				contenuLabelSemainePrecedente += '">'+data.listJourSemainePrecedente[i]+'</div>';
				contenuLabelSemaineActuelle += '">'+data.listJourSemaineActuelle[i]+'</div>';
				$('#semainePrecedente').append(contenuLabelSemainePrecedente);
				$('#semaineActuelle').append(contenuLabelSemaineActuelle);
			} 
		}
		
	});
}