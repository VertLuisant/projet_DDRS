
	
var treeData = 
    [{title: "Total", key: "total", 
      children: [
        {title: "Batiment est", key:"batiment_est" ,
          children: [
            {title: "serveur est", key: "serveur_est" }
          ]
        },
        {title: "Extention ouest",key:"extention_ouest" ,
          children: [
            {title: "capteur 1", key: "ouest_capteur1" },
            {title: "capteur 2", key: "ouest_capteur2" },
			{title: "capteur 3", key: "ouest_capteur3" }
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
			$('#module').append('<div id="titleGraphe" class="title">Graphe</div>'
								+ '<canvas id="graphe" width="1360" height="300" ></canvas>');
				var options ={
				scaleOverlay : true,
				scaleOverride : true,
				scaleStartValue : 0,
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 13
			};
			//On affiche les deux graphiques
			var ctx = $('#graphe').get(0).getContext("2d");
			var chart = new Chart(ctx);
			new Chart(ctx).Line(data.donnees,options);
		});
}