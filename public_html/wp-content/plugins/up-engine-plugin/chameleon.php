<?php
/**
 * Plugin Name:       Chameleon
 * Plugin URI:        
 * Update URI:        https://up-engine-plugin.s3.eu-west-1.amazonaws.com/plugin-version.json
 * Description:       Dynamic content engine used to tailor the website to the user.
 * Version:           4.2.7
 * Author:            UP Hotel Agency
 * Author URI:        https://uphotel.agency/
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       
 * Domain Path:       
 */
// Quick commit test
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


require_once( ABSPATH . 'wp-includes/pluggable.php' );
require_once( ABSPATH . ('wp-content/plugins/up-engine-plugin/php/functions/functions.php') );
require_once( ABSPATH . 'wp-content/plugins/up-engine-plugin/vendor/autoload.php' );
require_once( ABSPATH . 'wp-content/plugins/up-engine-plugin/php/functions/migrations.php' );

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, null, true, null);
$dotenv->load();

define( 'CHAMELEON_VERSION', $_ENV['PLUGIN_VERSION'] );
add_action('admin_init', 'chameleon_activation');

function chameleon_activation() {
  run_migrations();
  update_option('chameleon_version', CHAMELEON_VERSION);
}

add_action('admin_enqueue_scripts', function() {
  wp_enqueue_media();
  wp_register_style('udc-editor-css', plugins_url('/up-engine-plugin/blocks/chameleon-editor.css'));
  run_migrations();
  wp_enqueue_style('udc-editor-css');
});

define('JWT_PRESHARED_KEY', $_ENV['JWT_PRESHARED_KEY']);
define('SERVER_URL', $_ENV['SERVER_URL']);
define('JWT_SECRET_KEY', $_ENV['JWT_SECRET_KEY']);

function bootstrap_engine() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  $nonce = wp_create_nonce('wp_rest');
  $siteLanguage = apply_filters('wpml_current_language', NULL);

  ?> 
    <script>localStorage.setItem('wp_pages', '<?php echo json_encode(get_site_pages(), JSON_HEX_APOS); ?>')</script>
    <script nowprocket>
      window.onclick = function(event) {
        if (!['A', 'BUTTON'].includes(event.target.nodeName)) {
          return;
        }

        const existingEvents = JSON.parse(localStorage.getItem('userEvents') || '[]');

        let target = event.target.href;

        if (event.target.nodeName === 'BUTTON' && event.target.parentElement.classList.contains('booking-mask')) {
          target = 'IBE';
        }

        const clickEvent = {
          eventType: 'click',
          target,
          href: window.location.href
        };

        existingEvents.push(clickEvent);

        localStorage.setItem('userEvents', JSON.stringify(existingEvents));
      };

      const engineBootstrapped = new Event('engineBootstrapped');

      function bootstrapEngine() {
        window.upCoreEngine.bootstrapReact(<?php echo json_encode($settings['theming']); ?>);
        window.upCoreEngine.bootstrapListeners(<?php echo json_encode($settings['features']['bookingSearchMemory']); ?>);
        window.upCoreEngine.bootstrapCurrencySubject(<?php echo json_encode($settings['features']); ?>);

        <?php
          $url = get_site_url();
          if (!(str_contains($url, 'up-dev') || str_contains($url, 'localhost')|| str_contains($url, 'chameleon'))):
        ?>
          window.upCoreEngine.startSession('<?php echo $apiKey ?>').then(() => {
            document.dispatchEvent(engineBootstrapped);
          }).catch((error) => {
            if ((error.response?.data === 'API Key does not correspond to any registered site') || (error.response?.data === 'API Key is invalid: subscription ended')) {
              const blocks = document.querySelectorAll('[class*="wp-block-chameleon"]');
              blocks?.forEach(block => {
                block.remove();
              });
              return;
            } else {
              document.dispatchEvent(engineBootstrapped);
            }
          });
        <?php
          else:
        ?>
          document.dispatchEvent(engineBootstrapped);
        <?php
          endif;
        ?>
      }

      Object.defineProperty(window, 'upCoreEngine', {
        configurable: true,
        set(value) {
          value.restApiUrl = '<?php echo get_rest_url(); ?>';
          value.siteLocale = '<?php echo get_locale(); ?>';
          value.siteLanguage = '<?php echo $siteLanguage ? $siteLanguage : 'en' ?>'
          value.wpNonce = '<?php echo $nonce ?>'
          Object.defineProperty(window, 'upCoreEngine', {value});

          if (document.readyState !== 'complete') {
            document.addEventListener('DOMContentLoaded', async () => {
              bootstrapEngine();
            });
          } else {
            bootstrapEngine();
          }
        }
      });
    </script>
  <?php
  wp_register_script('upcore_engine_js', plugins_url('/main.js', __FILE__));
  wp_enqueue_script('upcore_engine_js');
}

// SETTINGS PAGE CREATION
function plugin_add_settings_link($links) {
  $settings_link = '<a href="options-general.php?page=chameleon">' . __('Settings') . '</a>';
  array_push($links, $settings_link);
  return $links;
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );


require_once( ABSPATH . ('wp-content/plugins/up-engine-plugin/php/admin-settings/settings.php') );

// ACTUAL PLUGIN FUNCTIONALITY

