<?php

namespace Membres;

use PDO;
use SplFileObject;
use Exception;

/**
 * Administrer
 */
class Administrer
{

	private $myHost;

	private $myDb;

	private $myUser;

	private $myPass;

	private $debug;

	/**
	 * Administrer
	 *
	 * @param string $myHost
	 * @param string $myDb
	 * @param string $myUser
	 * @param string $myPass
	 *
	 * @return Administrer
	 */
	function __construct($myHost = null, $myDb = null, $myUser = null, $myPass = null)
	{
		$this->myHost = $myHost;
		$this->myDb = $myDb;
		$this->myUser = $myUser;
		$this->myPass = $myPass;

		$this->debug = true;
	}

	/**
	 * Installer la base de données
	 *
	 * @return Administrer
	 */
	public function installerBaseDeDonnees()
    {
		try{
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost, $this->myUser, $this->myPass);
			$pdo->query("CREATE DATABASE IF NOT EXISTS " . $this->myDb . " DEFAULT CHARACTER SET utf8 COLLATE utf8_bin");
			$pdo = null;
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$requetesSQL = <<<EOF
			DROP TABLE IF EXISTS membre ;
			CREATE TABLE membre (
			id_membre INT NOT NULL AUTO_INCREMENT,
			pseudo VARCHAR(255), 
			mail VARCHAR(255),
			motdepasse TEXT,
			age INT, 
				PRIMARY KEY(id_membre) ) ;
EOF;
			$tabRequetesSQL = explode(";", $requetesSQL) ;
			foreach($tabRequetesSQL as $requeteSQL) {
				if(trim($requeteSQL) != "") {
					$pdo->query($requeteSQL);
				}
			}
			
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;  
		}
		catch(Exception $e) {
			if ($this->debug) {
				echo($e->getMessage()) ;
			}
		}
		
        return $this;
    }

	/**
	 * Inscrire un nouveau membre
	 *
	 * @param string $pseudo
	 * @param string $mail
	 * @param string $mdp
	 *            
	 * @exception string
	 */
	public function inscrire($pseudo, $mail, $mdp)
	{
		$erreur = "";
		if (
			!empty($pseudo)
			and !empty($mail)
			and !empty($mdp)
		) {
			$pseudo = htmlspecialchars($pseudo);
			$mail = htmlspecialchars($mail);
			$mdp = sha1($mdp);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$pseudolength = mb_strlen($pseudo);
			if ($pseudolength <= 255) {
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$statement = $pdo->prepare("SELECT * FROM membre WHERE mail = ?");
					$statement->execute(array($mail));
					$ligne = $statement->fetch(PDO::FETCH_ASSOC);
					if ($ligne == false) {
						// Etape 2 : envoi de la requête SQL au serveur
						$statement = $pdo->prepare("INSERT INTO membre(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
						$statement->execute(array($pseudo, $mail, $mdp));
					} else {
						$erreur = "Adresse mail déjà utilisée !";
					}
				} else {
					$erreur = "Votre adresse mail n'est pas valide !";
				}
			} else {
				$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}
		if ($erreur != "") {
			throw new Exception($erreur);
		}
	}

	/**
	 * Connecter un nouveau membre
	 *
	 * @param string $mailconnect
	 * @param string $mdpconnect
	 *            
	 * @exception string
	 * @return array $user (tableau associatif) ou null
	 */
	public function connecter($mailconnect, $mdpconnect)
	{
		$erreur = "";
		$user = null;
		if (
			!empty($mailconnect)
			and !empty($mdpconnect)
		) {
			$mailconnect = htmlspecialchars($mailconnect);
			$mdpconnect = sha1($mdpconnect);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Etape 2 : envoi de la requête SQL au serveur
			$statement = $pdo->prepare("SELECT * FROM membre WHERE mail = ? AND motdepasse = ? ");
			$statement->execute(array($mailconnect, $mdpconnect));
			$user = $statement->fetch(PDO::FETCH_ASSOC);
			if ($user == false) {
				$erreur = "Mauvais mail ou mot de passe !";
				$user = null;
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}

		if ($erreur != "") {
			throw new Exception($erreur);
		}

		return $user;
	}

	/**
	 * Obtenir un membre
	 *
	 * @param int $id (identifiant du membre)
	 *
	 * @return array $user (tableau associatif) ou null
	 */
	public function obtenirMembre($id = null)
	{
		$user = null;
		if ($id != null) {
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Etape 2 : envoi de la requête SQL au serveur
			$statement = $pdo->prepare("SELECT * FROM membre WHERE id_membre = ?");
			$statement->execute(array($id));
			// Etape 3 : récupère les données
			$user = $statement->fetch(PDO::FETCH_ASSOC);
			if ($user == false) {
				$user = null;
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		}
		return $user;
	}

	/**
	 * Mettre à jour l'un des membres
	 *
	 * @param int $id (identifiant du membre)
	 * @param string $newpseudo
	 * @param string $newmail
	 * @param string $newmdp
	 * @param int $newage
	 * @exception string
	 * @return array $user (tableau associatif) ou null
	 */
	public function mettreAJour($id = null, $newpseudo = null, $newmail = null, $newmdp = null, $newage = null,)
	{
		$erreur = "Aucune modification !";
		if ($id != null) {
			$user = $this->obtenirMembre($id);
			$erreur = "";

			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			if (isset($newpseudo) and !empty($newpseudo) and $newpseudo != $user['pseudo']) {
				$newpseudo = htmlspecialchars($newpseudo);
				$pseudolength = mb_strlen($newpseudo);
				if ($pseudolength <= 255) {
					$statement = $pdo->prepare("UPDATE membre SET pseudo = ? WHERE id_membre = ?");
					$statement->execute(array($newpseudo, $id));
				} else {
					$erreur = $erreur . "Votre pseudo ne doit pas dépasser 255 caractères !</br>";
				}
			}
			if (isset($newmail) and !empty($newmail) and $newmail != $user['mail']) {
				$newmail = htmlspecialchars($newmail);
				if (filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
					$statement = $pdo->prepare("UPDATE membre SET mail = ? WHERE id_membre = ?");
					$statement->execute(array($newmail, $id));
				} else {
					$erreur = $erreur . "Votre adresse mail n'est pas valide !</br>";
				}
			}
			if (isset($newmdp) and !empty($newmdp)) {
				if (mb_strlen($newmdp) >= 4) {
					$newmdp = sha1($newmdp);
					$statement = $pdo->prepare("UPDATE membre SET motdepasse = ? WHERE id_membre = ?");
					$statement->execute(array($newmdp, $id));
				} else {
					$erreur = $erreur . "Votre mot de passe doit posséder au moins 4 caractères !</br>";
				}
			}

			if (isset($newage) and !empty($newage)) {
				if (is_numeric($newage)) {
					$statement = $pdo->prepare("UPDATE membre SET age = ? WHERE id_membre = ?");
					$statement->execute(array($newage, $id));
				} else {
					$erreur = $erreur . "Votre age doit être un chiffre !</br>";
				}
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		}
		if ($erreur != "") {
			throw new Exception($erreur);
		}

		return $this->obtenirMembre($id); // Utilisateur avec les données mises à jour
	}
}
