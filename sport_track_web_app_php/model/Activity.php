<?php
declare(strict_types=1);

/**
 * Permet de représenter une activité dans la base de données "sport_track.db"
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class Activity {
    /** Identifiant associé à l'activité */
    private int $idActivity;
    /** Date associée à l'activité */
    private string $dateActivity;
    /** Description associée à l'activité */
    private string $descriptionActivity;
    /** Identifiant de l'utilisateur associé à l'activité */
    private int $idUser;

    /**
     * Constructeur sans paramètre
     */
    public function __construct() {}

    /**
     * Permet d'initialiser les attributs de l'instance appelante de la classe Activity
     * @param int $idActivity L'identifiant qu'on donne à l'instance de la classe Activity
     * @param string $dateActivity La date qu'on associe à l'instance de la classe Activity
     * @param string $descriptionActivity La description qu'on associe à l'instance de la classe Acctivity
     * @param int $idUser L'identifiant de l'utilisateur qu'on associe à l'instance de la classe Activity
     */
    public function init(int $idActivity, string $dateActivity, string $descriptionActivity, int $idUser) {
        $this->idActivity = $idActivity;
        $this->dateActivity = $dateActivity;
        $this->descriptionActivity = $descriptionActivity;
        $this->idUser = $idUser;
    }

    /**
     * Renvoie l'identifiant associé à l'activité
     * @return int L'identifiant associé à l'activity
     */
    public function getIdActivity() : int {
        return $this->idActivity;
    }

    /**
     * Renvoie la date associée à l'activité
     * @return string La date associée à l'activité
     */
    public function getDateActivity() : string {
        return $this->dateActivity;
    }

    /**
     * Renvoie la description associée à l'activité
     * @return string La description associée à l'activité
     */
    public function getDescriptionActivity() : string {
        return $this->descriptionActivity;
    }

    /**
     * Renvoie l'identifiant de l'utilisateur associé à l'activité
     * @return int L'identifiant de l'utilisateur associé à l'activté
     */
    public function getIdUser() : int {
        return $this->idUser;
    }

    /**
     * Renvoie les données concernant l'activité sous format lisible
     * @return string Les données concernant l'activité sous format lisible
     */
    public function __toString() : string {
        return "Identifiant : " . $this->idActivity . 
               ", Date : " . $this->dateActivity . 
               ", Description : " . $this->descriptionActivity . 
               ", ID de l'utilisateur: " . $this->idUser;
    }
}
?>