<?php

/*
  Project   : General functions - PHP Functions
  Author    : Robin Plojoux
  Date      : 22.11.2017
 */
include_once('lib/password.php');
include_once ('user_functions.php');

define("HOST", "poxj.myd.infomaniak.com");
define("DB_NAME", "poxj_sportsrush");
define("USER", "poxj_sportsrush");
define("PASSWORD", "devsportsrush127");

// ---------- ConnexionBD ---------- //
/**
 * Retourne un objet de base de données
 * @static var null $pdo => l'objet pdo
 * @return $pdo => la base de données
 */
function &getDatabaseObject() {
    try {
        static $pdo = null;
        if ($pdo === null) {
            $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME, USER, PASSWORD);
            $pdo->exec('set character set utf8;');
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $pdo;
}

// ---------- Connexion utilisateur ---------- //
/**
 * 
 * @param type $email
 * @param type $mdp
 * @return type
 */
function connectUser($email, $mdp) {
    $db = getDatabaseObject(); //Connexion à la base de données

    $error = "";     // Initialise le message d'erreur a vide
    $valid = TRUE;   // Initialise la variable valider a TRUE
    $firstName = null;
    $lastName = null;
    
    if ((!empty($email)) && (!empty($mdp))) {
        $emailArray = readEmail($email);
        $idUser = $emailArray['idUser'];
        if (!$emailArray['verified']){
            $valid = FALSE;
            $error = "email not verified";
        }
    } else {
        $valid = FALSE;
    }
    
   
    //Si les champs ne sont pas vide
    if ($valid && $idUser) {
        
        $dataUser = readUser($idUser);
        //Récupère le hash actuelle de l'utililsateur
        $hash = $dataUser["password"];


        // Vérifie si le mot de passe saisi correspond au hash avec la fonction php "password_verify()"
        //    if ((!empty($hash)) && password_verify($mdp, $hash)) {
        //        /* Connexion valid */
//
        //        // Update le hash
        //      $hash = password_hash($mdp, PASSWORD_BCRYPT); //Genère le nouveau hash
        //        updateHash($idUser, $hash); //Met à jour le nouveau hash
//
        //      $firstName = $dataUser["firstName"];
        //      $lastName = $dataUser["lastName"];
        //      
        //      //On définit les principales propriete de la session
        //     $_SESSION["UID"] = $idUser; //Stock l'identifient du client
        //     $_SESSION["USER"] = $firstName . " " . $lastName; //Stock le nom du client
        //      $_SESSION["CONN"] = true; //Connexion est definit a vrai

        if ($hash == $mdp) {
            $firstName = $dataUser["firstName"];
            $lastName = $dataUser["lastName"];
            $result['email'] = $emailArray['email'];
            $result['idEmail'] = $emailArray['idEmail'];
            $_SESSION["UID"] = $idUser; //Stock l'identifient du client
            $_SESSION["USER"] = $firstName . " " . $lastName; //Stock le nom du client
            $_SESSION["CONN"] = true; //Connexion est definit a vrai
        } else {
            /* Connexion invalid */
            $_SESSION["CONN"] = false; //Connexion définit a faux
            $valid = FALSE; //Valide definit a faux
            $error = $dataUser.'  | '.$mdp; //Prepare une erreur à retourner                
        }
    } else {
        $_SESSION["CONN"] = false; //Connexion définit a faux
        //$error = $dataUser; //Prepare une erreur à retourner 
        $valid = FALSE;
    }
    //}
    $result["valid"] = $valid; //Retourne si valide est vrai ou non
    $result["error"] = $error; //Retourne une erreur
    $result['idUser'] = $idUser;
    $result['firstName'] = $firstName;
    $result['lastName'] = $lastName;
    return $result; //Retourne un tableau avec les resultat
}

/**
 * 
 * @param type $email
 * @return type
 */
function emailExist($email) {
    $exist = false;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM t_emails
            WHERE email = :email
            ");
    $query->execute(array(
        'email' => $email
    ));

    $count = $query->rowCount();

    if ($count > 0) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data["idUser"];
    } else {
        $id = null;
    }


    $query->closeCursor();

    return $id;
}

/**
 * Fonction qui met à jour le hash d'un utilisateur
 * ---------------------------------------------------------
 * @param type $client : Identifiant du client
 * @param type $hash   : Hash du mot de passe
 */
function updateHash($idUser, $hash) {
    $db = getDatabaseObject();

    $query = $db->prepare("
            UPDATE t_users 
            SET password = :pwd
            WHERE idUser = :id");
    $query->execute(array(
        'id' => $idUser,
        'pwd' => $hash
    ));
    $query->closeCursor();
}

