<?php

add_action( 'after_setup_theme', 'klasik_setup' );

function klasik_default_image(){
	$imgconf = array(
	);
	return $imgconf;
}

if ( ! function_exists( 'klasik_setup' ) ):

function klasik_setup() {
	
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
		add_theme_support( 'post-thumbnails' );
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'gallery', 'video', 'audio' ) );
	
	//Add Custom Image Size
	add_image_size( 'widget-feature', '50', '50', true );
	add_image_size( 'widget-portfolio', '500', '378', true );
	add_image_size( 'widget-latestnews', '550', '330', true );
	add_image_size( 'widget-testimonial', '100', '100', true );
	add_image_size( 'widget-team', '190', '190', true );

	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primarymenu' => __( 'Primary Menu', 'klasik' )

	) );
	
	/* Sidebar woocommerce */
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	/* woocommerce hide page title */
	add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );
	function woo_hide_page_title() {
		return false;
	}
	
	/* remove breadcrumbs woocommerce on the page */
	add_action( 'init', 'klasik_remove_wc_breadcrumbs' );
	function klasik_remove_wc_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
		
}
endif;

/* Declare WooCommerce support  
code to hide the, "Your theme does not declare WooCommerce support" message. 
*/
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

if ( ! function_exists( 'klasik_theme_support' ) ):

function klasik_theme_support() {
	$args = "";
	 add_theme_support( 'custom-header', $args );
	 add_theme_support( 'custom-background', $args );
}
endif;