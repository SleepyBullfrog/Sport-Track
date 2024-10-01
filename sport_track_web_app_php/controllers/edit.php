<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
require MODELS_DIR . "/User.php";
require DAO_DIR . "/UserDAO.php";
use controllers\Controller;
use User;
use UserDAO;
use PDOException;

/**
 * Cette classe permet de gérer la modification
 * des données d'un utilisateur dans la base
 * de données selon ce qu'il souhaite modifier
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class EditUserController extends Controller
{
    /**
     * Permet d'afficher la page user_edit_form.php.
     * Si une session n'est pas en cours (accès à la page via url 
     * depuis certaines pages) alors on affiche une page d'erreur avec un message à l'utilisateur
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function get($request) : void {
        session_start();
        // une session est-elle ouverte ?
        if (isset($_SESSION['current']) && !empty($_SESSION['current'])) {
            // oui -> affichage de la page
            $this->render("user_edit_form", []);
        } else {
            // non -> affichage de la page d'erreur avec le message associé
            $this->render("error", ["errorMessage" => "Tentative d'accès à la page d'édition sans se connecter"]);
        }   
    }

    /**
     * Récupère les données envoyées par l'utilisateur pour vérifier
     * leur validité afin de déterminer si les données de l'utilisateur peuvent 
     * être modifiées ou non dans la base de données sport_track.db 
     * @param mixed $request Requête gérée et envoyéed par ApplicationController
     * @return void
     */
    public function post($request) : void {
        // On récupère les données et on se protège des tentatives d'injection
        $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])));
        $prenom = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
        $naissance = htmlspecialchars(strip_tags(trim($_POST['birth'])));
        $genre = htmlspecialchars(strip_tags(trim($_POST['gender'])));
        $taille = (int) $_POST['height'];
        $poids = (int) $_POST['weight'];
        $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
        $new_passwd = htmlspecialchars(trim($_POST['passwd']));
        $new_passwd_confirm = htmlspecialchars(trim($_POST['passwd-confirm']));

        // Vérification de l'égalité des mots de passe fournis
        $errors = [];
        if ($new_passwd !== $new_passwd_confirm) {
            $errors[] = 1;
        }

        // une erreur avec les mots de passe ?
        if (empty($errors)) {
            // Non -> on continue
            // On hash le mot de passe
            $hashed_new_password = password_hash($new_passwd, PASSWORD_DEFAULT);
            // On créé une instance de la classe User
            $u = new User();
            // On récupère l'identifiant de l'utilisateur connecté
            session_start();
            $resultsUser = $_SESSION['current'];
            // On initialise les valeurs dans la nouvelle instance
            $u->init($resultsUser, $email, $nom, $prenom, $naissance, $genre, $taille, $poids, $hashed_new_password);
            // On modifie l'utilisateur dans la base de données
            $userDAO = UserDAO::getInstance();
            try {
                // Mise à jour de la base de données
                $userDAO->update($u);
                $this->render("/user_edit_valid", ["result" => "Vos données ont été modifiées!"]);
            } catch (PDOException $e) {
                // Une erreur a été rencontrée lors de la modification de la base de données ou des données invalides (e.g même adresse e-mail) ont été spécifiées
                $this->render("/user_edit_valid", ["result" => "Cette adresse e-mail est déjà utilisée, réessayez avec une autre!"]);
            }
        } else {
            // Oui -> affichage d'une page user_edit_valid.php avec pour message un message d'erreur + aucunes modifications à la base de données
            $this->render("/user_edit_valid", ["result" => "Les mots de passe ne correspondent pas, vérifiez à ce qu'ils soient les mêmes!"]);
        }
    }
}

?>