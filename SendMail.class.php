<?php

Class SendMail {

    private static function uniqueLink( $page , $reciver, $token ) {
        return 'http://localhost:8080/camagru/' . $page . '?email=' . $reciver . '&token=' . $token;
    }

    public static function verify( $reciver, $token ) {
        $link = self::uniqueLink( 'verify.php', $reciver, $token);
        $subject = 'Confirm Camagru Registion';
        $message = 'To confirm your registration<br/><a href= ' . $link . '>Click Here!</a><br/>';
        self::send( $reciver, $subject, $message );
    }

    public static function resetPassword( $reciver, $token) {
        $link = self::uniqueLink( 'reset.php', $reciver, $token );
        $subject = 'Camagru Reset Password';
        $message = 'To reset your Password<br/><a href= ' . $link . '>Click Here!</a><br/>';
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