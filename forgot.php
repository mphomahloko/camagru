<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru</title>
</head>
    <body>
        <?php require('header.php');?>
            <h1>Reset Password</h1>
            <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ 'PHP_SELF' ] ); ?>">
                <div class = "inputBox">
                    <input type="text" name="username" value="<?php echo $username; ?>" required>
                    <label>Username: </label>
                </div>
                <div class = "inputBox">
                    <input type="submit" name="submit" value="Log in" requred="">
                </div>
            </form>
        <?php require('footer.php');?>
