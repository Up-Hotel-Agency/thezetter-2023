<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    up_cookie_consent
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function remove_plugin_options_on_uninstall() {
    // Check if Multisite is enabled
    if ( is_multisite() ) {
        global $wpdb;

        // Get all site IDs
        $sites = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

        // Loop through each site
        foreach ( $sites as $site ) {
            switch_to_blog( $site );

            // Get all options with the prefix "up_cookie_consent_"
            $options = wp_load_alloptions();
            foreach ( $options as $option_name => $option_value ) {
                if ( strpos( $option_name, 'up_cookie_consent_' ) === 0 ) {
                    // Delete the option
                    delete_option( $option_name );
                }
            }

            restore_current_blog();
        }
    } else {
        // Get all options with the prefix "up_cookie_consent_"
        $options = wp_load_alloptions();
        foreach ( $options as $option_name => $option_value ) {
            if ( strpos( $option_name, 'up_cookie_consent_' ) === 0 ) {
                // Delete the option
                delete_option( $option_name );
            }
        }
    }
}

remove_plugin_options_on_uninstall();