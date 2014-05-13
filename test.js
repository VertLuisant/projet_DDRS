
	
var treeData = 
    [{title: "Total", key: "total", 
      children: [
        {title: "Batiment_est",  
          children: [
            {title: "serveur_est", key: "serveurEst" }
          ]
        },
        {title: "Extention_ouest",
          children: [
            {title: "capteur 1", key: "ouestCapteur1" },
            {title: "capteur 2", key: "ouestCapteur2" },
			{title: "capteur 3", key: "ouestCapteur3" }
          ]
        }
      ]
    }
 ];
 
 var capteurChoisi;
 
	$(function(){
		// --- Initialize  tree
		$("#tree").fancytree({
		  checkbox: true,
		  selectMode: 3,
		  source: treeData,
		  select: function(event, data) {
			// Get a list of all selected nodes, and convert to a key array:
			  capteurChoisi = $.map(data.tree.getSelectedNodes(), function(node){
			  return node.key;
			});
		   
		  },
		  dblclick: function(event, data) {
			data.node.toggleSelected();
		  },
		  keydown: function(event, data) {
			if( event.which === 32 ) {
			  data.node.toggleSelected();
			  return false;
			}
		  }
		});
		
		window.onload = function(){
			new JsDatePick({
				useMode:2,
				target:"calendarDateDebut",
				dateFormat:"%d-%M-%Y"
			});
			new JsDatePick({
				useMode:2,
				target:"calendarDateFin",
				dateFormat:"%d-%M-%Y"
			});
		};
	  });
	  
	function dateToString(date){
	 return date.getDate()+'-'+(date.getMonth()+1)+'-'+date.getFullYear();
	}
   //recuper les options
	function getss()
	{
	var dateDebut=new Date(document.getElementById("calendarDateDebut").value);  
	var dateFin=new Date(document.getElementById("calendarDateFin").value);  
	var moyenne=document.getElementById("moyenne").value;
	 if(dateDebut>dateFin){
	  alert("date debut est superieur que date fin");
	 }else if(document.getElementById("calendarDateDebut").value==""||document.getElementById("calendarDateFin").value==""){
	  alert("il faut choisir la date debut et la date fin");
	 }
	 if(capteurChoisi.length<1){
	  alert("il faut choisir un capteur");
	 }
	 $('#echoSelection').text(capteurChoisi);
	 var envoiDonnees=$.post("graphe.php",{"dateDebut":dateToString(dateDebut),"dateFin":dateToString(dateFin),"capteur":capteurChoisi,"moyenne":moyenne});

	 envoiDonnees.done(function(data){
			//On initialise le contenu de la balise div module
			$('#module').html('');
			$('#module').append('<div id="titleGraphe" class="title"></div>'
								+ '<canvas id="graphe" width="1360" height="300" ></canvas>'
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
			var ctx = $('#graphe').get(0).getContext("2d");
			var chartSemainePrecedent = new Chart(ctx);
			new Chart(ctx).Line(data.dateSemainePrecedent,options);
			
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
		});
}