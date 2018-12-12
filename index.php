<?php
require_once 'config/config.php';

$username = $password = "";
$errors = $data = array();

if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' ) {
    if ( empty( $_POST[ 'username' ] ) ) {
        $errors[] = "Can't leave Username field empty!";
    }else {
		$username = test_input( $_POST[ 'username' ] );
        $data[ 'username' ] = $username;
    }
    if ( empty( $_POST[ 'passwrd' ] ) ) {
        $errors[] = "Can't leave Password field empty!";
    }else {
        $password = test_input( $_POST[ 'passwrd' ] );
        $data[ 'password' ] = $password;
    }
    if ( empty( $errors ) ) {
        $user->login( $data );
    }
}

function test_input( $trimm ) {
    $trimm = trim( $trimm );
    $trimm = stripslashes( $trimm );
    $trimm = htmlspecialchars( $trimm );
    return $trimm;
}

?>
<?php require('header.php');?>
        <div class="box">    
            <h1>Camagru</h1>
            <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>" >
                    <div class = "inputBox">
                        <input type="text" name="username" value="<?php echo $username; ?>" required="">
                        <label>Username: </label>
                    </div>
                    <div class = "inputBox">
                        <input type="password"  name="passwrd" required="">
                        <label>Password: </label>
                    </div>
                    <div class = "inputBox">
                        <input type="submit" name="submit" value="Log in" requred="">
                        <a href="register.php">Register</a>
                    </div>
                    <a href="forgot.php">forgot password ?</a>
            </form>
        </div>
<?php require('footer.php');?>