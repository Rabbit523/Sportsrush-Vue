<?php
/*
  Project   : Event functions - PHP Functions
  Author    : Robin Plojoux
  Date      : 22.11.2017
 */
require_once('general_functions.php');

// CREATE
function createEvent($title, $start, $end, $description, $idTeam) {
    $db = db_connect();
    $query = $db->prepare('
            INSERT INTO t_events (title, start, end, description, idTeam) 
                    VALUES(:title, :start, :end, :description, idTeam)');
    $query->execute(array(
        'title' => $title,
        'start' => $start,
        'end' => $end,
        'end' => $description,
        'idTeam' => $idTeam
    ));
    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}

// READ
function readEvent($idEvent) {
    $data = null;
    $db = db_connect();

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

// UPDATE
function updateEvent($idEvent, $title, $start, $end, $description, $idTeam) {
    $db = db_connect();

    $query = $db->prepare("
            UPDATE t_users 
            SET title = :title, start = :start, end = :end, description = :description 
            WHERE idEvent = :id");
    $query->execute(array(
        'id' => $idEvent,
        'title' => $title,
        'start' => $start,
        'end' => $end,
        'description' => $description,
        'end' => $idTeam
    ));
    $query->closeCursor();
}

// DELETE
function deleteEvent($idEvent) {
    $db = db_connect();

    $query = $db->prepare('DELETE FROM T_Events WHERE idEvent = :id');
    $query->execute(array(
        'id' => $idEvent
    ));
    $query->closeCursor();
}

// OTHER
