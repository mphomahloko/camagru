<?php
require_once 'config/database.php';
//Destroy sessions here!
session_destroy();
$destroy = new Application();
$user->redirect( 'index.php' );
?>