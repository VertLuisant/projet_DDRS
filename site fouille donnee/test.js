window.onload = function(){
	new JsDatePick({
		useMode:2,
		target:"calendarDateDebut",
		dateFormat:"%d-%m-%Y"
	});
	new JsDatePick({
		useMode:2,
		target:"calendarDateFin",
		dateFormat:"%d-%m-%Y"
	});
	$("#hide").hide();
	$("#question").hover(function(){
		$("#hide").show(500);
	});
	$("#question").mouseout(function(){
		$("#hide").hide(500);
	})
	
	//initialize tree
	$("#listeCapteur").fancytree({
		  checkbox: true,
		  selectMode: 2,
		  source: treeData,
		  select: function(event, data) {
			// Get a list of all selected nodes, and convert to a key array:
			  capteurChoisi = $.map(data.tree.getSelectedNodes(), function(node){
			  return node.key;
			});
		   
		  },
		  click: function(event, data) {
			if( $.ui.fancytree.getEventTargetType(event) === "title" ){
              data.node.toggleSelected();
			}
		  },
		  keydown: function(event, data) {
			if( event.which === 32 ) {
			  data.node.toggleSelected();
			  return false;
			}
		  }
		});
};
	

			
var treeData = 
    [{title: "Total", key: "total", 
      children: [
        {title: "Batiment est", key:"batiment_est" ,
          children: [
            {title: "serveur est", key: "serveur_est" }
          ]
        },
        {title: "Extension ouest",key:"extension_ouest" ,
          children: [
            {title: "capteur 1", key: "ouest_capteur1" },
            {title: "capteur 2", key: "ouest_capteur2" },
			{title: "capteur 3", key: "ouest_capteur3" }
          ]
        }
      ]
    }
 ];
 
 var capteurChoisi=[];
	  
   //recuper les options
	function getss(){
		$('#messageErreur').html('');
		$('#messageAttention').html('');
		$('#graphique').html('');
		var dateDebutDecompose = $('#calendarDateDebut').val().split("-");
		var dateFinDecompose = $('#calendarDateFin').val().split("-");
		var moyenne=$('#moyenne').val();
		
		var erreur = false;
		if(capteurChoisi.length<1){
			//aucun capteur sélectionné
			$('#messageErreur').append('<br />Vous n\'avez pas choisi de capteur');
			$('#messageErreur').fadeIn("normal");
			erreur = true;
		}
		if($('#calendarDateDebut').val()==""||$('calendarDateFin').val()==""){
			//date(s) non renseignée(s)
			$('#messageErreur').append('<br />Il faut renseigner la date de debut et la date de fin');
			$('#messageErreur').fadeIn("normal");
			erreur = true;
		}else{
			var dateDebut=new Date(dateDebutDecompose[2],dateDebutDecompose[1]-1,dateDebutDecompose[0],0,0,0);  
			var dateFin=new Date(dateFinDecompose[2],dateFinDecompose[1]-1,dateFinDecompose[0],0,0,0);   
			if($('#calendarDateDebut').val() == $('#calendarDateFin').val() && moyenne != "Heure"){
				$('#messageErreur').append('<br />La période sélectionné ne contient qu\'une valeur, l\'affichage ne pourra pas fonctionner');
				$('#messageErreur').fadeIn("slow");
				erreur = true;
			}
			if(dateDebut>dateFin){
				//date de début supérieure à date de fin
				$('#messageErreur').append('<br />La date de début est supérieure à la date de fin');
				$('#messageErreur').fadeIn("slow");
				erreur = true;
			}
		}
		
		if(erreur == false){
			//aucune erreur
			var envoiDonnees=$.post("graphe.php",{"dateDebut":dateDebut.getDate()+"-"+(dateDebut.getMonth()+1)+"-"+dateDebut.getFullYear(),"dateFin":dateFin.getDate()+"-"+(dateFin.getMonth()+1)+"-"+dateFin.getFullYear(),"capteur":capteurChoisi,"moyenne":moyenne});
			$('#graphique').append('<img class="image" src="design/loading.gif" />'
									+ '<p>Le calcul peut prendre un peu de temps suivant la période sélectionnée. <br />'
									+ 'Veuillez patientez...</p>');
			
			envoiDonnees.done(function(data){
				//On initialise le contenu de la balise div Graphique
				$('#graphique').html('');
				$('#graphique').append('<div id="titleGraphe" class="title">Graphe</div>'
										+ '<canvas id="graphe" width="1360" height="300" ></canvas>');	
				var dataParse = $.parseJSON(data)
				var options ={
					scaleFontFamily : "'Eurostile'",
					scaleFontColor : "#004A75",
					scaleFontSize : 13,
					pointDot:false
				};
				
				//On affiche le graphique
				var ctx = $('#graphe').get(0).getContext("2d");
				var chart = new Chart(ctx);
				new Chart(ctx).Line(dataParse,options);
				
				//legnede du graphique
				$('#graphique').append('<ul>Legende : '
										+'<li>img fdffs </li>'
										+'<li>img fdffs </li>'
										+'<li>img fdffs </li>'
										+'</ul>');
										
				//donnees invisible pour export
				$('#graphique').append('<span class="invisible" id="dateDebutChoisi" >'+$('#calendarDateDebut').val()+'</span>');
				$('#graphique').append('<span class="invisible" id="dateFinChoisi" >'+$('#calendarDateFin').val()+'</span>');
				//bouton export
				$('#graphique').append('<input name="export" type="button" onclick="exportDonnees();" value="Export" />');
				
				
			});
		}
	}
	
	function exportDonnees(){
		var dateDebutDecompose = $('#dateDebutChoisi').val().split("-");
		var dateFinDecompose = $('#dateFinChoisi').val().split("-");
		var dateDebut=new Date(dateDebutDecompose[2],dateDebutDecompose[1]-1,dateDebutDecompose[0],0,0,0);  
		var dateFin=new Date(dateFinDecompose[2],dateFinDecompose[1]-1,dateFinDecompose[0],0,0,0);   
		
		dateDebut=dateDebut.getDate()+"-"+(dateDebut.getMonth()+1)+"-"+dateDebut.getFullYear();
		dateFin=dateFin.getDate()+"-"+(dateFin.getMonth()+1)+"-"+dateFin.getFullYear();				
		window.location="exportDonnees.php?dateDebut="+dateDebut+"&dateFin="+dateFin+"&capteurChoisi="+capteurChoisi;
}