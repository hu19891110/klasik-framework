<?php
// =============================== Klasik Call To Action widget ======================================
class Klasik_CallToActionWidget extends WP_Widget {
    /** constructor */

	function Klasik_CallToActionWidget() {
		$widget_ops = array('classname' => 'widget_klasik_action', 'description' => __('Klasik CallToAction','klasik') );
		parent::__construct('klasik-action-widget', __('Klasik CallToAction','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title 			= apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		
		$buttext1 			= apply_filters('widget_buttext1', empty($instance['buttext1']) ? '' : $instance['buttext1']);
		$buturl1 			= apply_filters('widget_buturl1', empty($instance['buturl1']) ? '' : $instance['buturl1']);
		$text 				= apply_filters('widget_text', empty($instance['text']) ? '' : $instance['text']);
		$buttext2 			= apply_filters('widget_buttext2', empty($instance['buttext2']) ? '' : $instance['buttext2']);
		$buturl2 			= apply_filters('widget_buturl2', empty($instance['buturl2']) ? '' : $instance['buturl2']);
		$customclass 		= apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
		$linkbut 		= isset($instance['linkbut']) ? $instance['linkbut'] : false;
		$wpautop		= isset($instance['wpautop']) ? $instance['wpautop'] : false;
				
		$disabletext = false;
		
        if ( $customclass ) {
            $before_widget = str_replace('class="', 'class="'. $customclass . ' ', $before_widget);
        }  

        			 echo $before_widget; 
					 
					 echo '
					    <div class="all-widget-wrapper">
                		<div class="container">
                    	<div class="row">
                        <div class="twelve columns">
					 ';
					 
					 echo '<div class="klasik-action-widget-wrapper" >';
						
					$output = "";

					$output .='<div class="klasik-action-widget">';

						
							$tpl = '<div class="item-container">';
								$tpl .= '<div class="action-text">%%TITLE%% %%TEXT%%</div>';
								$tpl .= '<div class="action-button">%%BUTTON1%% %%BUTTON2%%</div>';
								$tpl .= '<div class="clear"></div>';
							$tpl .= '</div>';
							
							
							$tpl = apply_filters( 'klasik_actions_item_template', $tpl );
							

								
								$template = $tpl;
								
								
								//TITLE
								$maintitle  = '';
								if($title){
								$maintitle .= '<h1>'.$title.'</h1>';
								}
								$template = str_replace( '%%TITLE%%', $maintitle, $template );

								
								// MAINTEXT
								$maintext = '';
								if($text){
								if($wpautop == "on") { $text = wpautop($text); }
								$maintext .= '<div class="text">'.$text.'</div>';
								}
								$template = str_replace( '%%TEXT%%', $maintext, $template );
								
								//POST-DAY
								$postday  = '';
								$postday .= get_the_time( 'd' );
								$template   = str_replace( '%%DAY%%', $postday, $template );
								
								//POST-MONTH
								$postmonth  = '';
								$postmonth .= get_the_time('M');
								$template   = str_replace( '%%MONTH%', $postmonth, $template );
								
								//POST-YEAR
								$postyear  = '';
								$postyear .= get_the_time('Y');
								$template   = str_replace( '%%YEAR%', $postyear, $template );
									
								
								// BUTTON1
								$mainbuttext1 = '';
								if($linkbut){
									$external = 'target="_blank"';
								}else{
									$external = '';
								}
								if($buttext1){
									$mainbuttext1 .= '<a href="' . $buturl1 . '" title="' . $buttext1 . '" ' . $external . ' class="button left">' . $buttext1 . '</a>';
								}
								$template = str_replace( '%%BUTTON1%%', $mainbuttext1, $template );
								

								// BUTTON2 
								$mainbuttext2 = '';
								if($linkbut){
									$external = 'target="_blank"';
								}else{
									$external = '';
								}
								if($buttext2){
									$mainbuttext2 .= '<a href="' . $buturl2 . '" title="' . $buttext2 . '" ' . $external . ' class="button right">' . $buttext2 . '</a>';	
								}
								$template = str_replace( '%%BUTTON2%%', $mainbuttext2, $template );
								

								$output .= $template;
								

						$output.='<div class="clear"></div>';
					$output .='</div>';
						 
					echo do_shortcode($output);
					
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
		$instance['buttext1'] 				= strip_tags($new_instance['buttext1']);
		$instance['buturl1'] 				= esc_url($new_instance['buturl1']);
		$instance['buttext2'] 				= strip_tags($new_instance['buttext2']);
		$instance['buturl2'] 				= esc_url($new_instance['buturl2']);
		$instance['customclass'] 			= strip_tags($new_instance['customclass']);
		$instance['linkbut'] 				= strip_tags($new_instance['linkbut']);
				
    	return $instance;
		
    }

    /** @see WP_Widget::form */
    function form($instance) {			
        $title = isset($instance['title']) ? esc_attr($instance['title']) : "";

		$buttext1 = isset($instance['buttext1']) ? esc_attr($instance['buttext1']) : "";
		$buturl1 = isset($instance['buturl1']) ? esc_attr($instance['buturl1']) : "";
		$buttext2 = isset($instance['buttext2']) ? esc_attr($instance['buttext2']) : "";
		$buturl2 = isset($instance['buturl2']) ? esc_attr($instance['buturl2']) : "";
		$customclass = isset($instance['customclass']) ? esc_attr($instance['customclass']) : "";
		
		$instance['linkbut'] = (isset($instance['linkbut']))? $instance['linkbut'] : "";
		
		$text 		= isset($instance['text']) ? esc_attr($instance['text']) : "";
		$wpautop 	= isset($instance['wpautop']) ? esc_attr($instance['wpautop']) : "";
		$linkbut 	= isset($instance['linkbut']) ? esc_attr($instance['linkbut']) : "";
				
		
        ?>
        
          

        
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			            
            <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'klasik'); ?> <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="10"><?php echo $text; ?></textarea>	</label></p>
            <p>
                <input id="<?php echo $this->get_field_id('wpautop'); ?>" name="<?php echo $this->get_field_name('wpautop'); ?>" type="checkbox"<?php if($wpautop == "on") echo " checked='checked'"; ?>>&nbsp;
                <label for="<?php echo $this->get_field_id('wpautop'); ?>">Automatically add paragraphs</label>
            </p>
            <p><label for="<?php echo $this->get_field_id('buttext1'); ?>"><?php _e('Button1 Text:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buttext1'); ?>" name="<?php echo $this->get_field_name('buttext1'); ?>" type="text" value="<?php echo $buttext1; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('buturl1'); ?>"><?php _e('Button1 URL:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buturl1'); ?>" name="<?php echo $this->get_field_name('buturl1'); ?>" type="text" value="<?php echo $buturl1; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('buttext2'); ?>"><?php _e('Button2 Text:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buttext2'); ?>" name="<?php echo $this->get_field_name('buttext2'); ?>" type="text" value="<?php echo $buttext2; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('buturl2'); ?>"><?php _e('Button2 URL:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buturl2'); ?>" name="<?php echo $this->get_field_name('buturl2'); ?>" type="text" value="<?php echo $buturl2; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>
            
            <p>
				
                <input type="checkbox" name="<?php echo $this->get_field_name('linkbut'); ?>" id="<?php echo $this->get_field_id('linkbut'); ?>" <?php if($linkbut == "on") echo " checked='checked'"; ?> />						
                <label for="<?php echo $this->get_field_id('linkbut'); ?>"><?php _e('Open URL to new window', 'klasik'); ?> </label></p>


        <?php
    }
	
		
} // class  Widget