function changerModule(fichierPhp, fonctionJs){
	var fn = new Function(fonctionJs+'("'+fichierPhp+'")');
	fn();
}
