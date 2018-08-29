<?php
/*
  Project   : Ajax Chat Sample - PHP get-message
  Author    : Robin Plojoux
  Date      : 13.11.2017
  Reference : https://pub.phyks.me/sdz/sdz/un-chat-en-php-ajax.html
 */
session_start();
include('functions.php');

$db = db_connect();

if (user_verified()) {

    $json['error'] = '0'; // pas d'erreur 
    // Affichage de l'annonce //////////////////////////////////////////
    $query = $db->query("SELECT * FROM chat_annonce LIMIT 0,1");
    while ($data = $query->fetch())
        $json['annonce'] = $data['annonce_text'];
    $query->closeCursor();

    /* On effectue la requête sur la table contenant les messages. On récupère
      les 100 derniers messages. */

    $query = $db->prepare("
	SELECT message_id, message_user, message_time, message_text, account_id, account_login
	FROM chat_messages
	LEFT JOIN chat_accounts ON chat_accounts.account_id = chat_messages.message_user
	ORDER BY message_time ASC LIMIT 0,100
    ");
    $query->execute();
    $count = $query->rowCount();

    if ($count != 0) {
        $json['messages'] = '<div id="messages_content">';

        $i = 1;
        $e = 0;
        $prev = 0;
        $text = "";
        
        while ($data = $query->fetch()) {
            $text .= '<div class="msg" valign="bottom" style="height:500px;width:95%;height:50px;border-radius:10px;background-color:#96bbf7">';

            // On supprime les balises HTML
            $message = htmlspecialchars($data['message_text']);

            if (isset($data['account_login'])) {
                $text .= '<b>' . $data['account_login'] . '</b>' . ' : ' . $data['message_text'];
            } else {
                $text .= '<b>Unknown</b> : ' . $data['message_text'];
            }

            $text .= '</div>';

            $i++;
            $prev = $data['account_id'];
        }

        $json['messages'] .= $text;

        $json['messages'] .= '</div>';
    } else {
        $json['messages'] = 'Aucun message n\'a été envoyé pour le moment.';
    }
    $query->closeCursor();

    // Encodage de la variable tableau json et affichage
    echo json_encode($json);
} 