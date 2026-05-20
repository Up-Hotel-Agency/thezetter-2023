<?php

function get_plugin_settings() {
  if (is_multisite()) {
    $globalSettings = get_site_option('chameleon_global_settings');

    $siteSettings = get_option('chameleon_settings');

    if (is_array($siteSettings)) {
      if (is_array($globalSettings)) {
        if (array_key_exists('settings', $siteSettings) && is_array($siteSettings['settings'])) {
          $siteSettings['settings'] = array_merge($siteSettings['settings'], $globalSettings);
        } else {
          $siteSettings['settings'] = $globalSettings;
        }
      }
    } else {
      $siteSettings = [
        'settings' => $globalSettings
      ];
    }

    return $siteSettings;
  } else {
    $settings = get_option('chameleon_settings');
  
    return $settings;
  }
}

function create_jwt_token_api($request) {
  $requestObject = $request->get_json_params();
  $apiKey = $requestObject['apiKey'];

  return create_jwt_token($apiKey);
}

function create_jwt_token($apiKey) {
  $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
  $payload = json_encode(['apiKey' => $apiKey]);

  $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
  $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

  $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET_KEY, true);
  $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

  $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
  return $jwt;
}

function get_room_posts() {
  $args = array(
    'posts_per_page' => 500,
    'post_type' => 'rooms'
  );

  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) {
    $posts = $the_query->posts;

    $data = [];

    foreach ($posts as $post) {
      $postMeta = get_post_meta($post->ID);
      if (array_key_exists('date', $postMeta)) {
        $postMeta['date'] = strtotime(strval($postMeta['date'][0]));
      }
      
      $postMeta['image'] = get_post_image($postMeta, parse_blocks($post->post_content), 'room');

      $bookingLink = (object) [
        'link' => $postMeta['link_field_link_link_type'][0] === 'custom' ? $postMeta['link_field_link_external_link'][0] : $postMeta['link_field_link'][0],
        'buttonText' => $postMeta['link_field_link_link_text'][0],
        'openInNewTab' => filter_var($postMeta['link_field_link_new_tab'][0], FILTER_VALIDATE_BOOLEAN)
      ];

      $postMeta['cta_button'] = $bookingLink;

      $post->post_content = $postMeta['intro_content'][0];

      $post->post_link = get_permalink($post);

      $data[] = (object) [
        'post' => $post,
        'post_meta' => $postMeta
      ];
    }

    return $data;
  }
}

function get_offer_posts() {
  $args = array(
    'posts_per_page' => 500,
    'post_type' => 'offers'
  );
  $the_query = new WP_Query( $args );

  if ($the_query->have_posts()) {
    $posts = $the_query->posts;

    $data = [];

    foreach ($posts as $post) {
      $postMeta = get_post_meta($post->ID);
      $postMeta['start_date'] = strtotime(strval($postMeta['start_date'][0]));
      $postMeta['end_date'] = strtotime(strval($postMeta['end_date'][0]));

      $postMeta['image'] = get_post_image($postMeta, parse_blocks($post->post_content), 'offer');

      $post->post_content = $postMeta['intro_content'][0];

      $offerLink = (object) [
        'link' => $postMeta['link_field_link_link_type'][0] === 'custom' ? $postMeta['link_field_link_external_link'][0] : $postMeta['link_field_link'][0],
        'buttonText' => $postMeta['link_field_link_link_text'][0],
        'openInNewTab' => filter_var($postMeta['link_field_link_new_tab'][0], FILTER_VALIDATE_BOOLEAN)
      ];

      $postMeta['cta_button'] = $offerLink;

      $post->post_link = get_permalink($post);

      $data[] = (object) [
        'post' => $post,
        'post_meta' => $postMeta
      ];
    }

    return $data;
  }
}
  
