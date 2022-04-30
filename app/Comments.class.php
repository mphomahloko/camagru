<?php

Class Comments extends User {
    private $_comments = [];

    public function __construct() {
        parent::__construct();
        self::setComments();
    }

    public function comment( $id, $username, $comment ) {
        try {
            $sql = "INSERT INTO `comments` SET `img_Id` = ?, `username` = ?, comment = ?";
            $query = $this->_pdo->prepare( $sql );
            $query->execute( [ $id, $username, $comment ] );
            self::setComments();
            $details = self::_getPostDetails( $id );
            $user = self::_getUser( $details[ 'username' ] );
            if ( self::getUserNotifications( $details[ 'username' ] ) ) {
                require_once 'SendMail.class.php';
                SendMail::comment( $user[ 'email' ] );
            }
         } catch (PDOException $e ) {
			die( $e->getMessage() );
		}
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
