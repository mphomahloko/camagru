<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Camagru</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="css/style.css"/>
    </head>
    <body>
        <div >
            <ul>
                <?php if ( isset( $_SESSION[ 'username' ] ) ):?>
                <li><a href="dashboard.php"><p>Home</p></a></li>
                <li><a href="profile.php"><p>Profile</p></a></li>
                <li><a href="WebCam.php"><p>Web Cam</p></a></li>
                <li><a href="Upload.php"><p>Upload</p></a></li>
                <?php endif;?>
                <li><a href="gallery.php?page=1"><p>Gallery</p></a></li>
                <?php if ( !isset( $_SESSION[ 'username' ] ) ):?>
                <li><a href="index.php"><p>Login</p></a></li>
                <li><a href="register.php"><p>Register</p></a></li>
                <?php endif;?>
                <?php if ( isset( $_SESSION[ 'username' ] ) ):?>
                <li style="float:right;"><a href="logout.php"><p>Logout</p></a></li>
                <?php endif;?>
            </ul>
        </div>
        <br />