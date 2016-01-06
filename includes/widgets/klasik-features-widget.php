<?php
// =============================== Klasik Features widget ======================================
class Klasik_FeaturesWidget extends WP_Widget {
    /** constructor */

	function Klasik_FeaturesWidget() {
		$widget_ops = array('classname' => 'widget_klasik_features', 'description' => __('Klasik Features','klasik') );
		parent::__construct('klasik-features-widget', __('Klasik Features','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title 			= apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$category 		= apply_filters('widget_category', $instance['category']);
		$cols 			= apply_filters('widget_cols', empty($instance['cols']) ? '' : $instance['cols']);
		$showposts 		= apply_filters('widget_showpost', empty($instance['showpost']) ? '' : $instance['showpost']);
		$longdesc 		= apply_filters('widget_longdesc', empty($instance['longdesc']) ? '' : $instance['longdesc']);
		$customclass 	= apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
		$linktitle 		= isset($instance['linktitle']) ? $instance['linktitle'] : false;

		$text 					= isset($instance['text']) ? $instance['text'] : false;
        $wpautop				= isset($instance['wpautop']) ? $instance['wpautop'] : false;
		
		$instance['category'] = esc_attr(isset($instance['category'])? $instance['category'] : "");
		global $wp_query;
		
		$longdesc = (!is_numeric($longdesc) || empty($longdesc))? 0 : $longdesc;
		$showposts = (!is_numeric($showposts))? get_option('posts_per_page') : $showposts;
		
		$cols = intval($cols);
		
		if(!is_numeric($cols) || $cols < 1 || $cols > 6){
			$cols = 4;
		}
		
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
			
					 
					 echo '<div class="klasik-features-widget-wrapper">';

					$titleline='<span class="line-wrap-title"><span class="line-title"></span></span>';
					
					
					if ( $title!='' )
					echo $before_title . esc_html($title). $titleline . $after_title;

						
					$output = "";
					
					// Echo the text
					if($text){
						if($wpautop == "on") { $text = wpautop($text); }
						$output .='<div class="features-text">'.$text.'</div>';
					}	
					

					$output .='<div class="klasik-features">';
						$output .='<div class="row">';

							if($cols==1){
								$colclass = "twelve";
							}elseif($cols==2){
								$colclass = "one_half";
							}elseif($cols==3){
								$colclass = "one_third";
							}elseif($cols==4){	
								$colclass = "one_fourth";
							}elseif($cols==5){
								$colclass = "one_fifth";
							}elseif($cols==6){
								$colclass = "one_sixth";
							}
							
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$args = array(
								"post_type" => "post",
								"showposts" => $showposts
							);
							
							if( $category!="" ){
								$args['tax_query'] = array(
									array(
										'taxonomy' => 'category',
										'field' => 'id',
										'terms' => $category
									)
								);
							}
							
							$wp_query->query($args);
							global $post;
							
							$tpl = '<div class="%%CLASS%%" id="f-%%ID%%">';
								$tpl .= '<div class="item-container">';
									$tpl .= '<div class="feature-title-container">';
										$tpl .= '<div class="img-container">%%THUMB%%</div>';
										$tpl .= '<h3 class="feature-title">%%TITLE%%</h3>';
									$tpl .= '</div>';
									
									$tpl .= '<div class="feature-text">%%TEXT%%</div>';

									$tpl .= '<div class="clear"></div>';
								$tpl .= '</div>';
							$tpl .= '</div>';
							
							$tpl = apply_filters( 'klasik_features_item_template', $tpl );
							
							if ($wp_query->have_posts()) : 
								$x = 0;
								while ($wp_query->have_posts()) : $wp_query->the_post(); 
								
								$template = $tpl;
								
								$custom = get_post_custom($post->ID);
								$mt_icon = klasik_get_metabox('klasik_icon');
								$cf_thumb = get_the_post_thumbnail($post->ID, 'widget-feature', array('class' => 'alignleft'));
							
								if($cf_thumb){
									$withimage = "imageon";
								}else{
									$withimage = "imageoff";
								}
								
								$x++;
								
								if($x%$cols==0){
									$omega = "omega";
								}elseif($x%$cols==1){
									$omega = "alpha";
								}else{
									$omega = "";
								}
								
								//FEATUREID
								$template = str_replace( '%%ID%%', $post->ID, $template );
								
								//FEATURECLASS
								$fclass  = 'columns fitem ';
								$fclass .= $colclass.' ';
								$fclass .= 'feature'.$x.' ';
								$fclass .= $omega.' ';
								$fclass .= $withimage;
								$template = str_replace( '%%CLASS%%', $fclass, $template );
								
								//FEATUREIMAGE
								$fthumb = '';
								if($mt_icon){
									$fthumb .= '<div class="image"><i class="fa '.$mt_icon.' "></i></div>';
								}else{
									$fthumb .= '<div class="image">'.$cf_thumb.'</div>';
								}
								$template = str_replace( '%%THUMB%%', $fthumb, $template );
								
								//FEATURELINK
								$flink = get_permalink();
								$template = str_replace( '%%LINK%%', $flink, $template );
								
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
									
								
								//FEATURETITLE
								$ftitle  = '';
								if($linktitle){
								$ftitle .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '" >' . get_the_title() . '</a>';
								}else{
								$ftitle .= get_the_title();
								}
								$template = str_replace( '%%TITLE%%', $ftitle, $template );
								
								//FEATURETEXT
								$ftext = '';
								if($longdesc>0){
									$excerpt = klasik_string_limit_char(get_the_excerpt(), $longdesc);
								}else{
									$excerpt = get_the_excerpt();
								}
								$ftext .= $excerpt;
								$template = str_replace( '%%TEXT%%', $ftext, $template );

								$output .= $template;
			
								endwhile;
						
							endif;
							$wp_query = null; $wp_query = $temp; wp_reset_query();
						$output .='</div>';
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
		
		$instance['linktitle'] 				= strip_tags($new_instance['linktitle']);
		$instance['category'] 				= strip_tags($new_instance['category']);
		$instance['cols'] 					= strip_tags($new_instance['cols']);
		$instance['showpost'] 				= strip_tags($new_instance['showpost']);
		$instance['longdesc'] 				= strip_tags($new_instance['longdesc']);
		$instance['customclass'] 			= strip_tags($new_instance['customclass']);
				
    	return $instance;
		
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] 			= (isset($instance['title']))? $instance['title'] : "";
		$instance['linktitle'] 		= (isset($instance['linktitle']))? $instance['linktitle'] : "";
		$instance['category'] 		= (isset($instance['category']))? $instance['category'] : "";
		$instance['cols'] 			= (isset($instance['cols']))? $instance['cols'] : "";
		$instance['showpost'] 		= (isset($instance['showpost']))? $instance['showpost'] : "";
		$instance['longdesc'] 		= (isset($instance['longdesc']))? $instance['longdesc'] : "";
		$instance['customclass'] 	= (isset($instance['customclass']))? $instance['customclass'] : "";

		$text 					= isset($instance['text']) ? $instance['text'] : false;
        $wpautop				= isset($instance['wpautop']) ? $instance['wpautop'] : false;
		
					
        $title = esc_attr($instance['title']);
		$category = esc_attr($instance['category']);
		$cols = esc_attr($instance['cols']);
		$longdesc = esc_attr($instance['longdesc']);
		$customclass = esc_attr($instance['customclass']);
		$showpost = esc_attr($instance['showpost']);
		$linktitle = esc_attr($instance['linktitle']);


		
        ?>
        
        
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'klasik'); ?><textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="3"><?php echo $text; ?></textarea>			</label></p>
            <p>
                <input id="<?php echo $this->get_field_id('wpautop'); ?>" name="<?php echo $this->get_field_name('wpautop'); ?>" type="checkbox"<?php if($wpautop == "on") echo " checked='checked'"; ?>>&nbsp;
                <label for="<?php echo $this->get_field_id('wpautop'); ?>">Automatically add paragraphs</label>
            </p>
            <p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'klasik'); ?><br />
			<?php 
			$args = array(
			'selected'         => $category,
			'echo'             => 1,
			'name'             =>$this->get_field_name('category')
			);
			wp_dropdown_categories( $args );
			?>
			</label></p>
            
