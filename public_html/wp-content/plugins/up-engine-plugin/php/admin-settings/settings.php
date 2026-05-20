<?php

require_once( ABSPATH . ('wp-content/plugins/up-engine-plugin/php/functions/functions.php') );

define('STRIPE_PAYMENT_LINK', $_ENV['STRIPE_PAYMENT_LINK']);
define('STRIPE_MANAGEMENT_LINK', $_ENV['STRIPE_MANAGEMENT_LINK']);

function add_settings_page() {
  add_options_page('Dynamic Content Engine', 'Chameleon', 'manage_options', 'chameleon', 'render_plugin_settings');
}

add_action('admin_menu', 'add_settings_page');
add_action('admin_enqueue_scripts', function () {
  wp_enqueue_media();
});

add_action('admin_enqueue_scripts', function() {
  register_site();
});

function render_plugin_settings() {
  ?>
  <div class="udc-settings-page"></div>
  <?php
  $options = get_plugin_settings();
  $settingsFields = [
    'settings' => $options,
    'wpApi' => [
      'url' => esc_url_raw(rest_url('wp/v2')),
      'nonce' => wp_create_nonce('wp_rest')
    ],
    'pluginApi' => [
      'url' => esc_url_raw(SERVER_URL),
      'accessToken' => get_access_token(),
      'siteName' => get_site_name(),
      'email' => wp_get_current_user()->user_email
    ],
    'version' => CHAMELEON_VERSION
  ];
  wp_register_style('udc-settings-css', plugins_url('/up-engine-plugin/scss/admin/settings.css'));
  wp_enqueue_style('udc-settings-css');
  wp_enqueue_script('udc-settings-render', plugins_url('/up-engine-plugin/php/admin-settings/react-settings/index.js'), ['wp-element', 'wp-components', 'wp-api-fetch', 'wp-block-editor', 'wp-media-utils', 'wp-core-data', 'lodash'], '1.0');
  wp_add_inline_script('udc-settings-render', 'const PLUGIN_SETTINGS = ' . json_encode($settingsFields), 'before');
  wp_add_inline_script('udc-settings-render', 'const STRIPE_PAYMENT_LINK = \'' . STRIPE_PAYMENT_LINK . '\'', 'before');
  wp_add_inline_script('udc-settings-render', 'const STRIPE_MANAGEMENT_LINK = \'' . STRIPE_MANAGEMENT_LINK . '\'', 'before');
  wp_add_inline_script('udc-settings-render', 'const WP_TIMEZONE = \'' . wp_timezone_string() . '\'', 'before');
  wp_add_inline_script('udc-settings-render', 'const IS_MULTISITE = ' . json_encode(is_multisite()), 'before');
  wp_add_inline_script('udc-settings-render', 'const MAIN_SITE_URL = \'' . get_site_url(get_main_site_id()) . '\'', 'before');
}

function register_update_check($updates) {
  if (! is_object($updates)){
    return $updates;
  }

  if (! isset($updates->response ) || ! is_array($updates->response)) {
    $updates->response = array();
  }

  $version = CHAMELEON_VERSION;

  $pluginInfo = null;

  $siteUrl = get_site_url();

  // Query WordPress plugins available
  if (str_contains($siteUrl, 'up-dev') || str_contains($siteUrl, 'localhost')) {
    $settings = get_plugin_settings();

    if (is_array($settings) && array_key_exists('settings', $settings) && is_array($settings['settings']) && array_key_exists('dev', $settings['settings']) && array_key_exists('pluginBranch', $settings['settings']['dev'])) {
      $devBranch = $settings['settings']['dev']['pluginBranch'];

      if ($devBranch !== '') {
        $response = query_plugin_version($devBranch . '-dev');

        if (is_array($response) && array_key_exists('version', $response) && str_contains($response['version'], $devBranch)) {
          $pluginInfo = $response;
        }
      }
    }
  } 
  
  if (!$pluginInfo) {
    $response = query_plugin_version('latest');
    if (is_array($response) && array_key_exists('version', $response) && version_compare($response['version'], $version) > 0) {
      $pluginInfo = $response;
    }
  }

  // Compare the version
  // If returned version is greater than installed version,
  // mock & return WordPress response, feeding it a .zip
  // file which WordPress downloads, unzips the zip,
  // completely replacing the plugin and its files
  if ($pluginInfo) {
    // Only mock our plugin
    $updates->response['up-engine-plugin/chameleon.php'] = (object) array(
      'id'           => 'up-engine-plugin/chameleon.php',
      'slug'         => 'up-engine-plugin',
      'plugin'       => 'up-engine-plugin/chameleon.php',
      'new_version'  => $pluginInfo['version'],
      // 'url'          => $response['url'],
      'package'      => $pluginInfo['url']
    );
  } else {
    $updates->no_update['up-engine-plugin/chameleon.php'] = (object) array(
      'id'           => 'up-engine-plugin/chameleon.php',
      'slug'         => 'up-engine-plugin',
      'plugin'       => 'up-engine-plugin/chameleon.php',
      'new_version'  => $version,
      // 'url'          => $response['url'],
      'package'      => ''
    );
  }

  return $updates;
}

// Leave this here if we find a decent way to d a details section
// function add_custom_plugin_info_links($plugin_meta, $plugin_file, $plugin_data, $status) {
//   $chameleon = 'up-engine-plugin/chameleon.php';

//   if ($plugin_file === $chameleon) {
//     $plugin_meta[2] = '<a href="https://github.com/UpDao-Digital-Agency/Chameleon-Plugin/blob/main/README.md" rel="noopener">View Details</a>';
//   }

//   return $plugin_meta;
// }

add_filter('pre_set_site_transient_update_plugins', 'register_update_check', 10, 1);
// add_filter('plugin_row_meta', 'add_custom_plugin_info_links', 10, 4);

// This is not a real error until Wordpress upgrades PHP to >= 8.4.0
function polyfill_array_find(array $array, callable $callback) {
  foreach ($array as $key => $value) {
    if ($callback($value)) {
        return $value;
    }
  }

  return null;
}
