<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Instagram
 * @subpackage Up_Instagram/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Up_Instagram
 * @subpackage Up_Instagram/includes
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Instagram_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook('up_instagram_cron_token_refresh');
		wp_clear_scheduled_hook('up_instagram_cron_update_posts');
	}

}
