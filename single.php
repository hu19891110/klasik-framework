<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */

get_header(); ?>
            
    <div id="singlepost">
    	
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		

		
       <div class="single-article-wrapper">

            <?php
            $custom = get_post_custom($post->ID);
            $cf_disablemeta = klasik_get_metabox('klasik_disable_meta');

            if(!$cf_disablemeta){
                $hasmetaclass = 'hasmeta';
            }else{
                $hasmetaclass = 'nometa';
            }
			
			if(get_post_format()=='quote'||get_post_format()=='link'||get_post_format()=='aside'){
				$cf_disablemeta=1;
				
			}
			
			
            ?>
			
		<?php get_template_part( 'content', get_post_format() );?>
		
		
             <?php if(!$cf_disablemeta){?>
				<?php
                $posttags = get_the_tags();
                if($posttags){
                ?>
                <div class="entry-tag">
                    <span class="tag-text"><?php _e('Tags :','klasik'); ?></span>
                    <?php the_tags('<div class="tag-items"><span>','</span><span>','</span></div>');  ?>
                </div>
                <?php } ?>
             <?php } ?>
          </div><!-- single-article-wrapper --> 
          
             <?php if(!$cf_disablemeta){?>
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav"></span> Previous', 'klasik' ), TRUE ); ?></div>
                    <div class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav"></span>', 'klasik' ), TRUE ); ?></div>
                    <div class="clear"></div><!-- clear float --> 
                </div><!-- #nav-below -->
                
             <?php } ?>
         
         
        <?php

        // If a user has filled out their description, show a bio on their entries.
        if ( get_the_author_meta( 'description' ) && !$cf_disablemeta ) : ?>
        <div id="entry-author-info">
        	<h2 class="author-title"><?php _e('About Author','klasik'); ?></h2>
            <div class="clear"></div>
            <div id="author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'klasik_author_bio_avatar_size', 100 ) ); ?>
            </div><!-- author-avatar -->
            
            <div id="author-description">
                <h2><span class="author"><?php printf( __( 'About %s', 'klasik' ), get_the_author() ); ?></span></h2>
                <?php the_author_meta( 'description' ); ?>
            </div><!-- author-description	-->
            <div class="clear"></div><!-- clear float --> 
        </div><!-- entry-author-info -->
        <?php endif; ?>
		
		<?php if(!$cf_disablemeta){?>
        <?php comments_template( '', true ); ?>
        <?php }?>
        <?php endwhile; ?>
    
    </div><!-- singlepost --> 

    <div class="clear"></div><!-- clear float --> 

<?php get_footer(); ?>