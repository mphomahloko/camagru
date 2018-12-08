<?php

Class Pictures extends User {
    private $_pdo;
    private $_gallery = [];
    public $numImg;

    public function __construct() {
        try {
            require_once 'DB.class.php';
            $instance = DB::getInstance();
            $this->_pdo = $instance->connection();
            self::setGallery();
        } catch ( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    public function addToGallery( $username, $path ) {
        try {
            $sql = "INSERT INTO `gallery` (`username`, `path`) VALUES (?,?)";
            $query = $this->_pdo->prepare( $sql );
            $query->execute( [ $username, $path ] );
        } catch ( PDOException $e ) {
            die( $e->getMessage() );
        }
    } 

    private function setGallery() {
        $sql = "SELECT * FROM gallery ORDER BY date DESC";
        $query = $this->_pdo->prepare( $sql );
        $query->execute();
        $this->_gallery = $query->fetchALL();
        $this->numImg = count( $this->_gallery );
    }

    public function getGallery() {
        return $this->_gallery;
    }
}