<?php
declare(strict_types=1);

/**
 * Permet de représenter un des multiples jeux de données d'une activité dans la base de données "sport_track.db"
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class Data {
    /** L'identifiant associé au jeu de données de l'activité */
    private int $idData;
    /** L'heure associé au jeu de données de l'activité */
    private string $timeData;
    /** La valeur cardiologique associée au jeu de données de l'activité */
    private int $cardioData;
    /** La latitude associée au jeu de données de l'activité */
    private float $latitudeData;
    /** La longitude associée au jeu de données de l'activité */
    private float $longitudeData;
    /** L'altitude associée au jeu de données de l'activité */
    private int $altitudeData;
    /** L'identifiant de l'activité associée au jeu de données */
    private int $idActivity;

    /** 
     * Constructeur sans paramètre 
     */
    public function __construct() {}

    /**
     * Permet d'initialiser les attributs de l'instance appelante de la classe Data
     * @param int $idData L'identifiant qu'on associe à l'instance de la classe Data
     * @param string $timeData L'heure qu'on associe à l'instance de la classe Data
     * @param int $cardioData La valeur cardiologique qu'on associe à l'instance de la classe Data
     * @param float $latitudeData La latitude qu'on associe à l'instance de la classe Data
     * @param float $longitudeData La longitude qu'on associe à l'instance de la classe Data
     * @param int $idActivity L'identifiant de l'activité qu'on associe à l'instance de la classe Data
     */
    public function init(int $idData, string $timeData, int $cardioData, float $latitudeData, float $longitudeData, int $altitudeData, int $idActivity) {
        $this->idData = $idData;
        $this->timeData = $timeData;
        $this->cardioData = $cardioData;
        $this->latitudeData = $latitudeData;
        $this->longitudeData = $longitudeData;
        $this->altitudeData = $altitudeData;
        $this->idActivity = $idActivity;
    }

    /**
     * Renvoie l'identifiant associé au jeu de données
     * @return int L'identifiant associé au jeu de données
     */
    public function getIdData() : int {
        return $this->idData;
    }

    /**
     * Renvoie l'heure associé au jeu de données
     * @return string L'heure associé au jeu de données
     */
    public function getTimeData() : string {
        return $this->timeData;
    }

    /**
     * Renvoie la valeur cardiologique associée au jeu de données
     * @return int La valeur cardiologique associée au jeu de données
     */
    public function getCardioData() : int {
        return $this->cardioData;
    }

    /**
     * Renvoie la latitude associée au jeu de données
     * @return int La latitude associée au jeu de données
     */
    public function getLatitudeData() : float {
        return $this->latitudeData;
    }

    /**
     * Renvoie la longitude associée au jeu de données
     * @return int La longitude associée au jeu de données
     */
    public function getLongitudeData() : float {
        return $this->longitudeData;
    }

    /**
     * Renvoie l'altitude associée au jeu de données
     * @return int L'altitude associée au jeu de données
     */
    public function getAltitudeData() : int {
        return $this->altitudeData;
    }

    /**
     * Renvoie l'identifiant de l'activité associée au jeu de données
     * @return int L'identifiant de l'activité associée au jeu de données
     */
    public function getIdActivity() : int {
        return $this->idActivity;
    }

    /**
     * Renvoie les données concernant le jeu de données sous format lisible
     * @return string Les données concernant le jeu de données sous format lisible
     */
    public function __toString() : string {
        return  "Identifiant: " . $this->idData .
                ", Heure: " . $this->timeData . 
                ", Frequence cardiaque: " . $this->cardioData . 
                ", Latitude: " . $this->latitudeData . 
                ", Longitude: " . $this->longitudeData . 
                ", Altitude: " . $this->altitudeData . 
                ", ID de l'activité: " . $this->idActivity;
    }
}
?>