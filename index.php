<?php
include_once "autoload.php";
require_once 'vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 'On');

ini_set('session.save_path', '/tmp');
ini_set('session.cookie_path', '/');

session_start();

include_once "routes/web.php";

\core\Validator::resetErrors();
?>







