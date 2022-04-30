<?php

Class Likes extends User {
    public $numOfLikes = 0;

    public function __construct() {
        parent::__construct();
        self::setNumOfLikes();
    }

    private function _getLike( $img_Id, $username ) {
        try {
            $sql = "SELECT * FROM `like_pic` WHERE `img_Id` = ? AND `username` = ?";
            $query = $this->_pdo->prepare( $sql );
            $query->execute( [ $img_Id, $username ] );
            $results = $query->fetch();
            if ( $results )
                return true;
        } catch ( PDOException $e ) {
            die( $e->getMessage() );
        }
        return false;
    }

    public function deleteOrAddLike( $img_Id, $username ) {
        if ( self::_getLike( $img_Id, $username ) )
            return self::_deleteLike( $img_Id, $username );
        return self::_addLike( $img_Id, $username );
    }

    private function _deleteLike( $img_Id, $username ) {
        try {
            $sql = "DELETE FROM `like_pic` WHERE `img_Id` = ? AND `username` = ?";
            $query = $this->_pdo->prepare( $sql );
            $query->execute( [ $img_Id, $username ] );
            self::setNumOfLikes();
        } catch ( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    private function _addLike( $img_Id ,$username ) {
        try {
            $sql = "INSERT INTO `like_pic` 
            SET `img_Id` = ?, `username` = ?";
            $query = $this->_pdo->prepare( $sql );
            $query->execute( [ $img_Id, $username ] );
            self::setNumOfLikes();
            $details = self::_getPostDetails( $img_Id );
            $user = self::_getUser( $details[ 'username' ] );
            if ( self::getUserNotifications( $details[ 'username' ] ) ) {
                require_once 'SendMail.class.php';
                SendMail::like( $user[ 'email' ] );
            }
        } catch ( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    private function setNumOfLikes() {
        $sql = "SELECT *  FROM `like_pic`";
        $query = $this->_pdo->prepare( $sql );
        $query->execute();
        $results = $query->fetchALL();
        $this->numOfLikes = count( $results );
    }
}
