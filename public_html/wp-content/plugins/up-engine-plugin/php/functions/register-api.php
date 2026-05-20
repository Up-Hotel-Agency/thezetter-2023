<?php

require_once( ABSPATH . 'wp-content/plugins/up-engine-plugin/php/functions/functions.php' );

function create_api_routes() {
  register_rest_route(
    'wp/v2',
    'offers',
    array(
      'callback' => 'get_offer_posts',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'events',
    array(
      'callback' => 'get_event_posts',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'rooms',
    array(
      'callback' => 'get_room_posts',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'galleries',
    array(
      'callback' => 'get_gallery_posts',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'plugin-pages',
    array(
      'callback' => 'get_site_pages',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'plugin-settings',
    array(
      'callback' => 'set_plugin_settings_from_request',
      'methods' => WP_REST_Server::CREATABLE,
      'permission_callback' => '__return_true'
    ) 
  );
  register_rest_route(
    'wp/v2',
    'get-plugin-settings',
    array(
      'callback' => 'get_plugin_settings',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
    );
  register_rest_route(
    'wp/v2',
    'post-types',
    array(
      'callback' => 'get_all_post_types',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'plugin-all-posts',
    array(
      'callback' => 'get_all_posts',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'plugin-get-post',
    array(
      'callback' => 'plugin_get_post_by_id',
      'methods' => WP_REST_Server::READABLE,
      'permission_callback' => '__return_true'
    )
  );
  register_rest_route(
    'wp/v2',
    'multisite-sync',
    array(
      'callback' => 'multisite_sync_from_request',
      'methods' => WP_REST_Server::CREATABLE,
      'permission_callback' => '__return_true'
    )
  );
}
  
add_action('rest_api_init', 'create_api_routes', 20);
