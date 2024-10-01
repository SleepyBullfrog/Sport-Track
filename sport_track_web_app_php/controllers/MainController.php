<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
use controllers\Controller;

/**
 * Cette classe permet d'afficher la page principale ("/")
 * de notre application
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class MainController extends Controller
{
    /**
     * Permet d'afficher la page main.php.
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
            // oui -> fermeture de la session + affichage
            unset($_SESSION['current']);
            $this->render("main", []);
        } else {
            // non -> affichage
            $this->render("main", []);
        }
    }
}
?>
