//  Project   : Ajax Chat Sample - JS/AJAX chat
//  Author    : Robin Plojoux
//  Date      : 13.11.2017
//  Reference : https://pub.phyks.me/sdz/sdz/un-chat-en-php-ajax.html

var reloadTime = 500;

function getMessages() {
    // On lance la requête ajax
    $.getJSON('php/get-message.php', function (data) {
        /* On vérifie que error vaut 0, ce
         qui signifie qu'il n'y aucune erreur */

//    $.ajax({
//        type: "GET",
//        url: "php/get-message.php",
//        success: function (data) {

        if (data['error'] == '0') {

            $("#annonce").html('<span class="info"><b>' + data['annonce'] + '</b></span><br /><br />');
            $("#text").html(data['messages']);

        } else if (data['error'] == 'unlog') {
            /* Si error vaut unlog, alors l'utilisateur connecté n'a pas
             de compte. Il faut le rediriger vers la page de connexion */
            $("#annonce").html('');
            $("#text").html('');
            $(location).attr('href', "chat.php");
        }
    });
}

function postMessage() {
    // On lance la requête ajax
    // type: POST > nous envoyons le message

    // On encode le message pour faire passer les caractères spéciaux comme +
    var message = encodeURIComponent($("#message").val());
    $.ajax({
        type: "POST",
        url: "php/post-message.php",
        data: "message=" + message,
        success: function (msg) {
            // Si la réponse est true, tout s'est bien passé,
            // Si non, on a une erreur et on l'affiche
            if (msg == true) {
                // On vide la zone de texte
                $("#message").val('');
                $("#responsePost").slideUp("slow").html('');
            } else
                $("#responsePost").html(msg).slideDown("slow");
            // on resélectionne la zone de texte, en cas d'utilisation du bouton "Envoyer"
            $("#message").focus();
        },
        error: function (msg) {
            // On alerte d'une erreur
            alert('Erreur');
        }
    });
}

function getOnlineUsers() {
    // On lance la requête ajax
    $.getJSON('php/get-online.php', function (data) {

//    $.ajax({
//        type : "GET",
//        url: "php/get-online.php",
//        success: function (data) {

        if (data['error'] == '0') {
            var online = '', i = 1, image, text;
            // On parcours le tableau inscrit dans
            // la colonne [list] du tableau JSON
            for (var id in data['list']) {

                text = 'En ligne';
                image = 'active';
                // On affiche d'abord le lien pour insérer le pseudo dans la zone de texte
                online += '<a href="#post" title="' + text + '">';
                // Ensuite on affiche l'image
                // Enfin on affiche le pseudo
                online += data['list'][id]["login"] + '</a>';

                // Si i vaut 1, ça veut dire qu'on a affiché un membre
                // et qu'on doit aller à la ligne			
                if (i == 1) {
                    i = 0;
                    online += '<br>';
                }
                i++;
            }
            $("#users").html(online);
        } else if (data['error'] == '1') //Personne connecté
            $("#users").html('<span style="color:gray;">Aucun utilisateur connect&eacute;.</span>');
    });
}