function get_event_posts() {
  $args = array(
    'posts_per_page' => 500,
    'post_type' => 'events'
  );

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) {
    $posts = $the_query->posts;

    $data = [];

    foreach ($posts as $post) {
      $postMeta = get_post_meta($post->ID);
      $postMeta['date'] = strtotime(strval($postMeta['date'][0]));
      $postMeta['cost'] = $postMeta['cost'][0];

      if (array_key_exists('thumbnail_id', $postMeta)) {
        $postMeta['image'] = get_post_image($postMeta, parse_blocks($post->post_content), 'event');
      }

      $post->post_content = $postMeta['intro_content'][0];

      $eventLink = (object) [
        'link' => $postMeta['link_field_link_link_type'][0] === 'custom' ? $postMeta['link_field_link_external_link'][0] : $postMeta['link_field_link'][0],
        'buttonText' => $postMeta['link_field_link_link_text'][0],
        'openInNewTab' => filter_var($postMeta['link_field_link_new_tab'][0], FILTER_VALIDATE_BOOLEAN)
      ];

      $postMeta['cta_button'] = $eventLink;

      $post->post_link = get_permalink($post);

      $data[] = (object) [
        'post' => $post,
        'post_meta' => $postMeta
      ];
    }

    return $data;
  }
}

function get_gallery_posts() {
  $args = array(
    'posts_per_page' => 500,
    'post_type' => 'galleries'
  );

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) {
    $posts = $the_query->posts;

    $data = [];

    foreach ($posts as $post) {
      $postMeta = get_post_meta($post->ID);
      $postMeta['date'] = strtotime(strval($postMeta['date'][0]));

      $blocks = parse_blocks($post->post_content);

      $postHtml = '';

      foreach ($blocks as $block) {
        $postHtml = $postHtml . render_block($block);
      }

      $post->post_content->rendered = $postHtml;

      $data[] = (object) [
        'post' => $post,
        'post_meta' => $postMeta
      ];
    }

    return $data;
  }
}

function get_site_pages() {
  $args = array(
    'posts_per_page' => 500,
    'post_type' => 'page'
  );
  $the_query = new WP_Query( $args );

  if ($the_query->have_posts()) {
    $posts = $the_query->posts;

    $data = [];

    foreach ($posts as $post) {
      $post->post_image = get_page_image($post);
      $data[] = (object) [
        'id' => $post->ID,
        'link' => get_permalink($post),
        'title' => (object) [ 'rendered' => $post->post_title ],
        'slug' => $post->post_name,
        'type' => $post->post_type,
        'image' => $post->post_image
      ];
    }

    return $data;
  }
}

