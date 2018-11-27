<?php
require_once 'config/database.php';

if ( isset( $_GET[ 'token' ] ) && isset( $_GET[ 'email' ]) ){
    $data[ 'token' ] = $_GET[ 'token' ];
    $data[ 'email' ] = $_GET[ 'email' ];
    $data[ 'verified' ] = 1;
    $user->activate_user( $data );
}
$user->redirect( 'index.php' );
?>