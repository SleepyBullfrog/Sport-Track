<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
require MODELS_DIR . "/Activity.php";
require DAO_DIR . "/ActivityDAO.php";
require MODELS_DIR . "/Data.php";
require DAO_DIR . "/ActivityEntryDAO.php";
use controllers\Controller;
use Activity;
use Data;
use ActivityDAO;
use ActivityEntryDAO;
use PDOException;
use SqliteConnection;

/**
 * Cette classe permet de gérer l'ajout d'activités et des
 * données associées à ses activités à la base de données
 * sport_track.db en vérifiant la validité du fichier au format
 * JSON fourni par l'utilisateur
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class UploadActivityController extends Controller
{
    /**
     * Permet d'afficher la page upload_activity_form.php.
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
            // oui -> affichage
            $this->render("upload_activity_form", []);
        } else {
            // non -> affichage de la page d'erreur avec le message associé
            $this->render("error", ["errorMessage" => "Tentative d'accès au tableau de bord sans se connecter"]);
        }   
    }

    /**
     * Récupère les données du fichier au format JSON envoyé par l'utilisateur
     * pour vérifier leur validité afin de déterminer si ces données peuvent
     * être ajoutées à la base de données sport_track.db et puis les ajoutées
     * à la base de données si elles sont considérées comme des données valides
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function post($request): void {
        // Vérification du type du fichier et vérification de la réussite de l'envoi du fichier
        if (isset($_FILES['JSON']) && $_FILES['JSON']['error'] === UPLOAD_ERR_OK) {
            // On récupère le chemin du fichier
            $chemin = $_FILES['JSON']['tmp_name'];
            // On récupère les données du fichier
            $donneesJSON = file_get_contents($chemin);
            // On décode les données du fichier
            $donnees = json_decode($donneesJSON, true);
            // Y-a-t-il eu une erreur lors du décodage ?
            if (json_last_error() === JSON_ERROR_NONE) {
                // non -> on continue
                // Existe-t-il un champs activity dans le fichier (e.g /tests/data.json)
                if (isset($donnees['activity']) && isset($donnees['activity']['date']) && isset($donnees['activity']['description'])) {
                    // oui -> on continue
                    // On récupère les données associées au champs activity
                    $activityDate = $donnees['activity']['date'];
                    $activityDescription = $donnees['activity']['description'];
                    // Une des données est-elle vide ?
                    if (empty($activityDate) || empty($activityDescription)) {
                        // oui -> affichage d'un message d'erreur (les données du champs activity sont invalides)
                        $this->render("upload_activity_form", ["uploadMessage" => "Les données du champs activity sont invalides"]);
                        die();
                    } else {
                        // non -> on continue
                        // Création d'un tableau qui contiendra nos données
                        $lesDonnees = [];
                        $i = 0;
                        // Existe-t-il un champs data sous la forme d'un tableau ?
                        if (isset($donnees['data']) && is_array($donnees['data'])) {
                            // oui -> on continue
                            $donnees_invalides = false;
                            // Pour chaque partie du tableau :
                            foreach($donnees['data'] as $instanceDonnees) {
                                // time, cardio_frequency, latitude, longitude et altitude existe-t-ils ?
                                if (!isset($instanceDonnees['time']) || 
                                    !isset($instanceDonnees['cardio_frequency']) || 
                                    !isset($instanceDonnees['latitude']) || 
                                    !isset($instanceDonnees['longitude']) || 
                                    !isset($instanceDonnees['altitude'])) {
                                        // non -> sortie de la boucle
                                        $donnees_invalides = true;
                                        break;
                                }
                                // Récupérer les données existantes
                                $time = $instanceDonnees['time'];
                                $cardioFrequency = $instanceDonnees['cardio_frequency'];
                                $latitude = $instanceDonnees['latitude'];
                                $longitude = $instanceDonnees['longitude'];
                                $altitude = $instanceDonnees['altitude'];
                                // Vérifier la condition suivante : une des données est-elle vide ?
                                if (empty($time) || empty($cardioFrequency) || empty($latitude) || empty($longitude) || empty($altitude)) {
                                    // oui -> affichage d'un message d'erreur (les données du champs data sont invalides)
                                    $this->render("upload_activity_form", ["uploadMessage" => "Les données du champs data de l'activité sont invalides"]);
                                    die();
                                } else {
                                    // non -> on continue
                                    // ajout des données dans notre tableau
                                    $lesDonnees[$i] = [$time, $cardioFrequency, $latitude, $longitude, $altitude];  
                                    $i++;
                                }
                            }
                            if ($donnees_invalides) {
                                // ssi les données sont invalides
                                $this->render("upload_activity_form", ["uploadMessage" => "Une des données du champs data de l'activité n'existe pas"]);
                                die();
                            }
                        } else {
                            // non -> affichage d'un message d'erreur (format des données du champs data invalide)
                            $this->render("upload_activity_form", ["uploadMessage" => "Format du champs data invalide"]);
                            die();
                        }
                    }
                } else {
                    // non -> affichage d'un message d'erreur (format du champs activity invalide)
                    $this->render("upload_activity_form", ["uploadMessage" => "Format des données du champs activity invalide"]);
                    die();
                }
            } else {
                // oui -> affichage d'un message d'erreur (format du fichier invalide)
                $this->render("upload_activity_form", ["uploadMessage" => "Format du fichier invalide"]);
                die();
            }
            // À ce point, les données sont nécessairement sécurisées 
            // Récupération de l'identifiant de l'utilisateur
            session_start();
            $idUser = $_SESSION['current'];
            try {
                // Récupération de l'identifiant à utiliser pour l'activité (plus grand identifiant disponible)
                $dbc = SqliteConnection::getInstance()->getConnection();
                $query = "SELECT seq FROM sqlite_sequence WHERE name = 'Activity'";
                $stmt = $dbc->prepare($query);
                $stmt->execute();
                $resultsActivity = $stmt->fetch();
                // Est-ce la première activité ajoutée dans notre base de données ?
                if (empty($resultsActivity)) {
                    // oui -> utiliser l'identifiant 1
                    $resultsActivity = 1;
                } else {
                    // non -> utiliser l'identifiant (identifiant le plus récemment ajouté + 1)
                    $resultsActivity = $resultsActivity['seq'] + 1;
                }
                // Création de l'activité et initialisation de ses données
                $activity = new Activity();
                $activity->init($resultsActivity, $activityDate, $activityDescription   , $idUser);
                // Ajout de l'activité dans la base de données
                $activityDAO = ActivityDAO::getInstance();
                $activityDAO->insert($activity);
                // Pour chaque partie du tableau de données :
                foreach($lesDonnees as $leJeu) {
                    // Récupérer l'identifiant pour le jeu de données actuel (plus grand identifiant disponible)
                    $dbc = SqliteConnection::getInstance()->getConnection();
                    $query = "SELECT seq FROM sqlite_sequence WHERE name = 'Data'";
                    $stmt = $dbc->prepare($query);
                    $stmt->execute();
                    $resultsData = $stmt->fetch();
                    // Est-ce le premier jeu de données ajouté dans notre base de données .
                    if (empty($resultsData)) {
                        // oui -> utiliser l'identifiant 1
                        $resultsData = 1;
                    } else {
                        // non -> utiliser l'identifiant (identifiant le plus récemment ajouté + 1)
                        $resultsData = $resultsData['seq'] + 1;
                    }
                    // Création du jeu de données pour l'activité et initialisation de ses données
                    $data = new Data();
                    $data->init($resultsData, $leJeu[0], $leJeu[1], $leJeu[2], $leJeu[3], $leJeu[4], $resultsActivity);
                    // Ajout du jeu de données pour l'activité dans la base de données
                    $activityEntryDAO = ActivityEntryDAO::getInstance();
                    $activityEntryDAO->insert($data);
                }
                // Affichage d'un message de réussite (données sauvergardées dans la base de données)
                $this->render("upload_activity_form", ["uploadMessage" => "Réussite de l'envoi!"]);
            } catch (PDOException $e) {
                print $e->getMessage();
                $this->render("upload_activity_form", ["uploadMessage" => "Erreur dans la base de données"]);
            }
        } else {
            // Affichage d'un message d'erreur (type de fichier invalide ou envoi échoué)
            $this->render("upload_activity_form", ["uploadMessage" => "Echec de l'envoi!"]);
        }
    }
}

?>