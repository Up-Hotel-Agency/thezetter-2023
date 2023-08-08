<?php

/**
 * @desc disable emojis
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * @desc remove WP version from markup
 */
function remove_wp_version() {
    return '';
}
add_filter('the_generator', 'remove_wp_version');

/**
 * @desc Security - don't expose whether the attempted username exists
 */
function remove_all_login_errors( $error ) {
    return "Incorrect login information. Please try again.";
}
add_filter( 'login_errors', 'remove_all_login_errors');

/**
 * @desc stop tinymce pasting spans and classes
 */
add_filter('tiny_mce_before_init', 'customize_tinymce');
function customize_tinymce($in) {
    $in['paste_preprocess'] = "function(pl,o){ o.content = o.content.replace(/p class=\"p[0-9]+\"/g,'p'); o.content = o.content.replace(/span class=\"s[0-9]+\"/g,'span'); }";
    return $in;
}

/**
 * @desc remove spans around CF7 fields
 */
// add_filter('wpcf7_form_elements', function($content) {
//     $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
//     return $content;
// });

/**
 * @desc Disbale emojis DNS prefetch
 */
if (!function_exists('disable_emojis_remove_dns_prefetch')) {
    function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
        if ('dns-prefetch' == $relation_type) {
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
            $urls = array_diff($urls, array($emoji_svg_url));
        }
        return $urls;
    }
}

/**
 * @desc Security Headers
 */
function security_headers() {
    // the site should only be accessed via HTTPS (comment out when live with SSL)
    // header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains; preload' );
    // stops pages from loading when they detect reflected cross-site scripting (XSS) attacks
    header( 'X-XSS-Protection: 1; mode=block' );
    // this blocks the site being used in an iframe
    header( 'X-Frame-Options: SAMEORIGIN' );
    // defines what data is made available in the Referer header
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    // Set session cookie with HTTPOnly: trust the cookie only by the server, adding extra protection against XSS attacks.
    @ini_set('session.cookie_httponly', true);
    @ini_set('session.cookie_secure', true);
    @ini_set('session.use_only_cookies', true);
}
add_action( 'send_headers', 'security_headers' );

/**
 * @desc enable no sniff
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options
 */
send_nosniff_header();

/**
 * @desc limit revisions on a page to save the DB
 */
if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 20);


/**
 * @desc remove footer admin
 */
function remove_footer_admin () {
    //echo 'Powered by <a href="https://adao.co.uk" target="_blank" rel="noopener">ADAO</a>';
    echo 'Powered by <a href="https://uphotel.agency" target="_blank" rel="noopener">UP Hotel Agency</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');


/**
 * @desc disable WP JSON access to non logged users
 */
add_filter( 'rest_authentication_errors', function( $result ) {
	if ( ! empty( $result ) ) {
		return $result;
	}
	if ( ! is_user_logged_in() ) {
		return new WP_Error( 'restx_logged_out', 'Sorry, you must be logged in to make a request.', array( 'status' => 401 ) );
	}
	return $result;
});