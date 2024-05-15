<?php
// connexion.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header("Content-Type: text/html; charset=utf-8");

require __DIR__ . "/param.inc.php";

require __DIR__ . "/src/Membres/Administrer.php";

$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);
if (isset($_POST['formconnexion'])) {
    try {
        $user = $administrerMembres->connecter($_POST['mailconnect'], $_POST['mdpconnect']);
        $_SESSION['id_membre'] = $user['id_membre'];
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['mail'] = $user['mail'];
        header("Location: profil.php");
    } catch (Exception $e) {
        $erreur = $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
		<script src="script.js" defer></script>
    	<title>Connexion</title>
	</head>

	<header class="header">

        <a href="index.html" class="logo">
            <img src="./media/img/GL Logo.png" alt="">
        </a>

        <nav class="navbar">
            <div id="close" class="fas fa-times"></div>

            <a href="index.html" class="nav_item">Acceuil</a>
            <a href="inscription.php" class="nav_item">Inscription</a>
            <a href="connexion.php" class="nav_item">Connexion</a>

        </nav>

        <div id="menu" class="fas fa-bars"></div>

    </header>
	<body>
		
		<div class="wrapper" id="login-wrapper">
			<form method="post" action="connexion.php">
				<img class="logo__i" src="./media/img/GL Logo 2.png" alt="">
            	<h2>Connexion</h2>
				<div class="input-box">
					<input type="email" name="mailconnect" placeholder="" aria-label="email" required/>
					<label for="mailconnect">Adresse mail</label>
					<i class='bx bxs-user'></i>
				</div>
				<div class="input-box">
					<input type="password" name="mdpconnect" placeholder="" aria-label="mot de passe" required/>
					<label for="mdpconnect">Mot de passe</label>
					<i id="toggleLock"class='bx bxs-lock-alt' ></i>
					<i id="togglePassword" class='bx bx-hide'></i>
				</div>
				<button type="submit" class="btn__connexion" name="formconnexion">Se connecter</button>
				<div class="register-link">
                <p>Vous n'avez pas de compte ? <a href="inscription.php">Créer un compte</a></p>
            	</div>
<?php
if (isset($erreur)) {
    ?>
				<div ></div>
					<p><?php echo ($erreur); ?></p>
				</div>
<?php
}
?>
			
		</div>
	</body>
</html>