<?php
require_once 'config/config.php';

if ( isset( $_GET[ 'token' ] ) && isset( $_GET[ 'email' ] ) ) {
    $data[ 'token' ] = Input::get( 'token' );
    $data[ 'email' ] = Input::get('email' );
    $data[ 'verified' ] = 1;
    $user->confirmUser( $data );
    $user->redirect( 'index.php' );
}
?>
<?php require('footer.php');?>