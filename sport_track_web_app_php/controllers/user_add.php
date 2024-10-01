<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
require MODELS_DIR . "/User.php";
require DAO_DIR . "/UserDAO.php";
use controllers\Controller;
use User;
use SqliteConnection;
use UserDAO;
use PDOException;

/**
 * Cette classe permet de gérer l'ajout d'un utilisateur
 * à la base de données sport_track.db en vérifiant la validité
 * des données fournies par l'utilisateur
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class AddUserController extends Controller
{
    /**
     * Permet d'afficher la page user_add_form.php.
     * Si une session en cours (accès à la page via url 
     * depuis certaines pages) alors celle-ci est fermée par soucis de sécurité
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function get($request): void {
        session_start(); 
        // une session est-elle ouverte ?
        if (isset($_SESSION['current']) && !empty($_SESSION['current'])) {
            // oui -> fermeture de la session + affichage
            session_destroy();
            $this->render("user_add_form", []);
        } else {
            // non -> affichage
            $this->render("user_add_form", []);
        }
    }

    /**
     * Summary of post
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function post($request): void {
        // On récupère les données et on se protège des tentatives d'injections 
        $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])));
        $prenom = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
        $naissance = htmlspecialchars(strip_tags(trim($_POST['birth'])));
        $genre = htmlspecialchars(strip_tags(trim($_POST['gender'])));
        $taille = (int) $_POST['height'];
        $poids = (int) $_POST['weight'];
        $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
        $passwd = htmlspecialchars(trim($_POST['passwd']));
        $passwd_confirm = htmlspecialchars(trim($_POST['passwd-confirm']));
    
        // Vérification de l'égalité des mots de passe fournis
        $errors = [];
        if ($passwd !== $passwd_confirm) {
            $errors[] = 1;
        }
        
        // une erreur avec les mots de passe ?
        if (empty($errors)) {
            // non -> on continue
            // On hash le mot de passe
            $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);
            // On créé une instance de la classe User
            $u = new User();
            // Récupération de l'identifiant pour l'utilisateur
            $dbc = SqliteConnection::getInstance()->getConnection();
            $query = "SELECT seq FROM sqlite_sequence WHERE name = 'User'";
            $stmt = $dbc->prepare($query);
            $stmt->execute();
            $resultsUser = $stmt->fetch();
            // Est-ce le premier utilisateur ajouté à la base de données ?
            if (empty($resultsUser)) {
                // oui -> utiliser l'identifiant 1
                $resultsUser = 1;
            } else {
                // non -> utiliser l'identifiant (identifiant le plus récemment ajouté + 1)
                $resultsUser = $resultsUser['seq'] + 1;
            }
            // On initialise les valeurs de l'utilisateur
            $u->init($resultsUser, $email, $nom, $prenom, $naissance, $genre, $taille, $poids, $hashed_password);
            // On récupère le DAO approprié
            $userDAO = UserDAO::getInstance();
            try {
                // On ajoute dans la base de données le compte de l'utilisateur
                $userDAO->insert($u);
                $this->render("/user_add_valid", ["result" => "L'utilisateur a été créé! Vous pouvez vous y connecter via la page de connexion."]);
            } catch (PDOException $e) {
                print $e->getMessage();
                // Une erreur a été rencontrée lors de la modification de la base de données ou des données invalides (e.g adresse e-mail déjà existante) ont été spécifiées
                $this->render("/user_add_valid", ["result" => "L'adresse e-mail utilisée existe déjà, utilisez une autre!"]);
            }
        } else {
            // oui -> affichage d'une page user_add_valid.php avec pour message un message d'erreur + aucunes modifications à la base de données
            $this->render("/user_add_valid", ["result" => "Les mots de passe ne correspondent pas, vérifiez à ce qu'ils soient les mêmes!"]);
        }
    }
}

?>