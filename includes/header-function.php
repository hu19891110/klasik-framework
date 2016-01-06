<?php 
// Old get website title
if(!function_exists("klasik_document_title")){
	function klasik_document_title(){
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );

	}// end ts_get_title()
}

// New get website title start for WP 4.1
function theme_slug_setup() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );


// New get website title for under WP 4.1
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function klasik_title( $title, $sep ) {
		global $paged, $page;
	
		if ( is_feed() )
			return $title;
	
		// Add the site name.
		$title .= get_bloginfo( 'name', 'display' );
	
		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
	
		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'klasik' ), max( $paged, $page ) );
	
		return $title;
	}
	add_filter( 'wp_title', 'klasik_title', 10, 2 );
}

// head action hook
if(!function_exists("klasik_head")){
	function klasik_head(){
		do_action("klasik_head");
	}
	add_action('wp_head', 'klasik_head', 20);
}

if(!function_exists("klasik_print_headtag")){
	
	function klasik_print_headtag(){
		$favicon = klasik_get_option( 'klasik_favicon');
		if($favicon !="" ){
		?>
		<link rel="shortcut icon" href="<?php echo $favicon; ?>" />
		<?php
        }else{
		?>	
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" />
        <?php
		}
	}
	add_action("klasik_head","klasik_print_headtag",7);
}

if(!function_exists("klasik_print_customcss")){
	
	function klasik_print_customcss(){
		$customcss = klasik_get_option( 'klasik_customcss');
		if($customcss !="" ){
		?>
		<style type="text/css"><?php echo $customcss; ?></style>
		<?php
        }
	}
	add_action("klasik_head","klasik_print_customcss",8);
}


// print the logo html
if(!function_exists("klasik_logo")){
	function klasik_logo(){ 
	
		$logotype = klasik_get_option( 'klasik_logo_type');
		$logoimage = klasik_get_option( 'klasik_logo_image'); 
		$sitename =  klasik_get_option( 'klasik_site_name');
		$tagline = klasik_get_option( 'klasik_tagline');
		if($logoimage == ""){ $logoimage = get_stylesheet_directory_uri() . "/images/logo.png"; }
?>
		<?php if($logotype == 'textlogo'){ ?>
			
			<?php if($sitename=="" && $tagline==""){?>
                <h1><a href="<?php echo home_url( '/'); ?>" title="<?php _e('Click for Home','klasik'); ?>"><?php bloginfo('name'); ?></a></h1><span class="desc"><?php bloginfo('description'); ?></span>
            <?php }else{ ?>
                <h1><a href="<?php echo home_url( '/'); ?>" title="<?php _e('Click for Home','klasik'); ?>"><?php echo $sitename; ?></a></h1><span class="desc"><?php echo $tagline; ?></span>
            <?php }?>
        
        <?php } else { ?>
        	
            <div id="logoimg">
            <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'klasik' ) ); ?>" >
                <img src="<?php echo $logoimage;?>" alt="" />
            </a>
            </div>
            
		<?php } ?>
<?php 
	}
}

// print the page title
if(!function_exists('klasik_page_title')){
	function klasik_page_title(){
		//custom meta field
		$custom = klasik_get_customdata();

		$mt_icon = klasik_get_metabox('klasik_icon');
		
		$faicontitle = '';
		if($mt_icon){$faicontitle = '<span class="fa-icon-title"><i class="fa '.$mt_icon.' "></i></span> ';}
		
		if(is_singular('portfolio') || is_attachment()){
		
			$titleoutput='<h1 class="pagetitle nodesc">'.get_the_title().'</h1>';
			echo $titleoutput;
			
		}elseif(is_single()){
		
			$titleoutput= $faicontitle.'<h1 class="pagetitle nodesc">'.get_the_title().'</h1>';
			echo $titleoutput;
			
		}elseif(function_exists('is_woocommerce') && is_woocommerce()){
			
			echo '<h1 class="pagetitle nodesc">';
				woocommerce_page_title();
			echo '</h1>';
			
		}elseif(is_archive()){
			echo '<h1 class="pagetitle nodesc">';
			if ( is_day() ) :
			printf( __( 'Daily Archives <span>%s</span>', 'klasik' ), get_the_date() );
			elseif ( is_month() ) :
			printf( __( 'Monthly Archives <span>%s</span>', 'klasik' ), get_the_date('F Y') );
			elseif ( is_year() ) :
			printf( __( 'Yearly Archives <span>%s</span>', 'klasik' ), get_the_date('Y') );
			elseif ( is_author()) :
			printf( __( 'Author Archives %s', 'klasik' ), "<a class='url fn n' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" );
			else :
			printf( __( '%s', 'klasik' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			endif;
			echo '</h1>';
			
			if(category_description( get_cat_ID( single_cat_title( '', false ) ) )){
				echo '<span class="pagedesc">'.category_description( get_cat_ID( single_cat_title( '', false ) ) ).'</span>';
			}
			
		}elseif(is_search()){
			echo '<h1 class="pagetitle nodesc">';
			printf( __( 'Search Results for %s', 'klasik' ), '<span>' . get_search_query() . '</span>' );
			echo '</h1>';
			
		}elseif(is_404()){
			echo ' <h1 class="pagetitle nodesc">';
			_e( '404 Page', 'klasik' );
			echo '</h1>';
			
		}elseif( is_home() ){
			$homeid = get_option('page_for_posts');
			echo '<h1 class="pagetitle nodesc">';
			echo ($homeid)? get_the_title( $homeid ) : __('Latest Posts', 'klasik');
			echo '</h1>';
		}else{
		
		 if (have_posts()) : while (have_posts()) : the_post();
		
				$titleoutput='';
				$titleoutput.= $faicontitle.'<h1 class="pagetitle">'.get_the_title().'</h1>';
				echo $titleoutput;

				global $post;
				if( $post->post_excerpt ) {
					echo '<span class="pagedesc">'.get_the_excerpt().'</span>';
				}
				
			
		endwhile; endif; wp_reset_query();
		
		}
	}
}


if( !function_exists('klasik_page_image')){
	function klasik_page_image(){
	
		$custom = klasik_get_customdata();
		$cf_pageimg = (isset($custom["page-image"][0]) && $custom["page-image"][0]!="")? $custom["page-image"][0] : "";
		

		$bg_pagetitle = "";
		if($cf_pageimg!=""){
			$bg_pagetitle .='style="background-image:url(';
			$bg_pagetitle .= $cf_pageimg;
			$bg_pagetitle .=')"';
		};
		
		return $bg_pagetitle;
	}
}
?>
