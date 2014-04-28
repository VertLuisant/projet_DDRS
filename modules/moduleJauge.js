function affichageJauge(fichierPhp){
	$('#module').html(''); //Supprime le contenu de la balise div module
	$('#module').append('<div id="jauge"></div><div id="bottom"></div><div id="message"></div>');
	
	$.ajax({
		url: "modules/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			//affiche la jauge dans la balise div jauge
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
			//affiche le message indiquant la consommation dans la balise div message
			$('#message').html('Cela correspond à : ');
			if(data.valeur<8000){
				$('#message').append('<img class="image" src="image/radiateur.jpg" />');
			}else if(data.valeur<10000){
				$('#message').append('<img class="image" src="image/radiateur.jpg" />');
			}else{
				$('#message').append('<img class="image" src="image/radiateur.jpg" />');
			}
			//affiche la date de releve dans la balise div bottom
			$('#bottom').html('Relevé le '+data.date);
		}
		
	});
}