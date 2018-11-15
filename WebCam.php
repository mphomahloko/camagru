<?php
require_once 'config/database.php';

$path = "";
if ( isset( $_POST['s_img'] ) ) {
    $img = $_POST['photo'];
    $pic = explode( ",", $img );
    if ( $img ){
        $mg = base64_decode( $pic[1] );
        $image_id = uniqid();
        $imageDir = "./images/";
        if ( !file_exists( $imageDir ) )
            mkdir($imageDir);
        file_put_contents($imageDir . $image_id . '.jpeg', $mg);
        $path = "images/" . $image_id .".jpeg";
        //$sql = $db->prepare("INSERT INTO
    }
    else {
        echo 'Failed to take picture';
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Camagru</title>
    </head>
    <body>
    <video id="vid1"></video><br/>
    <button onclick="snap();">Snap</button><br/>
    <div>
        <img id="st" src="./images/fuck_off.jpg" width="60" height="60" onclick="draw('st');">
        <img id="st1" src="./images/Awe.jpeg" width="60" height="60" onclick="draw('st1');">
        <img id="st2" src="./images/respect.jpg" width="60" height="60" onclick="draw('st2');">
        <img id="st3" src="./images/shocked.png" width="60" height="60" onclick="draw('st3');">
    </div>
    <canvas id="canvas" ></canvas><br/>
    <form method = "POST">
        <input type="hidden" id="picture" name="photo">
        <input id="but" type="hidden" name="s_img" value="Save Image" onclick="finalImage();">
    </form><br/>
    <script type="text/javascript" src="./canvas.js"></script>
    </body>
</html>