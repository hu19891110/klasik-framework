(function () {
 "use strict";
jQuery(document).ready(function(){
	
	//=================================== FADE EFFECT ===================================//
	jQuery('.klasik-pfnew-img').hover(
		function() {
			jQuery(this).find('.rollover').stop().fadeTo(500, 0.6);
		},
		function() {
			jQuery(this).find('.rollover').stop().fadeTo(500, 0);
		}
	
	);
	
	jQuery('.klasik-pfnew-img').hover(
		function() {
			jQuery(this).find('.zoom').stop().fadeTo(500, 1);
		},
		function() {
			jQuery(this).find('.zoom').stop().fadeTo(500, 0);
		}
	);

});

jQuery(window).load(function() {
	runflexsliderHome();
	runflexslider();
});

//===================== For Slider Home FLEXSLIDER =====================//
function runflexsliderHome(){
	jQuery('#slideritems').flexslider({
		animation: "fade",
		touch:true,
		animationDuration: 6000,
		directionNav: false,
		smoothHeight: true,
		controlNav: true
	});
}

//=================================== FLEXSLIDER ===================================//
function runflexslider(){
	jQuery('.flexslider').flexslider({
		animation: "fade",
		touch:true,
		animationDuration: 6000,
		directionNav: false,
		smoothHeight: true,
		controlNav: true
	});
}


})(jQuery);