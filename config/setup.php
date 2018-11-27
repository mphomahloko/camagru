<?php

$host = "localhost";
$root = "root";
$pass = "123456";
$newdb = "camagru";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $dbh = new PDO( "mysql:host=$host", $root, $pass, $options );
    $dbh->exec("CREATE DATABASE IF NOT EXISTS camagru");
    $dbh->exec( "CREATE TABLE IF NOT EXISTS `camagru`.`users` ( 
        `user_Id` INT(255) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
        `username` VARCHAR(30) NOT NULL ,
        `fname` VARCHAR(20) NOT NULL ,
        `lname` VARCHAR(20) NOT NULL ,
        `email` VARCHAR(40) NOT NULL ,
        `password` VARCHAR(1000) NOT NULL ,
        `token` VARCHAR(255) NOT NULL ,
        `verified` INT(2) NOT NULL
        );" );
    $dbh->exec( "CREATE TABLE IF NOT EXISTS `camagru`.`gallery` ( 
        `user_Id` INT(255) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
        `username` VARCHAR(30) NOT NULL ,
        `path` VARCHAR(255) NOT NULL
        );" );
}catch( PDOException $e ) {
    echo "Connection failed: " . $e->getMessage();
}
$dbh = null;
header('location: ../index.php');

?>