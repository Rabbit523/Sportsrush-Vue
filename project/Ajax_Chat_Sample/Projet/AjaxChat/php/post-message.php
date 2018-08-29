<?php
/*
  Project   : Ajax Chat Sample - PHP post-message
  Author    : Robin Plojoux
  Date      : 13.11.2017
  Reference : https://pub.phyks.me/sdz/sdz/un-chat-en-php-ajax.html
 */
session_start();
include('functions.php');
$db = db_connect();

if (user_verified()) {
    if (isset($_POST['message']) AND ! empty($_POST['message'])) {
        /* On teste si le message ne contient qu'un ou plusieurs points et
          qu'un ou plusieurs espaces, ou s'il est vide.
          ^ -> début de la chaine - $ -> fin de la chaine
          [-. ] -> espace, rien ou point
          + -> une ou plusieurs fois
          Si c'est le cas, alors on envoie pas le message */
        if (!preg_match("#^[-. ]+$#", $_POST['message'])) {
            $query = $db->prepare("SELECT * FROM chat_messages WHERE message_user = :user ORDER BY message_time DESC LIMIT 0,1");
            $query->execute(array(
                'user' => $_SESSION['id']
            ));
            $data = $query->fetch();

                // Vérification de l'heure du dernier message. (anti spam)
                if (time() - 5 >= $data['message_time']) {

                    $insert = $db->prepare('
                    INSERT INTO chat_messages (message_id, message_user, message_time, message_text) 
                    VALUES(:id, :user, :time, :text)');
                    $insert->execute(array(
                        'id' => '',
                        'user' => $_SESSION['id'],
                        'time' => time(),
                        'text' => $_POST['message']
                    ));
                    echo true;
                } else
                    echo 'Votre dernier message est trop récent. Baissez le rythme :D';
        } else
            echo 'Votre message est vide.';
    } else
        echo 'Votre message est vide.';
} else
    echo 'Vous devez être connecté.';	