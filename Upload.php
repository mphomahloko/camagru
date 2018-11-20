<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if ( isset($_POST["submit"] ) ) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if ( !file_exists( $target_dir ) )
                mkdir( $target_dir );
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Camagru</title>
</head>
<body>
<form action="Upload.php" method="post" enctype="multipart/form-data">
    <p>Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit" onclick="UpLoadedImg();"></p>
</form><br>
<div>
    <img id="st" src="./images/fuck_off.jpg" width="60" height="60" onclick="draw('st');">
    <img id="st1" src="./images/Awe.jpeg" width="60" height="60" onclick="draw('st1');">
    <img id="st2" src="./images/shocked.png" width="60" height="60" onclick="draw('st2');">
    <img id="st3" src="./images/wink.png" width="60" height="60" onclick="draw('st3');">
    <img id="st4" src="./images/shit.png" width="60" height="60" onclick="draw('st4');">
    <img id="st5" src="./images/smile.png" width="60" height="60" onclick="draw('st5');">
</div>
    <br>
<canvas id="canvas" ></canvas><br/>
<form method = "POST">
    <input type="hidden" id="picture" name="photo">
    <input id="but" type="hidden" name="s_img" value="Save Image" onclick="finalImage();">
</form><br/>
<?php

    $folder = "uploads/";

    if ( is_dir( $folder ) ) {
        if ( $open = opendir( $folder ) ) {
            while ( ( $file = readdir( $open ) ) != false ) {
                if ( $file == '.' || $file == '..' ) continue;
                echo '<img style="display: none;" id="imgUpload" src="' . $folder . $file . '" width="150" height=150 ><br>';
            }
            closedir( $open );
        }
    }
?>
<script type="text/javascript" src="./upload.js"></script>
<script type="text/javascript" src="./custom.js"></script>
</body>
</html>