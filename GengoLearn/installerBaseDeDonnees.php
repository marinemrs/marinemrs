<?php
    // installerBaseDeDonnees.php
    
    // Activation de l'affichage des erreurs pour faciliter le débogage
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    // Inclusion du fichier de configuration des paramètres de la base de données
    require (__DIR__ . "/param.inc.php");
	
    // Inclusion de la classe pour gérer les membres (dans un éventuel dossier src/Membres)
	require (__DIR__ . "/src/Membres/Administrer.php");
	
    // Instanciation de la classe pour administrer les membres, en utilisant les paramètres de la base de données
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);
    
    // Installation de la base de données à l'aide de la méthode correspondante de la classe
    $administrerMembres->installerBaseDeDonnees();
    
    // Définition du type de contenu de la page comme étant du HTML avec l'encodage UTF-8
    header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>installerBaseDeDonnees.php</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<code>
		Tout se passe du côté serveur de base de données.<br>
		Les tables de la base de données "<?php echo(MYDB) ; ?>" ont été créées.<br>
		Sur la-perso.univ-lemans.fr, l'application <a
			href="https://la-perso.univ-lemans.fr/pma-tp" target="_blank">phpmyadmin</a>
		vous permet de vérifier.
	</code>
</body>
</html>