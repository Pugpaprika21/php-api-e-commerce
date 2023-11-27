<?php

$env = parse_ini_file(__DIR__ . "../../.env");

$utils = "../../utils/";

require_once(__DIR__ . "{$utils}classes/RB.php");
require_once(__DIR__ . "{$utils}functions/db.php");
require_once(__DIR__ . "{$utils}functions/helpers.php");
require_once(__DIR__ . "{$utils}classes/API.php");

ini_set('log_errors', 'on');
ini_set('display_errors', 'off');
ini_set('error_reporting', E_ALL);
