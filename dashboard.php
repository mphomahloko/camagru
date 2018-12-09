<?php require('header.php');?>
<?php
    require_once 'config/database.php';
        try {
            session_start();
            $sql = "SELECT * FROM gallery WHERE username = ? ORDER BY date DESC";
            $db = DB::getInstance();
            $stmt = $db->connection()->prepare( $sql );
            $stmt->execute( [ $_SESSION[ 'username' ] ] );
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
                <a target="_blank" href="#">
                    <img src="' . $use[ $k++ ][ "path" ] . '" alt="" width="200" height="300">
                </a>
                <div class="desc">
                
                    Here goes the comments
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
        ?>
<?php require('footer.php');?>