<?php
namespace controllers;

require CONTROLLERS_DIR . "/Controller.php";
require UTILS_DIR . "/CalculDistanceImpl.php";
require DAO_DIR . "/SqliteConnection.php";
require DAO_DIR . "/ActivityDAO.php";
require MODELS_DIR . "/Activity.php";
require DAO_DIR . "/ActivityEntryDAO.php";
require MODELS_DIR . "/Data.php";
use controllers\Controller;
use ActivityDAO;
use ActivityEntryDAO;
use CalculDistanceImpl;
use DateTime;
use SqliteConnection;

/**
 * Cette classe permet de récupérer et calculer les données
 * nécessaires dans la visualisation de list_activities.php
 * puis de charger la page correspondante ou une page d'erreur
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class ListActivityController extends Controller
{
    /**
     * Récupère et calcul l'ensemble des données nécessaires
     * dans la visualisation de list_activities.php et les envoie
     * stockées dans un tableau
     * @param mixed $request Requête gérée et envoyée par ApplicationController
     * @return void
     */
    public function get($request): void
    {
        session_start();
        // On vérifie si la session est en cours, sinon c'est que l'utilsiateur tente d'accéder à la page sans s'être connecter
        if (isset($_SESSION['current']) && !empty($_SESSION['current'])) {
            // Initialisation de nos variables principales
            $userID = $_SESSION['current'];
            $table = [];
            // Mise en place de nos DAO
            $activityDAO = ActivityDAO::getInstance();
            $activityEntryDAO = ActivityEntryDAO::getInstance();
            // Récupération de l'ensemble de nos activités via activityDAO
            $lesActivites = $activityDAO->findByUserId($userID);
            // Pour chaque activité :
            for ($i = 0; $i < count($lesActivites); $i++) {
                // Récupérer l'ensemble des données associées à l'activité
                $lesStatistiques = $activityEntryDAO->findByActivityId($lesActivites[$i]->getIdActivity());
                // Calculer la durée de l'activité
                $debut = new DateTime($lesStatistiques[0]->getTimeData());
                $fin = new DateTime(end($lesStatistiques)->getTimeData());
                $duree = $debut->diff($fin);
                // Formatter le résultat de ce calcul sous forme de string
                $duree = sprintf('%02d:%02d:%02d', $duree->h, $duree->i, $duree->s); // formatage en string
                // Calculer la distance parcourue lors de l'activité
                $lesDonneesGeographiques = ["data"];
                for ($j = 0; $j < count($lesStatistiques); $j++) {
                    $lesDonneesGeographiques["data"][$j] = [
                        "latitude" => $lesStatistiques[$j]->getLatitudeData(),
                        "longitude" => $lesStatistiques[$j]->getLongitudeData()
                    ];
                }
                $calculateur = new CalculDistanceImpl();
                $distance = $calculateur->calculDistanceTrajet($lesDonneesGeographiques);
                // Calculer les données cardiologiques de l'activité
                $dbc = SqliteConnection::getInstance()->getConnection();
                $query = "SELECT MIN(cardioData), MAX(cardioData), AVG(cardioData) FROM Data WHERE idActivity=" . $lesActivites[$i]->getIdActivity();
                $stmt = $dbc->prepare($query);
                $stmt->execute();
                $resultsCardio = $stmt->fetch();
                $cardio_min = $resultsCardio[0];
                $cardio_max = $resultsCardio[1];
                $cardio_moyen = $resultsCardio[2];
                // Inserer les valeurs obtenues dans notre tableau de données
                $table[$i] = [
                    $lesActivites[$i]->getDescriptionActivity(), // description
                    $lesActivites[$i]->getDateActivity(), // date
                    $lesStatistiques[0]->getTimeData(), // heure de début
                    $duree, // durée
                    $distance, // distance
                    $cardio_min, // cardio min
                    $cardio_max, // cardio max
                    $cardio_moyen // cardio moyen
                ];
            }
            // si aucune erreur a été rencontrée
            $this->render("list_activities", ["table" => $table]);
        } else {
            // si une erreur a été rencontrée
            $this->render("error", ["errorMessage" => "Tentative d'accès à la liste des activités sans se connecter"]);
        }   
    }
}
?>