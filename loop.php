<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>
	
<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<article id="post-0" class="post error404 not-found">
		<h1 class="posttitle"><?php _e( 'Not Found', 'klasik' ); ?></h1>
		<div class="entry">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'klasik' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</article>
<?php endif; ?>


<?php while ( have_posts() ) : the_post(); ?>

	<?php /* How to display all posts. */ 
	get_template_part( 'content', get_post_format() ); 
	?>
	
	<?php comments_template( '', true ); ?>

<?php endwhile; // End the loop. Whew. ?>


<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
 <?php if(function_exists('wp_pagenavi')) { ?>
	 <?php wp_pagenavi(); ?>
 <?php }else{ ?>
	<div id="nav-below" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous', 'klasik' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'klasik' ) ); ?></div>
        <div class="clear"></div>
	</div><!-- #nav-below -->
<?php }?>
<?php endif; ?>
