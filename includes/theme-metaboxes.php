<?php
add_filter( 'rwmb_meta_boxes', 'klasik_register_meta_boxes' );

function klasik_register_meta_boxes( $meta_boxes )
{
	$imagepath =  get_template_directory_uri() . '/images/';
	$prefix = 'klasik_';
	
	
	$meta_boxes[] = array(
		'title'  => __( 'General Setting', 'klasik' ),
		'post_types' => array('post', 'page'),
		'fields' => array(
			array(
				'name'     => __( 'Layout', 'klasik' ),
				'id'       => $prefix.'layout',
				'desc'  => '<div>'.__( 'Select the layout you want on this specific post/page. Overrides default site layout.', 'klasik' ).'</div>',
				'type'     => 'image_select',
				'options'  => array(
					'default' => $imagepath.'mb-default.png',
					'one-col' => $imagepath.'mb-1c.png',
					'two-col-left' => $imagepath.'mb-2cl.png',
					'two-col-right' => $imagepath.'mb-2cr.png',
					),
			),
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', 
			),
			array(
				'name'  => __( 'Font Awesome Icon ', 'klasik' ),
				'id'    => $prefix.'icon',
				'desc'  => __( 'Enter your font awesome icon code like <strong>fa-star</strong> to show on post/page title and features widget', 'klasik' ),
				'type'  => 'text',
				'std'   => '',
				'clone' => false,
			),
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'postsetting',
		'title'      => __( 'Post Setting', 'klasik' ),
		'post_types' => array( 'post'),
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'name'  => __( 'Feature on Homepage Slider', 'klasik' ),
				'id'    => "{$prefix}slider_post",
				'desc'  => __( 'Checked this checkbox if you want to show this post as Homepage Slider.', 'klasik' ),
				'type'  => 'checkbox',
			),
			array(
				'type' => 'divider',
				'id'   => 'fake_divider_id', 
			),
			array(
				'name'  => __( 'Disable Blog Info on Single', 'klasik' ),
				'id'    => $prefix.'disable_meta',
				'desc'  => __( 'Checked this checkbox if you want to disable the meta and author information on single page (date, author, categories, etc).', 'klasik' ),
				'type'  => 'checkbox',
			),
		),
	
	);
	

	return $meta_boxes;
}