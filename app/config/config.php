<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './DB.class.php';
require_once './User.class.php';
require_once './Session.class.php';
require_once './Router.class.php';
require_once './Input.class.php';

$user = new User();
Session::start();