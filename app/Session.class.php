<?php
//Still needs more work

Class Session {

    private static $_sessionStarted = false;

    public static function start() {
        if ( self::$_sessionStarted )
            return ;
        session_start();
        self::$_sessionStarted = true;
    }

    public static function set( $key, $value ) {
        $_SESSION[ $key ] = $value;
    }

    public static function get( $key ) {
        if ( isset( $_SESSION[ '$key' ] ) )
            return $_SESION[ $_key ];
        else
            return false;
    }
    
    //verifying if the user is logged in or not
	public static function isLoggedIn() {
        return isset( $_SESSION[ 'username' ] );
    }

    public static function destroy() {
        if ( self::$_sessionStarted ) {
            session_unset();
            session_destroy();
        }
        Router::redirect( 'index.php' );
    }
}