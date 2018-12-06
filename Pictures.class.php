<?php

Class Pictures {
    private $_pdo;
    private $_gallery = [];
    public $user_gallery = [];

    public function __construct() {
        require_once 'DB.class.php';
        $instance = DB::getInstance();
        $this->_pdo = $instance->connection();
        self::setGallery();
    }

    private function setGallery() {
        $sql = "SELECT * FROM gallery ORDER BY date DESC";
        $stmt = $this->_pdo->prepare( $sql );
        $stmt->execute();
        $this->_gallery = $stmt->fetchALL();
    }

    
    public function getGallery() {
        return $this->_gallery;
    }
}
?>