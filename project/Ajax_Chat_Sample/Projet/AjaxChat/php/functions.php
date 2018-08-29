<?php
/*
  Project   : Ajax Chat Sample - PHP Functions
  Author    : Robin Plojoux
  Date      : 13.11.2017
  Reference : https://pub.phyks.me/sdz/sdz/un-chat-en-php-ajax.html
 */

function db_connect() {
    // définition des variables de connexion à la base de données	
    try {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

        $host = '127.0.0.1';
        $dbname = 'ajaxtchat';
        $user = 'tchatUser';
        $password = 'Super';

        $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . '', $user, $password, $pdo_options);
        return $db;
    } catch (Exception $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}

function user_verified() {
    $state = false;
    if (isset($_SESSION['id']) && isset($_SESSION['login'])) {
        $state = true;
    }
    return $state;
}