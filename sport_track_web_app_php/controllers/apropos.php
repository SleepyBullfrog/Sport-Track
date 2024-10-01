<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
use controllers\Controller;

/**
 * Cette classe permet de charger la page apropos.php
 * qui détaille des informations sur le créateur du site
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class AProposController extends Controller
{
    /**
     * Permet d'afficher la page apropos.php.
     * Si une session en cours (accès à la page via url
     * depuis certaines pages) alors celle-ci est fermée par soucis de sécurité
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function get($request): void {
        session_start(); 
        // une session est-elle ouverte ?
        if (isset($_SESSION['current']) && !empty($_SESSION['current'])) {
            // oui -> fermeture de session et affichage
            session_destroy();
            $this->render("apropos", []);
        } else {
            // non -> affichage
            $this->render("apropos", []);
        }
    }
}

?>