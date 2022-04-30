<?php

Class User {
	protected $_pdo;
	public static $errMsg;

    public function __construct() {
		$instance = DB::getInstance();
		$this->_pdo = $instance->connection();
    }

    public function register( array $data ) {
		self::$errMsg = '';
		$user = self::_getUser( $data[ 'username' ] );
		if ( $user )
			return self::$errMsg = 'Username already taken';
		if ( ! filter_var( $data[ 'email' ], FILTER_VALIDATE_EMAIL) )
			return self::$errMsg = 'Invalid email';
		if ( empty( $data[ 'username' ] ) || empty( $data[ 'fname' ] ) || empty( $data[ 'lname' ] ) || empty( $data[ 'email' ] ) || empty( $data[ 'password' ] ) )
			return self::$errMsg = 'Fill in the required fields';
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
			$set = substr( $set, 0, -2);
			$stmt = $this->_pdo->prepare( "INSERT INTO `users` SET $set" );
			$stmt->execute( $values );
			require_once 'SendMail.class.php';
			SendMail::verify( $values[ 'email' ], $values[ 'token' ] );
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
	}

	public function getUserNotifications( $username ) {
		$user = self::_getUser( $username );
		return $user[ 'notifications' ];
	}

	protected function _getUser( $username ) {
		//to be modified to work with email and username
		try {
			$sql = "SELECT * FROM `users` WHERE `username` = ?";
			$query = $this->_pdo->prepare( $sql );
			$query->execute( [ $username ] );
			$user = $query->fetch();
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
		return $user;
	}

	public function confirmUser( array $data ) {
		self::$errMsg = '';
		try {
			//modify to be able to get user properly
			$stmt = $this->_pdo->prepare( "SELECT * FROM `users` WHERE email = ? AND token = ?" );
			$stmt->execute( [ $data[ 'email'], $data[ 'token'] ] );
			$res = $stmt->fetchColumn();
			if ( $res ) {
				$sql = "UPDATE `users` SET verified = :verified WHERE email = :email AND token = :token";
				$this->_pdo->prepare( $sql )->execute( $data );
			}
			else {
				echo 'User not found';
			}
		} catch ( PDOException $e ) {
			die ( $e->getMessage() );
		}
		return $res;
	}

	public function login( array $data ) {
		self::$errMsg = '';
		$user = self::_getUser( $data[ 'username' ] );
		if ( !$user )
			return self::$errMsg = 'User does not exist';
		try {
			if ( password_verify( $data[ 'password' ], $user[ 'password' ] ) && $user[ 'verified' ] == 1 ) {
				Session::set( 'username' , $user[ 'username' ] );
				Router::redirect( 'dashboard.php' );
			}
			elseif ( password_verify( $data[ 'password' ], $user[ 'password' ] ) && $user[ 'verified' ] == 0 ) {
				return self::$errMsg = 'Please Check Email to Activate your account';
			} else {
				return self::$errMsg = 'Invalid Password';
			}
		} catch( PDOException $e ) {
			die( $e->getMessage() );
		}
	}

	public function sendPassword( $username ) {
		self::$errMsg = '';
		$user = self::_getUser( $username );
		if ( !$user )
			return self::$errMsg = 'User does not exist';
		try {
			$new_pass = 'C' . bin2hex( random_bytes(6) ) . '@' . bin2hex( random_bytes(6) );
			$query = $this->_pdo->prepare( "UPDATE `users` SET `password` = ? WHERE `username` = ?" );
			$query->execute( [ password_hash( $new_pass, PASSWORD_DEFAULT ) , $username ] );
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
		require_once 'SendMail.class.php';
		SendMail::resetPassword( $user[ 'email' ], $new_pass );
	}

	public function updateProfile( $username, $password, $field, $value ) {
		self::$errMsg = '';
		$user = self::_getUser( $username ); 
		if ( !$user ) return self::$errMsg = 'No such user was found';
		if ( password_verify( $password, $user[ 'password' ] ) ) {
			if ( $field == 'username' ) {
				$new_username = self::_getUser( $value );
				if ( $new_username[ 'username' ] == $username ) return ;
				if ( $new_username ) return self::$errMsg = 'Username already in use';
				//update gallery table
				$query = $this->_pdo->prepare( "UPDATE `gallery` SET `{$field}` = ? WHERE `username` = ?" );
				$query->execute( [ $value, $username ] );
				//update comments table
				$query = $this->_pdo->prepare( "UPDATE `comments` SET `{$field}` = ? WHERE `username` = ?" );
				$query->execute( [ $value, $username ] );
				//update likes table
				$query = $this->_pdo->prepare( "UPDATE `like_pic` SET `{$field}` = ? WHERE `username` = ?" );
				$query->execute( [ $value, $username ] );
				Session::set( 'username', $value );
			}
			if ( $field == 'password' )
				$value = password_hash( $value, PASSWORD_DEFAULT );
			try {
				$query = $this->_pdo->prepare( "UPDATE `users` SET `{$field}` = ? WHERE `username` = ?" );
				$query->execute( [ $value, $username ] );
			} catch ( PDOException $e ) {
				die( $e->getMessage() );
			}
		} else {
			return self::$errMsg = 'Invalid Password';
		}
	}

    protected function _getPostDetails( $img_Id ) {
        try {
			$sql = "SELECT * FROM `gallery` WHERE `img_Id` = ?";
			$query = $this->_pdo->prepare( $sql );
			$query->execute( [ $img_Id ] );
			$user = $query->fetch();
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
		return $user;
	}
}
?>
