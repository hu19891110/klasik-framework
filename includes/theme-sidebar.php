<?php
function klasik_sidebar_init() {

	register_sidebar( array(
		'name' 					=> __( 'Primary Sidebar', 'klasik' ),
		'id' 						=> 'primary-sidebar',
		'description' 		=> __( 'Located at the left/right side of archives, single and search.', 'klasik' ),
		'before_widget' 	=> '<ul><li id="%1$s" class="widget-container %2$s"><div class="box">',
		'after_widget' 		=> '<div class="clear"></div></div></li></ul>',
		'before_title' 		=> '<h3 class="widget-title">',
		'after_title' 			=> '</h3>',
	));	
	
}



function klasik_maintop_sidebar(){	
		register_sidebar(array(
		'name'          => __('Main Top', 'klasik' ),
		'id'         	=> 'maintop',
		'description'   => __( 'Located at the top of the content top.', 'klasik' ),
		'before_widget' => '<div class="widget-maintop"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

function klasik_contenttop_sidebar(){
	
	register_sidebar(array(
		'name'          => __('Content Top', 'klasik' ),
		'id'         	=> 'contenttop',
		'description'   => __( 'Located at the top of the content.', 'klasik' ),
		'before_widget' => '<div class="widget-contenttop"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

function klasik_contentbottom_sidebar(){
	register_sidebar(array(
		'name'          => __('Content Bottom', 'klasik' ),
		'id'         	=> 'contentbottom',
		'description'   => __( 'Located at the bottom of the content.', 'klasik' ),
		'before_widget' => '<div class="widget-contentbottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}


function klasik_mainbottom_sidebar(){	
	register_sidebar(array(
		'name'          => __('Main Bottom', 'klasik' ),
		'id'         	=> 'mainbottom',
		'description'   => __( 'Located at the bottom of the content bottom.', 'klasik' ),
		'before_widget' => '<div class="widget-mainbottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));

}


function klasik_footer1_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer 1', 'klasik' ),
		'id'         	=> 'footer1',
		'description'   => __( 'Located at the footer column 1.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer2_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer 2', 'klasik' ),
		'id'         	=> 'footer2',
		'description'   => __( 'Located at the footer column 2.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));	
	
}

function klasik_footer3_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer 3', 'klasik' ),
		'id'         	=> 'footer3',
		'description'   => __( 'Located at the footer column 3.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer4_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer 4', 'klasik' ),
		'id'         	=> 'footer4',
		'description'   => __( 'Located at the footer column 4.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer5_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer 5', 'klasik' ),
		'id'         	=> 'footer5',
		'description'   => __( 'Located at the footer column 5.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer6_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer 6', 'klasik' ),
		'id'         	=> 'footer6',
		'description'   => __( 'Located at the footer column 6.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}



/** Register sidebars by running klasik_sidebar_init() on the widgets_init hook. */
add_action( 'widgets_init', 'klasik_sidebar_init' );

add_action( 'widgets_init', 'klasik_maintop_sidebar' );
add_action( 'widgets_init', 'klasik_contenttop_sidebar' );

add_action( 'widgets_init', 'klasik_contentbottom_sidebar' );
add_action( 'widgets_init', 'klasik_mainbottom_sidebar' );

