    <?php
        require_once 'config/config.php';
        require_once 'Pictures.class.php';
        require_once 'Comments.class.php';
        require_once 'Likes.class.php';
        require('header.php');

        $pic = new Pictures();
        $comnt = new Comments();
        $like = new Likes();
        if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
            if ( Session::isLoggedIn() ) {
                if ( !empty( htmlentities( $_POST[ 'subject' ] ) ) ) {
                    $comnt->comment(  htmlentities( $_POST[ 'img_id' ] ), htmlentities( $_SESSION[ 'username' ] ) , htmlentities( $_POST[ 'subject' ] )  );
                }
                if ( !empty( htmlentities( $_POST[ 'submit' ] == 'Like' ) ) ) {
                    $like->deleteOrAddLike( htmlentities( $_POST[ 'img_id' ] ), htmlentities( $_SESSION[ 'username' ] ) );
                }
            } else
                die( "You do not have proper acess to this page" );
        }
        //images
        $use = $pic->getGallery();
        if ( $use ) {
            //comments
            $comments = $comnt->getComments();
            //pagination
            $items = $pic->numImg;
            $itemsPerPage = 5;
            $totalPages = ceil( $items / $itemsPerPage );
            if ( isset ( $_GET[ 'page' ] )  && !empty( $_GET[ 'page' ] ) ) {
                $page = $_GET[ 'page' ];
                if ( $page > $totalPages || $page <= 0)
                    $user->redirect( 'gallery.php?page=1' );
            } else {
                $page = 1;
            }
            $itemsToDisplay = $page * $itemsPerPage; 
            $k = $page * $itemsPerPage - $itemsPerPage;
            echo '<div class="container">';
            $x = 0;
            while ( isset( $use[ $k ] ) && $k < $itemsToDisplay ) {
                echo '<div class="gallery">
                    <a href="#popup'.$x.'"><img src="' . $use[ $k ][ "path" ] . '"></a>
                    <div class="popup" id="popup'.$x++.'">
                        <div class="popup_inner">
                            <div class="popup_photo">
                                <img src="' . $use[ $k ][ "path" ] . '">
                            </div>
                            <div class="popup_text">';
                            $com = 0;
                            while ( isset( $comments[ $com ] ) ) {
                                if ( $comments[ $com ][ "img_Id"] === $use[ $k ][ "img_Id" ] ) {
                                    echo '<p>'.$comments[ $com ]["username"].': '.$comments[ $com ][ "comment" ].'</p>';
                                }
                                $com = $com + 1;
                            }
                            echo '
                                <form method="post" action="' . htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) . '">
                                    <div class = "inputBox">
                                    <input type="hidden" name="img_id" value="' . $use[ $k++ ][ "img_Id" ] . '" required>
                                    <textarea id="subject" name="subject" placeholder="Write something.." style="height:auto; width: 100%;"></textarea>
                                    </div>
                                    <div class = "inputBox">
                                    <p>' . $like->numOfLikes . ' likes </p>';
                                    if ( Session::isLoggedIn() )
                                        echo '<input type="submit" name="submit" value="comment">
                                        <input type="submit" name="submit" value="Like"></p>';
                                    echo '</div>
                                </form>
                            </div>
                            <a href="" class="popup_close">X</a>
                        </div>
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
                    echo '<a href="gallery.php?page=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';}
    ?>
<?php require('footer.php');?>