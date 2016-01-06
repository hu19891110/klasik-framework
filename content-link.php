<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="articlecontainer">
            <div class="entry-content">
                <div class="entry-links">
                <?php
                    $content = preg_match_all( '/href\s*=\s*[\"\']([^\"\']+)/', get_the_content(), $links );
                    $link = $links[1][0];

					if($link==""){
						$link = get_the_permalink();
					}
                ?>
                    <h2 class="posttitle"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h2>
                    <div><?php echo $link; ?></div>
                </div>
            </div><!-- .entry-content -->
            <div class="clear"></div>
        </div>
	</article><!-- #post -->
