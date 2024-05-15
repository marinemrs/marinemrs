<?php
    // profil.php

    // Activation de l'affichage des erreurs
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    // Démarrage de la session
	session_start();

    // Définition du type de contenu de la page
	header("Content-Type: text/html; charset=utf-8");

    // Vérification de l'existence de la session et si l'utilisateur est connecté
	if(isset($_SESSION['id_membre']) AND $_SESSION['id_membre'] > 0) {
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>TUTO PHP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<main>
            <!-- Affichage du titre du profil -->
			<h1>Profil de <?php echo($_SESSION['pseudo']); ?></h1>
			<div class="colspan-2">
                <!-- Affichage des informations du profil -->
				<p>Pseudo = <?php echo($_SESSION['pseudo']); ?></p>
				<p>Mail = <?php echo($_SESSION['mail']); ?></p>
                <!-- Liens pour éditer le profil et se déconnecter -->
				<a href="editionprofil.php">Editer mon profil</a>
				<a href="deconnexion.php">Se déconnecter</a>
			</div>
		</main>
	</body>
</html>
<?php   
    }
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
	else{
		header("location: connexion.php");
	}
?>