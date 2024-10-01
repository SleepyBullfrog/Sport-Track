<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
require MODELS_DIR . "/User.php";
require DAO_DIR . "/UserDAO.php";
use controllers\Controller;
use UserDAO;
use PDOException;
use TypeError;

/**
 * Cette classe permet de gérer la connexion d'un utilisateur
 * à la base de données sport_track.db en vérifiiant la validité
 * des données fournies par l'utilisateur
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class ConnectUserController extends Controller
{
    /**
     * Permet d'afficher la page user_connect_form.php.
     * Si une session en cours (accès à la page via url 
     * depuis certaines pages) alors celle-ci est fermée par soucis de sécurité
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function get($request): void
    {
        session_start(); 
        // une session est-elle ouverte ?
        if (isset($_SESSION['current']) && !empty($_SESSION['current'])) {
            // oui -> fermeture de la session et affichage
            session_destroy();
            $this->render("user_connect_form", []);
        } else {
            // non -> affichage
            $this->render("user_connect_form", []);
        }
    }

    /**
     * Récupère les données envoyées par l'utilisateur pour vérifier
     * leur validité afin de déterminer si l'utilisateur peut se connecter
     * ou non à son tableau de bord et accéder aux pages qui y sont associées
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function post($request): void {
        // On récupère les données et on se protège de tentatives d'injection
        $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
        $passwd = htmlspecialchars(trim($_POST['passwd']));

        try {
            // Récupération de l'instance de l'utilisateur dans la base de données
            $lUtilisateur = UserDAO::getInstance()->findByEmail($email);
            // Récupération du mot de passe pour l'utilisateur
            $passwdUser = $lUtilisateur->getPasswordUser();
            // Récupération de l'identifiant pour l'utilisateur
            $idUser = $lUtilisateur->getIdUser();
        } catch (PDOException|TypeError $e) {
            $passwdUser = null;
        }

        // Vérification de la validité du mot de passe
        $errors = [];
        if ($passwdUser === null || !(password_verify($passwd, $passwdUser))) {
            $errors[] = 1;
        }

        // une erreur ?
        if(empty($errors)) {
            // non -> création d'une session et affichage où buttonState est true c.a.d qu'on demande à l'utilisateur s'il souhaite vraiment se connecter
            session_start();
            $_SESSION['current'] = $idUser;
            $this->render("/user_connect_valid", ["buttonState" => "true"]);
        } else {
            // oui -> affichage où buttonState est false c.a.d qu'on reste sur la même page sans modification
            $this->render("/user_connect_valid", ["buttonState" => "false"]);
        }
    }
}

?>