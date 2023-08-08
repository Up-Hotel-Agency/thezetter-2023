<?php

if(!function_exists('get_event_single_type')){
	function get_event_single_type() {
		// set the event single type here
		// event_1 is page with event listing gutenberg block
		// event_2 is modal using the event grid gutenberg block
		$event_type = 'event_2';
		return $event_type;
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_event_atc' );
function enqueue_event_atc() {
	if ( get_post_type() === 'events' ) {
		wp_enqueue_script( 'atc-js', get_template_directory_uri() . '/assets/js/atc.min.js' );
	}
}

if( get_offer_single_type() == 'event_1' ) {
	add_action( 'wp_enqueue_scripts', 'enqueue_event_1_styles' );

	function enqueue_event_1_styles() {
		if ( get_post_type() === 'events' ) {
			wp_enqueue_style( 'block-acf-cta-blocks', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
		}
	}
}

if( get_event_single_type() == 'event_2' ) {
	add_action( 'wp_enqueue_scripts', 'enqueue_event_2_styles' );

	function enqueue_event_2_styles() {
		if ( get_post_type() === 'events' ) {
			wp_enqueue_style( 'block-acf-events-list', get_template_directory_uri() . '/assets/css/events_list/events_list.css' );
		}
	}
}

function events_func() {
	$event_rest;
	$event_rest = false;
	if( get_event_single_type() == 'event_1' ) {
		$event_rest = true;
	}
	$labels = array(
		'name'                  => 'Events',
		'singular_name'         => 'Event',
		'menu_name'             => 'Events',
		'name_admin_bar'        => 'Events',
		'archives'              => 'Events',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Events',
		'add_new_item'          => 'Add New Events',
		'add_new'               => 'Add New Events',
		'new_item'              => 'New Event',
		'edit_item'             => 'Edit Event',
		'update_item'           => 'Update Event',
		'view_item'             => 'View Events',
		'search_items'          => 'Search Events',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'insert_into_item'      => 'Insert into Event',
		'uploaded_to_this_item' => 'Uploaded to this Event',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Events',
		'description'           => 'Events',
		'labels'                => $labels,
		'show_in_rest' 			=> $event_rest, // this is to activate gutenberg
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array('with_front' => false, 'slug' => 'event'),
	);
	register_post_type( 'events', $args );

}
add_action( 'init', 'events_func', 0 );