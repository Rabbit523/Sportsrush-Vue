<?php

/*
  Project   : User functions - PHP Functions
  Author    : Robin Plojoux
  Date      : 22.11.2017
 */
require_once('general_functions.php');
require_once('calendar_functions.php');

// CREATE
function createUser($firstName, $lastName, $pwd, $birthday, $country, $city, $street, $zipcode, $phone, $interests) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Users (firstName, lastName, password, birthday, country, city, street, zipcode, phone, interests) 
                    VALUES(:first, :last, :pwd, :birth, :country, :city, :street, :zipcode, :phone, :interests )');
    $query->execute(array(
        'first' => $firstName,
        'last' => $lastName,
        'pwd' => $pwd,
        'birth' => $birthday,
        'country' => $country,
        'city' => $city,
        'street' => $street,
        'zipcode' => $zipcode,
        'phone' => $phone,
        'interests' => $interests
    ));
    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}

// READ
function readUser($idUser) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Users
            WHERE idUser = :id
            ");
    $query->execute(array(
        'id' => $idUser
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function readEmail($email) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Emails
            WHERE email = :email
            ");
    $query->execute(array(
        'email' => $email
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function readEmailById($idEmail) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Emails
            WHERE idEmail = :id
            ");
    $query->execute(array(
        'id' => $idEmail
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function writeEmail($email, $idUser, $code) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Emails (email, idUser, code) 
                    VALUES(:email, :idUser, :code)');
    $query->execute(array(
        'email' => $email,
        'idUser' => $idUser,
        'code' => $code
    ));
    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}

function writeEmailNoUser($email, $code) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Emails (email, code) 
                    VALUES(:email, :code)');
    $query->execute(array(
        'email' => $email,
        'code' => $code
    ));
    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}

function updateEmailUserId($idEmail, $idUser) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            UPDATE T_Emails 
            SET idUser = :idUser
            WHERE idEmail = :idEmail');
    $query->execute(array(
        'idUser' => $idUser,
        'idEmail' => $idEmail
    ));
    $query->closeCursor();

}

function writeSeenMessage($idUser, $idMessage) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_SeenMessages (idUser, idMessage) 
                    VALUES(:idUser, :idMessage)');
    $query->execute(array(
        'idUser' => $idUser,
        'idMessage' => $idMessage
    ));
    $query->closeCursor();
}

function readUnseenMessages($idUser) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            SELECT * FROM T_Messages AS msg
            LEFT JOIN T_Memberships AS mem ON msg.idReceiver = mem.idTeam
            WHERE mem.idUser = :id AND mem.seenDate < msg.sendingDateTime'
            );
    $query->execute(array(
        'id' => $idUser
    ));
    
    if ($query) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $query->closeCursor();
    return $data;
}

function readUnseenPM($idReceiver) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
        SELECT * FROM T_Messages
        WHERE idReceiverUser = :id AND seenDate IS NULL
            ");
    $query->execute(array(
        'id' => $idReceiver
    ));

    if ($query) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function verifyEmail($idEmail) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            UPDATE T_Emails 
            SET verified = 1
            WHERE idEmail = :id
                    ');
    $query->execute(array(
        'id' => $idEmail
    ));
}

// UPDATE
function updateUser($idUser, $firstName, $lastName, $password, $birthday, $country, $city, $interests) {
    $db = getDatabaseObject();

    $query = $db->prepare("
            UPDATE T_Users 
            SET firstName = :first, lastName = :last, password = :pwd, birthday = :birth, country = :country, city = :city, interests = :interests
            WHERE idUser = :id");
    $query->execute(array(
        'id' => $idUser,
        'first' => $firstName,
        'last' => $lastName,
        'pwd' => sha1($password),
        'birth' => $birthday,
        'country' => $country,
        'city' => $city,
        'interests' => $interests,
    ));
    $query->closeCursor();
    if ($query) {
        return $query->rowCount();
    } else {
        return false;
    }
}

// DELETE
function deleteUser($idUser) {
    $db = getDatabaseObject();

    $query = $db->prepare('DELETE FROM t_users WHERE idUser = :id');
    $query->execute(array(
        'id' => $idUser
    ));
    $query->closeCursor();
}

// OTHER
function hasTeams($idUser) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT T_Memberships.idTeam, teamName, description, type, idSport, coach
            FROM T_Memberships
            LEFT JOIN T_Teams ON T_Teams.idTeam = T_Memberships.idTeam
            WHERE T_Memberships.idUser = :id
            ");

    $query->execute(array(
        'id' => $idUser
    ));

    $count = $query->rowCount();

    if ($count != 0) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    $query->closeCursor();

    return $data;
}

function readInvitations($idEmail) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
        SELECT * FROM `T_Invitations` AS i
        natural JOIN  T_Teams AS t
        WHERE i.idEmail = :idEmail
            ");
    $query->execute(array(
        'idEmail' => $idEmail
    ));

    if ($query) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function readInvitation($idTeam, $idEmail) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
        SELECT * FROM `T_Invitations` 
        WHERE idEmail = :idEmail AND idTeam = :idTeam
            ");
    $query->execute(array(
        'idEmail' => $idEmail,
        'idTeam' => $idTeam
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}
