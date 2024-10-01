<?php

require_once "../config.php";

require_once DAO_DIR . "/UserDAO.php";
require_once MODELS_DIR . "/User.php";
require_once DAO_DIR . "/ActivityDAO.php";
require_once MODELS_DIR . "/Activity.php";
require_once DAO_DIR .  "/ActivityEntryDAO.php";
require_once MODELS_DIR . "/Data.php";

try {
    // Création de la connexion à la base de données "sport_track.db"
    $connection = SqliteConnection::getInstance()->getConnection();
    // Vérification de la connexion
    if ($connection) {
        echo "Connexion à la base de données réussie. \n";

        // Création d'une instance de UserDAO
        $userDAO = UserDAO::getInstance();
        // Création d'une instance de ActivityDAO
        $activityDAO = ActivityDAO::getInstance();
        // Création d'une instance de ActivityEntryDAO
        $activityEntryDAO = ActivityEntryDAO::getInstance();

        // Récupération de l'identifiant pour l'utilisateur
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT seq FROM sqlite_sequence WHERE name='User'";
        $stmt = $dbc->prepare($query);
        $stmt->execute();
        $resultsUser = $stmt->fetch();
        if (empty($resultsUser)) {
            $resultsUser = 1;
        } else {
            $resultsUser = $resultsUser['seq'] + 1;
        }
        // Récupération de l'identifiant pour l'activité
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT seq FROM sqlite_sequence WHERE name='Activity'";
        $stmt = $dbc->prepare($query);
        $stmt->execute();
        $resultsActivity = $stmt->fetch();
        if (empty($resultsActivity)) {
            $resultsActivity = 1;
        } else {
            $resultsActivity = $resultsActivity['seq'] + 1;
        }
        // Récupération de l'identifiant pour le jeu de données
        $dbc = SqliteConnection::getInstance()->getConnection();
        $query = "SELECT seq FROM sqlite_sequence WHERE name='Data'";
        $stmt = $dbc->prepare($query);
        $stmt->execute();
        $resultsData = $stmt->fetch();
        if (empty($resultsData)) {
            $resultsData = 1;
        } else {
            $resultsData = $resultsData['seq'] + 1;
        }

        // Créer un nouvel utilisateur
        $utilisateur = new User();
        $utilisateur->init($resultsUser, "nathan.guheneuf@gmail.com" . " (" . $resultsUser . ")", "Guheneuf", "Nathan", "2006-06-04", "Homme", 187, 80, "6dcd4ce23d88e2ee9568ba546c007c63d62f5e320c77d53d588f4d80f2f964b");
        // Créer une nouvelle activité
        $activite = new Activity();
        $activite->init($resultsActivity, "01/01/1900", "TEST", $resultsUser);
        // Créer un nouveau jeu de données
        $donnee = new Data();
        $donnee->init($resultsData, "12:00:00", 80, 50, 50, 50, $resultsActivity);

        // Insertion de l'utilisateur dans la base de données
        $userDAO->insert($utilisateur);
        echo "Nouvel utilisateur inséré avec succès. \n";
        // Insertion de l'activité dans la base de données
        $activityDAO->insert($activite);
        echo "Nouvelle activité insérée avec succès \n";
        // Insertion du jeu de données dans la base de données
        $activityEntryDAO->insert($donnee);
        echo "Nouveau jeu de données inséré avec succès \n";

        // Récupération de tous les utilisateurs (ici qu'un seul)
        $users = $userDAO->findAll();
        echo "Tous les utilisateurs dans la base de données : \n";
        foreach ($users as $user) {
            echo $user . "\n";
        }
        // Récupération de toutes les activités (ici qu'une seul)
        $activites = $activityDAO->findAll();
        echo "Toutes les activités dans la base de données : \n";
        foreach($activites as $activite) {
            echo $activite . "\n";
        }
        // Récupération de tous les jeux de données (ici qu'un seul)
        $donnees = $activityEntryDAO->findAll();
        echo "Tous les jeux de données dans la base de données : \n";
        foreach($donnees as $donnee) {
            echo $donnee . "\n";
        }

        // Récupération d'un unique utilisateur (Nathan Guheneuf)
        $leUser = $userDAO->findById($resultsUser);
        echo "Un unique utilisateur dans la base de données : \n";
        echo $leUser . "\n";
        // Récupération d'une unique activité via son identifiant
        $lActivite = $activityDAO->findById($resultsActivity);
        echo "Une unique activité dans la base de données trouvée via son identifiant : \n";
        echo $lActivite . "\n";
        // Récupération d'un unique jeu de données via son identifiant
        $leJeuDeDonnees = $activityEntryDAO->findById($resultsData);
        echo "Un unique jeu de données dans la base de données trouvé via son identifiant : \n";
        echo $leJeuDeDonnees . "\n";

        // Récupération d'une ensemble d'activités trouvées via l'identifiant de leur propriétaire (Nathan Guheneuf)
        $lesActivites = $activityDAO->findByUserId($resultsUser);
        echo "Un ensemble d'activités trouvées via l'identifiant de leur propriétaire : \n";
        foreach($lesActivites as $lActivite) {
            echo $lActivite . "\n";
        }
        // Récupération d'un ensemble de jeux de données trouvés via l'identifiant de leur activité propriétaire
        $lesJeuxDeDonnees = $activityEntryDAO->findByActivityId($resultsActivity);
        echo "Un ensemble de jeux de données trouvés via l'identifiant de leur propriétaire : \n";
        foreach($lesJeuxDeDonnees as $leJeuDeDonnees) {
            echo $leJeuDeDonnees . "\n";
        }
        
        // Modification d'un unique utilisateur (Nathan Guheneuf)
        $utilisateur->init($resultsUser, "error.error@error.error", "ERROR", "ERROR", "1900-01-01",  "Autre", 1, 1, "00000000");
        $userDAO->update($utilisateur);
        echo "L'unique utilisateur mis à jour : \n";
        $leUser = $userDAO->findById($resultsUser);
        echo $leUser . "\n";
        // Modification d'une unique activité (celle associée à Nathan Guheneuf)
        $activite->init($resultsActivity, "01/01/1900", "EMPTY", $resultsUser);
        $activityDAO->update($activite);
        echo "L'unique activité mise à jour : \n";
        $lActivite = $activityDAO->findById($resultsActivity);
        echo $lActivite . "\n";
        // Modification d'un unique jeu de données
        $leJeuDeDonnees->init($resultsData, "00:00:00", 1, 1, 1, 1, $resultsActivity);
        $activityEntryDAO->update($leJeuDeDonnees);
        echo "L'unique jeu de données mis à jour : \n";
        echo $leJeuDeDonnees . "\n";

        // Suppression d'un unique jeu de données
        $activityEntryDAO->delete($leJeuDeDonnees);
        echo "Jeu de données effacé \n";
        // Suppresion d'une unique activité (celle associée à Nathan Guheneuf)
        $activityDAO->delete($activite);
        echo "Activité effacée \n";
        // Suppression d'un unique utilisateur (Nathan Guheneuf)
        $userDAO->delete($utilisateur);
        echo "Utilisateur effacé \n";
    } else {
        echo "Échec de la connexion à la base de données. \n";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
}
