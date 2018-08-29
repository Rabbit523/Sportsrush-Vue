
<?php

class TTServices {

    private $allowedOrigins = [
        'https://dev.sportsrush.ch',
        'http://127.0.0.1:8080',
        'http://localhost:8080'
    ];
    public $resources = [
        'login'
    ];
    public $r = []; // The request array
    public $host, $method, $header, $origin;
    public $uid;
    public $bypassOn = true; // if activated, localhost login id will be be the $defaultUserId
    public $defaultUserId = 2;
    private $bypass = null;

    function setDefaultHeaders() {
        $this->origin = $_SERVER['HTTP_ORIGIN'];
        if (in_array($this->origin, $this->allowedOrigins))
            header("Access-Control-Allow-Origin: $this->origin");
        header("Access-Control-Allow-Methods: GET,POST");
        header("Access-Control-Allow-Headers: Content-Type");
    }

    function __construct() {
        require_once '../crud/db.php';
        include '../crud/lib/Bypass.php';
        if (session_status() == PHP_SESSION_NONE)
            session_start();

        // we directly init the bypass Object
        $this->bypass = new Bypass();

        // Prepare the request reception
        $this->setDefaultHeaders();

        // Set the attributes
        $this->host = $_SERVER['HTTP_HOST'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->header = "HTTP/$this->host";

        // If we send an action value with the $_POST, it is set as the main action request
        $request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        array_shift($request);
        $this->r = $request;
        $this->uid = $_SESSION['id'];


        // we set the user id, checking the bypass Object
        $this->setUid();

        // we invoke the corresponding service function, following the url instructions
        $this->servicesRouting();
    }

    /**
     * Set the $this->uid variable from the $_SESSION['id'] value
     */
    function setUid() {
        // we check if the bypass is needed (localhost hack)
        if ($this->bypass->isNeeded()) {
            $_SESSION['id'] = $this->bypass->getDefaultId();
            $this->uid = $this->bypass->getDefaultId();
        }

        // if the session is set, we ensure set the uid from the session
        else if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
            $this->uid = $_SESSION['id'];
        }

        // here the uid should be set, either from the the session or the bypass
        if (!isset($this->uid))
            $this->uid = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    }

    function servicesRouting() {
        if (in_array($this->r[0], $this->resources)) {
            // special actions : we append only the first resource, the rest is used as variables
            if (sizeof($this->r) > 1) {
                $v = "";
                foreach ($this->r as $r)
                    $v .= "_" . $r;
            } else
                $v = "_" . $this->r[0];

            $this->$v();
        }

        // The resource is not found
        else {
            header("$this->header 404 Resource not found");
        }
    }

    /**
     * Perform an user login.
     * If bypass is activated, and if the id is not set, it is set to defaultId
     *
     * @param $id int           The user id to log into
     * @param bool $bypass      If we simulate the session
     */
    function setSessionId($id, $bypass) {
        $_SESSION['id'] = $id;
        $this->uid = $id;

        if ($bypass) {
            $_SESSION['id'] = $this->defaultUserId;
            $_SESSION['bypass'] = true;
            $this->uid = $id;
        }
    }

}

new TTServices();
?>