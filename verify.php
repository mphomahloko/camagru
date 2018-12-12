<?php
require_once 'config/config.php';

if ( isset( $_GET[ 'token' ] ) && isset( $_GET[ 'email' ]) ) {
    $data[ 'token' ] = $_GET[ 'token' ];
    $data[ 'email' ] = $_GET[ 'email' ];
    $data[ 'verified' ] = 1;
    $user->confirmUser( $data );
    $user->redirect( 'index.php' );
}
?>
<?php require('footer.php');?>