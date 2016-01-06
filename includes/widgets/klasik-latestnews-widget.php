<?php
// =============================== Klasik LatestNews widget ======================================
class Klasik_LatestNewsWidget extends WP_Widget {
    /** constructor */

	function Klasik_LatestNewsWidget() {
		$widget_ops = array('classname' => 'widget_klasik_latestnews', 'description' => __('Klasik Latest News','klasik') );
		parent::__construct('klasik-latestnews-widget', __('Klasik Latest News','klasik'), $widget_ops);
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
		$enablepagenum 	= isset($instance['enablepagenum']) ? $instance['enablepagenum'] : false;
		
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
					 
					 echo '<div class="klasik-latestnews-widget-wrapper" >';
					 

					$titleline='<span class="line-wrap-title"><span class="line-title"></span></span>';
					
					
					if ( $title!='' )
					echo $before_title . esc_html($title). $titleline . $after_title;

					$pagenum = "";
					if(!$enablepagenum){$pagenum = 'nopagenum';}
						
					$output = "";
					
					// Echo the text
					if($text){
						if($wpautop == "on") { $text = wpautop($text); }
						$output .='<div class="news-text">'.$text.'</div>';
					}	

					$output .='<div class="klasik-latestnews-widget  '.$pagenum.'">';

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
							
						
							if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
							elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
							else { $paged = 1; }
							
						
							
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$args = array(
								"post_type" => "post",
								"ignore_sticky_posts" => true,
								"paged"         	=> $paged,
								"showposts" => $showposts

							);
							
							if($category == 0) $category = "";
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
							
							$tpl ='<div id="latestpost-%%ID%%" class="%%CLASS%%">';
								$tpl .= '<div class="recent-item">';
								$tpl .= '<div class="recent-thumb">%%THUMB%%</div>';
								$tpl .= '<div class="recent-text-wrap">';
									$tpl .= '<h3 class="recent-title"><a href="%%LINK%%">%%TITLE%%</a></h3>';
									$tpl .= '<span class="smalldate">%%COMMENTS%%%%DATE%%</span>';
									$tpl .= '<div class="recent-text">%%TEXT%%</div>';
								$tpl .= '</div>';
								$tpl .= '<div class="clear"></div>';
								
								$tpl .= '</div>';
							$tpl .= '</div>';
							$tpl = apply_filters( 'klasik_latestnews_item_template', $tpl );
							
							
							if ($wp_query->have_posts()) : 
								$x = 0;
								while ($wp_query->have_posts()) : $wp_query->the_post(); 
								
								$template = $tpl;
								
								$custom = get_post_custom($post->ID);
								$cf_thumb = get_the_post_thumbnail($post->ID, 'widget-latestnews', array('class' => 'alignleft'));
								
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
			
			
									//POSTID
									$template = str_replace( '%%ID%%', $post->ID, $template );
									
									//postformat
									$postformat = '';
									$postformat .= 'format-'.get_post_format($post->ID);
									$template = str_replace( '%%FORMAT%%', $postformat, $template );
									
									//POSTCLASS
									$postclass  = 'columns ';
									$postclass .= $colclass.' ';
									$postclass .= $omega.' ';
									$postclass .= $withimage;
									$template = str_replace( '%%CLASS%%', $postclass, $template );
									
									//POSTTITLE
									$posttitle  = '';
									$posttitle .= get_the_title();
									$template   = str_replace( '%%TITLE%%', $posttitle, $template );
									
									//TAGS
									$maintags = "";
									$posttags = get_the_tags();
									$count=0;
									if ($posttags) {
									  $maintags .= '<div class="tags">';
									  foreach($posttags as $tag) {
										$count++;
										if (1 == $count) {
										  $maintags .= $tag->name . ' ';
										}
									  }
									  $maintags .= '</div>' ; 
									}
									$template = str_replace( '%%TAG%%', $maintags, $template );
									
									//AllTAGS
									$alltags = '';
									$alltags = get_the_tag_list('<ul class="tags"><li>','</li><li>','</li></ul>');
									$template = str_replace( '%%ALLTAGS%%', $alltags, $template );
									
									//AVATAR
									$postavatar  = '';
									$postavatar .= get_avatar( get_the_author_meta('ID'));
									$template   = str_replace( '%%AVATAR%%', $postavatar, $template );
									
									
									//POSTDATE
									$postdate  = '';
									$postdate .= get_the_time( get_option('date_format') );
									$template   = str_replace( '%%DATE%%', $postdate, $template );
									
									//POSTCATEGORY
									$categories = get_the_category();
									$separator = apply_filters( 'klasik_advancedpost_cat_separator', ', ' );
									$atitle = apply_filters( 'klasik_advancedpost_cat_linktitle', __( "View all posts in %s", 'klasik' ) );
									$postcat = '';
									$i = 0;
									if($categories){
										foreach($categories as $category) {
											$i++;
											$postcat .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( $atitle, $category->name ) ) . '">'.$category->cat_name.'</a>';
											if($i != count($categories)){
												$postcat .= $separator;
											}
										}
									}
									$template = str_replace( '%%CATEGORY%%', $postcat, $template );
									
									//COMMENTS
									$postcomm  = '';
									$css_class = 'zero-comments';
									$number    = (int) get_comments_number( get_the_ID() );
									
									if ( 1 === $number )
										$css_class = 'one-comment';
									elseif ( 1 < $number )
										$css_class = 'multiple-comments';
								
