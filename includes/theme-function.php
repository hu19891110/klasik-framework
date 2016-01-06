<?php

/*********For Localization**************/
add_action('after_setup_theme', 'klasik_load_textdomain');
function klasik_load_textdomain(){
	load_theme_textdomain( 'klasik', get_template_directory().'/languages' );
	load_theme_textdomain( 'klasik', get_stylesheet_directory().'/languages' );
}
/*********End For Localization**************/

// Add the excerpts to pages
add_action( 'init', 'klasik_excerpts_to_pages' );
function klasik_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

// The excerpt based on character
if(!function_exists("klasik_string_limit_char")){
	function klasik_string_limit_char($excerpt, $substr=0, $strmore = ""){
		$string = strip_tags(str_replace('...', '...', $excerpt));
		if ($substr>0) {
			$string = substr($string, 0, $substr);
		}
		if(strlen($excerpt)>=$substr){
			$string .= $strmore;
		}
		return $string;
	}
}
// The excerpt based on words
if(!function_exists("klasik_string_limit_words")){
	function klasik_string_limit_words($string, $word_limit){
	  $words = explode(' ', $string, ($word_limit + 1));
	  if(count($words) > $word_limit)
	  array_pop($words);
	  
	  return implode(' ', $words);
	}
}

if(!function_exists("klasik_get_category")){
	function klasik_get_category(){
		global $post;
		$categories = get_the_category();
		$separator = ', ';
		$catoutput = '';
		if($categories){
			foreach($categories as $category) {
				$catoutput .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'klasik' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
			}
		}
		
		return trim($catoutput, $separator);
	}
}

if( !function_exists('klasik_is_pagepost')){
	function klasik_is_pagepost(){
		global $post;
		
		if( is_404() || is_archive() || is_attachment() || is_search() ){
			$custom = false;
		}else{
			$custom = true;
		}
		
		return $custom;
	}
}

if( !function_exists('klasik_get_customdata')){
	function klasik_get_customdata($pid=""){
		global $post;
		
		if($pid!=""){
			$custom = get_post_custom($pid);
		}elseif( klasik_is_pagepost() ){
			$custom = get_post_custom(get_the_ID());
		}else{
			$custom = array();
		}
		
		return $custom;
	}
}

if( !function_exists('klasik_get_imgsize')){
	function klasik_get_imgsize(){
	
		global $imgconf;
		$defaultimg = klasik_default_image();
		$imageconfs = (isset($imgconf) && is_array($imgconf))? $imgconf : array();
		
		$imageconfs = array_merge($defaultimg, $imageconfs);
		
		return $imageconfs;
	}
}

if( !function_exists('klasik_get_customstyle')){
	function klasik_get_customstyle(){
	
		global $customstyles;
		$defaultimg = klasik_default_styles();
		$imageconfs = (isset($customstyles) && is_array($customstyles))? $customstyles : array();
		
		$imageconfs = array_merge($defaultimg, $imageconfs);
		
		return $imageconfs;
	}
}

if( !function_exists('klasik_get_configval')){
	function klasik_get_configval($confstr,$defval=""){
	
		if(defined($confstr)){
			$return = constant($confstr);
		}else{
			$return = $defval;
		}
		
		return $return;
		
	}
}

if( !function_exists('klasik_widget_count')){
	function klasik_widget_count( $sidebar_name ) {
		global $sidebars_widgets;
		$count = count ($sidebars_widgets[$sidebar_name]);
		
		return $count;
	
	}
}


/* Remove inline styles printed when the gallery shortcode is used.*/
function klasik_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'klasik_remove_gallery_css' );

