<?php
/**
 * Loads up all the widgets defined by this theme. Note that this function will not work for versions of WordPress 2.7 or lower
 *
 */


$path_quickwidget = get_template_directory() . '/includes/widgets/nl-quick-widget.php';
if(file_exists($path_quickwidget)) include_once ($path_quickwidget);

$path_featureswidget = get_template_directory() . '/includes/widgets/klasik-features-widget.php';
if(file_exists($path_featureswidget)) include_once ($path_featureswidget);

$path_latestnwwidget = get_template_directory() . '/includes/widgets/klasik-latestnews-widget.php';
if(file_exists($path_latestnwwidget)) include_once ($path_latestnwwidget);

$path_testiwidget = get_template_directory() . '/includes/widgets/klasik-testimonial-widget.php';
if(file_exists($path_testiwidget)) include_once ($path_testiwidget);

$path_teamwidget = get_template_directory() . '/includes/widgets/klasik-team-widget.php';
if(file_exists($path_teamwidget)) include_once ($path_teamwidget);

$path_actionwidget = get_template_directory() . '/includes/widgets/klasik-action-widget.php';
if(file_exists($path_actionwidget)) include_once ($path_actionwidget);

$path_textwidget = get_template_directory() . '/includes/widgets/klasik-text-widget.php';
if(file_exists($path_textwidget)) include_once ($path_textwidget);

$path_imgcarouselwidget = get_template_directory() . '/includes/widgets/klasik-imagecarousel-widget.php';
if(file_exists($path_imgcarouselwidget)) include_once ($path_imgcarouselwidget);

if( function_exists('is_woocommerce')){
	$path_woofpwidget = get_template_directory() . '/includes/widgets/klasik-product-widget.php';
	if(file_exists($path_woofpwidget)) include_once ($path_woofpwidget);
}

/* new */
$path_portfoliowidget = get_template_directory() . '/includes/widgets/klasik-portfolio-widget.php';
if(file_exists($path_portfoliowidget)) include_once ($path_portfoliowidget);



add_action("widgets_init", "klasik_theme_widgets");

function klasik_theme_widgets() {
	register_widget("Klasik_PortfolioWidget");
	register_widget("Klasik_FeaturesWidget");
	register_widget("Klasik_TestimonialWidget");
	register_widget("Klasik_TeamWidget");
	register_widget("Klasik_PCarouselWidget");
	register_widget("Klasik_CallToActionWidget");
	register_widget("Klasik_TextWidget");
	register_widget("Klasik_LatestNewsWidget");


	if( function_exists('is_woocommerce')){
		register_widget("Klasik_WooProductWidget");
	}
}