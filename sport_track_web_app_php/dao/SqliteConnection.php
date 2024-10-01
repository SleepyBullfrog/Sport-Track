<?php
declare(strict_types=1);

/**
 * Singleton permettant d'établir une connexion à la base de données "sport_track.db"
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class SqliteConnection {
    /** Permet d'obtenir une unique instance de la classe */
    private static ?SqliteConnection $instance = null;
    /** Connexion à la base de données */
    private ?PDO $db;
    /** Chemin vers la base de données, voir ../config.php */
    private string $db_file = DB_FILE;

    /**
     * Constructeur du singleton, il va permettre d'initier la connexion à la base de données
     */
    private function __construct() {
        // dsn = data source name
        $dsn = "sqlite:" . $this->db_file;
        // options appliquées à la connexion prochainement créée
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->db = new PDO($dsn, null, null, $options);
        } catch (PDOException $e) {
            print "Error! : " . $e->getMessage() . "\n";
        }
    }

    /**
     * Renvoie l'instance unique de SqliteConnection et la créée si elle n'existe pas 
     * @return SqliteConnection L'instance unique de SqliteConnection
     */
    public static function getInstance() : SqliteConnection {
        if (self::$instance === null) {
            self::$instance = new SqliteConnection();
        }
        return self::$instance;
    }

    /**
     * Renvoie la connexion de l'instance de SqliteConnection
     * @return PDO La connexion de l'instance de SqliteConnection
     */
    public function getConnection() : PDO {
        return $this->db;
    }
}
?>