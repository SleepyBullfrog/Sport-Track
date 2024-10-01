<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
use controllers\Controller;

/**
 * Cette classe permet de gérer la déconnexion (proprement)
 * d'un utilisateur à l'aide d'une page user_disconnect.php
 * qui renvoie des données à MainController.php pour fermer
 * la session en cours 
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class DisconnectUserController extends Controller
{
    /**
     * Permet d'afficher la page user_disconnect.php.
     * Si une session n'est pas en cours (accès à la page via url 
     * depuis certaines pages) alors on affiche une page d'erreur avec un message à l'utilisateur
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function get($request): void
    {
        session_start();
        // une session est-elle ouverte ?
        if (isset($_SESSION['current']) && !empty($_SESSION['current'])) {
            // oui -> affichage de la page
            $this->render("user_disconnect", []);
        } else {
            // non -> affichage de la page d'erreur avec le message associé
            $this->render("error", ["errorMessage" => "Tentative d'accès à la page de déconnexion sans se connecter"]);
        }
    }
}

?>