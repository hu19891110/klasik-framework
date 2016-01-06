<?php
// =============================== Klasik Portfolio Widget ======================================
class Klasik_PortfolioWidget extends WP_Widget {
    /** constructor */

	function Klasik_PortfolioWidget() {
		$widget_ops = array('classname' => 'widget_klasik_portfolio', 'description' => __('Klasik Portfolio','klasik') );
		parent::__construct('klasik-theme-portfolio-widget', __('Klasik Portfolio','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title 					= apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		
		$category 				= apply_filters('widget_category', $instance['category']);
		$cols 					= apply_filters('widget_cols', empty($instance['cols']) ? '' : $instance['cols']);
		$showposts 				= apply_filters('widget_showpost', empty($instance['showpost']) ? '' : $instance['showpost']);
		$longdesc 				= apply_filters('widget_longdesc', empty($instance['longdesc']) ? '' : $instance['longdesc']);
		$customclass 			= apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
		$enablepagenum 			= isset($instance['enablepagenum']) ? $instance['enablepagenum'] : false;
		$text 					= isset($instance['text']) ? $instance['text'] : false;
        $wpautop				= isset($instance['wpautop']) ? $instance['wpautop'] : false;
		$instance['category'] = esc_attr(isset($instance['category'])? $instance['category'] : "");
				
		
        if ( $customclass ) {
            $before_widget = str_replace('class="', 'class="'. $customclass . ' ', $before_widget);
        }    
		
		global $wp_query;
		
		
        ?>
              <?php echo $before_widget; 


					 echo '
					    <div class="all-widget-wrapper">
                		<div class="container">
                    	<div class="row">
                        <div class="twelve columns">
					 ';
					 
					 echo '<div class="klasik-portfolionew-widget-wrapper">';

					 $titleline='<span class="line-wrap-title"><span class="line-title"></span></span>';
					 
			  			
					if ( $title!='' )
					echo $before_title . esc_html($title). $titleline . $after_title;
						
					$cols = intval($cols);
		
					if(!is_numeric($cols) || $cols < 1 || $cols > 6){
						$cols = 4;
					}
									
					
					$longdesc = (!is_numeric($longdesc) || empty($longdesc))? 0 : $longdesc;
					
					$showposts = (!is_numeric($showposts))? get_option('posts_per_page') : $showposts;
					
					
					$pagenum = "";
					
					$output = "";
				
					if(!$enablepagenum){$pagenum = 'nopagenum';}
					
					// Echo the text
					if($text){
						if($wpautop == "on") { $text = wpautop($text); }
						$output .='<div class="portfolionew-text">'.$text.'</div>';
					}
										
					$output .='<div class="klasik-portfolionew '.$pagenum.' col'.$cols.'">';

					
					
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
							"showposts" 		=> $showposts,
							"orderby" 			=> "date"
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
			
			
						$tpl = '<div data-id="id-%%ID%%" class="%%CLASS%%">';
							$tpl .= '<div class="klasik-pfnew-img">';
							$tpl .= '<a class="pfnewzoom" href="%%LINK%%"><span class="rollover"></span><span class="zoom"></span>%%THUMB%%</a>';
							$tpl .= '</div>';	
							$tpl .= '<div class="clear"></div>';
						$tpl .= '</div>';
						$tpl = apply_filters( 'klasik_portfolio_item_template', $tpl );
						
						
						if ($wp_query->have_posts()) : 
							$x = 0;
							
							$output .= '<div class="row">';
							

							
							
							while ($wp_query->have_posts()) : $wp_query->the_post(); 
								
				
								$template = $tpl;

								
								$custom = get_post_custom($post->ID);
								$cf_custom_price = (isset($custom['custom-price'][0]))? $custom['custom-price'][0] : "";
								$cf_custom_link = (isset($custom['custom-link'][0]))? $custom['custom-link'][0] : "";
								$cf_customdesc 		= get_the_title() ;
								
								$x++;
				
								if($cols==1){
									$colclass = "twelve columns";
								}elseif($cols==2){
									$colclass = "one_half columns";
								}elseif($cols==3){
									$colclass = "one_third columns";
								}elseif($cols==4){	
									$colclass = "one_fourth columns";
								}elseif($cols==5){
									$colclass = "one_fifth columns";
								}elseif($cols==6){
									$colclass = "one_sixth columns";
								}
								
								
								if($x%$cols==0){
									$omega = "omega";
								}elseif($x%$cols==1){
									$omega = "alpha";
								}else{
									$omega = "";
								}				
								
				
								$itemclass = $colclass .' '. $omega;
								
								
								//get post-thumbnail attachment
								$attachments = get_children( array(
									'post_parent' => $post->ID,
									'post_type' => 'attachment',
									'orderby' => 'menu_order',
									'post_mime_type' => 'image')
								);
								
								$fullimageurl = '';
								$cf_thumb2 = '';
								

								foreach ( $attachments as $att_id => $attachment ) {
									$getimage = wp_get_attachment_image_src($att_id, 'widget-portfolio', true);
									$fullimage = wp_get_attachment_image_src($att_id, 'full', true);
									$portfolioimage = $getimage[0];
									$cf_thumb2 ='<img src="'.$portfolioimage.'" alt="" />';
									$thethumblb = $portfolioimage;
									$fullimageurl = $fullimage[0];
								}
								
								//thumb image
								if(has_post_thumbnail($post->ID)){
									$cf_thumb = get_the_post_thumbnail($post->ID, 'widget-portfolio');
									$thumb_id = get_post_thumbnail_id($post->ID);
									$args = array(
										'post_type' => 'attachment',
										'post_status' => null,
										'include' => $thumb_id
									);
									$fullimage = wp_get_attachment_image_src($thumb_id, 'full', true);
									$fullimageurl = $fullimage[0];
									
									$thumbnail_image = get_posts($args);
									if ($thumbnail_image && isset($thumbnail_image[0])) {
										$cf_customdesc = $thumbnail_image[0]->post_content;
									}
								}else{
									$cf_thumb = $cf_thumb2;
								}
								
								if($cf_thumb){
									$withimage = "imageon";
								}else{
									$withimage = "imageoff";
								}
								
								//LIGHTBOX URL 
								$custom = get_post_custom($post->ID);
								$cf_lightboxurl = (isset($custom["lightbox-url"][0]) && $custom["lightbox-url"][0]!="")? $custom["lightbox-url"][0] : "";
								
								if($cf_lightboxurl != ""){
									$fullimageurl = $cf_lightboxurl;
								}
								
								$format = get_post_format($post->ID);
			
								if(($format=="link")||($format=="quote")){
									$lightboxrel = "";
									$fullimageurl = get_permalink();
								}else{
									$lightboxrel = "data-rel=prettyPhoto[mixed]";
								}
								
								
								$ids = get_the_ID();
								
								$addclass="";
							
								$catinfos = get_the_terms($post->ID,'category');
								$key = '';
								$separator = ', ';
								$quote = '&quot;';
								
							
									if($catinfos){
										foreach($catinfos as $catinfo){
											$key .= " ".$catinfo->slug;
										}
										$key = trim($key);
									}
									

								
								//PORTFOLIOID
								$template = str_replace( '%%ID%%', $post->ID, $template );
								
								//POST-DAY
								$postday  = '';
								$postday .= get_the_time( 'd' );
								$template   = str_replace( '%%DAY%%', $postday, $template );
								
								//POST-MONTH
								$postmonth  = '';
								$postmonth .= get_the_time('M');
								$template   = str_replace( '%%MONTH%%', $postmonth, $template );
								
								//POST-YEAR
								$postyear  = '';
								$postyear .= get_the_time('Y');
								$template   = str_replace( '%%YEAR%%', $postyear, $template );
									
								
								//PORTFOLIOCLASS
								$pfclass  = 'item ';
								$pfclass .= $itemclass.' ';
								$pfclass .= $key.' ';
								$pfclass .= $withimage;
								$template = str_replace( '%%CLASS%%', $pfclass, $template );
								
								//PORTFOLIOKEY
								$pfkey = $key;
								$template = str_replace( '%%KEY%%', $pfkey, $template );
								
								//PORTFOLIOFULLIMAGE
								$pffullimg = $fullimageurl;
								$template = str_replace( '%%FULLIMG%%', $pffullimg, $template );
								
								//LIGHTBOXREL
								$pflightbox = $lightboxrel;
								$template = str_replace( '%%LBOXREL%%', $pflightbox, $template );
								
								//PORTFOLIOIMGTITLE
								$pffullimgtitle = $cf_customdesc;
								$template = str_replace( '%%FULLIMGTITLE%%', $pffullimgtitle, $template );
								
								//PORTFOLIOLINK
								if($cf_custom_link !=""){
								$pflink = $cf_custom_link;
								}else{
								$pflink = get_permalink();
								}
								$template = str_replace( '%%LINK%%', $pflink, $template );
								
								//PORTFOLIOIMAGE
								$pfthumb = '';
								if($cf_thumb){
								$pfthumb .= '<div class="image">'.$cf_thumb.'</div>';
								}
								$template = str_replace( '%%THUMB%%', $pfthumb, $template );
	
								//PRICE
								$pfprice = '';
								$pfprice .= $cf_custom_price;
								$template = str_replace( '%%PRICE%%', $pfprice, $template );
	
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
								
								
								//PORTFOLIOTITLE
								$pftitle  = '';
								$pftitle .= get_the_title();
								$template = str_replace( '%%TITLE%%', $pftitle, $template );
	
								//PORTFOLIOTEXT
								$pftext = '';
								if($longdesc>0){
									$excerpt = klasik_string_limit_char(get_the_excerpt(), $longdesc);
								}else{
									$excerpt = get_the_excerpt();
								}
								$pftext .= $excerpt;
								$template = str_replace( '%%TEXT%%', $pftext, $template );
								
								//PORTFOLIOCATEGORY
								$pfcat = '';
								$categories = get_the_category();
								$separator = ', ';
								if($categories){
									foreach($categories as $category) {
										$pfcat .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'klasik' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
									}
								}
								$template = str_replace( '%%CATEGORY%%', trim($pfcat, $separator), $template );
							

							$output .= $template;

							endwhile;

							
							$output .= '</div>';
							
							
							if($enablepagenum){
								ob_start();
								klasik_pagination();
								$output .='<div class="clear"></div>';
								$output .= '<div class="page-numbers-wrapper">'.ob_get_contents().'</div>';
								
								ob_end_clean();
							}
							
						
							echo $output;
							

							
						endif;
						$wp_query = null; $wp_query = $temp; wp_reset_query();
						echo '<div class="clear"></div>';
					echo '</div>';
				?>


			
              <?php 
					echo '<div class="clear"></div></div>';
					
					echo '                        
					</div>
					</div>
					</div>
					<div class="clear"></div></div>';
					
								  
			  
			  echo $after_widget; ?>
			 
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {	
			
        $instance = $old_instance;
      
    	$instance['title'] 					= strip_tags($new_instance['title']);
		$instance['category'] 				= strip_tags($new_instance['category']);

        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = wp_filter_post_kses($new_instance['text']);
		$instance['wpautop'] 				= strip_tags($new_instance['wpautop']);
		
		$instance['cols'] 					= strip_tags($new_instance['cols']);
		$instance['showpost'] 				= strip_tags($new_instance['showpost']);
		$instance['longdesc'] 				= strip_tags($new_instance['longdesc']);
		$instance['customclass'] 			= strip_tags($new_instance['customclass']);
		$instance['enablepagenum'] 			= strip_tags($new_instance['enablepagenum']);
		
		
    	return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] = (isset($instance['title']))? $instance['title'] : "";
		$instance['category'] = (isset($instance['category']))? $instance['category'] : "";
		$instance['cols'] = (isset($instance['cols']))? $instance['cols'] : "";
		$instance['showpost'] = (isset($instance['showpost']))? $instance['showpost'] : "";
		$instance['longdesc'] = (isset($instance['longdesc']))? $instance['longdesc'] : "";
		$instance['customclass'] = (isset($instance['customclass']))? $instance['customclass'] : "";

		$enablepagenum  = isset($instance['enablepagenum']) ? esc_attr($instance['enablepagenum']) : "";
		$text 			= isset($instance['text']) ? esc_attr($instance['text']) : "";
		$wpautop 		= isset($instance['wpautop']) ? esc_attr($instance['wpautop']) : "";
		
        $title = esc_attr($instance['title']);
		$category 		= esc_attr($instance['category']);
		$cols = esc_attr($instance['cols']);
		$showpost = esc_attr($instance['showpost']);
		$customclass = esc_attr($instance['customclass']);
		$longdesc = esc_attr($instance['longdesc']);

		
		
        ?>
        
			<style type="text/css">
                .hide { display:none}
            </style>
        
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
            
			
            <p >
		
            <input type="checkbox" name="<?php echo $this->get_field_name('enablepagenum'); ?>" id="<?php echo $this->get_field_id('enablepagenum'); ?>" <?php if($enablepagenum == "on") echo " checked='checked'"; ?>/>			
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