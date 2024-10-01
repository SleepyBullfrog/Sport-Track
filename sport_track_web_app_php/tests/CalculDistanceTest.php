<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);
define("__ROOT__", dirname(__DIR__));

// Configuration
require_once __ROOT__ . "/config.php";

require_once UTILS_DIR . "/CalculDistanceImpl.php";

$calcul = new CalculDistanceImpl();

$dataTab = $calcul->readJSON(TESTS_DIR . "/data.json");

echo $calcul->calculDistanceTrajet($dataTab);
//var_dump($calcul -> calculDistanceTrajet($calcul -> getLongLatTab($dataTab)));
?>
