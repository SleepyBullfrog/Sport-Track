<?php
declare(strict_types=1);

/**
 * Représente un utilisateur dans la base de données "sport_track.db"
 * @author Nathan Guhéneuf-Le Brec - Septembre 2024
 * @version 1.0.0
 */
class User {
    /** Identifiant de l'utilisateur */
    private int $idUser;
    /** E-mail de l'utilisateur */
    private string $emailUser;
    /** Nom de famille de l'utilisateur */
    private string $nameUser;
    /** Prénom de l'utilisateur */
    private string $firstNameUser;
    /** Date de naissance de l'utilisateur */
    private string $birthdateUser;
    /** Sexe de l'utilisateur */
    private string $genderUser;
    /** Taille de l'utilisateur */
    private int $heightUser;
    /** Poids de l'utilisateur */
    private int $weightUser;
    /** Mot de passe de l'utilisateur */
    private string $passwordUser;

    /** 
     * Constructeur sans paramètre 
     */
    public function __construct() {}

    /**
     * Permet d'initialiser les attributs de l'instance appelante de la classe User
     * @param int $idUser L'identifiant qu'on donne à l'instance de la classe User
     * @param string $emailUser L'e-mail qu'on donne à l'instance de la classe User
     * @param string $nameUser Le nom de famille qu'on donne à l'instance de la classe
     * @param string $firstNameUser Le prénom qu'on donnne à l'instance de la classe User
     * @param string $birthdateUser La date de naissance qu'on donne à l'instance de la classe User
     * @param string $genderUser Le sexe qu'on donne à l'instance de la classe User
     * @param int $heightUser La taille qu'on donne à l'instance de la classe User
     * @param int $weightUser Le poids qu'on donne à l'instance de la classe User
     * @param string $passwordUser Le mot de passe qu'on donne à l'instance de la classe User
     */
    public function init(int $idUser, string $emailUser, string $nameUser, string $firstNameUser, string $birthdateUser, string $genderUser, int $heightUser, int $weightUser, string $passwordUser) {
        $this->idUser = $idUser;
        $this->emailUser = $emailUser;
        $this->nameUser = $nameUser;
        $this->firstNameUser = $firstNameUser;
        $this->birthdateUser = $birthdateUser;
        $this->genderUser = $genderUser;
        $this->heightUser = $heightUser;
        $this->weightUser = $weightUser;
        $this->passwordUser = $passwordUser;
    }

    /**
     * Renvoie l'identifiant de l'utilisateur
     * @return int L'identifiant de l'utilisateur
     */
    public function getIdUser() : int {
        return $this->idUser;
    }

    /** 
     * Renvoie l'e-mail de l'utilisateur 
     * @return string L'e-mail de l'utilisateur
     */
    public function getEmailUser() : string {
        return $this->emailUser;
    }

    /**
     * Renvoie le nom de famille de l'utilisateur
     * @return string Le nom de famille de l'utilisateur
     */
    public function getNameUser() : string {
        return $this->nameUser;
    }

    /**
     * Renvoie le prénom de l'utilisateur
     * @return string Le prénom de l'utilisateur
     */
    public function getFirstNameUser() : string {
        return $this->firstNameUser;
    }

    /**
     * Renvoie la date de naissance de l'utilisateur
     * @return string La date de naissance de l'utilisateur
     */
    public function getBirthdateUser() : string {
        return $this->birthdateUser;
    }

    /**
     * Renvoie le sexe de l'utilisateur
     * @return string Le sexe de l'utilisateur
     */
    public function getGenderUser() : string {
        return $this->genderUser;
    }

    /**
     * Renvoie la taille de l'utilisateur
     * @return int La taille de l'utilisateur
     */
    public function getHeightUser() : int {
        return $this->heightUser;
    }

    /**
     * Renvoie le poids de l'utilisateur
     * @return int Le poids de l'utilisateur
     */
    public function getWeightUser() : int {
        return $this->weightUser;
    }

    /**
     * Renvoie le mot de passe de l'utilisateur
     * @return string Le mot de passe de l'utilisateur
     */
    public function getPasswordUser() : string {
        return $this->passwordUser;
    }

    /**
     * Renvoie les données concernant l'utilisateur sous format lisible
     * @return string Les données concernant l'utilisateur sous format lisible
     */
    public function __toString() : string {
        return  $this->idUser . ", " . $this->nameUser . " " . $this->firstNameUser .
                ", Date de naissance : " . $this->birthdateUser .
                ", E-mail : " . $this->emailUser .
                ", Taille : " . $this->heightUser .
                ", Poids : " . $this->weightUser .
                ", Mot de passe : " . $this->passwordUser;
    }
}
?>