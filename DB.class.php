<?php

Class DB {
    private static $_instance = null;
    private $_pdo;

    private function __construct() {
        try {
            $this->_pdo = new PDO( "mysql:host=localhost;dbname=camagru;charset=utf8mb4", 'root', '123456', [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ] );
        } catch(PDOException $e) {
            die( $e->getMessage() );
        }
    }

    public static function getInstance() {
        if ( !isset( self::$_instance ) ) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function connection() {
        return $this->_pdo;
    }
}