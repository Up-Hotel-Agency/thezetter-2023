<?php

function gallery_func() {

	$labels = array(
		'name'                  => 'Galleries',
		'singular_name'         => 'Gallery',
		'menu_name'             => 'Galleries',
		'name_admin_bar'        => 'Galleries',
		'archives'              => 'Galleries',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Galleries',
		'add_new_item'          => 'Add New Galleries',
		'add_new'               => 'Add New Galleries',
		'new_item'              => 'New Gallery',
		'edit_item'             => 'Edit Gallery',
		'update_item'           => 'Update Gallery',
		'view_item'             => 'View Galleries',
		'search_items'          => 'Search Galleries',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'insert_into_item'      => 'Insert into Gallery',
		'uploaded_to_this_item' => 'Uploaded to this Gallery',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Galleries',
		'description'           => 'Galleries',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-format-gallery',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array('with_front' => false, 'slug' => 'gallery-ft'),
	);
	register_post_type( 'gallery', $args );

}
add_action( 'init', 'gallery_func', 0 );