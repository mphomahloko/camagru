<?php require('header.php');?>
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
            <?php
               require_once 'config/config.php';
               if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' )
                   if ( !empty( htmlentities( $_POST[ 'username' ] ) ) && htmlentities( $_POST[ 'submit' ] ) == 'Reset' ) {
                       $username = htmlentities( $_POST[ 'username' ] );
                       $user->sendPassword( $username );
                       if ( $user->errMsg )
                       echo '<p style="color:red;">' . $user->errMsg . '</p>';
                   }
            ?>
<?php require('footer.php');?>
