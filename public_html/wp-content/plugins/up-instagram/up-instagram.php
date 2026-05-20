<?php

/**
 * @link              https://uphotel.agency
 * @since             1.0.0
 * @package           Up_Instagram
 *
 * @wordpress-plugin
 * Plugin Name:       UP Instagram
 * Plugin URI:        https://instagram.up-dev.com
 * Description:       Connects your instagram feeds to Wordpress.
 * Version:           1.0.0
 * Author:            UP Hotel Agency
 * Author URI:        https://uphotel.agency/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       up-instagram
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
global $up_ig_db_name;
$up_ig_db_name = "up_instagram_";
define( 'UP_INSTAGRAM_VERSION', '1.0.0' );
define( 'UP_INSTAGRAM_SECRET', 'hF$d3JA)D)42(c1*)q3bMsb!' );

function activate_up_instagram() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-up-instagram-activator.php';
	Up_Instagram_Activator::activate();
}

function deactivate_up_instagram() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-up-instagram-deactivator.php';
	Up_Instagram_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_up_instagram' );
register_deactivation_hook( __FILE__, 'deactivate_up_instagram' );

require plugin_dir_path( __FILE__ ) . 'includes/class-up-instagram.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_up_instagram() {

	$plugin = new Up_Instagram();
	$plugin->run();

}
run_up_instagram();

/**
 * Global functions
 *
 * Functions that are used in public and admin 
 *
 * @since    1.0.0
 */

//Get main site ID
function up_ig_main_site_id(){
	if(is_multisite()){
		return get_main_site_id();
	}
}

//Update option function 
function up_ig_update_option($option = '', $value = '', $blogID = false){
	global $up_ig_db_name;
	//Check if the correct vars passed
	if(!isset($option) || !isset($value)){
		return $error = true;
	}
	if(is_multisite()){
		$id = up_ig_main_site_id();
		if($id){
			switch_to_blog($id);
				update_option($up_ig_db_name.$option, $value);
			restore_current_blog();
		}else{
			update_option($up_ig_db_name.$option, $value);
		}
	}else{
		update_option($up_ig_db_name.$option, $value);
	}
}

//Get option function
function up_ig_get_option($option = '', $blogID = false){
	global $up_ig_db_name;
	//Check if the correct var passed
	if(!isset($option)){
		return $error = true;
	}
	if(is_multisite()){
		$id = get_main_site_id();
		if($id){
			switch_to_blog($id);
			$response = get_option($up_ig_db_name.$option);
			restore_current_blog();
			return $response;
		}else{
			return get_option($up_ig_db_name.$option);
		}
	}else{
		return get_option($up_ig_db_name.$option);
	}
}

/**
 * Functions accessible outside of plugin
 *
 * Used for getting data to the WP theme
 *
 * @since    1.0.0
*/

function up_instagram_account($username = false){
	$accounts = up_ig_get_option('accounts');
	if($username):
		if(isset($accounts[$username])):
			$accounts = array($accounts[$username]);
		else:
			return false;
		endif; 
	endif;
	return $accounts;
}

function up_instagram($username = false, $args = []){

	//Instagram cache directory
	$dir = content_url() . '/up-instagram-cache/';

	//Define supported types
	$type_map = array(
		'IMAGE' => 'image',
		'VIDEO' => 'video',
		'CAROUSEL_ALBUM' => 'carousel'
	);

	//Define supported sizes
	$size_map = array('high', "medium", "low", "original");

	//Define arguments & defaults
	$account = isset($username) ? $username : false; // Required
	$size =  isset($args['size']) ? strtolower($args['size']) : "high"; // Set output size
	$types = isset($args['types']) ? $args['types'] : array('image', 'video', 'carousel'); // Supported types
	$captions = isset($args['captions']) ? $args['captions'] : true; // Include captions
	$permalink = isset($args['permalink']) ? $args['permalink'] : true; // Include direct link
	$likes = isset($args['likes']) ? $args['likes'] : false; // Include like count
	$comments = isset($args['comments']) ? $args['comments'] : false; // Include comments count
	$timestamp = isset($args['timestamp']) ? $args['timestamp'] : false; // Include comments count
	$limit = isset($args['limit']) ? $args['limit'] : false; // Include comments count

	if(!in_array($size, $size_map)): return false; endif;

	if($account){
		$accounts = up_ig_get_option('accounts');
		if(isset($accounts[$account]['media'])):
			$data = $accounts[$account]['media'];
			$return = array();
			$count=1;
			foreach($data as $id=>$item):

				if($limit && $limit < $count): break; endif;

				$type = isset($type_map[$item['type']]) ? $type_map[$item['type']] : false;
				$to_be_added = array();
				if($type == "image" && in_array($type, $types)):
					$link = $dir .$username."/".$id."/".$size.".jpg";
				endif;
				if($type == "carousel" && in_array($type, $types)):
					$link = $dir .$username."/".$id."/".$size.".jpg";
				endif;
				if($type == "video" && in_array($type, $types)):
					$link = $dir .$username."/".$id."/".$size.".jpg";
				endif;
				if($link):
					$to_be_added = array(
						"type" => $type,
						"src" => $link,
					);
					if($captions):
						$to_be_added['caption'] = $item['caption'];
					endif; 
					if($permalink):
						$to_be_added['permalink'] = $item['permalink'];
					endif; 
					if($likes):
						$to_be_added['likes'] = $item['like_count'];
					endif; 
					if($comments):
						$to_be_added['comments'] = $item['comments_count'];
					endif;
					if($timestamp):
						$to_be_added['timestamp'] = $item['timestamp'];
					endif;
					array_push($return, $to_be_added); 
				endif;
			$count++; endforeach;
			return $return;
		endif;
	}
	return array();	
}

//Check for upgrades

/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/



function custom_cron_schedules($schedules) {
	$schedules['every_1_minute'] = [
		'interval' => 60,
		'display'  => __('Every 1 Minute')
	];
	return $schedules;
}
add_filter('cron_schedules', 'custom_cron_schedules');