									ob_start();	
									comments_popup_link( 
										__( 'No Comments', 'klasik' ), 
										__( '1 Comment', 'klasik' ), 
										__( '% Comments', 'klasik' ),
										$css_class,
										__( 'Comments Closed', 'klasik' )
									);
									$postcomm  .= '<div class="news-comments '.$css_class.'">'.ob_get_contents().'</div>';
									ob_end_clean();

									$template   = str_replace( '%%COMMENTS%%', $postcomm, $template );
									
									//NUMBERCOMMENTS
									$number_postcomm  = '';
									$css_class = 'zero-comments';
									$number    = (int) get_comments_number( get_the_ID() );
									
									if ( 1 === $number )
										$css_class = 'one-comment';
									elseif ( 1 < $number )
										$css_class = 'multiple-comments';
								
									ob_start();	
									comments_popup_link( 
										__( '0', 'klasik' ), 
										__( '1', 'klasik' ), 
										__( '%', 'klasik' ),
										$css_class,
										__( 'Closed', 'klasik' )
									);
									$number_postcomm  .= '<div class="news-comments '.$css_class.'">'.ob_get_contents().'</div>';
									ob_end_clean();

									$template   = str_replace( '%%NUMBERCOMMENTS%%', $number_postcomm, $template );
									
									//POST-DAY
									$postday  = '';
									$postday .= get_the_time( 'd' );
									$template   = str_replace( '%%DAY%%', $postday, $template );
									
									//POST-MONTH
									$postmonth  = '';
									$postmonth .= get_the_time('M');
									$template   = str_replace( '%%MONTH%', $postmonth, $template );
									
									//POst Month Numeric, with leading zeros
									$postnumericmonth  = '';
									$postnumericmonth .= get_the_time('m');
									$template   = str_replace( '%%MONTH2%%', $postnumericmonth, $template );
									
									//POST-YEAR
									$postyear  = '';
									$postyear .= get_the_time('Y');
									$template   = str_replace( '%%YEAR%', $postyear, $template );
									
									//POSTLINK
									$postlink = get_permalink();
									$template = str_replace( '%%LINK%%', $postlink, $template );
			
									//POSTAUTHOR
									$postauthor = get_the_author();
									$template = str_replace( '%%AUTHOR%%', $postauthor, $template );
									
									//POSTAUTHORLINK
									$postauthorlink = get_author_posts_url( get_the_author_meta( 'ID' ) );
									$template = str_replace( '%%AUTHORLINK%%', $postauthorlink, $template );
									
									//POSTTHUMB
									$postthumb = '';
									if($cf_thumb){
									$postthumb .= '<div class="image">'.$cf_thumb.'</div>';
									}
									$template = str_replace( '%%THUMB%%', $postthumb, $template );
									
									//POSTTEXT
									$posttext = '';
									if($longdesc>0){
										$excerpt = klasik_string_limit_char(get_the_excerpt(), $longdesc);
									}else{
										$excerpt = get_the_excerpt();
									}
									$posttext .= $excerpt;
									$template = str_replace( '%%TEXT%%', $posttext, $template );
									
			
								$output .= $template;
			
								endwhile;
								
									$output.='<div class="clear"></div>';
								$output .='</div>';
								
								if($enablepagenum){
									ob_start();
									klasik_pagination();
									$output .='<div class="clear"></div>';
									$output .= ob_get_contents();
									
									ob_end_clean();
								}
					 
							endif;
							$wp_query = null; $wp_query = $temp; wp_reset_query();

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

		$instance['category'] 				= strip_tags($new_instance['category']);
		$instance['cols'] 					= strip_tags($new_instance['cols']);
		$instance['showpost'] 				= strip_tags($new_instance['showpost']);
		$instance['longdesc'] 				= strip_tags($new_instance['longdesc']);
		$instance['customclass'] 			= strip_tags($new_instance['customclass']);
		$instance['enablepagenum'] 			= strip_tags($new_instance['enablepagenum']);
			
    	return $instance;
		
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] 				= (isset($instance['title']))? $instance['title'] : "";

		$instance['category'] 			= (isset($instance['category']))? $instance['category'] : "";
		$instance['cols'] 				= (isset($instance['cols']))? $instance['cols'] : "";
		$instance['showpost'] 			= (isset($instance['showpost']))? $instance['showpost'] : "";
		$instance['longdesc'] 			= (isset($instance['longdesc']))? $instance['longdesc'] : "";
		$instance['customclass'] 		= (isset($instance['customclass']))? $instance['customclass'] : "";
		
		$enablepagenum  = isset($instance['enablepagenum']) ? esc_attr($instance['enablepagenum']) : "";
		$text 			= isset($instance['text']) ? esc_attr($instance['text']) : "";
		$wpautop 		= isset($instance['wpautop']) ? esc_attr($instance['wpautop']) : "";
	
        $title 			= esc_attr($instance['title']);

		$category 		= esc_attr($instance['category']);
		$cols 			= esc_attr($instance['cols']);
		$longdesc 		= esc_attr($instance['longdesc']);
		$customclass 	= esc_attr($instance['customclass']);
		$showpost 		= esc_attr($instance['showpost']);

		

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
			'show_option_all'  => 'All Categories',
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


            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>
            
            <p>
		
              <input type="checkbox" name="<?php echo $this->get_field_name('enablepagenum'); ?>" id="<?php echo $this->get_field_id('enablepagenum'); ?>" <?php if($enablepagenum == "on") echo " checked='checked'"; ?> />			
              <label for="<?php echo $this->get_field_id('enablepagenum'); ?>"><?php _e('Enable Paging', 'klasik'); ?> </label></p>


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