<?php

// Crappy needs work
Class Router {
    public static function redirect( $url ) {
		header( 'location: ' . $url );
	}
}
