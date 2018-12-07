<?php

Class Pictures {
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

    private function setGallery() {
        $sql = "SELECT * FROM gallery ORDER BY date DESC";
        $stmt = $this->_pdo->prepare( $sql );
        $stmt->execute();
        $this->_gallery = $stmt->fetchALL();
        $i = 0;
        while ( isset( $this->_gallery[ $i ] ) )
            $i++;
        $this->numImg = $i;
    }

    public function getGallery() {
        return $this->_gallery;
    }
}

?>