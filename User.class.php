<?php

Class User {

    private $_pdo;
    private $_table = 'users';
	private $_user = array();

    public function __construct() {
        $this->_pdo = DB::$conn;
    }

    public function register( array $data ) {
		try {
			$allowed = array ( 'username', 'fname', 'lname', 'email', 'password' );
			$values = array();
			$set = '';
			foreach ( $allowed as $field ) {
				if ( isset( $data[ $field ] ) ) {
					$set .= "`" . str_replace( "`", "``", $field) . "`" . "=:$field, ";
					$values[ $field ] = $data[ $field ];
				}
			}
			$values[ 'token' ] = hash( 'sha256', $values[ 'email' ] );
			$set .= "`" . str_replace( "`", "``", 'token') . "`" . "=:token, ";
			$values[ 'verified' ] = 0;
			$set .= "`" . str_replace( "`", "``", 'verified') . "`" . "=:verified, ";
			$this->_user = $values;
			$set = substr( $set, 0, -2);
			$stmt = $this->_pdo->prepare( "INSERT INTO $this->_table SET $set" );
			$stmt->execute( $values );
			self::verification();
		}catch ( PDOException $e ) {
			echo "Connection failed: " . $e->getMessage();
		}
	}


    public function login ( $email, $username, $password ) {}

    public function is_loggedin() {}

	private function verification() {
		$Subject = 'Signup | Verification';
		$Message = '

Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by clicking the url below.

---------------------------------------
Username: ' . $this->_user[ 'username' ] . '
Password: ' . $this->_user[ 'password' ] . '
---------------------------------------

Please click the link to activate your account:
http://localhost:8080/camagru/verify.php?email=' . $this->_user[ 'email' ] . '&token=' . $this->_user[ 'token' ] .'

';

		$Headers = 'From:nonreply@localhost:8080/camagru' . "\r\n";
		mail( $this->_user[ 'email' ], $Subject, $Message, $Headers );

	}
    public function redirect() {}

    public function logout() {}

}

?>
