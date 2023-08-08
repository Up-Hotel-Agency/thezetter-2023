<?php

if(!function_exists('get_offer_single_type')){
	function get_offer_single_type() {
		// set the offer single type here
		// offer_1 is page with offer listing gutenberg block
		// offer_2 is modal using the offer grid gutenberg block
		$offer_type = 'offer_2';
		return $offer_type;
	}
}

//Handle settings based on selected offer type]

if( get_offer_single_type() == 'offer_1' ) {
	add_action( 'wp_enqueue_scripts', 'enqueue_offer_1_styles' );

	function enqueue_offer_1_styles() {
		if ( get_post_type() === 'offers' ) {
			wp_enqueue_style( 'block-acf-cta-blocks', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
		}
	}
}

if( get_offer_single_type() == 'offer_2' ) {
	add_action( 'wp_enqueue_scripts', 'enqueue_offer_2_styles' );

	function enqueue_offer_2_styles() {
		if ( get_post_type() === 'offers' ) {
			wp_enqueue_style( 'block-acf-offers-grid', get_template_directory_uri() . '/assets/css/offers_grid/offers_grid.css' );
		}
	}
}

function offers_func() {
	$offer_rest;
	$offer_rest = false;
	if( get_offer_single_type() == 'offer_1' ) {
		$offer_rest = true;
	}
	$labels = array(
		'name'                  => 'Offers',
		'singular_name'         => 'Offer',
		'menu_name'             => 'Offers',
		'name_admin_bar'        => 'Offers',
		'archives'              => 'Offers',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Offers',
		'add_new_item'          => 'Add New Offers',
		'add_new'               => 'Add New Offers',
		'new_item'              => 'New Offer',
		'edit_item'             => 'Edit Offer',
		'update_item'           => 'Update Offer',
		'view_item'             => 'View Offers',
		'search_items'          => 'Search Offers',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'insert_into_item'      => 'Insert into Offer',
		'uploaded_to_this_item' => 'Uploaded to this Offer',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Offers',
		'description'           => 'Offers',
		'labels'                => $labels,
		'show_in_rest' 			=> $offer_rest, // this is to activate gutenberg
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-tickets-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array('with_front' => false, 'slug' => 'offer'),
	);
	register_post_type( 'offers', $args );

}
add_action( 'init', 'offers_func', 0 );

register_taxonomy(
	'hotel_categories',
	array('offers' ), //  The Custom Post Type it will belong to  //
	array(
		'labels' => array(
			'name'              => _x( 'Hotel Categories', 'Hotel Categories'),
			'singular_name'     => _x( 'Hotel Categories', 'Hotel Categories'),
			'search_items'      => __( 'Search Hotel Categories'),
			'all_items'         => __( 'All Hotel Categories'),
			'parent_item'       => __( 'Parent Hotel Categories'),
			'parent_item_colon' => __( 'Parent Hotel Categories'),
			'edit_item'         => __( 'Edit Hotel Categorys'),
			'update_item'       => __( 'Update Hotel Category'),
			'add_new_item'      => __( 'Add New Hotel Category'),
			'new_item_name'     => __( 'New Hotel Category'),
			'menu_name'         => __( 'Hotel Categories')
		),
		'hierarchical'      => true,
		'hasArchive'        => true,
		'public'			=> true,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite' => array('with_front' => false, 'slug' => 'hotel')
	)
);