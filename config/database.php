<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './DB.class.php';
require_once './User.class.php';
require_once __DIR__ . '/../Application.class.php';

$host = "localhost";
$username = "root";
$password = "123456";
$charset = 'utf8mb4';
$db = "camagru";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$user = new User();

$w = new Application();

?>