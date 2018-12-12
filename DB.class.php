<?php

Class DB {
    private static $_instance = null;
    private $_pdo;

    private function __construct() {
        try {
            require_once './config/database.php';
            $this->_pdo = new PDO( $dsn, $username, $password, $options );
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