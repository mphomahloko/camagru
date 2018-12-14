<?php
require_once 'config/config.php';

if ( Session::isLoggedIn() )
    Router::redirect( 'dashboard.php' );
$username = '';
if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' ) {
	$data[ 'username' ] = $username =  Input::get( 'username');
    $data[ 'password' ] = Input::get( 'passwrd' );
    echo $data[ 'password' ];
    $user->login( $data );
}
?>
<?php require('header.php');?>
        <div class="box">    
            <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>" >
                    <h1>Camagru</h1>
                    <div class = "inputBox">
                        <input type="text" placeholder="  Username" name="username" value="<?php echo $username; ?>" required>
                    </div>
                    <div class = "inputBox">
                        <input type="password" placeholder="  Password" name="passwrd" required>
                    </div>
                    <div class = "inputBox">
                        <input type="submit" name="submit" value="Log in">
                        <?php 
                            if ( User::$errMsg )
                            echo '<p style="color:red;">' . User::$errMsg . '</p>';
                        ?>
                        <a href="register.php">Register</a>
                    </div>
                    <a href="forgot.php">Forgot password?</a>
            </form>
        </div>
<?php require('footer.php');?>