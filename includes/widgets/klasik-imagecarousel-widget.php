<?php

// =============================== Klasik Image Carousel widget ======================================
class Klasik_PCarouselWidget extends WP_Widget {
    /** constructor */

	function Klasik_PCarouselWidget() {
		$widget_ops = array('classname' => 'widget_klasik_pcarousel', 'description' => __('Klasik Image Carousel','klasik') );
		parent::__construct('klasik-pcarousel-widget', __('Klasik Image Carousel','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title 			= apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$mediaid 		= apply_filters('widget_mediaid', empty($instance['mediaid']) ? '' : $instance['mediaid']);
		$imagecols 		= apply_filters('widget_imagecols', empty($instance['imagecols']) ? '' : $instance['imagecols']);
		$customclass 	= apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
				
		$text 					= isset($instance['text']) ? $instance['text'] : false;
        $wpautop				= isset($instance['wpautop']) ? $instance['wpautop'] : false;
		
		
        if ( $customclass ) {
            $before_widget = str_replace('class="', 'class="'. $customclass . ' ', $before_widget);
        }  
		
		
		global $wp_query;

		  echo $before_widget; 
		  

					 echo '
					    <div class="all-widget-wrapper">
                		<div class="container">
                    	<div class="row">
                        <div class="twelve columns">
					 ';
					 
					 echo '<div class="klasik-carousel-widget-wrapper">';

					$titleline='<span class="line-wrap-title"><span class="line-title"></span></span>';


					
					if ( $title!='' )
					echo $before_title . esc_html($title). $titleline . $after_title;

						if($imagecols==1){
							$colclass = "1";
							$minitems = "0";
							$itemwidth = "250";
						}elseif($imagecols==2){
							$colclass = "2";
							$minitems = "2";
							$itemwidth = "250";
						}elseif($imagecols==3){
							$colclass = "3";
							$minitems = "2";
							$itemwidth = "250";
						}elseif($imagecols==4){	
							$colclass = "4";
							$minitems = "2";
							$itemwidth = "250";
						}elseif($imagecols==5){
							$colclass = "5";
							$minitems = "2";
							$itemwidth = "240";
						}elseif($imagecols==6){
							$colclass = "6";
							$minitems = "2";
							$itemwidth = "150";
						}else{
							$colclass = "6";
							$minitems = "3";
							$itemwidth = "150";
						}
						
	
					
				$cf_imagecarousel = $mediaid;
				
				
				if($cf_imagecarousel!=""){
					$include = $cf_imagecarousel;
					$arrinclude = explode(',',$cf_imagecarousel);
					$orderby = 'post__in';
					$order = 'ASC';
					$unikid = str_replace(array('.', ',',' '),'',$cf_imagecarousel);
				
					$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
		
					$attachments = array();
					foreach ($_attachments as $key => $val) {
					  $attachments[$val->ID] = $_attachments[$key];
					}
					
					$tpl = '<li>%%IMAGE%%</li>';
					$tpl = apply_filters( 'klasik_pcarousel_item_template', $tpl );

					// Echo the text
					if($text){
						if($wpautop == "on") { $text = wpautop($text); }
						echo '<div class="imgcarausel-text">'.$text.'</div>';
					}
					
					if(count($attachments)){
				?>



					<div class="klasik-pcarousel flexslider-carousel car-flex-<?php echo $this->get_field_id('klasik-pcarousel-widget').$unikid;?> <?php echo 'col'.$imagecols?> row">
                    <ul class="slides">
					<?php
                    
                     foreach ($attachments as $id => $attachment) {
                     	
						$template = $tpl;
						
                        $cf_thumb = wp_get_attachment_image($id, 'widget-carousel', false, false);
                        $image_attributes = wp_get_attachment_image_src($id, 'full', false);// returns an array
						
						$alttext = get_post_meta( $attachment->ID , '_wp_attachment_image_alt', true);
						$image_title = $attachment->post_title;
						$caption = $attachment->post_excerpt;
						$description = $attachment->post_content;
						
						//IMAGEID
						$template = str_replace( '%%ID%%', $attachment->ID, $template );
						
						//IMAGESRC
						$carothumb = '';
						if($cf_thumb){
						$carothumb .= '<div class="image">'.$cf_thumb.'</div>';
						}
						$template = str_replace( '%%IMAGE%%', $carothumb, $template );
						
						//IMAGETITLE
						$template = str_replace( '%%TITLE%%', $image_title, $template );
						
						//IMAGEALT
						$template = str_replace( '%%ALT%%', $alttext, $template );
						
						//IMAGECAPTION
						$template = str_replace( '%%CAPTION%%', $caption, $template );
						
						//IMAGEDESC
						$template = str_replace( '%%DESC%%', $description, $template );
						
						//PORTFOLIOFULLIMAGE
						$pffullimg = (isset($image_attributes[0]))? $image_attributes[0] : '';
						$template = str_replace( '%%FULLIMG%%', $pffullimg, $template );
						
						echo $template;

                     }
                    ?>
                    </ul>
                    </div>
                    
					<script type="text/javascript">
                    jQuery(document).ready(function(){
                        //Add Class Js to html
                        jQuery('.car-flex-<?php echo $this->get_field_id('klasik-pcarousel-widget').$unikid;?>').flexslider({
                            animation: "slide",
                            touch:true,
                            animationLoop: false,
							//smoothHeight: true,
                            controlNav: false,
                            itemWidth: <?php echo $itemwidth;?>,
							minItems: <?php echo $minitems; ?>,
                            itemMargin: 0,
                            maxItems: <?php echo $colclass; ?>
                        });
                    });
                    </script>
                    
				<?php
					}
				}


					echo '<div class="clear"></div></div>';

					echo '                        
					</div>
					</div>
					</div>
					<div class="clear"></div></div>';
	
					
		  echo $after_widget;

    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				

        $instance = $old_instance;
		
    	$instance['title'] 					= strip_tags($new_instance['title']);
		
        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
        $instance['text'] = wp_filter_post_kses($new_instance['text']);
		$instance['wpautop'] 				= strip_tags($new_instance['wpautop']);
		
		$instance['customclass'] 			= strip_tags($new_instance['customclass']);
		$instance['mediaid']				= strip_tags($new_instance['mediaid']);
		$instance['imagecols'] 				= strip_tags($new_instance['imagecols']);
				
    	return $instance;

    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] 					= (isset($instance['title']))? $instance['title'] : "";
		$instance['mediaid'] 				= (isset($instance['mediaid']))? $instance['mediaid'] : "";
		$instance['imagecols'] 				= (isset($instance['imagecols']))? $instance['imagecols'] : "";
		$instance['customclass'] 			= (isset($instance['customclass']))? $instance['customclass'] : "";

		$text 			= isset($instance['text']) ? esc_attr($instance['text']) : "";
		$wpautop 		= isset($instance['wpautop']) ? esc_attr($instance['wpautop']) : "";
					
        $title 			= esc_attr($instance['title']);
		$mediaid 		= esc_attr($instance['mediaid']);
		$imagecols 		= esc_attr($instance['imagecols']);
		$customclass 	= esc_attr($instance['customclass']);
		
		
		
        ?>
        
        
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'klasik'); ?><textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="3"><?php echo $text; ?></textarea>			</label></p>
            <p>
                <input id="<?php echo $this->get_field_id('wpautop'); ?>" name="<?php echo $this->get_field_name('wpautop'); ?>" type="checkbox"<?php if($wpautop == "on") echo " checked='checked'"; ?>>&nbsp;
                <label for="<?php echo $this->get_field_id('wpautop'); ?>">Automatically add paragraphs</label>
            </p>
            <p><label for="<?php echo $this->get_field_id('mediaid'); ?>"><?php _e('Media IDs:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('mediaid'); ?>" name="<?php echo $this->get_field_name('mediaid'); ?>" type="text" value="<?php echo $mediaid; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('imagecols'); ?>"><?php _e('Images Columns:', 'klasik'); ?></label><br />
            <select id="<?php echo $this->get_field_id('imagecols'); ?>" name="<?php echo $this->get_field_name('imagecols'); ?>" class="widefat" style="width:50%;">
				<?php foreach($this->get_image_number_options() as $k => $v ) { ?>
                    <option <?php selected( $instance['imagecols'], $k); ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php } ?>      
            </select></p>
            
            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> 
            <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>



        <?php
    }


	protected function get_image_number_options () {
		return array(
					'default' 		=> __( 'Default', 'klasik' ),
					'1' 			=> __( '1 Column', 'klasik' ),		
					'2' 			=> __( '2 Column', 'klasik' ),
					'3' 			=> __( '3 Column', 'klasik' ),
					'4' 			=> __( '4 Column', 'klasik' ),
					'5' 			=> __( '5 Column', 'klasik' ),
					'6' 			=> __( '6 Column', 'klasik' )
					);
	} // End get_image_number_options()

} // class  Widget