<?php

$host = "localhost";
$username = "root";
$password = "";
$charset = 'utf8mb4';
$db = "camagru";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];


?>