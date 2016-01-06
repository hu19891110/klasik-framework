<?php
/**
 * The template for displaying search forms in Innova
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<div class="searcharea">
    <input type="text" name="s" id="s" value="<?php _e('Enter the keyword...','klasik');?>" onfocus="if (this.value == '<?php _e('Enter the keyword...','klasik');?>')this.value = '';" onblur="if (this.value == '')this.value = '<?php _e('Enter the keyword...','klasik');?>';" />
    <input type="submit" class="searchbutton" value="" />
</div>
</form>