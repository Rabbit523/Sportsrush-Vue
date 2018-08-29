
<?php

class TTAPI {

    private $db_tables = [
        'T_Users',
    ];
    private $allowedOrigins = [
        'https://dev.sportsrush.ch',
        'http://127.0.0.1:8080',
        'http://localhost:8080',
        'http://dev.sportsrush.ch',
        'https://127.0.0.1:8080',
        'https://localhost:8080',
        'http://localhost:8080',
        'http://sportsrush.ch',
        'https://sportsrush.ch'
    ];
    private $GETGranting = [
        'test',
        'loginCheck',
        'sports',
        'teams',
        'logout',
        'verifyEmail',
        'joinTeam'
    ];
    private $POSTGranting = [
        'test',
        'registerUser',
        'login',
        'createTeam',
        'teams',
        'newMessage',
        'messages',
        'invite',
        'invitations',
        'joinTeam',
        'declineInvitation',
        'updateUser',
        'countCoaches',
        'countPlayers',
        'getEmail',
        'unseenMessages',
        'newPrivateMessage',
        'privateMessages',
        'unseenPMs',
        'getUser',
        'createEvent',
        'events',
        'deleteEvent',
        'deleteMembership',
        'seenDateM',
        'seenDateP',
        'updateTeam',
        'eventsTeams',
        'deleteTeam',
        'setCoach',
        'leaveTeam'
    ];
    private $PATCHGranting = [
        'test',
        'updateUser'
    ];
    private $DELETEGranting = [
        'test'
    ];
    private $r = [], $s = 0; // The request array
    private $method;
    private $uid = null;
    private $nbLettersCode = 16;

    function __construct() {

        require_once './crud/db.php';
        require_once './crud/lib/Bypass.php';
        if (session_status() == PHP_SESSION_NONE)
            session_start();


        $this->setDefaultHeaders();
        $request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        array_shift($request);
        $this->r = $request;
        $this->s = sizeof($request);
        $this->uid = $_SESSION['id'];
        $this->setUid();
        $this->apiRouting();
    }

