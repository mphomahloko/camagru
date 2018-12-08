<?php

Class Pictures extends User {
    private $_gallery = [];
    public $numImg;

    public function __construct() {
        parent::__construct();
        self::setGallery();
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

    public function deleteImg( $img_Id ) {
        try {
            $sql = "DELETE FROM `gallery` WHERE `img_Id` = ?";
            $query = $this->_pdo->prepare( $sql );
            $query->execute( $img_Id );
        } catch ( PDOException $e ) {
            die( $e->getMessage() );
        } 
    }

    private function setGallery() {
        try {
            $sql = "SELECT * FROM gallery ORDER BY date DESC";
            $query = $this->_pdo->prepare( $sql );
            $query->execute();
            $this->_gallery = $query->fetchALL();
            $this->numImg = count( $this->_gallery );
        } catch ( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    public function getGallery() {
        return $this->_gallery;
    }
}