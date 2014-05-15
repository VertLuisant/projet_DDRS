function affichageGrapheLigne(fichierPhp){
	$.ajax({
		url: "modules/moduleGrapheLigne/"+fichierPhp,
		dataType:'JSON',
		success:function(data){
			//On initialise le contenu de la balise div module
			$('#module').html('');
			$('#module').append('<div id="titleGraphe" class="title"></div>'
								+ '<div class="typeOrdonneLigne">W</div>'
								+ '<canvas id="grapheSemainePrecedente" width="1300" height="300" ></canvas>'
								+ '<table id="semainePrecedente"></table>'
								+ '<div id="titleSemainePrecedent" class="nomSemaine"></div>'
								+ '<div class="typeOrdonneLigne"> W </div>'
								+ '<canvas id="grapheSemaineActuelle" width="1300" height="300"></canvas>'
								+ '<table id="semaineActuelle"></table>'
								+ '<div id="titleSemaineActuelle" class="nomSemaine"></div>');
								
			//options graphique pour le graphe
			var options ={
				scaleOverlay : true,
				scaleOverride : true,
				scaleSteps : 10,
				scaleStepWidth : data.echelle,
				scaleStartValue : 0,
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 15,
				animation : false
			}
			
			//On affiche les deux graphiques
			var ctx = $('#grapheSemainePrecedente').get(0).getContext("2d");
			var chartSemainePrecedent = new Chart(ctx);
			new Chart(ctx).Line(data.dateSemainePrecedent,options);
			
			var ctx2 = $('#grapheSemaineActuelle').get(0).getContext("2d");
			var chart = new Chart(ctx2);
			new Chart(ctx2).Line(data.dateSemaineActuelle,options);
			
			//On affiche les titres du graphiques dans les balises prévues à cet effet
			$('#titleGraphe').html('Consommation électrique du bâtiment 31 par semaine');
			$('#titleSemainePrecedent').html('Semaine du '+data.dateDebutSemainePrecedente);
			$('#titleSemaineActuelle').html('Semaine du '+data.dateDebutSemaineActuelle);
			
			//On génère la liste des labels présents sous les graphiques
			$('#semainePrecedente').width($('#grapheSemainePrecedente').width()-51);
			$('#semaineActuelle').width($('#grapheSemaineActuelle').width()-51);
			
			//on affiche les heures
			var texteHeure = '<td class="labelHeure"></td>'
							+'<td class="labelHeure"></td>'
							+'<td class="labelHeure nombre"> 6</td>'
							+'<td class="labelHeure lettre">H</td>'
							+'<td class="labelHeure"></td>'
							+'<td class="labelHeure nombre">12</td>'
							+'<td class="labelHeure lettre">H</td>'
							+'<td class="labelHeure"></td>'
							+'<td class="labelHeure nombre">18</td>'
							+'<td class="labelHeure lettre">H</td>'
							+'<td class="labelHeure"></td>'
							+'<td class="labelHeureFin"></td>';
											
			var codeHTMLsemainePrecedente = '<tr>';
			var codeHTMLsemaineActuelle = '<tr>';
			for (i = 0; i < 7; i++){
				codeHTMLsemainePrecedente += texteHeure;
				codeHTMLsemaineActuelle += texteHeure;
			}
			codeHTMLsemainePrecedente += '</tr>';
			codeHTMLsemaineActuelle += '</tr>';
			
			//on affiche les jours
			codeHTMLsemainePrecedente += '<tr>';
			codeHTMLsemaineActuelle += '<tr>';
			for (i = 0; i < 7; i++){
				codeHTMLsemainePrecedente += '<td COLSPAN=12 class="labelJour">'+data.listJourSemainePrecedente[i]+'</td>';
				codeHTMLsemaineActuelle += '<td COLSPAN=12 class="labelJour">'+data.listJourSemaineActuelle[i]+'</td>';
			}
			codeHTMLsemainePrecedente += '</tr>';
			codeHTMLsemaineActuelle += '</tr>';
			
			$('#semainePrecedente').append(codeHTMLsemainePrecedente);
			$('#semaineActuelle').append(codeHTMLsemaineActuelle);
			
		}
	});
}