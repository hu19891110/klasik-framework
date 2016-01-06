<?php

//if no plugin Theme Options
function klasik_get_option( $name, $default = false ) {
	return of_get_option($name, $default);
}


/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */
if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = false) {
		
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
		
		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}
			
		if ( isset($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}


/* Metabox */
function klasik_get_metabox( $field_id, $args = array(), $post_id = null ) {
	return get_rwmb_meta( $field_id, $args , $post_id );
}


if ( !function_exists( 'get_rwmb_meta' ) ) {
	function get_rwmb_meta( $field_id, $args = array(), $post_id = null) {
			$custom_fields = klasik_get_customdata();
			if(function_exists('rwmb_meta')){
				if(rwmb_meta( $field_id, $args, $post_id)){
					return rwmb_meta( $field_id, $args, $post_id);
				}elseif(isset( $custom_fields[$field_id] )){
					//return $custom_fields['klasik_layout'];
				}
				
			}elseif(isset( $custom_fields[$field_id] )){
				return $custom_fields[$field_id];
			}else{
				return false;
			}
			
	}
}