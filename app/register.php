<?php
require_once 'config/config.php';

if ( Session::isLoggedIn() )
    Router::redirect( 'dashboard.php' );
$name = $username = $fname = $lname = $email = $password = "";
$errors = $data = array();
if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' ) {
		$username = Input::get( 'username' );
        $data[ 'username' ] = $username;
        $fname = Input::get( 'fname' );
        $data[ 'fname' ] = $fname;
        $lname = Input::get( 'lname' );
        $data[ 'lname' ] = $lname;
        $email = Input::get( 'email' );
        $data[ 'email' ] = $email;
        $data[ 'password' ] = Input::get( 'passwrd' );
       $user->register( $data );
}
?>
<?php require('header.php');?>
        <div>
            <form id="sign-up-form" method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>" >
                <hr><div><em><h2>Camagru Sign-Up</h2></em></div><hr>
                <div>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                </div>
                <br />
                <div>
                    <input type="text" name="fname" placeholder="FirstName" value="<?php echo $fname; ?>" required  pattern='[a-zA-Z\-]+'>
                </div>
                <br />
                
                <div>
                    <input type="text" name="lname" placeholder="LastName" value="<?php echo $lname; ?>" required  pattern='[a-zA-Z\-]+'>
                </div>
                
                <br />
                <div>
                    <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required pattern="\w+" title="letters And/Or numbers are allowed">
                </div>
                <br />
                <div>
                    <input id="pass1" type="password" placeholder="Password" name="passwrd" required minlength="6" pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*" 
								title="Must have digits, caps and small letters">
                </div>
                <br />
                <div>
                    <input id="pass2" type="password" placeholder="Confirm Password" name="re_passwrd" required minlength="6" pattern="(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*" 
								title="Must have digits, caps and small letters">
                    <p id="alert-error" style="color:red;">
                    <?php
                        if ( User::$errMsg )
                            echo User::$errMsg;
                    ?></p>
                </div>
                <br />
                <div>
                <input type="submit" name="submit" value="Submit">
                    <br />
                </div>
            </form>
            
        </div>
        <script type="text/javascript" src="js/custom.js"></script><br/>
<?php require('footer.php');?>
