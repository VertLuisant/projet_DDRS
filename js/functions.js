function changerModule(fichier, fonction){
	//$('#module').html(fichier+' '+fonction);
	$.ajax({
		url: "modules/"+fichier,
		dataType:'html'
	}).done(function(arg){
		$('#module').html(arg); 
	});
}