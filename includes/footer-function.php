<?php
// get website title
if(!function_exists("klasik_footer_text")){
	function klasik_footer_text(){
	
		$foot= stripslashes(klasik_get_option( 'klasik_footer'));
		if($foot!=""){
        	echo $foot;
        }
		
	}// end klasik_footer_text()
}

// Copyright
if(!function_exists("klasik_copyright_text")){
	function klasik_copyright_text(){

			_e('Copyright', 'klasik'); echo ' &copy; ';
			
				echo date('Y') . ' <a href="'.home_url( '/').'">'.get_bloginfo('name') .'</a>.';
			?>
			<?php _e(' Designed by', 'klasik'); ?>	<a href="<?php echo esc_url( __( 'http://www.klasikthemes.com', 'klasik' ) ); ?>" title=""><?php _e('Klasik Themes','')?></a>.
            
        <?php 
		
	}// end klasik_copyright_text()
}


if(!function_exists("klasik_print_js_menu")){
	
	function klasik_print_js_menu(){
	?>
	<script type="text/javascript">
	//Add Class Js to html
	jQuery('html').addClass('js');	
	
	//=================================== MENU ===================================//
	jQuery("ul.sf-menu").superfish({
					//add options here if required
				});
	
	//=================================== MOBILE MENU DROPDOWN ===================================//
	jQuery('#topnav').tinyNav({
		active: 'current-menu-item'
	});	
	
	
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_menu",1);
}


if(!function_exists("klasik_print_js_prettyphoto")){
	
	function klasik_print_js_prettyphoto(){
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		runprettyPhoto();
	});
	
	function runprettyPhoto(){
		//=================================== PRETTYPHOTO ===================================//
		jQuery('a[data-rel]').each(function() {jQuery(this).attr('rel', jQuery(this).data('rel'));});
		jQuery("a[rel^='prettyPhoto']").prettyPhoto({
			animationSpeed:'slow',
			theme:'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			gallery_markup:'',
			social_tools: false,
			slideshow:2000
		});
	}
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_prettyphoto",2);
}


if(!function_exists("klasik_print_js_fixed_menu")){
	
	function klasik_print_js_fixed_menu(){
	?>
	<script type="text/javascript">
	
		<?php 
			if(file_exists( get_stylesheet_directory() . '/fixedmenu.css')){
			$enablefixedmenu = klasik_get_option( 'klasik_enable_fixed_menu' ,'');
			if($enablefixedmenu ){
		?>
		// Sticky menu
		jQuery(document).ready(function() {
			var stickyNavTop = jQuery('.fixedmenu').offset().top;
			
			var stickyNav = function(){
			var scrollTop = jQuery(window).scrollTop();
				 
			if (scrollTop > stickyNavTop) { 
				jQuery('.fixedmenu').addClass('sticky');
			} else {
				jQuery('.fixedmenu').removeClass('sticky'); 
			}
			};
			
			stickyNav();
			
			jQuery(window).scroll(function() {
				stickyNav();
			});
		});
		<?php }
			}
		?>
		
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_fixed_menu",3);
}


if(!function_exists("klasik_foot")){
	function klasik_foot(){
		do_action("klasik_foot");
	}
}
add_action("wp_footer","klasik_foot",20);

?>
