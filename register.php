<?php
require_once 'config/database.php';

$name = $username = $fname = $lname = $email = $password = "";
$errors = $data = array();
if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' ) {
		$username = Input::get( test_input( $_POST[ 'username' ] ) );
        $data[ 'username' ] = $username;
        $fname = Input::get( test_input( $_POST[ 'fname' ] ) );
        $data[ 'fname' ] = $fname;
        $lname = Input::get( test_input( $_POST[ 'lname' ] ) );
        $data[ 'lname' ] = $lname;
        $email = Input::get( test_input( $_POST[ 'email' ] ) );
        $data[ 'email' ] = $email;
        $password = Input::get( test_input( $_POST[ 'passwrd' ] ) );
        $data[ 'password' ] = $password;
        $user->register( $data );
}

function test_input( $trimm ) {
    $trimm = trim( $trimm );
    $trimm = stripslashes( $trimm );
    $trimm = htmlspecialchars( $trimm );
    return $trimm;
}

?>
<?php require('header.php');?>
        <div>
            <div><em>Camagru</em></div>
            <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>" >
                <div>
                    <input id="0e2" type="text" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                </div>
                <br />
                <div>
                    <input id="01e2" type="text" name="fname" placeholder="FirstName" value="<?php echo $fname; ?>" required>
                </div>
                <br />
                <div>
                    <input id="02be2" type="text" name="lname" placeholder="LastName" value="<?php echo $lname; ?>" required>
                </div>
                <br />
                <div>
                    <input id="03be3" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                </div>
                <br />
                <div>
                    <input id="03bz3" type="password" placeholder="Password" name="passwrd" required>
                </div>
                <br />
                <div>
                <input type="submit" name="submit" value="submit">
                    <br />
                </div>
            </form>
        </div>
<?php require('footer.php');?>
