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
				title: "Consommation électrique actuelle du bâtiment 31",
				titleFontColor: "#004A75",
				label: "Watt",
				shadowOpacity: 0.6,
				shadowSize: 0,
				shadowVerticalOffset:10
			});
			
			//On affiche le message indiquant la consommation dans la balise div message
			$('#message').html('Cela correspond à la consommation de : <br />');
			if(data.valeur<5000){
				$('#message').append('<img class="image" src="design/image/machine_a_laver.png" />');
			$('#message').append('<div id="MessageInfo">Une machine à laver</div>');
			}else if(data.valeur<8000){
				$('#message').append('<img class="image" src="design/image/plaque_induction.jpeg" />');
				$('#message').append('<div id="MessageInfo">une plaque à induction</div>');
			}else if(data.valeur<15000){
				$('#message').append('<img class="image" src="design/image/chaudiere1.jpg" />');
				$('#message').append('<div id="MessageInfo">Une chaudière</div>');
			}else if(data.valeur<30000){
				$('#message').append('<img class="image" src="design/image/chaudiere2.jpg" />');
				$('#message').append('<div id="MessageInfo">2 chaudières</div>');
			}else if(data.valeur<50000){
				$('#message').append('<img class="image" src="design/image/chaudiere3.jpg" />');
				$('#message').append('<div id="MessageInfo">3 chaudières</div>');
			}else{
				//au dela de 50000
				$('#message').append('<img class="image" src="design/image/voiture_citadine.jpg" />');
				$('#message').append('<div id="MessageInfo">Une voiture citadine</div>');
			}
			
			//affiche la date de relevé dans la balise div bottom
			$('#bottom').html('Relevé le '+data.date);
		}
	});
}