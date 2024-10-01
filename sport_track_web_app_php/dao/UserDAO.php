<?php
require_once "SqliteConnection.php";

/**
 * Permet d'insérer, de supprimer, de modifier et de lister les utilisateurs à partir de la base de données "sport_track.db"
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class UserDAO {
    /** Permet d'obtenir une unique instance de la classe */
    private static ?UserDAO $dao;

    /**
     * Constructeur du singleton
     */
    private function __construct() {}

    /**
     * Renvoie l'instance unique de UserDAO et la créée si elle n'existe pas
     * @return UserDAO L'instance unique de UserDAO 
     */
    public static function getInstance(): UserDAO {
        if(!isset(self::$dao)) {
            self::$dao = new UserDAO();
        }
        return self::$dao;
    }

    /**
     * Permet d'insérer un utilisateur dans la base de données "sport_track.db"
     * @param User $u L'utilisateur qu'on souhaite insérer
     * @return void
     */
    public final function insert(User $u): void{
        if ($u instanceof User) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "INSERT INTO User(emailUser, nameUser, firstNameUser, birthdateUser, genderUser, heightUser, weightUser, passwordUser) VALUES (:eU,:nU,:fnU,:bU,:gU,:hU,:wU,:pU)";
            $stmt = $dbc->prepare($query);

            // bind the paramaters
            // doesn't need to bind a value for the ID because we are using AUTOINCREMENT in SQLITE3
            $stmt->bindValue(':eU', $u->getEmailUser(), PDO::PARAM_STR);
            $stmt->bindValue(':nU', $u->getNameUser(), PDO::PARAM_STR);
            $stmt->bindValue(':fnU', $u->getFirstNameUser(), PDO::PARAM_STR);
            $stmt->bindValue(':bU', $u->getBirthdateUser(), PDO::PARAM_STR);
            $stmt->bindValue(':gU', $u->getGenderUser(), PDO::PARAM_STR);
            $stmt->bindValue(':hU', $u->getHeightUser(), PDO::PARAM_INT);
            $stmt->bindValue(':wU', $u->getWeightUser(), PDO::PARAM_INT);
            $stmt->bindValue(':pU', $u->getPasswordUser(), PDO::PARAM_STR);

            // execute the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Permet d'effacer un utilisateur dans la base de données "sport_track.db"
     * @param User $u L'utilisateur qu'on souhaite effacer
     * @return void
     */
    public function delete(User $u) : void {
        if ($u instanceof User) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "DELETE FROM User WHERE idUser = :iU";
            $stmt = $dbc->prepare($query);

            // bind the parameter
            $stmt->bindValue(':iU', $u->getIdUser(), PDO::PARAM_INT);

            // execute the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Permet de modifier un utilisateur dans la base de données "sport_track.db"
     * @param User $u L'utilisateur qu'on souhaite effacer
     * @return void
     */
    public function update(User $u) : void {
        if ($u instanceof User) {
            $dbc = SqliteConnection::getInstance()->getConnection();
            // prepare the SQL statement
            $query = "UPDATE User SET emailUser = :eU, nameUser = :nU, firstNameUser = :fnU, birthdateUser = :bU, genderUser = :gU, heightUser = :hU, weightUser = :wU, passwordUser = :pU WHERE idUser = :iU";
            $stmt = $dbc->prepare($query);

            // bind the parameters
            $stmt->bindValue(':eU', $u->getEmailUser(), PDO::PARAM_STR);
            $stmt->bindValue(':nU', $u->getNameUser(), PDO::PARAM_STR);
            $stmt->bindValue(':fnU', $u->getFirstNameUser(), PDO::PARAM_STR);
            $stmt->bindValue(':bU', $u->getBirthdateUser(), PDO::PARAM_STR);
            $stmt->bindValue(':gU', $u->getGenderUser(), PDO::PARAM_STR);
            $stmt->bindValue(':hU', $u->getHeightUser(), PDO::PARAM_INT);
            $stmt->bindValue(':wU', $u->getWeightUser(), PDO::PARAM_INT);
            $stmt->bindValue(':pU', $u->getPasswordUser(), PDO::PARAM_STR);
            $stmt->bindValue(':iU', $u->getIdUser(), PDO::PARAM_INT);

            // exectue the prepared statement
            $stmt->execute();
        }
    }

    /**
     * Renvoie l'ensemble des utilisateurs inscrits dans la base de données "sport_track.db"
     * @return array L'ensemble des utilisateurs inscrits dans la base de données "sport_track.db"
     */
    public final function findAll() : array {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM User ORDER BY idUser";
        $stmt = $dbc->query($query);
        $results = $stmt->fetchALL(PDO::FETCH_CLASS, 'User');
        return $results;
    }

    /**
     * Renvoie un unique utilisateur inscrit dans la base de données "sport_track.db" dont l'identifiant est égal à celui passé en paramètre
     * @param int $idUser L'identifiant de l'utilisateur qu'on cherche à renvoyer
     * @return User Un unique utilisateur inscrit dans la base de données "sport_track.db" dont l'identifiant est égal à celui passé en paramètre
     */
    public final function findById(int $idUser) : User {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM User WHERE idUser = " . $idUser; 
        $stmt = $dbc->query($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $results = $stmt->fetch();
        return $results;
    }

    /**
     * Renvoie un unique utilisateur inscrit dans la base de données "sport_track.db" dont l'e-mail est égal à celui passé en paramètre
     * @param string $emailUser L'e-mail de l'utilisateur qu'on cherche à renvoyer
     * @return User Un unique utilisateur inscrit dans la base de données "sport_track.db" dont l'e-mail est égal à celui passé en paramètre
     */
    public final function findByEmail(string $emailUser) : User {
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT * FROM User WHERE emailUser = :eU";
        $stmt = $dbc->prepare($query);
        $stmt->bindValue(":eU", $emailUser, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $results = $stmt->fetch();
        return $results;
    }
}
?>