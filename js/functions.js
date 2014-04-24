function changerModule(fichierPhp, fonctionJs){
	var fn = new Function(fonctionJs+'("'+fichierPhp+'")');
	fn();
}



function afficherDeux(){
	$('#module').html("affichage 2");
}