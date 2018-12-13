<?php
require_once 'config/config.php';

if ( Session::isLoggedIn() )
    Router::redirect( 'dashboard.php' );
$username = '';
if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' ) {
	$data[ 'username' ] = $username =  Input::get( 'username');
    $data[ 'password' ] = Input::get( 'password' );
    $user->login( $data );
}
?>
<?php require('header.php');?>
        <div class="box">    
            <h1>Camagru</h1>
            <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>" >
                    <div class = "inputBox">
                        <input type="text" name="username" value="<?php echo $username; ?>" required>
                        <label>Username: </label>
                    </div>
                    <div class = "inputBox">
                        <input type="password"  name="passwrd" required>
                        <label>Password: </label>
                    </div>
                    <div class = "inputBox">
                        <input type="submit" name="submit" value="Log in">
                        <?php 
                            if ( $user->errMsg )
                            echo '<p style="color:red;">' . $user->errMsg . '</p>';
                        ?>
                        <a href="register.php">Register</a>
                    </div>
                    <a href="forgot.php">forgot password ?</a>
            </form>
        </div>
<?php require('footer.php');?>