<?php
function team_func() {

	$labels = array(
		'name'                  => 'Team',
		'singular_name'         => 'Team',
		'menu_name'             => 'Team',
		'name_admin_bar'        => 'Team',
		'archives'              => 'Team',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Team',
		'add_new_item'          => 'Add New Team Member',
		'add_new'               => 'Add New Team Member',
		'new_item'              => 'New Team Member',
		'edit_item'             => 'Edit Team Member',
		'update_item'           => 'Update Team Member',
		'view_item'             => 'View Team Member',
		'search_items'          => 'Search Team Member',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'insert_into_item'      => 'Insert into Gallery',
		'uploaded_to_this_item' => 'Uploaded to this Gallery',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Team',
		'description'           => 'Team',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'team', $args );

}
add_action( 'init', 'team_func', 0 );