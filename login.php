<?php
require_once 'config/database.php';

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
<!Doctype html>
<html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <div><em>Camagru</em></div>
        <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>" >
            <div>
                <input id="03be3" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
            </div>
            <br />
            <div>
                <input id="03bz3" type="password" placeholder="Password" name="passwrd" required>
            </div>
            <br />
            <div>
            <input type="submit" name="submit" value="Login">
                <br />
            </div>
        </form>
    </div>
</body>
</html>