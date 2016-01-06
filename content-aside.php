<?php
/**
 * The template for displaying posts in the Aside post format
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="articlecontainer">
            <div class="entry-content">
                <div class="aside">
                    <?php the_content(); ?>
                </div><!-- .aside -->
            </div><!-- .entry-content -->
            <div class="clear"></div>
        </div>
	</article><!-- #post -->