function get_post_image($postMeta, $postBlocks, $postType) {
  $img = '';

  if (array_key_exists('_thumbnail_id', $postMeta) && isset($postMeta['_thumbnail_id'][0])) {
    // Featured image
    $img = wp_get_attachment_image($postMeta['_thumbnail_id'][0], 'large');
  } else if (array_key_exists('rooms_listing_images_images_0_image', $postMeta) && isset($postMeta['rooms_listing_images_images_0_image'][0]) && $postType == 'room') {
    // Room listing image
    $img = wp_get_attachment_image($postMeta['rooms_listing_images_images_0_image'][0], 'large');
  } else {
    // Literally any image we can find
    foreach ($postMeta as $key => $value) {
      if (str_contains($key, 'image')) {
        if (is_numeric($value[0]) && wp_attachment_is_image($value[0])) {
          $img = wp_get_attachment_image($value[0], 'large');
          break;
        }
      }
    }

    if (!$img) {
      if (is_array($postBlocks)) {
        foreach ($postBlocks as $index => $block) {
          if (is_array($block) && array_key_exists('attrs', $block)) {
            foreach ($block['attrs'] as $key => $attrs) {
              if (is_array($attrs)) {
                foreach ($attrs as $attrName => $attrValue) {
                  if (str_contains($attrName, 'image') || str_contains($attrName, 'picture') || str_contains($attrName, 'photo')) {
                    if (is_numeric($attrValue) && wp_attachment_is_image($attrValue)) {
                      $img = wp_get_attachment_image($attrValue, 'large');
                      break 3;
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  return str_replace('"', '\'', str_replace("\n", ' ', $img));
}

function get_page_image($page) {
  $blocks = parse_blocks($page->post_content);
  return get_post_image(get_post_meta($page->ID), $blocks, 'page');
}

function set_plugin_settings_from_request($request) {
  $settings = $request->get_json_params();

  set_plugin_settings($settings);
}

function set_plugin_settings($settings) {
  $allowedSettings = [
    'features',
    'booking-search-memory',
    'recently-visited-block',
    'currency-conversion',
    'seasonal-media',
    'smart-room-order',
    'popular-rooms-block',
    'dynamic-content-block',
    'slide-callout',
    'highlight-bar',
    'promotion-modal',
    'booking-intent-message',
    'settings',
    'localisation',
    'apiKey',
    'value',
    'active',
    'gaId',
    'ibeUrl',
    'theming',
    'colors',
    'typeScale',
    'textStyles'
  ];

  foreach($settings as $category => $values) {
    if (!in_array($category, $allowedSettings)) {
      unset($settings[$category]);
    }
    foreach($values as $setting => $value) {
      if (!in_array($setting, $allowedSettings)) {
        unset($values[$setting]);
      }
    }
  }

  if (is_multisite()) {
    $globalSettings = [
      'apiKey' => $settings['settings']['apiKey'],
      'dev' => $settings['settings']['dev'],
      'uniqueRefId' => $settings['settings']['uniqueRefId']
    ];

    update_site_option('chameleon_global_settings', $globalSettings);
  }

  update_option('chameleon_settings', $settings);
  return true;
}

function multisite_sync_from_request($request) {
  $val = $request->get_json_params();

  multisite_sync($val['settingName'], $val['settingToSync']);
}

function multisite_sync($settingName, $settingValue) {
  if (is_multisite()) {
    $sites = get_sites();

    foreach($sites as $site) {
      switch_to_blog($site->blog_id);

      $chamSettings = get_option('chameleon_settings');

      if (!is_array($chamSettings)) {
        $chamSettings = [];
      }

      if (array_key_exists('settings', $chamSettings)) {
        if (is_array($chamSettings['settings'])) {
          if (is_array($chamSettings['settings'][$settingName])) {
            $chamSettings['settings'][$settingName] = array_merge($chamSettings['settings'][$settingName], $settingValue);
          } else {
            $chamSettings['settings'][$settingName] = $settingValue;
          }
        } else {
          $chamSettings['settings'] = [
            $settingName => $settingValue
          ];
        }
      } else {
        $chamSettings = [
          'settings' => [
            $settingName => $settingValue
          ]
        ];
      }

      update_option('chameleon_settings', $chamSettings);

      restore_current_blog();
    }
  }
}

function get_all_post_types() {
  return get_post_types(array(
    '_builtin' => false,
    'public' => true
  ));
}

function get_all_posts() {
  $offerPosts = new WP_Query(array(
    'posts_per_page' => 500,
    'post_type' => 'offers'
  ));
  $roomPosts = new WP_Query(array(
    'posts_per_page' => 500,
    'post_type' => 'rooms'
  ));
  $eventPosts = new WP_Query(array(
    'posts_per_page' => 500,
    'post_type' => 'events'
  ));
  $galleryPosts = new WP_Query(array(
    'posts_per_page' => 500,
    'post_type' => 'galleries'
  ));
  $blogPosts = get_posts(array(
    'numberposts' => -1
  ));

  return array_merge($offerPosts->posts, $roomPosts->posts, $eventPosts->posts, $galleryPosts->posts, $blogPosts);
}

function query_plugin_version($versionToQuery = 'latest'){
  $url = esc_url_raw(SERVER_URL) . '/api/engine/github/version?versionToQuery=' . $versionToQuery;

  $token = get_access_token();

  $headers = array(
    'Authorization:Bearer ' . $token
  );

  $remote = make_api_request('/api/engine/github/version?versionToQuery=' . $versionToQuery, [], $headers, 'GET');

  if (is_array($remote)) {
    $body = json_decode($remote['body'], true);

    if (is_array($body) && array_key_exists('assets', $body)) {
      $pluginVersionUrl = polyfill_array_find($body['assets'], function ($asset) {
        return $asset['name'] === 'plugin-version.json';
      });

      if (is_array($pluginVersionUrl) && array_key_exists('url', $pluginVersionUrl)) {
        $pluginVersionFile = wp_remote_get($pluginVersionUrl['url'], array(
          'timeout' => 10,
          'headers' => array(
            'Accept' => 'application/octet-stream'
          ))
        );

        $version = json_decode($pluginVersionFile['body'], true)['up-engine-plugin/chameleon.php']['version'];

        $pluginArchive = polyfill_array_find($body['assets'], function ($asset) {
          return $asset['name'] === 'up-engine-plugin.zip';
        });

        $archiveUrl = $pluginArchive['url'];

        return [
          'version' => $version,
          'url' => $archiveUrl
        ];
      }
    }
  }
}

function plugin_get_post_by_id($request) {
  $queryParams = $request->get_query_params();

  if (is_array($queryParams) && array_key_exists('id', $queryParams)) {
    $postQuery = new WP_Query(array(
      'p' => $queryParams['id'],
      'post_type' => 'any'
    ));

    $data = [];

    $posts = $postQuery->posts;

    foreach ($posts as $post) {
      $postMeta = get_post_meta($post->ID);

      $data[] = (object) [
        'name' => $post->post_title,
        'content' => $postMeta['intro_content'][0],
        'image' => get_post_image($postMeta, parse_blocks($post->post_content), 'post'),
        'link' => get_permalink($post)
      ];
    }

    return $data;
  }
}

function register_site() {
  try {
    $settings = get_plugin_settings();

    if (is_array($settings) && array_key_exists('settings', $settings) && is_array($settings['settings']) && array_key_exists('apiKey', $settings['settings']) && $settings['settings']['apiKey']['value']) {
      return false;
    }

    $result = do_register_call($settings);

    if (is_object($result) && property_exists($result, 'encryptedKey')) {
      $settings['settings']['apiKey']['value'] = $result->encryptedKey;
      $settings['settings']['uniqueRefId'] = $result->uniqueRefId;
      $settings['settings']['apiKey']['active'] = $result->keyValid;
    }

    set_plugin_settings($settings);

    return $result->success;
  } catch (Exception $error) {
    throw $error;
  }
}

function do_register_call() {
  $token = get_access_token();

  $data = array(
    'siteName' => get_site_name(),
    'email' => wp_get_current_user()->user_email,
    'tier' => 'basic'
  );

  $headers = array(
    'Authorization:Bearer ' . $token
  );

  $result = json_decode(make_api_request('/api/engine/register-site', $data, $headers, 'POST'));

  if (is_object($result) && property_exists($result, 'encryptedKey')) {
    return $result;
  } else {
    if (is_object($result) && property_exists($result, 'uniqueRefId')) {
      $keyResult = json_decode(make_api_request('/api/engine/get-key', array('uniqueRefId' => $result->uniqueRefId), $headers, 'POST'));

      if (is_object($keyResult) && property_exists($keyResult, 'encryptedKey')) {
        return $keyResult;
      }
    }
  }
}

function get_site_name() {
  if (is_multisite()) {
    return get_site_option('site_name');
  } else {
    return get_bloginfo( 'name' );
  }
}

function get_access_token() {
  $result = make_api_request('/api/engine/token', array('presharedKey' => JWT_PRESHARED_KEY), [], 'POST');

  return $result;
}

function make_api_request($path, $data, $headers, $reqType) {
  try {
    if (SERVER_URL != 'http://localhost:6060') {
      $url = SERVER_URL . $path;
    } else {
      $url = 'http://up-engine-node:6060' . $path;
    }

    $headers = array_merge(array(
      'Content-Type:application/json'
    ), $headers);
    
    $ch = curl_init();

    if ($ch === false) {
      throw new Exception('Failed to initialise');
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $reqType);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);


    $result = curl_exec($ch);

    if (!$result || (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200)) {
      throw new Exception(curl_error($ch), curl_errno($ch));
    }

    return $result;
  } catch (Exception $error) {
    echo $error->getMessage();
  }
}
