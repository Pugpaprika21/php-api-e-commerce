<?php

$env = parse_ini_file(__DIR__ . "../../.env");

$utils = "../../utils/";

require(__DIR__ . "{$utils}classes/RB.php");
require(__DIR__ . "{$utils}functions/db.php");
require(__DIR__ . "{$utils}functions/helpers.php");
require(__DIR__ . "{$utils}classes/API.php");
require(__DIR__ . "../../controllers/BaseController.php");

// ini_set('log_errors', 'on');
// ini_set('display_errors', 'off');
// ini_set('error_reporting', E_ALL);

# {Redbean}

if (!empty($env['DB_NAME'])) {
    R::setup($env['DB_CONNECT_DNS'], $env['DB_USERNAME'], '');
    R::debug(false);
}

if (!empty($env['CORS'])) {
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
}

if (!empty($env['CLASS_API']) && $env['CLASS_API'] == true) { 
    $api = new API();
    $request = $api->setRequest();
}
