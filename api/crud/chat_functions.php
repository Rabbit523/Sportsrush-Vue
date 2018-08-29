<?php
/*
  Project   : Chat functions - PHP Functions
  Author    : Robin Plojoux
  Date      : 22.11.2017
 */

// CREATE
function createMsg($dateTime, $msg, $idUser, $idReceiver, $private, $sender) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Messages (sendingDateTime, message, idUser, idReceiver, private, sender) 
                    VALUES(:dateTime, :msg, :idU, :idR, :private, :sender)');
    $query->execute(array(
        'dateTime' => $dateTime,
        'msg' => $msg,
        'idU' => $idUser,
        'idR' => $idReceiver,
        'private' => $private,
        'sender' => $sender
    ));
    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}

function createPrivateMsg($dateTime, $msg, $idUser, $idReceiver, $private, $sender) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Messages (sendingDateTime, message, idUser, idReceiverUser, private, sender) 
                    VALUES(:dateTime, :msg, :idU, :idR, :private, :sender)');
    $query->execute(array(
        'dateTime' => $dateTime,
        'msg' => $msg,
        'idU' => $idUser,
        'idR' => $idReceiver,
        'private' => $private,
        'sender' => $sender
    ));
    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}

function updateSeenDateP($idMessage, $idReceiver, $seenDate){
    $db = getDatabaseObject();

    $query = $db->prepare("
            UPDATE T_Messages
            SET seenDate = :seenDate
            WHERE idReceiverUser = :idR AND idMessage = :idM");
    $query->execute(array(
        'seenDate' => $seenDate,
        'idR' => $idReceiver,
        'idM' => $idMessage
        
    ));
    $query->closeCursor();
        if ($query) {
        return $query->rowCount();
    } else {
        return false;
    }
}

// READ
function readTeamMessages($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Messages
            WHERE idReceiver = :id AND private = FALSE
            ");
    $query->execute(array(
        'id' => $idTeam
    ));

    if ($query) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function readPrivateMessages($idSender, $idUser) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Messages
            WHERE ( idReceiverUser = :idUser AND idUser = :idSender )
            OR ( idReceiverUser = :idSender AND idUser = :idUser )
            ");
    $query->execute(array(
        'idUser' => $idUser,
        'idSender' => $idSender
    ));

    if ($query) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}




// DELETE

// OTHER