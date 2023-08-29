<?php

/**
 * Fired during plugin activation
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/includes
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Cookie_Consent_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Set default options if they don't exist 
		up_default_options();
	}

}
