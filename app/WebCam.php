<?php
require_once 'config/config.php';
require_once 'Pictures.class.php';
if ( !Session::isLoggedIn() )
    Router::redirect( 'index.php' );
$pic = new Pictures();
$path = "";
if ( isset( $_POST['s_img'] ) ) {
    $img = $_POST['photo'];
    $pics = explode( ",", $img );
    if ( $img ) {
        $mg = base64_decode( $pics[1] );
        $image_id = uniqid();
        $imageDir = "./images/";
        if ( !file_exists( $imageDir ) )
            mkdir($imageDir);
        file_put_contents($imageDir . $image_id . '.jpeg', $mg);
        $path = "images/" . $image_id .".jpeg";
        $pic->addToGallery( $_SESSION[ 'username' ], $path );
    }
}

?>
<?php require('header.php');?>
<div class="camera-section">
    <div id="stickers">
        <img id="st" src="./images/fuck_off.jpg" width="60" height="60" onclick="draw('st', 500, 300);">
        <img id="st1" src="./images/Awe.jpeg" width="60" height="60" onclick="draw('st1', 500, 200);">
        <img id="st2" src="./images/shocked.png" width="60" height="60" onclick="draw('st2', 400, 200);">
        <img id="st3" src="./images/wink.png" width="60" height="60" onclick="draw('st3', 400, 300);">
        <img id="st4" src="./images/shit.png" width="60" height="60" onclick="draw('st4', 300, 200);">
        <img id="st5" src="./images/smile.png" width="60" height="60" onclick="draw('st5', 300, 300);">
    </div><hr>
    <video id="vid1"></video>
    <canvas id="canvas"></canvas><br/>
    <button onclick="snap();">Snap</button><br/>
    <form method = "POST">
        <input type="hidden" id="picture" name="photo">
        <input id="but" type="hidden" name="s_img" value="Save Image" onclick="finalImage();">
    </form>
</div><hr>
<div class="container">
    <h2>Recent photos</h2>
    <?php
        $pic = new Pictures();
        $use = $pic->getUserGallery( $_SESSION[ 'username' ] );
        $k = 0;
        while ( isset( $use[ $k ] ) && $k < 5 ) {
            echo '<div class="gallery">
                    <img src="' . $use[ $k++ ][ "path" ] . '" alt="">
            </div>';
        }
    ?>    
</div>
    <script type="text/javascript" src="js/camera.js"></script>
<?php require('footer.php');?>
