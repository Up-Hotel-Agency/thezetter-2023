<?php

/**
 * @desc add ACF options page
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Site Options');
}

// Allow unsafe HTML from client side (ACF the_field)
add_filter( 'acf/the_field/allow_unsafe_html', function() { return true; }, 10, 2);

//Disable ACF admin notice about upcoming ACF escape function 
add_filter( 'acf/admin/prevent_escaped_html_notice', '__return_true' );

/**
* @desc auto set licenese key
*/
function acf_auto_set_license_keys() {
  if (!get_option('acf_pro_license')) {
    $save = array(
        'key'	=> 'b3JkZXJfaWQ9NjYxNjZ8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE1LTEwLTA5IDEzOjIzOjI1',
        'url'	=> home_url()
    );
    $save = maybe_serialize($save);
    $save = base64_encode($save);
    update_option('acf_pro_license', $save);
  }
}
add_action('after_switch_theme', 'acf_auto_set_license_keys');

/**
* @desc change dev key when go live
*/
function acf_google_map_api( $api ){
    $hostName = get_site_url();
    if(preg_match('/(up-dev)/',$hostName) || preg_match('/(adaodev)/',$hostName)){
        $api['key'] = 'AIzaSyCb4yfZhPvS3pTzhiVUR3E5jZ7UHNF1HZc';
    }else{
        $api['key'] = 'AIzaSyCb4yfZhPvS3pTzhiVUR3E5jZ7UHNF1HZc';
    }
    return $api;
}
add_filter('acf/fields/google_map/api', 'acf_google_map_api');


/**
 * @desc get link from the cloned link group
 *
 * Example:
 * 
 *
 */

function linkField($field, $function){
    if( $function == 'url') {
        if( $field['link_type'] == 'internal' ) {
            return get_the_permalink( $field['internal_link'] );
        } elseif ( $field['link_type'] == 'custom' ) {
            return $field['external_link'];
        }
    }
    if( $function == 'text') {
        return $field['link_text'];
    }
    if( $function == 'target') {
        if( $field['new_tab'] == true ) {
            return 'target="_blank" rel="noopener"';
        }
    }
}

function isLink($field){
    if( $field['internal_link'] || $field['external_link'] ) {
        return true;
    }
}

/**
 * @desc setup ACF load listeners 
 *
 * Example: 
 * 
 *
 */

function acf_load_listener(){
    echo "
    <script>
    if (document.addEventListener){
        document.addEventListener('DOMContentLoaded', function(){
            if (document.documentElement.classList.contains('no-cssgrid')) {
                    IEneighbourhood();
                    IEgoogleMap();
                    instagram();
            } else {
                // refresh AOS after lazy loading images
                document.addEventListener('lazybeforeunveil', function(e){
                    AOS.refresh();
                });
                // google map on AOS
                document.addEventListener('aos:in:googlemap', function(res) {
                    googleMap();
                });
                // neighbourhood Map on AOS
                document.addEventListener('aos:in:neighbourhood', function(res) {
                    neighbourhood();
                });
                // liteYoutube autoplay on AOS
                document.addEventListener('aos:in:liteYoutube', function(res) {
                    autoPlayLiteYoutube();
                });
                document.addEventListener('aos:in:instagram', function(res) {
                    instagram();
                });
            }
        }, false);
    }
    </script>
    ";

}
