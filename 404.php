<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */

get_header(); ?>

    <p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'klasik' ); ?></p>
    <?php get_template_part('searchform'); ?>
    
    <div class="clear"></div><!-- clear float --> 
                
<?php get_footer(); ?>