/*Template for comments and pingbacks. */
if ( ! function_exists( 'klasik_comment' ) ) :
function klasik_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="con-comment">
		<div class="comment-author vcard">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</div><!-- .comment-author .vcard -->


		<div class="comment-body">
			<?php  printf( __( '%s ', 'klasik' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
            <span class="time">
               <?php
                /* translators: 1: date, 2: time */
                printf( __( '%1$s %2$s', 'klasik' ), get_comment_date(),  get_comment_time() ); ?>
            </span>
			<div class="commenttext">
			<?php comment_text(); ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'klasik' ); ?></em>
			<?php endif; ?>
            <?php edit_comment_link( __( 'Edit', 'klasik' ), '<span class="com-link">', '</span>' );?>
			<?php comment_reply_link( 
                array_merge( 
                    $args, array(
                    'before' => '<span class="com-reply">', 
                    'depth' => $depth, 
                    'max_depth' => $args['max_depth'],
                    'after'      => '</span>' 
                    ) 
                ) 
            ); ?>
            
			</div>
            <div class="arrow"></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'klasik' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'klasik'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*Prints HTML with meta information for the current post (category, tags and permalink).*/
if ( ! function_exists( 'klasik_posted_in' ) ) :
function klasik_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'Categories: %1$s <br/> Tags: %2$s', 'klasik' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'Categories: %1$s', 'klasik' );
	} else {
		$posted_in = __( '', 'klasik' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if( ! function_exists('klasik_filter_title') ){
	function klasik_filter_title($title) {
		if ($title == '') {
			return __('Untitled','klasik');
		} else {
			return $title;
		}
	}
	add_filter('the_title', 'klasik_filter_title');
}

/* for top menu */
function nav_page_fallback() {
if(is_front_page()){$class="current_page_item";}else{$class="";}
print '<ul id="topnav" class="sf-menu">';
//print '<li class="'.$class.'"><a href=" '.home_url( '/') .' " title=" '.__('Click for Home','klasik').' ">'.__('Home','klasik').'</a></li>';
    wp_list_pages( 'title_li=&sort_column=menu_order' );
print '</ul>';
}

/* for shortcode widget  */
add_filter('widget_text', 'do_shortcode');


/*Remove Paragraph Tags From Around Images*/
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');


/* for removing the wpautop */
function klasik_run_shortcode( $content ) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
	
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
 
//add_filter( 'the_content', 'klasik_run_shortcode', 7 );


// Numbered Pagination
if ( !function_exists( 'klasik_pagination' ) ) {
	
	function klasik_pagination() {
		
		$prev_arrow = is_rtl() ? '&rsaquo;' : '&lsaquo;';
		$next_arrow = is_rtl() ? '&lsaquo;' : '&rsaquo;';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if( $total > 1 )  {
			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> $prev_arrow,
				'next_text'		=> $next_arrow,
			 ) );
		}
	}
	
}



/* Convert hexdec color string to rgb(a) string */
if ( !function_exists( 'klasik_hex2rgba' ) ) {
	function klasik_hex2rgba($klasik_color, $opacity = false) {
	
		$default = 'rgb(255,255,255)';
	
		//Return default if no color provided
		if(empty($klasik_color))
			  return $default; 
	
		//Sanitize $klasik_color if "#" is provided 
			if ($klasik_color[0] == '#' ) {
				$klasik_color = substr( $klasik_color, 1 );
			}
	
			//Check if color has 6 or 3 characters and get values
			if (strlen($klasik_color) == 6) {
					$hex = array( $klasik_color[0] . $klasik_color[1], $klasik_color[2] . $klasik_color[3], $klasik_color[4] . $klasik_color[5] );
			} elseif ( strlen( $klasik_color ) == 3 ) {
					$hex = array( $klasik_color[0] . $klasik_color[0], $klasik_color[1] . $klasik_color[1], $klasik_color[2] . $klasik_color[2] );
			} else {
					return $default;
			}
	
			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);
	
			//Check if opacity is set(rgba or rgb)
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}
	
			//Return rgb(a) color string
			return $output;
	}
}


// Enqueue scripts
function klasik_comment_js(){
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action('wp_enqueue_scripts', 'klasik_comment_js');



/* Color Picker */
add_action( 'admin_enqueue_scripts', 'klasik_enqueue_color_picker' );
function klasik_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'klasik-script-handle', get_template_directory_uri().'/js/colorscript.js', array( 'wp-color-picker','jquery' ), false, true );
}


/* Make all future posts visible in single post */
add_filter('the_posts', 'show_future_posts');
function show_future_posts($posts){ 
   global $wp_query, $wpdb;
   if(is_single() && $wp_query->post_count ==0){ 
      $posts = $wpdb->get_results($wp_query->request);
   } 
   return $posts;
};


function klasik_get_slider_args(){ 
    //global $wp_query, $post;
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'showposts' => 5,
		'orderby' => 'date',
		'ignore_sticky_posts' => 1
	);
	
	$args["meta_query"] = array(
		array(
			'key' => 'klasik_slider_post',
			'value' => '1',
			'compare' => '='
		)
	);

	return $args;
};

?>