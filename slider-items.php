<!-- SLIDER -->

<?php

$output="";
		
	$cf_imgslider ="";
	
	$slidercount = $wp_query->post_count;

	echo '<div id="slideritems"> <ul class="slides">';
	
	while ($wp_query->have_posts()) : $wp_query->the_post(); 
	
	$cf_slideurl = "";
	$cf_media = "";
	
	if(get_post_format()=='video' || get_post_format()=='audio'){
		$pregvid = preg_match_all('/(\<video.*\<\/video\>)/is', get_the_content(), $videos);
		$pregemb = preg_match_all('/(\[embed.*\[\/embed\])/is', get_the_content(), $embeds);
		$pregifr = preg_match_all('/(\<iframe.*\<\/iframe\>)/is', get_the_content(), $iframes);
		$pregvsh = preg_match_all('/(\[video.*\[\/video\])/is', get_the_content(), $vshorts);
		$video = isset($videos[1][0])? $videos[1][0] : "";
		$embed = isset($embeds[1][0])? $embeds[1][0] : "";
		$iframe = isset($iframes[1][0])? $iframes[1][0]: "";
		$vshort = isset($vshorts[1][0])? $vshorts[1][0]: "";
		$media = "";
		
		if(!empty($vshort)){
			$media = $vshort;
		}elseif(!empty($video)){
			$media = $video;
		}elseif(!empty($embed)){
			global $wp_embed;
			$media = $wp_embed->run_shortcode($embed);
		}elseif(!empty($iframe)){
			$media = $iframe;
		}
		
		$cf_media = $media;
	}
	
	if(get_post_format()=='link'){
		$content = preg_match_all( '/href\s*=\s*[\"\']([^\"\']+)/', get_the_content(), $links );
		$link = $links[1][0];
		$cf_slideurl=$link;	
	}

	$output="";
	
		//slider images
		$postthumbnailid = get_post_thumbnail_id($post->ID);
		$sliderimgsrc = wp_get_attachment_image_src($postthumbnailid,'full');
		$cf_imgslider = $sliderimgsrc[0];

		$output .='<li>';
		$output .='<div class="slider-img">';

			if($cf_slideurl==""){
				$cf_slideurl = get_permalink();
			}
			
			if($cf_media!=""){
				$output .= '<div class="videoWrapper">'.$cf_media.'</div>';
			}else{
				$output .= '<img src="'.$cf_imgslider.'" alt="'.get_the_title().'">';
				
			}
											
			//slider text
			$output .='<div class="flex-caption">';
				$output  .='<div class="slider-title-wrap">';
										
					if($cf_slideurl!=""){
						$output .='<div class="slider-title"><a href="'.$cf_slideurl.'">' . get_the_title() . '</a></div>';
					}else{
						$output .='<div class="slider-title">' . get_the_title() . '</div>';
					}
					
				$output  .='</div>';
			$output .='</div>';
		
		
		$output .= '</div>';
		$output .= '</li>';

	echo $output;
	
	endwhile;

	echo '</ul> </div>';

?>

<!-- END SLIDER -->