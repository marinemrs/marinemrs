<?php
// inscription.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: text/html; charset=utf-8");

require(__DIR__ . "/param.inc.php");

require(__DIR__ . "/src/Membres/Administrer.php");

$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS);

if (isset($_POST['forminscription'])) {
	var_dump($_POST);

	if (
		!empty($_POST['pseudo'])
		and !empty($_POST['mailinscription'])
		and !empty($_POST['mailinscription2'])
		and !empty($_POST['mdpconnect'])
		and !empty($_POST['mdpconnect2'])
	) {
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$mail = htmlspecialchars($_POST['mailinscription']);
		$mail2 = htmlspecialchars($_POST['mailinscription2']);
		$mdp = $_POST['mdpconnect'];
		$mdp2 = $_POST['mdpconnect2'];

		if ($mail == $mail2) {
			if (strlen($mdp) < 4) {
				$erreur = "Votre mot de passe doit posséder au moins 4 caractères !";
			} else if ($mdp == $mdp2) {
				try {
					$administrerMembres->inscrire($pseudo, $mail, $mdp);
					 // Redirection vers la page profil.php après inscription réussie
					 header("Location: connexion.php");
				} catch (Exception $e) {
					$erreur = $e->getMessage();
				}
			} else {
				$erreur = "Vos mots de passes ne correspondent pas !";
			}
		} else {
			$erreur = "Vos adresses mail ne correspondent pas !";
		}
	} else {
		$erreur = "Tous les champs doivent être complétés !";
	}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Inscription</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="styles.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
	<script src="script.js" defer></script>
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
	<div class="content-wrapper">
		<div class="wrapper" id="login-wrapper">
			<img class="logo__i" src="./media/img/GL Logo 2.png" alt="">
			<h2>Inscription</h2>
			<form method="post" action="inscription.php">
				<div class="input-box">
					<input type="text" placeholder="" id="pseudo" name="pseudo" value="<?php if (isset($_POST['pseudo'])) {
																										echo (htmlspecialchars($_POST['pseudo']));
																									} ?>" />
					<label for="pseudo">Pseudo</label>
					<i class='bx bxs-user'></i>
				</div>
				<div class="input-box">
					
					<input type="email" placeholder="" id="mail" name="mailinscription" value="<?php if (isset($_POST['mailinscription'])) {
																														echo (htmlspecialchars($_POST['mailinscription']));
																													} ?>" />
					<label for="mailinscription">Mail</label>
					<i class='bx bxs-envelope'></i>
				</div>
				<div class="input-box">
					
					<input type="email" placeholder="" id="mail2" name="mailinscription2" value="<?php if (isset($_POST['mailinscription2'])) {
																																	echo (htmlspecialchars($_POST['mailinscription2']));
																																} ?>" />
					<label for="mailinscription2">Confirmez votre mail</label>
					<i class='bx bxs-envelope'></i>
				</div>
				<div class="input-box">
					<input type="password" name="mdpconnect" placeholder="" id="mdp"  />
					<label for="mdpconnect">Mot de passe</label>
					<i id="toggleLock" class='bx bxs-lock-alt'></i>
					<i id="togglePassword" class='bx bx-hide'></i>
				</div>
				<div class="input-box">
					<input type="password" name="mdpconnect2" placeholder="" id="mdp2"  />
					<label for="mdpconnect2">Confirmez votre mot de passe</label>
					<i id="toggleLock" class='bx bxs-lock-alt'></i>
					<i id="togglePassword" class='bx bx-hide'></i>
				</div>
				<button type="submit" class="btn__inscription" name="forminscription">Créer mon compte</button>
				<div class="register-link">
					<p>Vous avez déjà un compte ? <a href="connexion.php">Me connecter</a></p>
				</div>
				<?php
				if (isset($_POST['forminscription'])) {
					if (isset($erreur)) {
				?>
						<div>
							<p><?php echo ($erreur); ?></p>
						</div>
					<?php
					} else {
					?>
						<div>
							<p>Votre compte a bien été créé !</p>
						</div>
				<?php
					}
				}
				?>
			</form>
		</div>
	</div>
</body>

</html>