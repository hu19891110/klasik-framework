<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>
	<article id="post-<?php the_ID(); ?>"  <?php post_class(); ?>>
    	<div class="articlecontainer">
            <div class="entry-video">
                <?php
                $custom = get_post_custom($post->ID);
				$cf_disablemeta = klasik_get_metabox('klasik_disable_meta');
				
                $pregvid = preg_match_all('/(\<video.*\<\/video\>)/is', get_the_content(), $videos);
                $pregobj = preg_match_all('/(\<object.*\<\/object\>)/is', get_the_content(), $objects);
                $pregemb = preg_match_all('/(\[embed.*\[\/embed\])/is', get_the_content(), $embeds);
                $pregifr = preg_match_all('/(\<iframe.*\<\/iframe\>)/is', get_the_content(), $iframes);
				$pregvsh = preg_match_all('/(\[video.*\[\/video\])/is', get_the_content(), $vshorts);
                $video = isset($videos[1][0])? $videos[1][0] : "";
				$object = isset($objects[1][0])? $objects[1][0] : "";
				$embed = isset($embeds[1][0])? $embeds[1][0] : "";
				$iframe = isset($iframes[1][0])? $iframes[1][0]: "";
				$vshort = isset($vshorts[1][0])? $vshorts[1][0]: "";
                $media = "";
                
                if(!empty($vshort)){
					$media = $vshort;
				}elseif(!empty($video)){
                    $media = $video;
                }elseif(!empty($object)){
                    $media = $object;
                }elseif(!empty($embed)){
					global $wp_embed;
                    $media = $wp_embed->run_shortcode($embed);
                }elseif(!empty($iframe)){
                    $media = $iframe;
                }
                //echo $media;
				
				//echo $wp_embed->run_shortcode($media);
				$mediahtml = '';
                if(!empty($media)){
                    $mediahtml = '<div class="mediacontainer">'.$media.'</div>';
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
				
                <?php echo $mediahtml; ?>
                
                <div class="entry-content">
                    <?php the_excerpt(); ?>
					<?php if(!is_single()){?>
						<a href="<?php the_permalink(); ?>" class="more"><?php _e('Read More','klasik'); ?></a>
					<?php }?>
                </div>
                

                            
            </div>
            <div class="clear"></div>
        </div>
		<div class="clear"></div>
	</article><!-- end post -->
    
    
