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
    <div class="wrapper">
    <div class="box-content">
        <div class="header"><em><h1>Camagru</h1></em></div>
        <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>" >
            <div class="box1">
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required class="input-1"/>
            <div class="overlap-text">
                <input type="password" placeholder="Password" name="passwrd" required class="input-2"/>
            </div>
                <input type="button" name="submit" value="Log in" class="btn1">
                <div class="fpwd">
                    <a href="#">forgot password ?</a>
                </div>
                <div class="col-xs-2 col-sm6">
                <hr class="obm_hrOr">
                <span class="spanOR"></span>
                </div>
            </div>
        </form>
        </div>
    </div>
</body>
</html>
