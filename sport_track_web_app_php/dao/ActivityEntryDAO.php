<?php
require_once "SqliteConnection.php";

/**
 * Permet d'insérer, de supprimer, de modifier et de lister des jeux de données à partir de la base de données "sport_track.db"
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class ActivityEntryDAO {
    /** Permet d'obtenir une unique instance de la classe */
    private static ?ActivityEntryDAO $dao;

    /**
     * Constructeur du singleton
     */
    private function __construct() {}

    /**
     * Renvoie l'instance unique de ActivityEntryDAO et la créée si elle n'existe pas
     * @return ActivityEntryDAO L'instance unique de ActivityEntryDAO 
     */
    public static function getInstance(): ActivityEntryDAO {
        if(!isset(self::$dao)) {
            self::$dao = new ActivityEntryDAO();
        }
        return self::$dao;
    }

    /**
     * Permet d'insérer un jeu de données dans la base de données "sport_track.db"
     * @param Data $d Le jeu de données qu'on souhaite insérer
     * @return void 
     */
    public final function insert(Data $d): void{
        if ($d instanceof Data) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "INSERT INTO Data(timeData, cardioData, latitudeData, longitudeData, altitudeData, idActivity) VALUES (:tD, :cD, :laD, :loD, :aD, :iA)";
            $stmt = $dbc->prepare($query);

            // bind the paramaters
            // doesn't need to bind a value for the ID because we are using AUTOINCREMENT in SQLITE3
            $stmt->bindValue(':tD', $d->getTimeData(), PDO::PARAM_STR);
            $stmt->bindValue(':cD', $d->getCardioData(), PDO::PARAM_INT);
            $stmt->bindValue(':laD', $d->getLatitudeData(), PDO::PARAM_INT);
            $stmt->bindValue(':loD', $d->getLongitudeData(), PDO::PARAM_INT);
            $stmt->bindValue(':aD', $d->getAltitudeData(), PDO::PARAM_INT);
            $stmt->bindValue(':iA', $d->getIdActivity(), PDO::PARAM_INT);
            
            // execute the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Permet d'effacer un jeu de données dans la base de données "sport_track.db"
     * @param Data $d Le jeu de données qu'on souhaite effacer
     * @return void
     */
    public function delete(Data $d) : void {
        if ($d instanceof Data) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "DELETE FROM Data WHERE idData = :iD";
            $stmt = $dbc->prepare($query);

            // bind the parameter
            $stmt->bindValue(':iD', $d->getIdData(), PDO::PARAM_INT);

            // execute the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Permet de modifier un jeu de données dans la base de données "sport_track.db"
     * @param Data $d Le jeu de données qu'on souhaite modifier
     * @return void
     */
    public function update(Data $d) : void {
        if ($d instanceof Data) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "UPDATE Data SET timeData = :tD, cardioData = :cD, latitudeData = :laD, longitudeData = :loD, altitudeData = :aD, idActivity = :iA WHERE idData = :iD";
            $stmt = $dbc->prepare($query);

            // bind the parameters
            $stmt->bindValue(':tD', $d->getTimeData(), PDO::PARAM_STR);
            $stmt->bindValue(':cD', $d->getCardioData(), PDO::PARAM_INT);
            $stmt->bindValue(':laD', $d->getLatitudeData(), PDO::PARAM_INT);
            $stmt->bindValue(':loD', $d->getLongitudeData(), PDO::PARAM_INT);
            $stmt->bindValue(':aD', $d->getAltitudeData(), PDO::PARAM_INT);
            $stmt->bindValue(':iA', $d->getIdActivity(), PDO::PARAM_INT);
            $stmt->bindValue(':iD', $d->getIdData(), PDO::PARAM_INT);

            // exectue the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Renvoie l'ensemble des jeux de données inscrits dans la base de données "sport_track.db"
     * @return array L'ensemble des jeux de données inscrits dans la base de données "sport_track.db"
     */
    public final function findAll() : array {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Data ORDER BY idData";
        $stmt = $dbc->query($query);
        $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'Data');
        return $results;
    }

    /**
     * Renvoie un unique jeu de données inscrit dans la base de données "sport_track.db" dont l'identifiant est égal à celui passé en paramètre
     * @param int $idData L'identifiant du jeu de données qu'on cherche à renvoyer
     * @return Data Un unique jeu de données inscrit dans la base de données "sport_track.db" dont l'identifiant est égal à celui passé en paramètre
     */
    public final function findById(int $idData) : Data {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Data WHERE idData = " . $idData; 
        $stmt = $dbc->query($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Data');
        $results = $stmt->fetch();
        return $results;
    }

    /**
     * Renvoie l'ensemble des jeux de données inscrits dans la base de données "sport_track.db" dont l'identifiant associé à l'activité est égal à celui passé en paramètre
     * @param int $idActivity L'identifiant associé à l'activité à qui appartient les jeux de données
     * @return array L'ensemble des jeux de données inscrits dans la base de données "sport_track.db" dont l'identifiant associé à l'activité est égal à celui passé en paramètre
     */
    public final function findByActivityId(int $idActivity) : array {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Data WHERE idActivity = " . $idActivity;
        $stmt = $dbc->query($query);
        $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'Data');
        return $results;
    }
}
?>