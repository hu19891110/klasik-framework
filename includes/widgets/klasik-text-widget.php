<?php
// =============================== Klasik text in Widget ======================================
class Klasik_TextWidget extends WP_Widget {
    /** constructor */

	function Klasik_TextWidget() {
		$widget_ops = array('classname' => 'widget_klasik_text', 'description' => __('Klasik Text','klasik') );
		parent::__construct('klasik-text-widget', __('Klasik Text','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) 
    {	
        extract( $args );
        $title 			= isset($instance['title']) ? $instance['title'] : false;
		$text 			= isset($instance['text']) ? $instance['text'] : false;
        $wpautop		= isset($instance['wpautop']) ? $instance['wpautop'] : false;
		$customclass 	= empty($instance['customclass']) ? '' : $instance['customclass'];

        
        if ( $customclass ) {
            $before_widget = str_replace('class="', 'class="'. $customclass . ' ', $before_widget);
        }        
       
        ?>
          <?php echo $before_widget; 
		  

	
					 
					 echo '
					    <div class="all-widget-wrapper">
                		<div class="container">
                    	<div class="row">
                        <div class="twelve columns">
					 ';
					 
					 echo '<div class="klasik-text-widget-wrapper">';
					 
					 
					$titleline='<span class="line-wrap-title"><span class="line-title"></span></span>';
					
					
					if ( $title!='' )
					echo $before_title . esc_html($title). $titleline . $after_title;

			  
			  ?>
				<div class="text-block ">
				<?php 
			
					// To run shortcode 
					$text = do_shortcode($text);
					
					// Echo the content
					if($wpautop == "on") { $text = wpautop($text); }
					echo $text;
				 ?>
                 </div>
          	<?php 
					echo '<div class="clear"></div></div>';

					echo '                        
					</div>
					</div>
					</div>
					<div class="clear"></div></div>';
					
		  			echo $after_widget; 
			?>
        <?php
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
		
		
    	return $instance;
		
    }
	
	

    /** @see WP_Widget::form */
    function form($instance) {
		$title 			= isset($instance['title']) ? esc_attr($instance['title']) : "";

		$text 			= isset($instance['text']) ? esc_attr($instance['text']) : "";
		$wpautop 		= isset($instance['wpautop']) ? esc_attr($instance['wpautop']) : "";
		$customclass 	= isset($instance['customclass']) ? esc_attr($instance['customclass']) : "";

		
        ?>
        
        
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			          
            <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'klasik'); ?><textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="10"><?php echo $text; ?></textarea>			</label></p>
            <p>
                <input id="<?php echo $this->get_field_id('wpautop'); ?>" name="<?php echo $this->get_field_name('wpautop'); ?>" type="checkbox"<?php if($wpautop == "on") echo " checked='checked'"; ?>>&nbsp;
                <label for="<?php echo $this->get_field_id('wpautop'); ?>">Automatically add paragraphs</label>
            </p>

            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> 
            <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>


            

        <?php
    }


} // class  Widget