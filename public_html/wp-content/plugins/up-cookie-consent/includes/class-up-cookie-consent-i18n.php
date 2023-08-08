<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Cookie_Consent
 * @subpackage Up_Cookie_Consent/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Up_Cookie_Consent
 * @subpackage Up_Cookie_Consent/includes
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Cookie_Consent_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'up-cookie-consent',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
