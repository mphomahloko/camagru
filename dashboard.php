<?php
    require_once 'config/config.php';
    require_once 'Pictures.class.php';
    require('header.php');
    
    if ( Session::isLoggedIn() ) {
        $pic = new Pictures();
        $use = $pic->getUserGallery( $_SESSION[ 'username' ] );
        if ( $use ){
            $items = $pic->numOfUserImgs;    
            $itemsPerPage = 5;
            $totalPages = ceil( $items / $itemsPerPage );
            if ( isset ($_GET[ 'page' ] )  && !empty( $_GET[ 'page' ] ) ) {
                $page = $_GET[ 'page' ];
                if ( $page > $totalPages || $page <= 0 )
                    $user->redirect( 'gallery.php?page=1' );
            } else {
                $page = 1;
            }
            $itemsToDisplay = $page * $itemsPerPage; 
            $k = $page * $itemsPerPage - $itemsPerPage;
            echo '<div class="container">';
            while ( isset( $use[ $k ] ) && $k < $itemsToDisplay ) {
                echo '<div class="gallery">
                        <img src="' . $use[ $k ][ "path" ] . '" alt="" width="200" height="300">
                    <div class="desc">
                        <a href="deletePost.php?img_Id='. $use[ $k++ ][ "img_Id" ] . '">delete post</a>
                    </div>
                </div>';
            }
            echo '</div>
            <br/>
            <div class="pagination">';
            for( $i = 1; $i <= $totalPages; $i++ ) {
                if ( $i == $page )
                    echo '<a class="active">' . $i . '</a>';
                else
                    echo '<a href="dashboard.php?page=' . $i . '">' . $i . '</a>';
                }
                echo '</div>';
        }
    } else
        die( "You do not have access to this page" );
?>
<?php require('footer.php');?>