$settings = get_plugin_settings();
$url = get_site_url();

if ((str_contains($url, 'up-dev') || str_contains($url, 'localhost')) || (is_array($settings) && array_key_exists('settings', $settings) && is_array($settings['settings']) && array_key_exists('apiKey', $settings['settings']) && array_key_exists('active', $settings['settings']['apiKey']))) {
  add_action('wp_enqueue_scripts', 'bootstrap_engine');

  require_once( ABSPATH . ('wp-content/plugins/up-engine-plugin/php/functions/register-blocks.php') );
  
  require_once( ABSPATH . ('wp-content/plugins/up-engine-plugin/php/functions/register-api.php') );
}

function dynamicContentBlock() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', async function () {
        window.upCoreEngine.modifyDynamicContentBlock(
          '<?php echo $apiKey ?>',
          <?php echo json_encode($settings['features']['dynamicContentBlock']); ?>
        );
      }, { once: true });
    </script>
  <?php
}

function bookingSearchMemory() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);

  $activateOnGroupSiteMask = $settings['features']['bookingSearchMemory']['activated'] && is_multisite();

  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', function () {
        window.upCoreEngine.bookingSearchMemory(
          <?php echo json_encode($settings['features']['bookingSearchMemory']) ?>,
          '<?php echo $settings['settings']['ibe']['ibeUrl'] ?>',
          <?php echo json_encode($activateOnGroupSiteMask) ?>
        );
      })
    </script>
  <?php
}

function suggestedPagesBlock() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', async function() {
        await window.upCoreEngine.modifyReturnToBlock(
          '<?php echo $settings['settings']['analytics']['gaId'] ?>',
          '<?php echo $apiKey ?>',
          <?php echo json_encode($settings['features']['suggestedPagesBlock']) ?>
        )
      });
    </script>
  <?php
}

function popularRoomsBlock() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);

  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', function () {
        window.upCoreEngine.updateMostPopularRoom(
          '<?php echo $apiKey ?>',
          '<?php echo $settings['settings']['analytics']['gaId'] ?>',
          <?php echo json_encode($settings['features']['popularRoomsBlock']) ?>,
          '<?php echo $settings['settings']['ibe']['ibeUrl'] ?>'
        );
      })
    </script>
  <?php
}

function currencyConversion() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', async function () {
        await window.upCoreEngine.setExchangeRates('<?php echo $apiKey ?>');
        await window.upCoreEngine.modifyCurrencyValues(
          <?php echo json_encode($settings['features']['currencyConversion']) ?>
        );
      });
    </script>
  <?php
}

function smartRoomOrder() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', function () {
        const currentUrl = window.location.href;
        if (currentUrl.includes('/rooms/')) {
          localStorage.setItem('recentlyVisitedRoomUrl', currentUrl);
        }
      })
      document.addEventListener('engineBootstrapped', async function () {
        await window.upCoreEngine.updateRoomGrid(
          <?php echo json_encode($settings['features']['smartRoomOrder']); ?>
        );
      })
    </script>
  <?php
}

function seasonalMedia() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', async function() {
        await window.upCoreEngine.changeToSeasonalMedia(<?php echo json_encode($settings['features']['seasonalMedia']) ?>);
      })
    </script>
  <?php
}

function slideCallout() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', async function() {
        await window.upCoreEngine.renderSlideCallout(<?php echo json_encode($settings['features']['slideCallout']['slideCallout']['items']) ?>);
      })
    </script>
  <?php
}

function promotionModal() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', async function() {
        await window.upCoreEngine.renderPromotionModal(<?php echo json_encode($settings['features']['promotionModal']['promotionModal']['items']) ?>, '<?php echo $settings['settings']['ibe']['ibeUrl'] ?>');
      })
    </script>
  <?php
}

function highlightBar() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script nowprocket>
      document.addEventListener('engineBootstrapped', async function() {
        await window.upCoreEngine.renderHighlightBar(<?php echo json_encode($settings['features']['highlightBar']['highlightBar']['items']) ?>);
      })
    </script>
  <?php
}

function bookingIntentOverlay() {
  $settings = get_plugin_settings();
  $apiKey = create_jwt_token($settings['settings']['apiKey']['value']);
  ?>
    <script>
      document.addEventListener('engineBootstrapped', async function() {
        await window.upCoreEngine.renderBookingIntentOverlay(<?php echo json_encode($settings['features']['bookingIntentOverlay']['bookingIntentOverlay']['items']) ?>, '<?php echo $settings['settings']['ibe']['ibeUrl'] ?>');
      })
    </script>
  <?php
}

function activate_features() {
  $settings = get_plugin_settings();
  if (
    is_array($settings) &&
    array_key_exists('settings', $settings) &&
    is_array($settings['settings']) &&
    array_key_exists('apiKey', $settings['settings']) &&
    array_key_exists('active', $settings['settings']['apiKey']) &&
    $settings['settings']['apiKey']['active'] &&
    array_key_exists('features', $settings)
  ) {  
    $featureList = $settings['features'];

    if (is_array($featureList)) {
      foreach ($featureList as $feature => $featureSettings) {
        if (!is_admin() && $featureSettings['activated'] == true && is_callable($feature)) {
          add_action('wp_head', $feature);
        }
      }
    }
  }
}

activate_features();
