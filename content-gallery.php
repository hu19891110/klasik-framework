<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="articlecontainer">
            <div class="entry-gallery">
				<?php
				$custom = get_post_custom($post->ID);
				$cf_disablemeta = klasik_get_metabox('klasik_disable_meta');
				//get post-thumbnail attachment
				$attachments = get_children( array(
					'post_parent' => get_the_ID(),
					'post_type' => 'attachment',
					'orderby' => 'menu_order',
					'post_mime_type' => 'image')
				);
				 $thethumblb = '';
				 foreach ( $attachments as $att_id => $attachment ) {
					$getimage = wp_get_attachment_image_src($att_id, 'full', true);
					$thumbimage  = $getimage[0];
					$thumbwidth  = $getimage[1];
					$thumbheight = $getimage[2];
					$cf_thumb2 ='<img src="'.$thumbimage.'" width="'. $thumbwidth .'" height="'. $thumbheight .'" alt="" />';
					$thethumblb .= '<li>'.$cf_thumb2.'</li>';
				 }
				 
				 if($thethumblb!=''){
				 	$thethumblb = '<div class="postimg">
										<div id="postgallery-'.get_the_ID().'" class="flexslider">
											<ul class="slides">'. $thethumblb .'</ul>
											<div class="arrow"></div>
											<div class="clear"></div>  
										</div>
									</div>';
				 }
				?>
	
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
                <?php }else{ ?>
				    <div class="entry-space"></div>
				 <?php } ?>  
                
                <?php echo $thethumblb; ?>
                
                <div class="entry-content">
                    <?php the_excerpt(); ?>
					<?php if(!is_single()){?>
							<a href="<?php the_permalink(); ?>" class="more"><?php _e('Read More','klasik'); ?></a>
					 <?php }?>
                </div>
               
                                
            </div>
            <div class="clear"></div>
        </div>
			<script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#postgallery-<?php the_ID(); ?>').flexslider({
                    animation: "fade",
                    touch:true,
                    animationDuration: 6000,
                    directionNav: true,
					smoothHeight: true,
                    controlNav: true
                });
                
            });
            </script>
        
		<div class="clear"></div>
	</article><!-- end post -->
    
    
