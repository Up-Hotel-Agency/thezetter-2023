<?php

/**
 * Fired during plugin activation
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Instagram
 * @subpackage Up_Instagram/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Up_Instagram
 * @subpackage Up_Instagram/includes
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Instagram_Activator {

	/**
	 * 
	 * @since    1.0.0
	 */
	public static function activate() {

		//Add in cron events

		if (!wp_next_scheduled('up_instagram_cron_token_refresh')) {
            wp_schedule_event(time(), 'weekly', 'up_instagram_cron_token_refresh');
        }
		
		if (!wp_next_scheduled('up_instagram_cron_update_posts')) {
            wp_schedule_event(time(), 'weekly', 'up_instagram_cron_update_posts');
        }

	}	

}
