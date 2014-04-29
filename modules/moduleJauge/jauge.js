function affichageJauge(fichierPhp){
	$.ajax({
		url: "modules/moduleJauge/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			//On initialise le contenu de la balise div module
			$('#module').html(''); 
			$('#module').append('<div id="jauge"></div>'
								+'<div id="bottom"></div>'
								+'<div id="message"></div>');
								
			//On affiche la jauge dans la balise div jauge
			var jauge = new JustGage({
				id: "jauge",
				value: data.valeur,
				min: 5000,
				max: 35000,
				title: "Consommation électrique actuelle",
				titleFontColor: "#004A75",
				label: "Watt",
				shadowOpacity: 0.6,
				shadowSize: 0,
				shadowVerticalOffset:10
			});
			
			//On affiche le message indiquant la consommation dans la balise div message
			$('#message').html('Cela correspond à : ');
			if(data.valeur<8000){
				$('#message').append('<img class="image" src="design/image/radiateur.jpg" />');
			}else if(data.valeur<10000){
				$('#message').append('<img class="image" src="design/image/radiateur.jpg" />');
			}else{
				$('#message').append('<img class="image" src="design/image/radiateur.jpg" />');
			}
			
			//affiche la date de relevé dans la balise div bottom
			$('#bottom').html('Relevé le '+data.date);
		}
	});
}