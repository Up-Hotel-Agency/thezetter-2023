<?php
/**
 * Plugin Name:       UP Booking Engine
 * Plugin URI:        https://github.com/apaleo/ibe-wordpress-plugin
 * Description:       Integrates the UP Booking Engine widget into a WordPress site
 * Version:           1.2.0
 * Author:            UP Hotel Agency
 * Author URI:        www.uphotel.agency
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       up-ibe
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.2.0' );


function ibe_snippet($environment, $args, $extra_attributes){

switch ($environment) {
	case 'development':
		$domain = 'apaleo.local:3000';
		break;
	case 'staging':
		$domain = 'staging.uphotel.agency';
		break;
	default:
		$domain = 'uphotel.agency';
		break;
}

$ibeTag = <<<HEREDOC
<ibe-up 
    ibe-key="{$args['ibe_key']}"
    language="{$args['language']}" 
    $extra_attributes></ibe-up>
HEREDOC;

$otherTagsProduction = <<<HEREDOC
<script type="text/javascript" src="https://ibe.$domain/ibe.min.js"></script>
<link href="https://ibe.$domain/ibe.min.css" rel="stylesheet" />
HEREDOC;

$otherTagsStaging = <<<HEREDOC
<script type="text/javascript" src="https://ibe.$domain/runtime.js"></script>
<script type="text/javascript" src="https://ibe.$domain/polyfills.js"></script>
<script type="text/javascript" src="https://ibe.$domain/scripts.js"></script>
<script type="text/javascript" src="https://ibe.$domain/vendor.js"></script>
<script type="text/javascript" src="https://ibe.$domain/main.js"></script>

<link href="https://ibe.$domain/styles.css" rel="stylesheet" />
HEREDOC;

if($environment == 'staging'){
    return $ibeTag . $otherTagsStaging;
}else{
    return $ibeTag . $otherTagsProduction;
}

}

add_shortcode( 'up-booking-engine', function( $attributes ) {

    $args = shortcode_atts(array(
        "ibe_key" => '',
        "mask_redirect_path" => false,
        "language" => '',
        "default_property_id" => false,
        "environment" => 'production'
    ), $attributes);

    $extra_attributes = '';
    if($args['mask_redirect_path'] !== false){
        $extra_attributes .= " mask-redirect-path=\"{$args['mask_redirect_path']}\" ";
    }

	if($args['default_property_id'] !== false){
		$extra_attributes .= " default-property-id=\"{$args['default_property_id']}\" ";
	}

    return ibe_snippet($args['environment'], $args, $extra_attributes);
});

