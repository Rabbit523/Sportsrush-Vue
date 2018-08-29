<?php

/*
  Project   : Team functions - PHP Functions
  Author    : Robin Plojoux
  Date      : 22.11.2017
 */

// CREATE
require_once('general_functions.php');

function createTeam($teamName, $description, $teamLogo, $idSport) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Teams (teamName, description, teamLogo, idSport) 
                    VALUES(:name, :desc, :logo, :sport)');
    $query->execute(array(
        'name' => $teamName,
        'desc' => $description,
        'logo' => $teamLogo,
        'sport' => $idSport
    ));
    $id = $db->lastInsertId();

    $query->closeCursor();

    return $id;
}

function createTeamNoLogo($teamName, $description, $idSport, $type) {
    $db = getDatabaseObject();

    $query = $db->prepare("
            INSERT INTO T_Teams (teamName, description, teamLogo, idSport, type)
                    VALUES(:name, :desc, :logo, :sport, :type)");
    
    $query->execute(array(
        'name' => $teamName,
        'desc' => $description,
        'logo' => "no logo uploaded",
        'sport' => $idSport,
        'type' => $type
    ));

    $id = $db->lastInsertId();
    $query->closeCursor();

    return $id;
}


function createInvitation($idTeam, $idEmail, $code, $coachInput) {
    $db = getDatabaseObject();
    $data = null;
    if ($coachInput == "false"){
        $coach = 0;
    } else {
        $coach = 1;
    }
    $query = $db->prepare('
            INSERT INTO T_Invitations (idTeam, idEmail, code, coach) 
                    VALUES(:idTeam, :idEmail, :code, :coach)');
    $query->execute(array(
        'idTeam' => $idTeam,
        'idEmail' => $idEmail,
        'code' => $code,
        'coach' => $coach
    ));

    $query = $db->prepare("
            SELECT *
            FROM T_Invitations
            WHERE idTeam = :idTeam AND idEmail = :idEmail
            ");
    $query->execute(array(
        'idTeam' => $idTeam,
        'idEmail' => $idEmail
    ));
    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function createMembership($idUser, $idTeam, $isCoach) {
    $db = getDatabaseObject();
    $query = $db->prepare('
            INSERT INTO T_Memberships (idUser, idTeam, coach) 
                    VALUES(:idUser, :idTeam, :coach)');
    $query->execute(array(
        'idUser' => $idUser,
        'idTeam' => $idTeam,
        'coach' => $isCoach
    ));

    $query = $db->prepare("
            SELECT *
            FROM T_Memberships
            WHERE idTeam = :idTeam AND idUser = :idUser
            ");
    $query->execute(array(
        'idTeam' => $idTeam,
        'idUser' => $idUser
    ));
    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }

    $id = $db->lastInsertId();
    $query->closeCursor();

    return $data;
}

function readMembership($idTeam, $idUser) {
    $db = getDatabaseObject();

    $query = $db->prepare('SELECT * FROM T_Memberships WHERE idTeam = :idTeam AND idUser = :idUser');
    $query->execute(array(
        'idTeam' => $idTeam,
        'idUser' => $idUser
    ));
    
    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }

    $id = $db->lastInsertId();
    $query->closeCursor();

    return $data;
}

function deleteMembership($idTeam, $idUser) {
    $db = getDatabaseObject();

    $query = $db->prepare('DELETE FROM T_Memberships WHERE idTeam = :idTeam AND idUser = :idUser');
    $query->execute(array(
        'idTeam' => $idTeam,
        'idUser' => $idUser
    ));
    $query->closeCursor();
}

// READ
function readTeam($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Teams
            WHERE idTeam = :id
            ");
    $query->execute(array(
        'id' => $idTeam
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

function updateSeenDateM($idTeam, $idUser, $seenDate){
    $db = getDatabaseObject();

    $query = $db->prepare("
            UPDATE T_Memberships
            SET seenDate = :seenDate
            WHERE idTeam = :idTeam AND idUser = :idUser");
    $query->execute(array(
        'seenDate' => $seenDate,
        'idTeam' => $idTeam,
        'idUser' => $idUser
        
    ));
    $query->closeCursor();
        if ($query) {
        return $query->rowCount();
    } else {
        return false;
    }
}

function countCoaches($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
        SELECT COUNT(*) AS nbCoaches FROM T_Memberships
        WHERE idTeam = :id AND coach = 1
            ");
    $query->execute(array(
        'id' => $idTeam
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}
function readCoaches($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
        SELECT idUser, firstName, lastName FROM T_Memberships
        NATURAL JOIN T_Users
        WHERE idTeam = :id AND coach = 1
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
function readPlayers($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
        SELECT idUser, firstName, lastName FROM T_Memberships
        NATURAL JOIN T_Users
        WHERE idTeam = :id AND coach = 0
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

function countPlayers($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
        SELECT COUNT(*) AS nbPlayers FROM T_Memberships
        WHERE idTeam = :id AND coach = 0
            ");
    $query->execute(array(
        'id' => $idTeam
    ));

    if ($query) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
    }
    $query->closeCursor();

    return $data;
}

// UPDATE
function updateTeam($idTeam, $teamName, $description, $idSport) {
    $db = getDatabaseObject();

    $query = $db->prepare("
            UPDATE T_Teams 
            SET teamName = :name, description = :desc, idSport = :sport
            WHERE idTeam = :id");
    $query->execute(array(
        'id' => $idTeam,
        'name' => $teamName,
        'desc' => $description,
        'sport' => $idSport
    ));
    $query->closeCursor();
    if ($query) {
        return $query->rowCount();
    } else {
        return false;
    }
}

function setCoach($idUser, $idTeam) {
    $db = getDatabaseObject();

    $query = $db->prepare("
            UPDATE T_Memberships
            SET coach = 1
            WHERE idUser = :idUser AND idTeam = :idTeam");
    $query->execute(array(
        'idUser' => $idUser,
        'idTeam' => $idTeam
    ));
    $query->closeCursor();
    if ($query) {
        return $query->rowCount();
    } else {
        return false;
    }
}

function leaveTeam($idUser, $idTeam) {
    $db = getDatabaseObject();

    $query = $db->prepare("
            DELETE FROM T_Memberships
            WHERE idUser = :idUser AND idTeam = :idTeam");
    $query->execute(array(
        'idUser' => $idUser,
        'idTeam' => $idTeam
    ));
    $query->closeCursor();
}

// DELETE
function deleteTeam($idTeam) {
    $db = getDatabaseObject();

    $query = $db->prepare('DELETE FROM T_Teams WHERE idTeam = :id');
    $query->execute(array(
        'id' => $idTeam
    ));
    $query->closeCursor();
}

function deleteInvitation($idTeam, $idEmail) {
    $db = getDatabaseObject();

    $query = $db->prepare('DELETE FROM T_Invitations WHERE idTeam = :idTeam AND idEmail = :idEmail ');
    $query->execute(array(
        'idTeam' => $idTeam,
        'idEmail' => $idEmail
    ));
    $query->closeCursor();
}

// OTHER
function hasEvents($idTeam) {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM t_events
            WHERE idTeam = :id
            ");

    $query->execute(array(
        'id' => $idTeam
    ));

    $count = $query->rowCount();

    if ($count != 0) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    return $data;
}

function readSports() {
    $data = null;
    $db = getDatabaseObject();

    $query = $db->prepare("
            SELECT *
            FROM T_Sports ");

    $query->execute();

    $count = $query->rowCount();

    if ($count != 0) {
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    $query->closeCursor();

    return $data;
}
