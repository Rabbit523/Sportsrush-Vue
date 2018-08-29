<!DOCTYPE html>
<!--
Project   : Ajax Chat Sample - Index
Author    : Robin Plojoux
Date      : 13.11.2017
Reference : https://pub.phyks.me/sdz/sdz/un-chat-en-php-ajax.html
-->
<?php
session_start();
include('php/functions.php');
$db = db_connect();
?>

<html>
    <head>
        <title>Ajax Chat Sample</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="js/chat.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

        <script>
            // Au chargement de la page, on effectue cette fonction
            $(document).ready(function () {
                // On vérifie que la zone de texte existe
                // Servira pour la redirection en cas de suppression de compte
                // Pour ne pas rediriger quand on est sur la page de connexion
                firstload = true;
                if (document.getElementById('message')) {
                    
                    if (firstload) {
                        getMessages();
                        getOnlineUsers();
                        firstload = false;
                    }
                    // actualisation des membres connectés
                    window.setInterval(getOnlineUsers, reloadTime);

                    // actualisation des messages
                    window.setInterval(getMessages, reloadTime);
                    // on sélectionne la zone de texte
                    $("#message").focus();
                }
            });

        </script>

    </head>
    <body>
        <div id="container">

            <?php
            if (isset($_POST['deco'])) {
                session_destroy();
                header('location: chat.php');
            }

            if (isset($_POST['login'])) {
                $login = $_POST['login'];

                $query = $db->prepare("SELECT * FROM chat_accounts WHERE account_login = :login");
                $query->execute(array(
                    'login' => $login
                ));
                // On compte le nombre d'entrées
                $count = $query->rowCount();

                // Si ce nombre est nul, alors on crée le compte, sinon on le connecte simplement
                if ($count == 0) {
                    // Création du compte
                    $insert = $db->prepare('
		INSERT INTO chat_accounts (account_id, account_login) 
		VALUES(:id, :login)
                ');
                    $insert->execute(array(
                        'id' => '',
                        'login' => htmlspecialchars($login),
                    ));

                    /* Création d'une session id ayant pour valeur le dernier ID créé
                      par la dernière requête SQL effectuée */
                    $_SESSION['id'] = $db->lastInsertId();
                    // On crée une session time qui prend la valeur de la date de connexion
                    $_SESSION['time'] = time();
                    $_SESSION['login'] = $login;
                } else {
                    $data = $query->fetch();

                    $_SESSION['id'] = $data['account_id'];
                    // On crée une session time qui prend la valeur de la date de connexion
                    $_SESSION['time'] = time();
                    $_SESSION['login'] = $data['account_login'];
                }
            }

            // Si l'utilisateur n'est pas connecté 
            if (!user_verified()) {
                ?>
                <h1>Welcome, Stranger...</h1>
                <div class="unlog">
                    <form action="" method="post">
                        Indiquez votre pseudo afin de vous connecter au chat. 
                        Entrez simplement votre pseudo.<br><br>

                        <center>
                            <input type="text" name="login" placeholder="Pseudo" /><br />
                            <input type="submit" value="Connexion" />
                        </center>
                    </form>
                </div>

            <?php } else { ?>      
                <h1>Welcome, <?php echo $_SESSION['login']; ?></h1>
                <input type="hidden" id="dateConnexion" value="<?php echo $_SESSION['time']; ?>" />

                <form action="" method="post"><input name="deco" id="exitBtn" type="submit" value="Deconnexion" /></form>

                <table class="chat">
                    <tr>	     

                        <td valign="top" id="text-td">
                            <div id="annonce"></div>
                            <div id="text">
                                <div id="loading">
                                    <center>
                                        <span class="info" id="info">Loading...</span><br />
                                        <img src="img/loading.gif" alt="patientez..."> 
                                    </center>
                                </div>
                            </div>
                        </td>

                        <!-- colonne avec les membres connectés au chat -->
                        <td valign="top" id="users-td"><div id="users"> </div></td>
                    </tr>
                </table>

                <!-- Zone de saisie -->
                <a name="post"></a>
                <table class="post_message">
                    <tr>
                        <td>
                            <form action="" method="" onsubmit="postMessage();
                                        return false;">
                                <input type="text" id="message" maxlength="255" />
                                <input type="button" onclick="postMessage();getMessages()" value="Envoyer" id="post" />
                            </form>
                            <div id="responsePost" style="display:none"></div>
                        </td>
                    </tr>
                </table>

            <?php } ?>

        </div>
    </body>
</html>
