<?php

if(!function_exists('get_room_single_type')){
	function get_room_single_type() {
		// set the room single type here
		// room_1 is page with gutenberg
		// room_2 is modal using the rooms grid gutenberg block
		$room_type = 'room_2';
		return $room_type;
	}
}

if( get_room_single_type() == 'room_1' ) {

	add_action( 'wp_enqueue_scripts', 'enqueue_room_1_styles' );

	function enqueue_room_1_styles() {
		if ( get_post_type() === 'rooms' ) {
			wp_enqueue_style( 'block-acf-image-content-block', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
		}
	}

}

if( get_room_single_type() == 'room_2' ) {
	// here are some ACF fields just for room_2

	add_action( 'wp_enqueue_scripts', 'enqueue_rooms_2_styles' );

	function enqueue_rooms_2_styles() {
		if ( get_post_type() === 'rooms' ) {
			wp_enqueue_style( 'block-acf-featured-list', get_template_directory_uri() . '/assets/css/featured_list/featured_list.css' );
			wp_enqueue_style( 'block-acf-cta-blocks', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
		}
	}

	if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array(
			'key' => 'group_room_2_details',
			'title' => 'Room Details',
			'fields' => array(
				array(
					'key' => 'field_room_2_overview',
					'label' => 'Room Overview',
					'name' => 'room_overview',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_room_2_amenities',
					'label' => 'Amenities',
					'name' => 'amenities',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'table',
					'button_label' => '',
					'sub_fields' => array(
						array(
							'key' => 'field_room_2_amenities_title',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_room_2_amenities_content',
							'label' => 'Content',
							'name' => 'content',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
				),
				array(
					'key' => 'field_room_cta_activate',
					'label' => 'Show room CTA?',
					'name' => 'show_room_cta',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_room_cta_overline',
					'label' => 'CTA Overline',
					'name' => 'room_cta_overline',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_room_cta_activate',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_room_cta_title',
					'label' => 'CTA Title',
					'name' => 'room_cta_title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_room_cta_activate',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_room_cta_subheading',
					'label' => 'CTA Subheading',
					'name' => 'room_cta_subheading',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_room_cta_activate',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_room_cta',
					'label' => 'Room CTA',
					'name' => 'room_cta',
					'type' => 'clone',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_room_cta_activate',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'clone' => array(
						0 => 'field_5f75b04e969d7',
					),
					'display' => 'group',
					'layout' => 'block',
					'prefix_label' => 0,
					'prefix_name' => 1,
				),
				array(
					'key' => 'field_room_cta_img',
					'label' => 'CTA Image',
					'name' => 'room_cta_image',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_room_cta_activate',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'preview_size' => 'medium',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'rooms',
					),
				),
			),
			'menu_order' => 30,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));
		
	endif;
}

function rooms_func() {
	$room_rest;
	$room_rest = false;
	if( get_room_single_type() == 'room_1' ) {
		$room_rest = true;
	}
	$labels = array(
		'name'                  => 'Rooms',
		'singular_name'         => 'Rooms',
		'menu_name'             => 'Rooms',
		'name_admin_bar'        => 'Rooms',
		'archives'              => 'Rooms',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Rooms',
		'add_new_item'          => 'Add New Rooms',
		'add_new'               => 'Add New Rooms',
		'new_item'              => 'New Rooms',
		'edit_item'             => 'Edit Rooms',
		'update_item'           => 'Update Rooms',
		'view_item'             => 'View Rooms',
		'search_items'          => 'Search Rooms',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into Rooms',
		'uploaded_to_this_item' => 'Uploaded to this Rooms',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Rooms',
		'description'           => 'Rooms',
		'labels'                => $labels,
		'show_in_rest' 			=> $room_rest, // this is to activate gutenberg
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-building',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array('with_front' => false, 'slug' => 'rooms'),
	);
	register_post_type( 'rooms', $args );

}
add_action( 'init', 'rooms_func', 0 );

// here are some hard coded fields depending on the room listing you're using