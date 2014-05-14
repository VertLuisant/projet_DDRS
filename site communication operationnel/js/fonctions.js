//Contient toutes les fonctions générique javascript


//Fonction permettant de changer de module, on apelle la fonction fonctionJs qui utilisera le fichier php passé en paramètre.
function changerModule(fichierPhp, fonctionJs){
	var fn = new Function(fonctionJs+'("'+fichierPhp+'")');
	fn();
}