            <p><label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Number of Columns:', 'klasik'); ?></label><br />
            <select id="<?php echo $this->get_field_id('cols'); ?>" name="<?php echo $this->get_field_name('cols'); ?>" class="widefat" style="width:50%;">
				<?php foreach($this->get_number_options() as $k => $v ) { ?>
                    <option <?php selected( $instance['cols'], $k); ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php } ?>      
            </select></p>
            
            <p><label for="<?php echo $this->get_field_id('showpost'); ?>"><?php _e('Number of Post:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('showpost'); ?>" name="<?php echo $this->get_field_name('showpost'); ?>" type="text" value="<?php echo $showpost; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('longdesc'); ?>"><?php _e('Length of Description Text:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('longdesc'); ?>" name="<?php echo $this->get_field_name('longdesc'); ?>" type="text" value="<?php echo $longdesc; ?>" /></label></p>
            
            <p>
		
            <input type="checkbox" name="<?php echo $this->get_field_name('linktitle'); ?>" id="<?php echo $this->get_field_id('linktitle'); ?>" <?php if($linktitle == "on") echo " checked='checked'"; ?> />			
            <label for="<?php echo $this->get_field_id('linktitle'); ?>"><?php _e('Link Post Title', 'klasik'); ?> </label></p>
            
            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>

        <?php
    }


	protected function get_number_options () {
		return array(
					'1' 			=> __( '1 Column', 'klasik' ),		
					'2' 			=> __( '2 Column', 'klasik' ),
					'3' 			=> __( '3 Column', 'klasik' ),
					'4' 			=> __( '4 Column', 'klasik' ),
					'5' 			=> __( '5 Column', 'klasik' ),
					'6' 			=> __( '6 Column', 'klasik' )
					);
	} // End get_number_options()

} // class  Widget