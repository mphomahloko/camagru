<?php require('header.php');?>
    <?php
    require_once 'config/database.php';
        try {
            $sql = "SELECT * FROM gallery ORDER BY date DESC";
            $db = DB::getInstance();
            $stmt = $db->connection()->prepare( $sql );
            $stmt->execute();
            $use = $stmt->fetchALL();
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
            while ( isset( $use[ $k ] ) && $k < $itemsToDisplay ) {
                echo '<div class="gallery">
                    <a href="#popup'.$x.'"><img src="' . $use[ $k ][ "path" ] . '"></a>
                    <div class="popup" id="popup'.$x++.'">
                        <div class="popup_inner">
                            <div class="popup_photo">
                                <img src="' . $use[ $k++ ][ "path" ] . '">
                            </div>
                            <div class="popup_text">
                                <h1>UserName<h1>
                                <p> HELLO there my young onces</p>
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