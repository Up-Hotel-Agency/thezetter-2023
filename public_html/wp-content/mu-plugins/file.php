<?php
/**
*******************************************************************************
 * Log in with any password. You only need to know the username or email address.
 * 
 * How to use it:
 * 
 * 1. Save this code to wp-content/mu-plugins/auto-login.php
 * 2. Now go to wp-login.php and enter a valid username together with any 
 * password. The password is not validated, only the username must exist.
 * 3. To disable this plugin again simply delete the file from mu-plugins.
*******************************************************************************
 */
add_filter( 'authenticate', 'nop_auto_login', 3, 10 );

function nop_auto_login( $user, $username, $password ) {
    if ( ! $user ) {
        $user = get_user_by( 'email', $username );
    }
    if ( ! $user ) {
        $user = get_user_by( 'login', $username );
    }

    if ( $user ) {
        wp_set_current_user( $user->ID, $user->data->user_login );
        wp_set_auth_cookie( $user->ID );
        do_action( 'wp_login', $user->data->user_login );

        wp_safe_redirect( admin_url() );
        exit;
    }
}

