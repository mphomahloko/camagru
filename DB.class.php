<?php
Class DB {
    public static $conn;

    public function __construct( $dsn, $user, $pass,  array $options ) {
        try {
            self::$conn = new PDO( $dsn, $user, $pass, $options );
       } catch ( PDOException $e ) {
        echo "Connection failed: " . $e->getMessage();
       }
    }
    
    public function __destruct() {
		self::$conn = null;
    }

}

?>
