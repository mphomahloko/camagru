<?php

Class User {

    private $_instance;
    private $_table = 'users';
	public $errMsg;

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
					if ( $field === 'password' ) {
						$values[ $field ] = password_hash( $data[ $field ], PASSWORD_DEFAULT );
					} else {
						$values[ $field ] = $data[ $field ];
					}
				}
			}
			$values[ 'token' ] = hash( 'sha256', $values[ 'email' ] ) . bin2hex( random_bytes(4) );
			$set .= "`" . str_replace( "`", "``", 'token') . "`" . "=:token, ";
			$values[ 'verified' ] = 0;
			$set .= "`" . str_replace( "`", "``", 'verified') . "`" . "=:verified, ";
			$set = substr( $set, 0, -2);
			$stmt = $this->_instance->connection()->prepare( "INSERT INTO $this->_table SET $set" );
			$stmt->execute( $values );
			self::verify( $values[ 'email' ], $values[ 'token' ] );
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
	}

	private function getUser( $username ) {
		//to be modified to work with email and username
		try {
			$sql = "SELECT * FROM `users` WHERE `username` = ?";
			$query = $this->_instance->connection()->prepare( $sql );
			$query->execute( [ $username ] );
			$user = $query->fetch();
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
		return $user;
	}

	public function confirmUser( array $data ) {
		try {
			//modify to be able to get user properly
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
		} catch ( PDOException $e ) {
			die ( $e->getMessage() );
		}
	}

	public function login ( array $data ) {
		try {
			$stmt = $this->_instance->connection()->prepare( "SELECT * FROM $this->_table WHERE username = ?" );
			$stmt->execute( [ $data[ 'username' ] ] );
			$res = $stmt->fetch();
			if ( password_verify( $data[ 'password' ], $res[ 'password' ] ) && $res[ 'verified' ] == 1 ) {
				session_start();
				$_SESSION[ 'username' ] = $data[ 'username' ];
				self::redirect( 'dashboard.php' );
			}
			elseif ( password_verify( $data[ 'password' ], $res[ 'password' ] ) && $res[ 'verified' ] == 0 ) {
				echo 'Please Check Email to Activate your account';
			}else {
				echo 'Invalid Password';
			}

		}catch( PDOException $e ) {
			die( $e->getMessage() );
		}
	}

	public function sendPassword( $username ) {
		$this->errMsg = '';
		$user = self::getUser( $username );
		if ( !$user )
			return $this->errMsg = 'User does not exist';
		try {
			$query = $this->_instance->connection()->prepare( "UPDATE `users` SET `token` = ? WHERE `username` = ?" );
			$query->execute( [ hash( 'sha256', $user[ 'email' ] ) . bin2hex( random_bytes(4) ), $username ] );
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
		require_once 'SendMail.class.php';
		SendMail::resetPassword( $user[ 'email' ], $user[ 'token' ] );
	}

	public function updateProfile( $username, $password, $field, $value ) {
		$this->errMsg = '';
		$user = self::getUser( $username );
		if ( password_verify( $password, $user[ 'password' ] ) ) {
			if ( $field == 'username' ) {
				$new_username = self::getUser( $value );
				if ( $new_username[ 'username' ] == $username ) return ;
				if ( $new_username ) return $this->errMsg = 'Username already in use';
			}
			try {
				$query = $this->_instance->connection()->prepare( "UPDATE `users` SET `{$field}` = ? WHERE `username` = ?" );
				$query->execute( [ $value, $username ] );
			} catch ( PDOException $e ) {
				die( $e->getMessage() );
			}
		} else return $this->errMsg = 'Invalid Password';
	}
    public static function redirect( $url ) {
		header( 'location: ' . $url );
	}

	//verifying if the user is logged in or not
	public function is_loggedin() {

	}
	
	//Modify the logout functionality
    public function logout() {

	}
}

?>