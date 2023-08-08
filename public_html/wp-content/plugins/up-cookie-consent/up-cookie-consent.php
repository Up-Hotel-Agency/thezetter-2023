<?php

/**
 * @link              https://uphotel.agency
 * @since             1.0.0
 * @package           Up_Cookie_Consent
 *
 * @wordpress-plugin
 * Plugin Name:       UP Cookie Consent
 * Plugin URI:        https://uphotel.agency
 * Description:       Replace me description
 * Version:           1.0.0
 * Author:            UP Hotel Agency
 * Author URI:        https://uphotel.agency
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       up-cookie-consent
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'UP_COOKIE_CONSENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-up-cookie-consent-activator.php
 */
function activate_up_cookie_consent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-up-cookie-consent-activator.php';
	Up_Cookie_Consent_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-up-cookie-consent-deactivator.php
 */
function deactivate_up_cookie_consent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-up-cookie-consent-deactivator.php';
	Up_Cookie_Consent_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_up_cookie_consent' );
register_deactivation_hook( __FILE__, 'deactivate_up_cookie_consent' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-up-cookie-consent.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_up_cookie_consent() {

	$plugin = new Up_Cookie_Consent();
	$plugin->run();

}
run_up_cookie_consent();
