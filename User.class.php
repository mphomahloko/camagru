<?php

Class User {

    private $_instance;
    private $_table = 'users';
	private $_user = array();
	private $_pass;

    public function __construct() {
		$this->_instance = DB::getInstance();
    }

    public function register( array $data ) {
		try {
			$allowed = array ( 'username', 'fname', 'lname', 'email', 'password' );
			$values = array();
			$set = '';
			foreach ( $allowed as $field ) {
				if ( isset( $data[ $field ] ) ) {
					$set .= "`" . str_replace( "`", "``", $field) . "`" . "=:$field, ";
					if ( $field === 'password' ){
						$values[ $field ] = password_hash( $data[ $field ], PASSWORD_DEFAULT );
						$this->_pass = $data[ $field ];
					}else {
						$values[ $field ] = $data[ $field ];
					}
				}
			}
			$values[ 'token' ] = hash( 'sha256', $values[ 'email' ] );
			$set .= "`" . str_replace( "`", "``", 'token') . "`" . "=:token, ";
			$values[ 'verified' ] = 0;
			$set .= "`" . str_replace( "`", "``", 'verified') . "`" . "=:verified, ";
			$this->_user = $values;
			$set = substr( $set, 0, -2);
			$stmt = $this->_instance->connection()->prepare( "INSERT INTO $this->_table SET $set" );
			$stmt->execute( $values );
			self::send_verification();
		}catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
	}

	public function activate_user( array $data ) {
		try {
			$stmt = $this->_instance->connection()->prepare( "SELECT * FROM $this->_table WHERE email = ? AND token = ?" );
			$stmt->execute( [ $data[ 'email'], $data[ 'token'] ] );
			$res = $stmt->fetchColumn();
			if ( $res ) {
				$sql = "UPDATE $this->_table SET verified = :verified WHERE email = :email AND token = :token";
				$this->_instance->connection()->prepare( $sql )->execute( $data );
			}
			else {
				echo 'User not found';
			}
		}catch ( PDOException $e ) {
			die ( $e->getMessage() );
		}
	}

	public function login ( array $data ) {
		try {
			//try adding a feature where user can input an email instead of a username
			$stmt = $this->_instance->connection()->prepare( "SELECT * FROM $this->_table WHERE username = ?" );
			$stmt->execute( [ $data[ 'username' ] ] );
			$res = $stmt->fetch();
			// echo '<pre>';
			// var_dump( $res );
			// echo '</pre>';
			// die();
			if ( password_verify( $data[ 'password' ], $res[ 'password' ] ) && $res[ 'verified' ] == 1 ) {
				self::redirect( 'dashboard.php' );
			}
			elseif ( password_verify( $data[ 'password' ], $res[ 'password' ] ) && $res[ 'verified' ] == 0 ) {
				echo 'Please Check Email to Activate your account';
			}else {
				echo 'Invalid Password';
			}

		}catch( PDOException $e ) {
			echo "Connection failed: " . $e->getMessage();
		}
	}
	
	public function is_loggedin() {}
	
	private function send_verification() {
		$Subject = 'Signup | Verification';
		$Message = '

Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by clicking the url below.

---------------------------------------
Username: ' . $this->_user[ 'username' ] . '
Password: ' . $this->_pass . '
---------------------------------------

Please click the link to activate your account:
http://localhost:8080/camagru/verify.php?email=' . $this->_user[ 'email' ] . '&token=' . $this->_user[ 'token' ] .'

';

		$Headers = 'From:nonreply@localhost:8080/camagru' . "\r\n";
		mail( $this->_user[ 'email' ], $Subject, $Message, $Headers );
	}
    public static function redirect( $url ) {
		header( 'location: ' . $url );
	}

    public function logout() {}

}

?>