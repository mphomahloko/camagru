<?php
require_once 'config/database.php';
session_start();
unset( $_SESSION[ 'username' ] );
session_destroy();
$user->redirect( 'index.php' );
?>