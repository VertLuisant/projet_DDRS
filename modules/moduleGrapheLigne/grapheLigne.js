function affichageGrapheLigne(fichierPhp){
	$.ajax({
		url: "modules/moduleGrapheLigne/"+fichierPhp,
		dataType:'JSON',
		success:function(data){
			//On initialise le contenu de la balise div module
			$('#module').html('');
			$('#module').append('<div id="titleGraphe" class="title"></div>'
								+ '<canvas id="grapheSemainePrecedente" width="1360" height="300" ></canvas>'
								+ '<div id="semainePrecedente"></div>'
								+ '<div id="titleSemainePrecedent" class="nomSemaine"></div>'
								+ '<canvas id="grapheSemaineActuelle" width="1360" height="300"></canvas>'
								+ '<div id="semaineActuelle"></div>'
								+ '<div id="titleSemaineActuelle" class="nomSemaine"></div>');
								
			//options graphique pour le graphe
			var options ={
				scaleOverlay : true,
				scaleOverride : true,
				scaleSteps : 10,
				scaleStepWidth : ((data.valeurMax - 0) / 10),
				scaleStartValue : 0,
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 13
			}
			
			//On affiche les deux graphiques
			var ctx = $('#grapheSemainePrecedente').get(0).getContext("2d");
			var chartSemainePrecedent = new Chart(ctx);
			new Chart(ctx).Line(data.dateSemainePrecedent,options);
			
			var ctx2 = $('#grapheSemaineActuelle').get(0).getContext("2d");
			var chart = new Chart(ctx2);
			new Chart(ctx2).Line(data.dateSemaineActuelle,options);
			
			//On affiche les titres du graphiques dans les balises prévues à cet effet
			$('#titleGraphe').html('Consommation électrique de la semaine');
			$('#titleSemainePrecedent').html('Semaine du '+data.dateDebutSemainePrecedente);
			$('#titleSemaineActuelle').html('Semaine du '+data.dateDebutSemaineActuelle);
			
			//On génère la liste des labels présents sous les graphiques
			$('#semainePrecedente').width($('#grapheSemainePrecedente').width());
			$('#semaineActuelle').width($('#grapheSemaineActuelle').width());
			var tailleDivJour = ($('#grapheSemainePrecedente').width()-70)/7;
			
			for (i = 0; i < 7; i++){
				var contenuLabelSemainePrecedente = '<div class="labelJour" style="width:'+tailleDivJour+'px; ';
				var contenuLabelSemaineActuelle = '<div class="labelJour" style="width:'+tailleDivJour+'px; ';
				if(i == 0){
					//si c'est le 1er label (lundi), on le décale afin d'être bien aligné
					contenuLabelSemainePrecedente += 'margin-left:40px;';
					contenuLabelSemaineActuelle += 'margin-left:40px;';
				}
				if(i == 6){
					//si c'est le dernier label (dimanche) on rajoute une bordure à droite
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