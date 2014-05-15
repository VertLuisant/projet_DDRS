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
				min: 5,
				max: 35,
				title: "Consommation électrique actuelle du bâtiment 31",
				titleFontColor: "#004A75",
				label: "Kilowatt",
				shadowOpacity: 0.6,
				shadowSize: 0,
				shadowVerticalOffset:10
			});
			
			var prixkWh = Math.round(data.valeur*0.1*100)/100;
			var prixkWan = Math.round(data.valeur*0.1*24*355*100)/100;
			$('#message').html('A 0,1€ HT le kWh, '+data.valeur+'kWh c\'est <strong>'+prixkWh+'</strong>€ HT / heure soit <strong>'+prixkWan+'</strong>€ HT / an');
				
			
			//affiche la date de relevé dans la balise div bottom
			$('#bottom').html('Relevé le '+data.date);
		}
	});
}