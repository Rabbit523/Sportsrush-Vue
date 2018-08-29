<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function createEvent($idTeam, $title, $desc, $startDateTime, $endDateTime, $wRepeat, $mRepeat) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Events (title, startDate, endDate, description, idteam, wRepeat, mRepeat) 
                    VALUES(:title, :start, :end, :desc, :idteam, :wRepeat, :mRepeat)');
    $query->execute(array(
        'title' => $title,
        'start' => $startDateTime,
        'end' => $endDateTime,
        'desc' => $desc,
        'idteam' => $idTeam,
        'wRepeat' => $wRepeat,
        'mRepeat' => $mRepeat
    ));
    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}

function readEvents($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Events
            WHERE idTeam = :id 
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

function readEvent($idEvent) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Events
            WHERE idEvent = :id
            ");
    $query->execute(array(
        'id' => $idEvent
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function deleteEvent($idEvent) {
    $db = getDatabaseObject();

    $query = $db->prepare('DELETE FROM T_Events WHERE idEvent = :id');
    $query->execute(array(
        'id' => $idEvent
    ));
    $query->closeCursor();
}

