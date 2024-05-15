<?php
	/*// Configuration pour le serveur la-perso.univ-lemans.fr
	if(!defined("MYHOST"))
		define("MYHOST","localhost");
	if(!defined("MYUSER"))
		define("MYUSER","mmi1_i2300065"); // Indiquer votre identifiant
	if(!defined("MYPASS"))
		define("MYPASS","0144AD"); // Indiquer votre mot de passe (6 derniers codes de votre Identité Nationale de l'Etudiant)
	if(!defined("MYDB"))
		define("MYDB","mmi1_i2300065"); // Indiquer votre identifiant
	*/
		
	// Configuration pour le serveur de XAMPP (sur votre ordinateur)
	
	// Définition des paramètres de connexion pour le serveur local XAMPP
	if(!defined("MYHOST"))
		define("MYHOST","localhost"); // L'hôte est généralement 'localhost' pour le serveur local
	if(!defined("MYUSER"))
		define("MYUSER","root"); // Nom d'utilisateur par défaut pour MySQL sur XAMPP
	if(!defined("MYPASS"))
		define("MYPASS",""); // Mot de passe par défaut pour MySQL sur XAMPP (laissez vide si aucun)
	if(!defined("MYDB"))
		define("MYDB","GengoLearn"); // Nom de la base de données à utiliser
?>
