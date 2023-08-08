<?php

/**
 * @desc add ACF options page
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Site Options');
}

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
 * @desc Load all SVGs from <theme dir>/autoload-svgs/
 *
 * Example:
 * add_filter('acf/load_field/name=autoloaded_icon', 'up_load_icon_choices');
 *
 * ensure your field is named 'autoloaded_icon' if using the direct example above
 *
 */
function up_load_icon_choices($field) {
    $path = __DIR__ . '/' . '../autoload-svgs/';
    $field['choices'] = array();

    if(!is_dir($path)){
        return $field;
    }

    $svgsUnprocessed = scandir($path);

    $svgs = array_filter($svgsUnprocessed, function($svg){
        return (substr($svg, -4) == '.svg');
    });

    foreach($svgs as $svg){
        $friendlyName = basename($svg, '.svg');
        $svgContents = file_get_contents($path . $svg);
        $field['choices'][ $svgContents ] = $friendlyName;
    }

    return $field;
}
add_filter('acf/load_field/name=autoloaded_icon', 'up_load_icon_choices');


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
