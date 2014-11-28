<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if (!isset( $content_width ) )
	$content_width = 620;

function getCurrentPage()
{
	$url = $_SERVER["REQUEST_URI"];
	$urlParts = explode("/", ltrim(rtrim($url, "/"), "/"));
	$urlParts = array_reverse($urlParts);
	
	if(empty($urlParts[0]))
		return 0;
	
	return $urlParts[0];
}

function register_menu() {
  register_nav_menus(
    array( 'main' => __( 'Main Menu' ) )
  );
}
add_action( 'init', 'register_menu' );