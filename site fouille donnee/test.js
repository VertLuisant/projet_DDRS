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
		
		
	  });
	  
   //recuper les options
	function getss()
	{
	var dateDebutDecompose = $('#calendarDateDebut').val().split("-");
	var dateFinDecompose = $('#calendarDateFin').val().split("-");
	var dateDebut=new Date(dateDebutDecompose[2],dateDebutDecompose[1]-1,dateDebutDecompose[0],0,0,0);  
	var dateFin=new Date(dateFinDecompose[2],dateFinDecompose[1]-1,dateFinDecompose[0],0,0,0);   
	var moyenne=$('#moyenne').val();
	 if(dateDebut>dateFin){
	  alert("date debut est superieur que date fin");
	 }else if($('#calendarDateDebut').val()==""||$('calendarDateFin').val()==""){
	  alert("il faut choisir la date debut et la date fin");
	 }
	 if(capteurChoisi.length<1){
	  alert("il faut choisir un capteur");
	 }
	 var envoiDonnees=$.post("graphe.php",{"dateDebut":dateDebut.getDate()+"-"+(dateDebut.getMonth()+1)+"-"+dateDebut.getFullYear(),"dateFin":dateFin.getDate()+"-"+(dateFin.getMonth()+1)+"-"+dateFin.getFullYear(),"capteur":capteurChoisi,"moyenne":moyenne});
	 $('#module').html('<img class="image" src="design/loading.gif" />');
	 envoiDonnees.done(function(data){
			//On initialise le contenu de la balise div module
			$('#module').html('');
			$('#module').append('<div id="titleGraphe" class="title">Graphe</div>'
								+ '<canvas id="graphe" width="1360" height="300" ></canvas>');
			
			var dataParse = $.parseJSON(data)
				var options ={
				scaleFontFamily : "'Eurostile'",
				scaleFontColor : "#004A75",
				scaleFontSize : 13,
				pointDot:false
			};
			//On affiche les deux graphiques
			var ctx = $('#graphe').get(0).getContext("2d");
			var chart = new Chart(ctx);
			new Chart(ctx).Line(dataParse,options);
		});
	}
	
	function exportDonnees()
	{
	var dateDebutDecompose = $('#calendarDateDebut').val().split("-");
	var dateFinDecompose = $('#calendarDateFin').val().split("-");
	var dateDebut=new Date(dateDebutDecompose[2],dateDebutDecompose[1]-1,dateDebutDecompose[0],0,0,0);  
	var dateFin=new Date(dateFinDecompose[2],dateFinDecompose[1]-1,dateFinDecompose[0],0,0,0);   
	 if(dateDebut>dateFin){
	  alert("date debut est superieur que date fin");
	 }else if($('#calendarDateDebut').val()==""||$('calendarDateFin').val()==""){
	  alert("il faut choisir la date debut et la date fin");
	 }
	 if(capteurChoisi.length<1){
	  alert("il faut choisir un capteur");
	 }
	 
	 dateDebut=dateDebut.getDate()+"-"+(dateDebut.getMonth()+1)+"-"+dateDebut.getFullYear();
	 dateFin=dateFin.getDate()+"-"+(dateFin.getMonth()+1)+"-"+dateFin.getFullYear();				
	 window.location="exportDonnees.php?dateDebut="+dateDebut+"&dateFin="+dateFin+"&capteurChoisi="+capteurChoisi;
}