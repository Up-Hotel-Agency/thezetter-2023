<?php

require_once( ABSPATH . 'wp-content/plugins/up-engine-plugin/php/functions/functions.php' );

// Register Block category for chameleon plugin blocks
add_filter( 'block_categories_all' , function( $categories ) {
  $categories[] = array(
    'slug'  => 'chameleon',
    'title' => 'Chameleon'
  );

  return $categories;
}, 10, 2);

// Add our custom blocks
add_action('init', function() {
  $options = get_plugin_settings();

  if (is_array($options) && array_key_exists('features', $options) && is_array($options['features'])) {
    $features = $options['features'];
    foreach ($features as $feature => $config) {
      if ($config['activated'] && function_exists($feature . '_registration')) {
        call_user_func($feature . '_registration');
      }
    }
  }
});

function dynamicContentBlock_registration() {
  register_block_type(
    ABSPATH . 'wp-content/plugins/up-engine-plugin/blocks/dynamic-content-block/block.json',
    [
      'supports' => ['custom-fields', 'title', 'editor']
    ]
  );
}

function suggestedPagesBlock_registration() {
  register_block_type(
    ABSPATH . 'wp-content/plugins/up-engine-plugin/blocks/suggested-pages-block/block.json',
    [
      'supports' => ['custom-fields', 'title', 'editor']
    ]
  );
}

function popularRoomsBlock_registration() {
  register_block_type(
    ABSPATH . 'wp-content/plugins/up-engine-plugin/blocks/popular-rooms-block/block.json',
    [
      'supports' => ['custom-fields', 'title', 'editor']
    ]
  );
}
