<?php

Class SendMail {

    private static function uniqueLink( $page , $reciver, $token ) {
        return 'http://localhost:8080/camagru/' . $page . '?email=' . $reciver . '&token=' . $token;
    }

    public static function verify( $reciver, $token ) {
        $link = self::uniqueLink( 'verify.php', $reciver, $token );
        $subject = 'Confirm Camagru Registion';
        $message = 'To confirm your registration<br/><a href= ' . $link . '>Click Here!</a><br/>';
        self::send( $reciver, $subject, $message );
    }

    public static function resetPassword( $reciver, $new_pass ) {
        $subject = 'Camagru Reset Password';
        $message = 'Your new Password is ' . $new_pass;
        self::send( $reciver, $subject, $message );
    }

    public static function comment( $reciver ) {
        $subject = "Camagru Notification";
        $message = "Someone has commented on one of your post";
        self::send( $reciver, $subject, $message );
    }

    public static function like( $reciver ) {
        $subject = "Camagru Notification";
        $message = "You just recived a like on one of your posts";
        self::send( $reciver, $subject, $message );
    }

    private static function send( $reciver, $subject, $message ) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From:nonreply@localhost:8080/camagru' . "\r\n";
        mail( $reciver, $subject, $message, $headers );
    }
}

?>