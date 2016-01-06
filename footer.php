<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
 
?>
			
		<?php get_template_part('layout-footer'); ?>
        


    	<?php if(is_active_sidebar('footer1') || is_active_sidebar('footer2') || is_active_sidebar('footer3') || is_active_sidebar('footer4')){ ?>
        <!-- FOOTER SIDEBAR -->
        <div id="outerfootersidebar">
        	<div id="footersidebarcontainer">
                <div class="container">
                    <div class="row"> 
                    
                        <footer id="footersidebar">
                            <div id="footcol1"  class="three columns">
                                <div class="widget-area">
                                    <?php 
									if ( ! dynamic_sidebar( 'footer1' ) ){

									}// end general widget area 
									?>
                                </div>
                            </div>
                            <div id="footcol2"  class="three columns">
                                 <div class="widget-area">
                                 	<?php 
									if ( ! dynamic_sidebar( 'footer2' ) ){
			
									}// end general widget area 
									?>
                                </div>
                            </div>
                            <div id="footcol3"  class="three columns">
                                 <div class="widget-area">
                                 	<?php 
									if ( ! dynamic_sidebar( 'footer3' ) ){

									}// end general widget area 
									?>
                                </div>
                            </div>
                            <div id="footcol4"  class="three columns">
                                 <div class="widget-area">
                                 	<?php 
									if ( ! dynamic_sidebar( 'footer4' ) ){
						
									}// end general widget area 
									?>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </footer>
    
                    </div>
                </div>
            </div>
        </div>
        <!-- END FOOTER SIDEBAR -->
        <?php } ?>
        
        <!-- FOOTER -->
        <div id="outerfooter">
        	<div id="footercontainer">
                <div class="container">
                    <div class="row">

                        <div class="twelve columns">
                            <footer id="footer">
								<div class="copyrighttext">
									<?php klasik_copyright_text(); ?>
                                
                                </div>
                                <div class="footertext">
									<?php klasik_footer_text(); ?>
                                </div>
                            </footer>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        <!-- END FOOTER -->
        
	</div><!-- end outercontainer -->
</div><!-- end bodychild -->


<?php get_template_part('site-footer'); ?>
