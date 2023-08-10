<?php

function careers_func() {
	$offer_rest = false;
	$labels = array(
		'name'                  => 'Careers',
		'singular_name'         => 'Career',
		'menu_name'             => 'Careers',
		'name_admin_bar'        => 'Careers',
		'archives'              => 'Careers',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Careers',
		'add_new_item'          => 'Add New Careers',
		'add_new'               => 'Add New Careers',
		'new_item'              => 'New Offer',
		'edit_item'             => 'Edit Offer',
		'update_item'           => 'Update Offer',
		'view_item'             => 'View Careers',
		'search_items'          => 'Search Careers',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'insert_into_item'      => 'Insert into Offer',
		'uploaded_to_this_item' => 'Uploaded to this Offer',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Careers',
		'description'           => 'Careers',
		'labels'                => $labels,
		'show_in_rest' 			=> $offer_rest, // this is to activate gutenberg
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array('with_front' => false, 'slug' => 'career'),
	);
	register_post_type( 'careers', $args );

}
add_action( 'init', 'careers_func', 0 );

register_taxonomy(
	'hotel_category',
	array('careers' ), //  The Custom Post Type it will belong to  //
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
		'rewrite' => array('with_front' => false, 'slug' => 'hotels')
	)
);