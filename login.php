<?php
require_once 'config/database.php';

$name = $username = $fname = $lname = $email = $password = "";
$errors = $data = array();
if ( $_SERVER[ 'REQUEST_METHOD'] == 'POST' ) {
    
    if ( empty( $_POST[ 'username' ] ) ) {
        $errors[] = "Can't leave Username field empty!";
    }else {
		$username = test_input( $_POST[ 'username' ] );
        $data[ 'username' ] = $username;
    }
    if ( empty( $_POST[ 'fname' ] ) ) {
        $errors[] = "Can't leave your first name field empty!";
    }else {
        $fname = test_input( $_POST[ 'fname' ] );
        $data[ 'fname' ] = $fname;
    }
    if ( empty( $_POST[ 'lname' ] ) ) {
        $errors[] = "Can't leave your last name field empty!";
    }else {
        $lname = test_input( $_POST[ 'lname' ] );
        $data[ 'lname' ] = $lname;
    }
    if ( empty( $_POST[ 'email' ] ) ) {
        $errors[] = "Can't leave the email field empty!";
    }else {
        $email = test_input( $_POST[ 'email' ] );
        $data[ 'email' ] = $email;
    }
    if ( empty( $_POST[ 'passwrd' ] ) ) {
        $errors[] = "Can't leave Password field empty!";
    }else {
        $password = test_input( $_POST[ 'passwrd' ] );
        $data[ 'password' ] = $password;
    }
    if ( empty( $errors ) ) {
        $user->register( $data );
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
