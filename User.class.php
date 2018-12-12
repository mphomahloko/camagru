<?php

Class User {
	protected $_pdo;
	public $errMsg;

    public function __construct() {
		$instance = DB::getInstance();
		$this->_pdo = $instance->connection();
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
	}

	public function login( array $data ) {
		try {
			$stmt = $this->_pdo->prepare( "SELECT * FROM `users` WHERE username = ?" );
			$stmt->execute( [ $data[ 'username' ] ] );
			$res = $stmt->fetch();
			if ( password_verify( $data[ 'password' ], $res[ 'password' ] ) && $res[ 'verified' ] == 1 ) {
				$_SESSION[ 'username' ] = $data[ 'username' ];
				Router::redirect( 'dashboard.php' );
			}
			elseif ( password_verify( $data[ 'password' ], $res[ 'password' ] ) && $res[ 'verified' ] == 0 ) {
				echo 'Please Check Email to Activate your account';
			}else {
				echo 'Invalid Password';
			}

		} catch( PDOException $e ) {
			die( $e->getMessage() );
		}
	}

	public function sendPassword( $username ) {
		$this->errMsg = '';
		$user = self::_getUser( $username );
		if ( !$user )
			return $this->errMsg = 'User does not exist';
		try {
			$query = $this->_pdo->prepare( "UPDATE `users` SET `token` = ? WHERE `username` = ?" );
			$query->execute( [ hash( 'sha256', $user[ 'email' ] ) . bin2hex( random_bytes(4) ), $username ] );
		} catch ( PDOException $e ) {
			die( $e->getMessage() );
		}
		require_once 'SendMail.class.php';
		SendMail::resetPassword( $user[ 'email' ], $user[ 'token' ] );
	}

	public function updateProfile( $username, $password, $field, $value ) {
		$this->errMsg = '';
		$user = self::_getUser( $username ); 
		if ( !$user ) return $this->errMsg = 'No such user was found';
		if ( password_verify( $password, $user[ 'password' ] ) ) {
			if ( $field == 'username' ) {
				$new_username = self::_getUser( $value );
				if ( $new_username[ 'username' ] == $username ) return ;
				if ( $new_username ) return $this->errMsg = 'Username already in use';
				$query = $this->_pdo->prepare( "UPDATE `gallery` SET `{$field}` = ? WHERE `username` = ?" );
				$query->execute( [ $value, $username ] );
				$_SESSION[ 'username' ] = $value;
			}
			try {
				$query = $this->_pdo->prepare( "UPDATE `users` SET `{$field}` = ? WHERE `username` = ?" );
				$query->execute( [ $value, $username ] );
				self::redirect( 'profile.php' );
			} catch ( PDOException $e ) {
				die( $e->getMessage() );
			}
		} else {
			return $this->errMsg = 'Invalid Password';
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
	
	//Modify the logout functionality
    public function logout() {

	}
}
?>