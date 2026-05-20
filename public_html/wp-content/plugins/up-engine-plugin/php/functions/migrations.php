<?php

require_once( ABSPATH . ('wp-content/plugins/up-engine-plugin/php/functions/functions.php') );

function run_migrations() {
  $currentVersion = get_option('chameleon_version');

  booking_search_memory_migration($currentVersion);
  autofill_group_site_migration($currentVersion);
  refresh_api_key($currentVersion);
  rename_chameleon_settings($currentVersion);
  multisite_setting_migration($currentVersion);
  theming_color_slug_migration($currentVersion);
}

function refresh_api_key($version) {
  if (!$version || version_compare($version, '4.0.16', '<=')) {
    $currentSettings = get_option('dynamic_content_plugin_options');
    $keyResponse = do_register_call($currentSettings);
  
    if (is_object($keyResponse) && property_exists($keyResponse, 'encryptedKey')) {
      $currentSettings['settings']['apiKey']['value'] = $keyResponse->encryptedKey;
      $currentSettings['settings']['apiKey']['active'] = true;
      $currentSettings['settings']['uniqueRefId'] = $keyResponse->uniqueRefId;
    }
  
    update_option('dynamic_content_plugin_options', $currentSettings);
  }
}

function rename_chameleon_settings($version) {
  if (!$version || version_compare($version, '4.0.22', '<=')) {
    $currentSettings = get_option('dynamic_content_plugin_options');

    if (is_array($currentSettings)) {
      add_option('chameleon_settings', $currentSettings);

      delete_option('dynamic_content_plugin_options');
    }
  }
}

function booking_search_memory_migration($version) {
  if (!$version || version_compare($version, '4.1.0', '<=')) {
    $currentSettings = get_option('chameleon_settings');

    if (is_array($currentSettings) && array_key_exists('features', $currentSettings) && array_key_exists('autoPopulateBookingSearchBar', $currentSettings['features'])) {
      $temp = $currentSettings['features']['autoPopulateBookingSearchBar'];

      $currentSettings['features']['bookingSearchMemory'] = $temp;

      unset($currentSettings['features']['autoPopulateBookingSearchBar']);

      update_option('chameleon_settings', $currentSettings);
    }
  }
}

function autofill_group_site_migration($version) {
  if (!$version || version_compare($version, '4.1.0', '<=')) {
    $currentSettings = get_option('chameleon_settings');

    if (is_array($currentSettings) && array_key_exists('features', $currentSettings) && (array_key_exists('bookingSearchMemory', $currentSettings['features']))) {
      $temp = $currentSettings['features']['bookingSearchMemory'];

      if (array_key_exists('bookingBarDetection', $temp) && array_key_exists('detectAttributes', $temp['bookingBarDetection'])) {
        $originalAttribute = $temp['bookingBarDetection']['detectAttributes'];

        if (is_array($originalAttribute)) {
          if (array_key_exists(0, $originalAttribute)) {
            $temp['bookingBarDetection']['bookingBarElement'] = $originalAttribute[0];
          } else {
            $temp['bookingBarDetection']['bookingBarElement'] = (object) [];
          }
          $temp['bookingBarDetection']['locationSelectElement'] = (object) [];

          unset($temp['bookingBarDetection']['detectAttributes']);

          $currentSettings['features']['autoPopulateBookingSearchBar'] = $temp;

          update_option('chameleon_settings', $currentSettings);
        }
      }
    }
  }
}

function multisite_setting_migration($version) {
  if (is_multisite()) {
    if (!$version || version_compare($version, '4.2.5', '<=')) {
      $currentGlobalSettings = get_site_option('chameleon_global_settings');

      if (array_key_exists('ibe', $currentGlobalSettings)) {
        unset($currentGlobalSettings['ibe']);
      }
      if (array_key_exists('localisation', $currentGlobalSettings)) {
        unset($currentGlobalSettings['localisation']);
      }
      if (array_key_exists('analytics', $currentGlobalSettings)) {
        unset($currentGlobalSettings['analytics']);
      }

      update_site_option('chameleon_global_settings', $currentGlobalSettings);
    }
  }
}

function theming_color_slug_migration($version) {
  if (!$version || version_compare($version, '4.2.1', '<=')) {
    $currentSettings = get_option('chameleon_settings');

    if (is_array($currentSettings) && array_key_exists('theming', $currentSettings) && (array_key_exists('colors', $currentSettings['theming']))) {
      $temp = $currentSettings['theming']['colors'];

      foreach ($temp as &$color) {
        if (is_array($color) && array_key_exists('slug', $color)) {
          switch ($color['slug']) {
            case 'text':
              $color['slug'] = 'contrast';
              break;
            case 'background':
              $color['slug'] = 'base';
              break;
            case 'primary-reverse':
              $color['slug'] = 'accent-reverse';
              break;
          }
        }
      }

      $slugTemp = $currentSettings['theming']['textStyles'];

      foreach ($slugTemp as &$textStyle) {
        if (array_key_exists('sections', $textStyle) && is_array($textStyle['sections'])) {
          if (array_key_exists(0, $textStyle['sections']) && is_array($textStyle['sections'][0]) && array_key_exists('name', $textStyle['sections'][0]) && $textStyle['sections'][0]['name'] == 'Medium Size') {
            $textStyle['sections'][0]['name'] = 'Large Size';
          } 
        }
      }

      $currentSettings['theming']['colors'] = $temp;
      $currentSettings['theming']['textStyles'] = $slugTemp;
      update_option('chameleon_settings', $currentSettings);
    }
  }
}
