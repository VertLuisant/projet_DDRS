function affichageJauge(fichierPhp){
	$('#module').html(''); //Supprime le contenu de la balise div module
	$('#module').append('<div id="jauge"></div><div id="message"></div><div id="bottom"></div>');
	
	$.ajax({
		url: "modules/"+fichierPhp,
		dataType:'JSON',
		success:function(data){	
			//affiche la jauge dans la balise div jauge
			var jauge = new JustGage({
				id: "jauge",
				value: data.valeur,
				min: 5000,
				max: 12000,
				title: "Consommation électrique actuelle",
				label: "Watt",
				shadowOpacity: 0.6,
				shadowSize: 0,
				shadowVerticalOffset:10
			});
			//affiche le message indiquant la consommation dans la balise div message
			$('#message').html('Cela correspond à : ');
			if(data.valeur<8000){
				$('#message').append('<img src="" />');
			}else {
				if(data.valeur<10000){
				}else{
				}
			}
			//affiche la date de releve dans la balise div bottom
			$('#bottom').html('Relevé le '+data.date);
		}
		
	});
}