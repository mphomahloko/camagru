<?php require('header.php');
$username = '';
?>
    <div class="reset_password">
        <h1>Reset Password</h1>
        <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>">
            <div class = "inputBox">
                <label>Username: </label>
                <input type="text" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class = "inputBox">
                <input type="submit" name="submit" value="Reset">
            </div>
        </form>
    </div>
        <?php
            require_once 'config/config.php';
            if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' )
                if ( !empty( htmlentities( $_POST[ 'username' ] ) ) && htmlentities( $_POST[ 'submit' ] ) == 'Reset' ) {
                    $username = Input::get( 'username' );
                    $user->sendPassword( $username );
                    if ( $user->errMsg )
                    echo '<p style="color:red;">' . $user->errMsg . '</p>';
                }
        ?>
<?php require('footer.php');?>
