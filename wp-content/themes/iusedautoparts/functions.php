<?php
require_once('wp_bootstrap_navwalker.php');

add_theme_support( 'custom-header' );

add_theme_support( 'menus' );

//Widgets
if ( function_exists ('register_sidebar')) { 
    register_sidebar( array(
		'id'          => 'top-menu',
		'name'        => __( 'Sidebar', $text_domain ),
		'description' => __( 'This sidebar is located of the right column.', $text_domain ),
	) );
}

//Menu
function register_menus() {
  register_nav_menus(
    array(
      'header-menu-left' => __( 'Header Menu Left' ),
	  'header-menu-right' => __( 'Header Menu Right' ),
      'footer-menu' => __( 'Footer Menu' ),
	  'footer-menu-copy' => __( 'Footer Copyright' )
    )
  );
}
add_action( 'init', 'register_menus' );




?>