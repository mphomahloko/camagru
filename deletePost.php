<?php
require_once './config/config.php';
require_once './Pictures.class.php';

if ( Session::isLoggedIn() ) {
    $pic = new Pictures(); 
    if ( isset( $_GET[ 'img_Id' ]  ) )
        $pic->deleteImg( htmlentities( $_GET[ 'img_Id' ] ) );
    Router::redirect( 'dashboard.php' );
} else
    die( "You do not have acess to this page" );
?>