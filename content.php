<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
 

$custom = get_post_custom($post->ID);
$cf_disablemeta = klasik_get_metabox('klasik_disable_meta');

?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="articlecontainer">

            <h2 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'klasik' ), the_title_attribute( 'echo=0' ) ); ?>" data-rel="bookmark"><?php the_title(); ?></a></h2>
				
			<?php  if(!$cf_disablemeta){ ?>
                <div class="entry-utility">
                    <div class="date"> <?php the_time(get_option('date_format')); ?></div>  <span class="text-sep text-sep-date">/</span>
                    <div class="user"><?php _e('by','klasik'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php the_author();?></a></div> <span class="text-sep text-sep-user">/</span>
                    <div class="category"><?php _e('in','klasik'); ?> <?php the_category(', '); ?></div>  
						<?php 
                            $css_class = 'zero-comments';
                            $number    = (int) get_comments_number( get_the_ID() );
                            
                            if ( 1 === $number )
                                $css_class = 'one-comment';
                            elseif ( 1 < $number )
                                $css_class = 'multiple-comments';
                        ?>
                         <span class="text-sep <?php echo $css_class; ?> text-sep-category">/</span>
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
                    <div class="clear"></div>  
                </div>  
			 <?php } ?>
				 
            <div class="entry-content">
				<?php 
                	the_content(''); 
                ?>
                
                <?php
                if(is_single() && !$cf_disablemeta){ 
                    wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'klasik' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    ) );
                }
                ?>
                
                <?php if(!is_single()){?>
                <a href="<?php the_permalink(); ?>" class="more"><?php _e('Read More','klasik'); ?></a>
                <?php }?>
            </div>
            

        
            <div class="clear"></div>
        </div>
	</article><!-- end post -->
    
    
