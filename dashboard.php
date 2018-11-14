<?php
require_once 'config/database.php';
$path = "";
if ( isset( $_POST['submit'] ) ) {
    $img = $_POST['photo'];
    $pic = explode(",",$img);
    if ( $img ){
        $mg = base64_decode($pic[1]);
        $image_id = uniqid();
        $imageDir = "./images/";
        if ( !file_exists( $imageDir ) )
            mkdir($imageDir);
        file_put_contents($imageDir . $image_id . '.jpeg', $mg);
        $path = "images/" . $image_id .".jpeg";
        //$sql = $db->prepare("INSERT INTO
    }
    else {
        echo "<script>alert ('no image');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Camagru</title>
    </head>
    <body>
    <video id="vid1" ></video><br>
        <button onclick="snap();">Snap</button><br>
        <canvas id="canvas"></canvas><br>
    <form method = "POST">
        <input type="hidden" id = "picture" name = "photo">
        <input type = "submit" name = "submit" value = "save image">
    </form>
    <script type="text/javascript" src="./cam.js"></script>
    <?php if ( $path )
            echo "<div><img src = '$path'></div>"; ?>
    </body>
</html>