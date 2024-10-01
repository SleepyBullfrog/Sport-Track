<?php
require_once "SqliteConnection.php";

/**
 * Permet d'insérer, de supprimer, de modifier et de lister les activités à partir de la base de données "sport_track.db"
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class ActivityDAO {
    /** Permet d'obtenir une unique instance de la classe */
    private static ?ActivityDAO $dao;

    /**
     * Constructeur du singleton
     */
    private function __construct() {}

    /**
     * Renvoie l'instance unique de ActivityDAO et la créée si elle n'existe pas
     * @return ActivityDAO L'instance unique de ActivityDAO 
     */
    public static function getInstance(): ActivityDAO {
        if(!isset(self::$dao)) {
            self::$dao = new ActivityDAO();
        }
        return self::$dao;
    }

    /**
     * Permet d'insérer une activité dans la base de données "sport_track.db"
     * @param Activity $a L'activité qu'on souhaite insérer
     * @return void
     */
    public final function insert(Activity $a): void{
        if ($a instanceof Activity) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "INSERT INTO Activity(dateActivity, descriptionActivity, idUser) VALUES (:daA, :deA, :iU)";
            $stmt = $dbc->prepare($query);

            // bind the paramaters
            // doesn't need to bind a value for the ID because we are using AUTOINCREMENT in SQLITE3
            $stmt->bindValue(':daA', $a->getDateActivity(), PDO::PARAM_STR);
            $stmt->bindValue(':deA', $a->getDescriptionActivity(), PDO::PARAM_STR);
            $stmt->bindValue(':iU', $a->getIdUser(), PDO::PARAM_INT);

            // execute the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Permet d'effacer une activité dans la base de données "sport_track.db"
     * @param Activity $a L'activité qu'on souhaite effacer
     * @return void
     */
    public function delete(Activity $a) : void {
        if ($a instanceof Activity) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "DELETE FROM Activity WHERE idActivity = :iA";
            $stmt = $dbc->prepare($query);

            // bind the parameter
            $stmt->bindValue(':iA', $a->getIdActivity(), PDO::PARAM_INT);

            // execute the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Permet de modifier une activité dans la base de données "sport_track.db"
     * @param Activity $a L'activité qu'on souhaite modifier
     * @return void
     */
    public function update(Activity $a) : void {
        if ($a instanceof Activity) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "UPDATE Activity SET dateActivity = :daA, descriptionActivity = :deA, idUser = :iU WHERE idActivity = :iA";
            $stmt = $dbc->prepare($query);

            // bind the parameters
            $stmt->bindValue(':daA', $a->getDateActivity(), PDO::PARAM_STR);
            $stmt->bindValue(':deA', $a->getDescriptionActivity(), PDO::PARAM_STR);
            $stmt->bindValue(':iU', $a->getIdUser(), PDO::PARAM_INT);
            $stmt->bindValue(':iA', $a->getIdActivity(), PDO::PARAM_INT);

            // exectue the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Renvoie l'ensemble des activités inscrites dans la base de données "sport_track.db"
     * @return array L'ensemble des activités inscrites dans la base de données "sport_track.db"
     */
    public final function findAll() : array {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Activity ORDER BY idActivity";
        $stmt = $dbc->query($query);
        $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'Activity');
        return $results;
    }

    /**
     * Renvoie une unique activité inscrite dans la base de données "sport_track.db" dont l'identifiant est égal à celui passé en paramètre
     * @param int $idActivity L'identifiant de l'activité qu'on cherche à renvoyer
     * @return Activity Une unique activité inscrite dans la base de données "sport_track.db" dont l'identifiant est égal à celui passé en paramètre
     */
    public final function findById(int $idActivity) : Activity {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Activity WHERE idActivity = " . $idActivity; 
        $stmt = $dbc->query($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Activity');
        $results = $stmt->fetch();
        return $results;
    }

    /**
     * Renvoie l'ensemble des activités inscrites dans la base de données "sport_track.db" dont l'identifiant associé à l'utilisateur est égal à celui passé en paramètre
     * @param int $idUser L'identifiant associé à l'utilisateur à qui appartient les activités
     * @return array L'ensemble des activités inscrites dans la base de données "sport_track.db" dont l'identifiant associé à l'utilisateur est égal à celui passé en paramètre
     */
    public final function findByUserId(int $idUser) : array {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM Activity WHERE idUser = " . $idUser;
        $stmt = $dbc->query($query);
        $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'Activity');
        return $results;
    }
}
?>