<?php
function klasik_styles() {
	
	wp_register_style('prettyphoto-css', get_template_directory_uri().'/css/prettyPhoto.css', '', '', 'screen, all');
	wp_enqueue_style( 'prettyphoto-css');
	
	if (is_admin()) {
		wp_register_style('admin-css', get_template_directory_uri().'/css/admin.css', '', '', 'screen, all');
		wp_enqueue_style('admin-css');
	}
	
	if (!is_admin()) {
		
		wp_register_style('googleFonts', ( is_ssl() ? 'https' : 'http' ) . '://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700,600italic,400italic,300italic,700italic');
		wp_enqueue_style( 'googleFonts');
		
		wp_register_style('skeleton-css', get_template_directory_uri().'/css/skeleton.css', '', '', 'screen, all');
		wp_enqueue_style('skeleton-css');
		
		wp_register_style('general-css', get_template_directory_uri().'/css/general.css', '', '', 'screen, all');
		wp_enqueue_style('general-css');
		
		wp_register_style('flexslider-css', get_template_directory_uri().'/css/flexslider.css', '', '', 'screen, all');
		wp_enqueue_style( 'flexslider-css');
		

		wp_register_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css' , array(), '4.0.3', 'all' );
		wp_enqueue_style( 'fontawesome' );

		wp_register_style('main-css', get_bloginfo( 'stylesheet_url' ), '', '', 'all');
		wp_enqueue_style('main-css');
		
		if(file_exists( get_stylesheet_directory() . '/color.css')){
			wp_register_style('color-css', get_stylesheet_directory_uri().'/color.css', '', '', 'screen, all');
		}else{
			wp_register_style('color-css', get_stylesheet_directory_uri().'/css/color.css', '', '', 'screen, all');
		}
		wp_enqueue_style('color-css');
		
		if(file_exists( get_stylesheet_directory() . '/rtl.css')){
			wp_register_style('rtl-css', get_stylesheet_directory_uri().'/rtl.css', '', '', 'screen, all');
			$enablertl = klasik_get_option( 'klasik_enable_rtl','');
			if($enablertl=='1'){
				wp_enqueue_style('rtl-css');
			}
		}
		
		if(file_exists( get_stylesheet_directory() . '/fixedmenu.css')){
			wp_register_style('fixedmenu-css', get_stylesheet_directory_uri().'/fixedmenu.css', '', '', 'screen, all');
			$enable_fixedmenu = klasik_get_option( 'klasik_enable_fixed_menu','');
			if($enable_fixedmenu=='1'){
				wp_enqueue_style('fixedmenu-css');
			}
		}
		
		
		wp_register_style('layout-css', get_stylesheet_directory_uri().'/css/layout.css', '', '', 'all');
		wp_enqueue_style('layout-css');
		
		wp_register_style('noscript-css', get_stylesheet_directory_uri().'/css/noscript.css', '', '', 'screen, all');
		wp_enqueue_style('noscript-css');	
		
		
	}
}
add_action('init', 'klasik_styles');