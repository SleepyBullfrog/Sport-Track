<?php
define("__ROOT__", __DIR__);
// Configuration
require_once __ROOT__ . "/config.php";

if (DEBUG) {
    ini_set("display_errors", "On");
    error_reporting(E_ALL);
}
// ApplicationController
require_once CONTROLLERS_DIR . "/ApplicationController.php";
use controllers\ApplicationController;

// Add routes here
ApplicationController::getInstance()->addRoute(
    "",
    CONTROLLERS_DIR . "/MainController.php"
);
ApplicationController::getInstance()->addRoute(
    "apropos",
    CONTROLLERS_DIR . "/apropos.php"
);
ApplicationController::getInstance()->addRoute(
    "user_add",
    CONTROLLERS_DIR . "/user_add.php"
);
ApplicationController::getInstance()->addRoute(
    "connect",
    CONTROLLERS_DIR . "/connect.php"
);
ApplicationController::getInstance()->addRoute(
    "disconnect",
    CONTROLLERS_DIR . "/disconnect.php"
);
ApplicationController::getInstance()->addRoute(
    "activities",
    CONTROLLERS_DIR . "/activities.php"
);
ApplicationController::getInstance()->addRoute(
    "upload",
    CONTROLLERS_DIR . "/upload.php"
);
ApplicationController::getInstance()->addRoute(
    "edit",
    CONTROLLERS_DIR . "/edit.php"
);

// Process the request
ApplicationController::getInstance()->process();

?>
