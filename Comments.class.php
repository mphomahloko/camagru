<?php

Class Comments {
    private $_pdo;
    private $_comments = [];

    public function __construct() {
        require_once 'DB.class.php';
        $instance = DB::getInstance();
        $this->_pdo = $instance->connection();
        self::setComments();
    }

    public function comment( $id, $username, $comment ) {
        $sql = "INSERT INTO `comments` SET `img_Id` = ?, `username` = ?, comment = ?";
        $query = $this->_pdo->prepare( $sql );
        $query->execute( [ $id, $username, $comment ] );
        //enable comment notification with a condition
    }

    private function setComments() {
        $sql = "SELECT * FROM comments";
        $query = $this->_pdo->prepare( $sql );
        $query->execute();
        $this->_comments = $query->fetchALL();
    }

    public function getComments() {
        return $this->_comments;
    }
}

?>