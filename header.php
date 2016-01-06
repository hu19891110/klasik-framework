<?php
/**
 * The Header for our theme.
 *
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

<?php get_template_part( 'site-header'); ?>


<div id="bodychild">
	<div id="outercontainer">
    
        <!-- HEADER -->
        <div id="outerheader" class="fixedmenu">
        	<div id="headercontainer">
                <div class="container">
                    <header id="top">
                        <div class="row">
                        
                            <div id="logo" class="four columns"><?php klasik_logo();?></div>
                            <section id="navigation" class="eight columns">
                                <nav id="nav-wrap">
                                    <?php wp_nav_menu( array(
                                      'container'       => 'ul', 
                                      'menu_class'      => 'sf-menu',
                                      'menu_id'         => 'topnav', 
                                      'depth'           => 0,
                                      'sort_column'    => 'menu_order',
                                      'fallback_cb'     => 'nav_page_fallback',
                                      'theme_location' => 'primarymenu' 
                                      )); 
                                    ?>
                                </nav><!-- nav -->	
                                <div class="clear"></div>
                            </section>
                            <div class="clear"></div>
                            
                        </div>
                        <div class="clear"></div>
                    </header>
                </div>
                <div class="clear"></div>
            </div>
		</div>
        <!-- END HEADER -->

		<!-- AFTERHEADER -->
        
		<!-- SLIDER -->
	
		<?php 
		$isfrontpage=is_front_page();
		$args = klasik_get_slider_args();
		global $wp_query;
		$temp = $wp_query;
		$wp_query= null;
		$wp_query = new WP_Query();
		$wp_query->query($args);
		global $post;

		if( $isfrontpage && $wp_query->have_posts()  ){
		
			echo '
			<div id="outerslider">
				<div class="container">
					<div class="row">
						<div class="twelve columns">
						<div id="slidercontainer">
							<section id="slider">
								
			
			';
			
			get_template_part( 'slider-items');
				
			echo '
								
								<div class="clear"></div>
							</section>
							
						</div>
						</div>
					</div>
				</div>
			</div>
			';
			
			$outermainclass = "";
		}else{
			$outermainclass = "noslider"; 
		}
		wp_reset_query();
		?>
		<!-- END SLIDER -->
				
		<?php
		if($outermainclass=='noslider'){
		?>
            <div id="outerafterheader" class="<?php echo $outermainclass; ?>" <?php echo klasik_page_image() ?>>
                <div class="container">
                    <div class="row">
                        <div class="twelve columns">
                            <div id="afterheader">
                            	<div id="page-title-wrap">
                                <?php  
                                    klasik_page_title();
                                ?>
                                
								<?php 
								$custom = klasik_get_customdata();
								$cf_disablemeta = klasik_get_metabox('klasik_disable_meta');


								if(is_single() && !$cf_disablemeta && function_exists('is_woocommerce') && !is_woocommerce()){ 
								?>
                                    <div class="entry-utility">
                                        <div class="date"> <?php the_time(get_option('date_format')); ?></div>  
                                        <span class="text-sep text-sep-date">/</span>
                                        <div class="user">
										<?php _e('by','klasik'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php the_author();?></a>
                                        </div> 
                                        <span class="text-sep text-sep-user">/</span>
										<?php 
                                            $css_class = 'zero-comments';
                                            $number    = (int) get_comments_number( get_the_ID() );
                                            
                                            if ( 1 === $number )
                                                $css_class = 'one-comment';
                                            elseif ( 1 < $number )
                                                $css_class = 'multiple-comments';
                                        ?>
                                         
                                         <div class="comment <?php echo $css_class; ?>">
                                             <?php 
                                            
                                                comments_popup_link( 
                                                    __( 'No Comments', 'klasik' ), 
                                                    __( '1 Comment', 'klasik' ), 
                                                    __( '% Comments', 'klasik' ),
                                                    $css_class,
                                                    __( 'Comments Closed', 'klasik' )
                                                );
                                             ?>
                                        </div>
                                            
                                        <span class="text-sep <?php echo $css_class; ?> text-sep-category">/</span>
                                        <div class="category"><?php _e('in','klasik'); ?> <?php the_category(', '); ?></div>  
                                            
                                        <div class="clear"></div>  
                                    </div>  
                                <?php 
								}
								?>
                                
                                </div>
                                
								<?php
                                    $args = array(
											'wrap_before' => '<div id="breadcrumbs" class="is-Right">',
                                            'delimiter' => ' / ',
											'wrap_after' => '</div>'
                                    );
									if(function_exists('is_woocommerce') && is_woocommerce()){
										woocommerce_breadcrumb( $args ); 
									}elseif ( function_exists('yoast_breadcrumb') && !is_front_page() ) {
										yoast_breadcrumb('<div id="breadcrumbs" class="is-Right">','</div>');
									} 
								?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
		}
		?>
        <!-- END AFTERHEADER -->

        <?php get_template_part('layout-header'); ?>
							