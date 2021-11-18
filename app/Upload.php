<?php
require_once 'config/config.php';
require_once 'Pictures.class.php';
if ( !Session::isLoggedIn() )
    Router::redirect( 'index.php' );

$pic = new Pictures();
// Check if image file is a actual image or fake image
if ( isset( $_POST["submit"] ) ) {
    unset( $_POST['submit'] );
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if ( isset( $_FILES["fileToUpload"]["tmp_name"] ) )
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if( $check !== false ) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
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
        if ( move_uploaded_file( $_FILES["fileToUpload"]["tmp_name"] , $target_file ) ) {
            $pic->addToGallery( $_SESSION[ 'username' ], $target_file );
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>
<?php require('header.php');?>
    <form action="Upload.php" method="post" enctype="multipart/form-data">
        <p>Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit" ></p>
    </form><br />
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
    <script type="text/javascript" src="js/upload.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
<?php require('footer.php');?>