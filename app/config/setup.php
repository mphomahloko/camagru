<?php

$host = $_ENV['DB_HOST'];
$root = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db = $_ENV['DB'];
$port = $_ENV['DB_PORT'];
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $dbh = new PDO( "mysql:host=$host;port=$port", $root, $pass, $options );
    $dbh->exec("CREATE DATABASE IF NOT EXISTS $db");
    $dbh->exec( "CREATE TABLE IF NOT EXISTS `$db`.`users` ( 
        `user_Id` INT(255) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
        `username` VARCHAR(30) NOT NULL ,
        `fname` VARCHAR(20) NOT NULL ,
        `lname` VARCHAR(20) NOT NULL ,
        `email` VARCHAR(40) NOT NULL ,
        `password` VARCHAR(1000) NOT NULL ,
        `token` VARCHAR(255) NOT NULL ,
        `verified` INT(2) NOT NULL DEFAULT 0,
        `notifications` TINYINT(2) NOT NULL DEFAULT 1
        );" );
    $dbh->exec( "CREATE TABLE IF NOT EXISTS `$db`.`gallery` ( 
        `img_Id` INT(255) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
        `username` VARCHAR(30) NOT NULL ,
        `path` VARCHAR(255) NOT NULL,
        `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        );" );
    $dbh->exec( "CREATE TABLE IF NOT EXISTS`$db`.`comments` (
        `comment_Id` INT NOT NULL AUTO_INCREMENT ,
        `img_Id` INT NOT NULL ,
        `username` VARCHAR(30) NOT NULL ,
        `comment` TEXT NOT NULL ,
        PRIMARY KEY (`comment_id`));" );
    $dbh->exec( "CREATE TABLE IF NOT EXISTS `$db`.`like_pic` (
        `like_Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `img_Id` INT NOT NULL,
        `username` VARCHAR(30)
        );" );
    
} catch( PDOException $e ) {
    echo "Connection failed: " . $e->getMessage();
}
$dbh = null;
header('location: ../index.php');

?>
