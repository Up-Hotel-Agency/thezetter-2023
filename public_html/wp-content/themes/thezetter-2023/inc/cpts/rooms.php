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

register_taxonomy(
	'room_categories',
	array('rooms' ), //  The Custom Post Type it will belong to  //
	array(
		'labels' => array(
			'name'              => _x( 'Room Categories', 'Room Categories'),
			'singular_name'     => _x( 'Room Categories', 'Room Categories'),
			'search_items'      => __( 'Search Room Categories'),
			'all_items'         => __( 'All Room Categories'),
			'parent_item'       => __( 'Parent Room Categories'),
			'parent_item_colon' => __( 'Parent Room Categories'),
			'edit_item'         => __( 'Edit Room Categorys'),
			'update_item'       => __( 'Update Room Category'),
			'add_new_item'      => __( 'Add New Room Category'),
			'new_item_name'     => __( 'New Room Category'),
			'menu_name'         => __( 'Room Categories')
		),
		'hierarchical'      => true,
		'hasArchive'        => true,
		'public'			=> true,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite' => array('with_front' => false, 'slug' => 'room')
	)
);

// here are some hard coded fields depending on the room listing you're using