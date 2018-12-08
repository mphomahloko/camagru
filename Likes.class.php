<?php

Class Likes extends User {
    public $numOfLikes;

    public function __construct() {
        parent::__construct();
    }

    private function _getLike( $img_Id, $username ) {
        $sql = "SELECT * FROM `like_pic`
        WHERE `img_Id` = ? AND `username` = ?";
        $query = $this->prepare( $sql );
        $query->execute();
        $results = $query->fetch();
        if ( count( $results ) ) return true;
        return false;
    }

    public function deleteOrAddLike( $img_Id, $username ) {
        if ( self::getLike( $img_Id, $username ) )
            return self::_deleteLike( $img_Id, $username );
        return self::_addLike();
    }

    private function _deleteLike( $img_Id, $username ) {
        $sql = "DELETE FROM `like_pic`
        WHERE `img_Id` = ? AND `username` = ?";
        $query = $this->_pdo->prepare( $sql );
        $query->execute( [ $img_Id, $username ] );
        self::setNumOfLikes();
    }

    private function _addLike( $img_Id ,$username ) {
        $sql = "INSERT INTO `like_pic` 
        SET `img_Id` = ?, `username` = ?";
        $query = $this->_pdo->prepare( $sql );
        $query->execute( [ $img_Id, $username ] );
        self::setNumOfLikes();
        //send an notification if conditions favor   
    }

    private function setNumOfLikes() {
        $sql = "SELECT *  FROM `like_pic`";
        $query = $this->_pdo->prepare( $sql );
        $query->execute();
        $results = $query->fetchALL();
        $this->numOfLikes = count( $results );
    }
}

?>