    function setDefaultHeaders() {
        $origin = $_SERVER['HTTP_ORIGIN'];

        //if (in_array($origin, $this->allowedOrigins))
        header("Access-Control-Allow-Origin: $origin");


        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS,PATCH");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: application/json");
        header("Access-Control-Allow-Credentials: true");
    }

    function setUid() {
        $bypass = new Bypass();

        // we check if the bypass is needed (localhost hack)
        if ($bypass->isNeeded()) {
            $_SESSION['id'] = $bypass->getDefaultId();
            $this->uid = $bypass->getDefaultId();
        }

        // if the session is set, we ensure set the uid from the session
        else if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
            $this->uid = $_SESSION['id'];
        }

        // here the uid should be set, either from the the session or the bypass
        if (!isset($this->uid))
            $this->uid = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    }

    function genericMethodLoader($haystack, $prefix) {
        $resourceMem = explode('?', trim($this->r[0]));
        $r = $resourceMem[0];
        $rId = $this->r[1];
        $child = $this->r[2];
        $p = strtolower($prefix);

        // The resource is called by default with the $_SESSION['user_id']
        if ($this->s == 1) {
            if (in_array($r, $haystack) || array_key_exists($r, $haystack)) {
                $v = "_" . $p . "_" . $r;
                $this->$v();
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "Resource not granted ($r)"
                ]);
            }
        }
        if ($this->s == 2) {
            // TODO check resource rights
            if (in_array($r, $haystack) || array_key_exists($r, $haystack)) {
                $v = "_" . $p . "_" . $r;
                $this->$v();
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "Resource not granted"
                ]);
            }
        }
        if ($this->s == 3) {
            if (array_key_exists($r, $haystack)) {
                if (in_array($child, $haystack[$r])) {
                    $v = "_" . $p . "_" . $child;
                    $this->$v($rId);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "Resource not granted"
                ]);
            }
        }
    }

    function apiRouting() {

        if ($this->s <= 0) {
            $this->buildHeader("501");
            exit();
        }
        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method == 'GET') {
            $this->genericMethodLoader($this->GETGranting, $this->method);
        } else if ($this->method == 'PUT') {
            parse_str(file_get_contents('php://input'), $_PUT); // Create the globally akin variable $_PUT
            $this->buildHeader("404 PUT Method");
        } else if ($this->method == 'PATCH') {
            parse_str(file_get_contents('php://input'), $this->_PATCH); // Create the globally akin variable $_PATCH
            $this->genericMethodLoader($this->PATCHGranting, $this->method);
        } else if ($this->method == 'POST') {
            $this->genericMethodLoader($this->POSTGranting, $this->method);
        } else if ($this->method == 'DELETE') {
            $this->genericMethodLoader($this->DELETEGranting, $this->method);
        }
    }

    function buildHeader($message) {
        $host = $_SERVER['HTTP_HOST'];
        header("HTTP/$host $message");
    }

    function createRandomPassword($nbLetters) {

        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double) microtime() * 1000000);
        $i = 0;
        $pass = '';

        while ($i <= $nbLetters - 1) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;
    }

    function _get_test() {
        echo json_encode([
            'success' => true,
            'message' => "test api",
            'testApi' => "test"
        ]);
    }

    function _get_loginCheck() {
        if (!empty($_SESSION['UID'])) {
            $user = readUser($_SESSION['UID']);
            echo json_encode([
                'success' => true,
                'message' => "user connected",
                'idUser' => $_SESSION['UID'],
                'firstName' => $_SESSION['firstName'],
                'lastName' => $_SESSION['lastName'],
                'user' => $user
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "user not connected",
                'idUser' => null,
                'session' => $_SESSION
            ]);
        }
    }

    function _get_verifyEmail() {
        $codeSent = $_GET['code'];
        $idEmail = $_GET['idEmail'];
        $email = readEmailById($idEmail);
        if ($email) {
            if ($email['code'] == $codeSent) {
                verifyEmail($idEmail);               
                echo json_encode([
                    'success' => true,
                    'message' => "email verified",
                    'code' => $codeSent,
                    'idEmail' => $idEmail
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "wrong code",
                    'code' => $codeSent,
                    'idEmail' => $idEmail
                ]);
            }
        } else {

            echo json_encode([
                'success' => false,
                'message' => "email does not exist",
                'code' => $codeSent,
                'idEmail' => $idEmail
            ]);
        }
    }

    function _get_sports() {
        $sports = readSports();
        if (!empty($sports)) {
            echo json_encode([
                'success' => true,
                'message' => "test api",
                'testApi' => "test",
                'sports' => $sports
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no sports in database",
                'sports' => $sports
            ]);
        }
    }

    function _get_logout() {
        session_destroy();
        echo json_encode([
            'success' => true,
            'message' => "user logged out"
        ]);
    }
    
    function _get_joinTeam() {
        $idTeam = filter_input(INPUT_GET, 'idTeam');
        $idEmail = filter_input(INPUT_GET, 'idEmail');
        $idUser = filter_input(INPUT_GET, 'idUser');
        $invitation = readInvitation($idTeam, $idEmail);
        if (!empty($invitation)) {

            $membership = createMembership($idUser, $invitation['idTeam'], $invitation['coach']);

            if ($membership) {
                deleteInvitation($invitation['idTeam'], $invitation['idEmail']);
                echo json_encode([
                    'success' => true,
                    'message' => "team joined",
                    'membership' => $membership,
                    'invitation' => $invitation
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "error in team creation",
                    'membership' => $membership,
                    'invitation' => $invitation
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => "invitation not found",
                'membership' => $membership,
                'invitation' => $invitation
            ]);
        }
    }
    
    function _post_teams() {
        $idUser = filter_input(INPUT_POST, 'idUser');
        $teams = hasTeams($idUser);
        foreach ($teams as $key => $team) {
            $nbCoaches = countCoaches($team['idTeam']);
            $teams[$key]['nbCoaches'] = $nbCoaches['nbCoaches'];
            $coaches = readCoaches($team['idTeam']);
            $teams[$key]['coaches'] = $coaches;

            $nbPlayers = countPlayers($team['idTeam']);
            $teams[$key]['nbPlayers'] = $nbPlayers['nbPlayers'];
            $players = readPlayers($team['idTeam']);
            $teams[$key]['players'] = $players;
        }
        if (!empty($teams)) {
            echo json_encode([
                'success' => true,
                'message' => "teams found",
                'teams' => $teams
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no teams found",
                'idUser' => $idUser
            ]);
        }
    }

    function _post_declineInvitation() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $idEmail = filter_input(INPUT_POST, 'idEmail');
        $invitation = readInvitation($idTeam, $idEmail);
        if (!empty($invitation)) {

            deleteInvitation($invitation['idTeam'], $invitation['idEmail']);
            echo json_encode([
                'success' => true,
                'message' => "invitation declined",
                'invitation' => $invitation
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "invitation not found",
                'invitation' => $invitation
            ]);
        }
    }
    
    function _post_deleteEvent() {
        $idEvent = filter_input(INPUT_POST, 'idEvent');
        $event = readEvent($idEvent);
        if (!empty($event)) {

            deleteEvent($idEvent);
            echo json_encode([
                'success' => true,
                'message' => "event deleted"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "event not found"
            ]);
        }
    }
    
    function _post_leaveTeam() {
        $idUser = filter_input(INPUT_POST, 'idUser');
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $membership = readMembership($idTeam, $idUser);
        if (!empty($membership)) {

            leaveTeam($idUser, $idTeam);
            echo json_encode([
                'success' => true,
                'message' => "team left",
                'idTeam' => $idTeam,
                'idUser' => $idUser
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "membership not found",
                'idTeam' => $idTeam,
                'idUser' => $idUser
            ]);
        }
    }
    
    function _post_deleteTeam() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $team = readTeam($idTeam);
        if (!empty($team)) {

            deleteTeam($idTeam);
            echo json_encode([
                'success' => true,
                'message' => "team deleted"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "team not found"
            ]);
        }
    }
    
    function _post_deleteMembership() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $player = $_POST['player'];
        $team = $_POST['team'];
        $membership = readMembership($idTeam, $idUser);
        if (!empty($membership)) {
            deleteMembership($idTeam, $idUser);
            echo json_encode([
                'success' => true,
                'message' => "membership deleted",
                'team' => $team,
                'player' => $player
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "membership not found",
                'idTeam' => $idTeam,
                'idUser' => $idUser,
                'membership' => $membership
            ]);
        }
    }
    
    function _post_getEmail() {
        $emailIn = filter_input(INPUT_POST, 'email');
        $emailOut = readEmail($emailIn);
        if (!empty($emailOut)) {
            echo json_encode([
                'success' => true,
                'message' => "email found",
                'emailInput' => $emailIn,
                'emailOutput' => $emailOut
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "email not found",
                'email input' => $emailIn
            ]);
        }
    }
    
    // not working
    function _post_unseenMessages() {
        $idUser = filter_input(INPUT_POST, 'idUser');
        $messages = readUnseenMessages($idUser);
        foreach($messages as $key => $message){
            $team = readTeam($message['idReceiver']);
            $messages[$key]['team'] = $team;
        }
        if (!empty($messages)){
            echo json_encode([
                'success' => true,
                'message' => "messages found",
                'idUser' => $idUser,
                'messages' => $messages
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "messages not found",
                'idUser' => $idUser,
                'messages' => $messages
            ]);
        }
        
    }
    
    function _post_unseenPMs() {
        
        $idUser = filter_input(INPUT_POST, 'idUser');
        $messages = readUnseenPM($idUser);
        
        
        if (!empty($messages)){
            echo json_encode([
                'success' => true,
                'message' => "messages found",
                'idUser' => $idUser,
                'messages' => $messages,
                'seenDate' => $seenDate
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "messages not found",
                'idUser' => $idUser,
                'messages' => $messages,
                'seenDate' => $seenDate
            ]);
        }
        
    }
    
    function _post_updateTeam() {
        
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $teamName= filter_input(INPUT_POST, 'teamName');
        $idSport = filter_input(INPUT_POST, 'idSport');
        $teamDesc = filter_input(INPUT_POST, 'teamDesc');
        $updateSuccess = updateTeam($idTeam, $teamName, $teamDesc, $idSport);
        
        if (!empty($updateSuccess)){
            echo json_encode([
                'success' => true,
                'message' => "team updated",
                'idTeam' => $idTeam,
                'teamName' => $teamName,
                'idSport' => $idSport,
                'teamDesc' => $teamDesc
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "team not updated",
                'idTeam' => $idTeam,
                'teamName' => $teamName,
                'idSport' => $idSport,
                'teamDesc' => $teamDesc
            ]);
        }
        
    }
    
    function _post_setCoach() {
        
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $updateSuccess = setCoach($idUser, $idTeam);
        
        if (!empty($updateSuccess)){
            echo json_encode([
                'success' => true,
                'message' => "player set as coach",
                'idTeam' => $idTeam,
                'idUser' => $idUser
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "player not set as coach",
                'idTeam' => $idTeam,
                'idUser' => $idUser
            ]);
        }
        
    }
    
    
    function _post_getUser() {
        
        $idUser = filter_input(INPUT_POST, 'idUser');
        $user = readUser($idUser);
        
        
        if ($user){
            echo json_encode([
                'success' => true,
                'message' => "user found",
                'idUser' => $idUser,
                'user' => $user
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "user not found",
                'idUser' => $idUser,
                'user' => $user
            ]);
        }
        
    }
    
    function _post_joinTeam() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $idEmail = filter_input(INPUT_POST, 'idEmail');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $invitation = readInvitation($idTeam, $idEmail);
        if (!empty($invitation)) {

            $membership = createMembership($idUser, $invitation['idTeam'], $invitation['coach']);

            if ($membership) {
                deleteInvitation($invitation['idTeam'], $invitation['idEmail']);
                echo json_encode([
                    'success' => true,
                    'message' => "team joined",
                    'membership' => $membership,
                    'invitation' => $invitation
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "error in team creation",
                    'membership' => $membership,
                    'invitation' => $invitation
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => "invitation not found",
                'membership' => $membership,
                'invitation' => $invitation
            ]);
        }
    }

    function _post_invitations() {
        $idEmail = filter_input(INPUT_POST, 'idEmail');
        $invitations = readInvitations($idEmail);
        if (!empty($invitations)) {
            echo json_encode([
                'success' => true,
                'message' => "invitations received",
                'invitations' => $invitations
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no invitations found",
                'invitations' => $invitations,
                'idEmail' => $idEmail
            ]);
        }
    }

    function _post_countCoaches() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $nbCoaches = countCoaches($idTeam);
        if ($nbCoaches) {
            echo json_encode([
                'success' => true,
                'message' => "coaches found",
                'nbCoaches' => $nbCoaches
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no coaches",
                'post-val' => $_POST,
                'nbCoaches' => $nbCoaches
            ]);
        }
    }

    function _post_countPlayers() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $nbPlayers = countPlayers($idTeam);
        if ($nbPlayers) {
            echo json_encode([
                'success' => true,
                'message' => "players found",
                'nbPlayers' => $nbPlayers
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'message' => "no players found",
                'post-val' => $_POST,
                'nbPlayers' => $nbPlayers
            ]);
        }
    }

    function _post_messages() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $messages = readTeamMessages($idTeam);
        if ($messages) {
            foreach($messages as $message){
                writeSeenMessage($idUser, $message['idMessage']);
            }
            echo json_encode([
                'success' => true,
                'message' => "messages received",
                'messages' => $messages
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no messages",
                'post-val' => $_POST,
                'messages' => null
            ]);
        }
    }
    
    function _post_privateMessages() {
        $idSender = filter_input(INPUT_POST, 'idSender');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $messages = readPrivateMessages($idSender, $idUser);
        if ($messages) {
            foreach($messages as $message){
                if ($idUser !== $message['idUser']){
                    writeSeenMessage($idUser, $message['idMessage']);
                }
            }
            echo json_encode([
                'success' => true,
                'message' => "messages received",
                'messages' => $messages,
                'idUser' => $idUser
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no messages",
                'post-val' => $_POST,
                'messages' => null,
                'idUser' => $idUser
            ]);
        }
    }

    function _post_registerUser() {
        $user = null;
        $email = filter_input(INPUT_POST, 'email');
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $password = sha1(filter_input(INPUT_POST, 'password'));
        $existingEmail = readEmail($email);
        $code = $this->createRandomPassword(16);
        if (!$existingEmail or is_null($existingEmail['idUser'])) {

            $userId = createUser($firstName, $lastName, $password);
            if ($userId) {

                if (!$existingEmail) {

                    $idEmail = writeEmail($email, $userId, $code);
                    $message = "Hello $firstName $lastName \r Your email has been registered to sportsrush.ch . \r To verify that this email belongs to you please click on the link below : \r https://dev.sportsrush.ch/api/verifyEmail?code=$code&idEmail=$idEmail";
                    mail($email, 'Sportsrush registration', $message);
                } else {
                    updateEmailUserId($existingEmail['idEmail'], $userId);
                }

                echo json_encode([
                    'success' => true,
                    'message' => "user created",
                    'idUser' => $userId
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "error in user creation",
                    'idUser' => null
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => "email already linked to an account",
                'idUser' => null
            ]);
        }
    }

    function _post_login() {
        $email = filter_input(INPUT_POST, 'email');
        $password = sha1(filter_input(INPUT_POST, 'password'));
        $result = connectUser($email, $password);
        if ($result['valid']) {
            $message = "connection success";
            $_SESSION['UID'] = $result['idUser'];
        }
        echo json_encode([
            'success' => $result['valid'],
            'message' => $result['error'],
            'idUser' => $result['idUser'],
            'firstName' => $result['firstName'],
            'lastName' => $result['lastName'],
            'email' => $result['email'],
            'idEmail' => $result['idEmail'],
            'result' => $result
        ]);
    }

    function _post_updateUser() {
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');
        $idUser = filter_input(INPUT_POST, 'idUser');

        $updateSuccess = updateUser($idUser, $firstName, $lastName);

        if ($updateSuccess) {
            echo json_encode([
                'success' => true,
                'message' => "update successfull",
                'idUser' => $idUser,
                'firstName' => $firstName,
                'lastName' => $lastName
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no update made",
                'idUser' => $idUser,
                'firstName' => $firstName,
                'lastName' => $lastName
            ]);
        }
    }
    
    function _post_seenDateM() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $seenDate = filter_input(INPUT_POST, 'seenDate');

        $updateSuccess = updateSeenDateM($idTeam, $idUser, $seenDate);

        if ($updateSuccess) {
            echo json_encode([
                'success' => true,
                'message' => "update successfull",
                'idUser' => $idUser,
                'idTeam' => $idTeam,
                'seenDate' => $seenDate
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no update made",
                'idUser' => $idUser,
                'idTeam' => $idTeam,
                'seenDate' => $seenDate
            ]);
        }
    }
    
    function _post_seenDateP() {
        $idMessage = filter_input(INPUT_POST, 'idMessage');
        $idReceiver = filter_input(INPUT_POST, 'idUser');
        $seenDate = filter_input(INPUT_POST, 'seenDate');

        $updateSuccess = updateSeenDateP($idMessage, $idReceiver, $seenDate);

        if ($updateSuccess) {
            echo json_encode([
                'success' => true,
                'message' => "update successfull",
                'idMessage' => $idMessage,
                'idUser' => $idReceiver,
                'seenDate' => $seenDate
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no update made",
                'idMessage' => $idMessage,
                'idUser' => $idReceiver,
                'seenDate' => $seenDate
            ]);
        }
    }
    
    function _post_createTeam() {
        $teamName = filter_input(INPUT_POST, 'teamName');
        $sport = $_POST['sport'];
        $teamDesc = filter_input(INPUT_POST, 'teamDesc');
        $idUser = filter_input(INPUT_POST, 'idUser');

        $idTeam = createTeamNoLogo($teamName, $teamDesc, $sport['idSport']);

        if ($idTeam) {
            $idMembership = createMembership($idUser, $idTeam, true);
            echo json_encode([
                'success' => true,
                'message' => "team created",
                'idTeam' => $idTeam,
                'teamDesc' => $teamDesc,
                'teamName' => $teamName
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "team not created",
                'sport' => $sport
            ]);
        }
    }
    
    function _post_createEvent() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $title = filter_input(INPUT_POST, 'title');
        $desc = filter_input(INPUT_POST, 'desc');
        $startDateTime = filter_input(INPUT_POST, 'startDateTime');
        $endDateTime = filter_input(INPUT_POST, 'endDateTime');
        $wRepeat = filter_input(INPUT_POST, 'wRepeat');
        $mRepeat = filter_input(INPUT_POST, 'mRepeat');
        if ($wRepeat === "true"){
            $wRepeatInt = 1;
        } else {
            $wRepeatInt = 0;
        }
        if ($mRepeat === "true"){
            $mRepeatInt = 1;
        } else {
            $mRepeatInt = 0;
        }


        $idEvent = createEvent($idTeam, $title, $desc, $startDateTime, $endDateTime, $wRepeatInt, $mRepeatInt);

        if ($idEvent) {
            echo json_encode([
                'success' => true,
                'message' => "event created",
                'idTeam' => $idTeam,
                'title' => $title,
                'desc' => $desc,
                'startDateTime' => $startDateTime,
                'endDateTime' => $endDateTime,
                'wRepeat' => $wRepeat,
                'mRepeat' => $mRepeat
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "event not created",
                'idTeam' => $idTeam,
                'title' => $title,
                'desc' => $desc,
                'startDateTime' => $startDateTime,
                'endDateTime' => $endDateTime
            ]);
        }
    }
    
    function _post_events() {
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $events = readEvents($idTeam);
        $team = readTeam($idTeam);
        if ($events) {
            foreach ($events as $key => $event){
                $startTime = explode(' ', $event['startDate']);
                $events[$key]['startTime'] = $startTime[1];
                $endTime = explode(' ', $event['endDate']);
                $events[$key]['endTime'] = $endTime[1];
                
            }
            echo json_encode([
                'success' => true,
                'message' => "events received",
                'events' => $events,
                'team' => $team
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no events",
                'post-val' => $_POST,
                'events' => null
            ]);
        }
    }
    function _post_eventsTeams() {
        $teams = $_POST['teams'];
        if(!empty($teams)){
            foreach($teams as $team){
                $events = readEvents($team['idTeam']);
                if (!empty($events)){
                    $events['team'] = $team;
                    $eventsTeams[] = $events;
                }
            }
        }
        if ($eventsTeams) {
            foreach ($eventsTeams as $keyEvents => $events){
                foreach ($events as $keyEvent => $event){
                    $startTime = explode(' ', $event['startDate']);
                    $eventsTeams[$keyEvents][$keyEvent]['startTime'] = $startTime[1];
                    $endTime = explode(' ', $event['endDate']);
                    $eventsTeams[$keyEvents][$keyEvent]['endTime'] = $endTime[1];
                }
                
            }
            echo json_encode([
                'success' => true,
                'message' => "events received",
                'eventsTeams' => $eventsTeams,
                'post-val' => $_POST,
                'teams' => $teams
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "no events",
                'eventsTeams' => $eventsTeams,
                'post-val' => $_POST,
                'teams' => $teams
            ]);
        }
    }
    
    function _post_newMessage() {
        $msg = filter_input(INPUT_POST, 'message');
        $idReceiver = filter_input(INPUT_POST, 'idReceiver');
        $private = filter_input(INPUT_POST, 'private');
        $sendingDateTime = filter_input(INPUT_POST, 'sendingDateTime');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $sender = filter_input(INPUT_POST, 'sender');



        $idMessage = createMsg($sendingDateTime, $msg, $idUser, $idReceiver, $private, $sender);

        if ($idMessage) {
            echo json_encode([
                'success' => true,
                'message' => "message sent",
                'idMessage' => $idMessage,
                'msg' => $msg,
                'iduser' => $idUser,
                'idReceiver' => $idReceiver,
                'private' => $private,
                'dateTime' => $sendingDateTime,
                'sender' => $sender
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "message not sent",
                'message' => $msg,
                'idMessage' => $idMessage,
                'iduser' => $idUser,
                'idReceiver' => $idReceiver,
                'private' => $private,
                'dateTime' => $sendingDateTime,
                'sender' => $sender
            ]);
        }
    }
    
    function _post_newPrivateMessage() {
        $msg = filter_input(INPUT_POST, 'message');
        $idReceiver = filter_input(INPUT_POST, 'idReceiver');
        $private = filter_input(INPUT_POST, 'private');
        $sendingDateTime = filter_input(INPUT_POST, 'sendingDateTime');
        $idUser = filter_input(INPUT_POST, 'idUser');
        $sender = filter_input(INPUT_POST, 'sender');



        $idMessage = createPrivateMsg($sendingDateTime, $msg, $idUser, $idReceiver, $private, $sender);

        if ($idMessage) {
            echo json_encode([
                'success' => true,
                'message' => "message sent",
                'idMessage' => $idMessage,
                'message' => $msg,
                'idMessage' => $idMessage,
                'iduser' => $idUser,
                'idReceiver' => $idReceiver,
                'private' => $private,
                'dateTime' => $sendingDateTime,
                'sender' => $sender
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "message not sent",
                'message' => $msg,
                'idMessage' => $idMessage,
                'iduser' => $idUser,
                'idReceiver' => $idReceiver,
                'private' => $private,
                'dateTime' => $sendingDateTime,
                'sender' => $sender
            ]);
        }
    }

    function _post_invite() {
        $email = filter_input(INPUT_POST, 'email');
        $idTeam = filter_input(INPUT_POST, 'idTeam');
        $coach= filter_input(INPUT_POST, 'coach');
        
        $invitedEmail = readEmail($email);
        
        if ($invitedEmail) {
            $idEmail = $invitedEmail['idEmail'];
            $message = "You have been invited to join a team in sportsrush.ch log into https://dev.sportsrush.ch to join the team ";
        } else {
            $codeMail = $this->createRandomPassword(16);    
            $idEmail = writeEmailNoUser($email, $codeMail);
            $message = "You have been invited to join a team in sportsrush.ch \r To verify that this email"
                    . " belongs to you please click on the link below : \r https://dev.sportsrush.ch/api/verifyEmail?code=$codeMail&idEmail=$idEmail";
        }
        mail($email, 'Sportsrush registration', $message);
        $codeInvite = $this->createRandomPassword(16);
        
        $invite = createInvitation($idTeam, $idEmail, $codeInvite, $coach);

        if (!empty($invite)) {
            echo json_encode([
                'success' => true,
                'message' => "invitation sent",
                'invite' => $invite,
                'post' => $_POST,
                'code' => $codeMail,
                'idEmail' => $idEmail,
                'coach' => $coach
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "invitation not sent",
                'post' => $_POST,
                'code' => $codeMail,
                'idEmail' => $idEmail,
                'coach' => $coach
            ]);
        }
    }

}

new TTAPI();
?>