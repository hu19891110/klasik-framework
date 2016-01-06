/**
 * Prints out the inline javascript needed fot Theme Options
 * 
 */

jQuery(document).ready(function($) {
	
	// Fade out the save message
	$('.fade').delay(1000).fadeOut(1000);

	// Custom CSS
	
	$("#section-klasik_customcss a").prettyPhoto({
		animationSpeed:'slow',
		theme:'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
		gallery_markup:'',
		social_tools: false,
		slideshow:2000
	});
		 		
});	