<?php
require_once 'config/database.php';
//Destroy sessions here!
session_start();
$destroy = new Application();
session_destroy();
$user->redirect( 'index.php' );
?>