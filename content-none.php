<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

	<article id="post-0" class="post no-results not-found">
    	<div class="articlecontainer">
            <header class="entry-header">
                <h1 class="entry-title"><?php _e( 'Nothing Found', 'klasik' ); ?></h1>
            </header>
    
            <div class="entry-content">
                <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'klasik' ); ?></p>
                <?php get_search_form(); ?>
            </div><!-- .entry-content -->
            <div class="clear"></div>
        </div>
	</article><!-- #post-0 -->
