<?php require('header.php');?>
    <?php
    session_start();
    require_once 'config/database.php';
        if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
            if ( !empty( htmlentities( $_POST[ 'subject' ] ) &&  !empty( htmlentities( $_POST[ 'username' ] ) )) ) {
                try {
                    $sql = 'INSERT INTO comments SET `img_id` = ?, `username` = ?, comment = ?';
                    $db = DB::getInstance();
                    $stmt = $db->connection()->prepare( $sql );
                    $stmt->execute( [ htmlentities( $_POST[ 'img_id' ] ), htmlentities( $_POST[ 'username' ] ) , htmlentities( $_POST[ 'subject' ] ) ] );
            } catch (PDOException $e) {
                die( $e->getMessage() );
            }
        }
    }
        try {
            $sql = "SELECT * FROM gallery ORDER BY date DESC";
            $db = DB::getInstance();
            $stmt = $db->connection()->prepare( $sql );
            $stmt->execute();
            $use = $stmt->fetchALL();
            $sql= "SELECT * FROM comments";
            $stmt = $stmt = $db->connection()->prepare( $sql );
            $stmt->execute();
            $comments = $stmt->fetchALL();
            } catch ( PDOException $e ) {
                die( $e->getMessage() );
            }
            $items = 0;
            while ( isset( $use[ $items ] ) )
                $items++;
            $itemsPerPage = 5;
            $totalPages = ceil( $items / $itemsPerPage );
            if ( isset ($_GET[ 'page' ] )  && !empty( $_GET[ 'page' ] ) ) {
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
            if ( !isset($_SESSION[ 'username'] ) ){
                $_SESSION[ 'username' ] = '';
            }
            while ( isset( $use[ $k ] ) && $k < $itemsToDisplay ) {
                echo '<div class="gallery">
                    <a href="#popup'.$x.'"><img src="' . $use[ $k ][ "path" ] . '"></a>
                    <div class="popup" id="popup'.$x++.'">
                        <div class="popup_inner">
                            <div class="popup_photo">
                                <img src="' . $use[ $k++ ][ "path" ] . '">
                            </div>
                            <div class="popup_text">
                                <form method="post" action="' . htmlspecialchars( $_SERVER[ "PHP_SELF" ] ) . '">
                                    <div class = "inputBox">
                                    <input type="hidden" name="img_id" value="' . $use[ $k ][ 'user_Id' ] . '" required>
                                    <input type="hidden" name="username" value="' . $_SESSION[ 'username' ] . '" required>
                                    <textarea id="subject" name="subject" placeholder="Write something.." style="height:auto; width: 100%;"></textarea>
                                    </div>
                                    <div class = "inputBox">
                                        <input type="submit" name="submit" value="comment">
                                    </div>
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
            echo '</div>';
        ?>
<?php require('footer.php');?>