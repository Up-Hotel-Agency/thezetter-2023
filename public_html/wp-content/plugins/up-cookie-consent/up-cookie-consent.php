<?php

/**
 * @link              https://uphotel.agency
 * @since             1.0.0
 * @package           up_cookie_consent
 *
 * Plugin Name:       UP Cookie Consent
 * Description:       GDPR EU / UK Cookie Consent Plugin
 * Version:           1.0.3
 * Author:            UP Hotel Agency
 * Author URI:        https://uphotel.agency
 * License:           GPL-2.0+
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $up_db_name;
$up_db_name = "up_cookie_consent_";

/**
 * Currently plugin version.
 */
define( 'UP_COOKIE_CONSENT_VERSION', '1.0.3' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-up-cookie-consent-activator.php
 */
function activate_up_cookie_consent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-up-cookie-consent-activator.php';
	Up_Cookie_Consent_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-up-cookie-consent-deactivator.php
 */
function deactivate_up_cookie_consent() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-up-cookie-consent-deactivator.php';
	Up_Cookie_Consent_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_up_cookie_consent' );
register_deactivation_hook( __FILE__, 'deactivate_up_cookie_consent' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-up-cookie-consent.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_up_cookie_consent() {

	$plugin = new Up_Cookie_Consent();
	$plugin->run();

}
run_up_cookie_consent();



/**
 * Global functions
 *
 * Functions that are used in public and admin 
 *
 * @since    1.0.0
 */


//Function to handle multisite 
function up_multisite_setting(){
	global $up_db_name;
	$id = up_main_site_id();
	switch_to_blog($id);
	$response = get_option($up_db_name."multisite_setting");
	restore_current_blog();
	return $response;
}

//Get main site ID
function up_main_site_id(){
	if(is_multisite()){
		return get_main_site_id();
	}
}

//Update option function 
function up_update_option($option = '', $value = '', $blogID = false){
	global $up_db_name;
	//Check if the correct vars passed
	if(!isset($option) || !isset($value)){
		return $error = true;
	}
	if(is_multisite()){
		$id = up_main_site_id();
		if($blogID){
			switch_to_blog($blogID);
				update_option($up_db_name.$option, $value);
			restore_current_blog();
		}elseif(up_multisite_setting()){
			switch_to_blog($id);
				update_option($up_db_name.$option, $value);
			restore_current_blog();
		}else{
			update_option($up_db_name.$option, $value);
		}
	}else{
		update_option($up_db_name.$option, $value);
	}
}

//Get option function
function up_get_option($option = '', $blogID = false){
	global $up_db_name;
	//Check if the correct var passed
	if(!isset($option)){
		return $error = true;
	}
	if(is_multisite()){
		$id = get_main_site_id();
		if($blogID){
			switch_to_blog($blogID);
			$response = get_option($up_db_name.$option);
			restore_current_blog();
			return $response;
		}elseif(up_multisite_setting()){
			switch_to_blog($id);
			$response = get_option($up_db_name.$option);
			restore_current_blog();
			return $response;
		}else{
			return get_option($up_db_name.$option);
		}
	}else{
		return get_option($up_db_name.$option);
	}
}


//Check plugin license
function up_check_license($info = false){
	$response = up_get_option('licence_setting', get_main_site_id());
	if(empty($response)){
		$response = array(false, array(false));
	}
	if($info){
		return $response;
	}else{
		return $response[1][0];
	}
	
}

//Function used to validate plugin license 
function up_validate_license($key = false){

	if(!$key){
		$key = up_check_license(true)[0] ?? false;
	}

	$url = "https://cookieplugin.up-dev.com/call.php";
	$ch = curl_init();
	if ($ch === false) {
		throw new Exception('Failed to initialise');
	}
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('key' => $key)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	$result = curl_exec($ch);
	if (!$result || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
		throw new Exception(curl_error($ch), curl_errno($ch));
	}
	$result = json_decode($result);
	$db = array($key, $result);
	up_update_option('licence_setting', $db, up_main_site_id());

	//Check if license is active and add cron job
	if($result[0]){
		up_license_cron();
	}

	return $result[0] ?? false;
}

function up_license_cron(){
	// Schedule the cron job to run every day at a random time
	if ( ! wp_next_scheduled( 'up_license_validation' ) ) {
		// Generate a random time between 1:00 AM and 11:59 PM
		$rand_hour = rand( 1, 23 );
		$rand_minute = rand( 0, 59 );
		$rand_second = rand( 0, 59 );
		$schedule_time = strtotime( "{$rand_hour}:{$rand_minute}:{$rand_second}" );

		// Schedule the cron job to run at the random time every day
		wp_schedule_event( $schedule_time, 'daily', 'up_license_validation' );
	}
}
// Hook license function into the cron event
add_action( 'up_license_validation', 'up_validate_license' );

//Check for upgrades
if( ! class_exists( 'UPUpdateChecker' ) ) {

	class UPUpdateChecker{

		public $plugin_slug;
		public $version;
		public $cache_key;
		public $cache_allowed;

		public function __construct() {

			$this->plugin_slug = plugin_basename( __DIR__ );
			$this->version = UP_COOKIE_CONSENT_VERSION;
			$this->cache_key = 'up_cookie_consent_custom_upd';
			$this->cache_allowed = false;

			add_filter( 'plugins_api', array( $this, 'info' ), 20, 3 );
			add_filter( 'site_transient_update_plugins', array( $this, 'update' ) );
			add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );

		}

		public function request(){

			$remote = get_transient( $this->cache_key );

			if( false === $remote || ! $this->cache_allowed ) {

				$remote = wp_remote_get(
					'https://cookieplugin.up-dev.com/update.php',
					array(
						'timeout' => 10,
						'headers' => array(
							'Accept' => 'application/json'
						)
					)
				);

				if(
					is_wp_error( $remote )
					|| 200 !== wp_remote_retrieve_response_code( $remote )
					|| empty( wp_remote_retrieve_body( $remote ) )
				) {
					return false;
				}

				set_transient( $this->cache_key, $remote, DAY_IN_SECONDS );

			}

			$remote = json_decode( wp_remote_retrieve_body( $remote ) );

			return $remote;

		}


		function info( $res, $action, $args ) {

			// print_r( $action );
			// print_r( $args );

			// do nothing if you're not getting plugin information right now
			if( 'plugin_information' !== $action ) {
				return $res;
			}

			// do nothing if it is not our plugin
			if( $this->plugin_slug !== $args->slug ) {
				return $res;
			}

			// get updates
			$remote = $this->request();

			if( ! $remote ) {
				return $res;
			}

			$res = new stdClass();

			$res->name = $remote->name;
			$res->slug = $remote->slug;
			$res->version = $remote->version;
			$res->tested = $remote->tested;
			$res->requires = $remote->requires;
			$res->author = $remote->author;
			$res->author_profile = $remote->author_profile;
			$res->download_link = $remote->download_url;
			$res->trunk = $remote->download_url;
			$res->requires_php = $remote->requires_php;
			$res->last_updated = $remote->last_updated;

			$res->sections = array(
				'description' => $remote->sections->description,
				'installation' => $remote->sections->installation,
				'changelog' => $remote->sections->changelog
			);

			if( ! empty( $remote->banners ) ) {
				$res->banners = array(
					'low' => $remote->banners->low,
					'high' => $remote->banners->high
				);
			}

			return $res;

		}

		public function update( $transient ) {

			if ( empty($transient->checked ) ) {
				return $transient;
			}

			$remote = $this->request();

			if(
				$remote
				&& version_compare( $this->version, $remote->version, '<' )
				&& version_compare( $remote->requires, get_bloginfo( 'version' ), '<=' )
				&& version_compare( $remote->requires_php, PHP_VERSION, '<' )
			) {
				$res = new stdClass();
				$res->slug = $this->plugin_slug;
				$res->plugin = plugin_basename( __FILE__ ); // UP-update-plugin/UP-update-plugin.php
				$res->new_version = $remote->version;
				$res->tested = $remote->tested;
				$res->package = $remote->download_url;

				$transient->response[ $res->plugin ] = $res;

	    }

			return $transient;

		}

		public function purge( $upgrader, $options ){

			if (
				$this->cache_allowed
				&& 'update' === $options['action']
				&& 'plugin' === $options[ 'type' ]
			) {
				// just clean the cache when new plugin version is installed
				delete_transient( $this->cache_key );
			}

		}


	}

	new UPUpdateChecker();

}

/**
 * Site Setup functions
 *
 * Functions that are used to enter default content.
 *
 * @since    1.0.0
 */

function up_decode_html_entities($arr) {
	foreach ($arr as $key => $value) {
		if (is_array($value)) {
			$arr[$key] = up_decode_html_entities($value);
		} else {
			$arr[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		}
	}
	return $arr;
}

function up_default_options(){

	//Check if the site has had options set yet.
	if(!up_get_option('site_active')){

		if(!up_get_option('widget_colors')){
			$db_data = array(
				'background' => "#FFFFFF",
				'text' => "#434343",
				'button' => "#0070FF",
				'button-text' => "#FFFFFF"
			);
			up_update_option('widget_colors', $db_data);
		}
		if(!up_get_option('layout')){
			up_update_option('layout', 'floating_notice');
		}
		if(!up_get_option('widget_font')){
			up_update_option('widget_font', true);
		}
		if(!up_get_option('policy_intro')){
			$db_data = array(
				'intro-short' => "We use cookies on our website to give you the most relevant experience by remembering your preferences and repeat visits. By clicking “Accept”, you consent to the use of ALL the cookies.",
				'intro' => "This website uses cookies to improve your experience while you navigate through the website. Out of these cookies, the cookies that are categorized as necessary are stored on your browser as they are essential for the working of basic functionalities of the website. We also use third-party cookies that help us analyze and understand how you use this website. These cookies will be stored in your browser only with your consent. You also have the option to opt-out of these cookies. But opting out of some of these cookies may have an effect on your browsing experience.",
				'link' => "https://yourdomain.com/cookiepolicy",
				'title' => "This website uses cookies to improve your experience",
			);
			up_update_option('policy_intro', $db_data );
		}
		if(!up_get_option('strictly_necessary')){
			$db_data = array(
				'desc' => "We use necessary cookies to ensure our website works properly and provide essential functionalities and security features. These cookies do not collect any personal information and are always enabled. By continuing to use our website, you agree to our use of these cookies.",
				'toggle' => true,
				'default' => true,
				'head' => "",
				'body' => ""
			);
			up_update_option('strictly_necessary', $db_data );
		}
		if(!up_get_option('functional')){
			$db_data = array(
				'desc' => "Functional cookies enable specific functionalities such as social media sharing, feedback collection, and other third-party features. These cookies may collect anonymous data to improve user experience.",
				'toggle' => false,
				'default' => false,
				'head' => "",
				'body' => ""
			);
			up_update_option('functional', $db_data );
		}
		if(!up_get_option('performance_analytics')){
			$db_data = array(
				'desc' => "To enhance user experience, we use performance and analytical cookies to understand and analyze the key performance indexes of our website. Performance cookies help us deliver better user experiences by tracking metrics such as load times and response times. Analytical cookies help us understand how visitors interact with our website by providing information on metrics like the number of visitors, bounce rate, traffic source, and more. ",
				'toggle' => false,
				'default' => false,
				'head' => "",
				'body' => ""
			);
			up_update_option('performance_analytics', $db_data );
		}
		if(!up_get_option('advertisement_targeting')){
			$db_data = array(
				'desc' => "To personalize your online experience, we use advertisement cookies that track your activity across websites and gather information to display relevant ads and marketing campaigns. These cookies help us tailor our advertising to your interests and preferences. ",
				'toggle' => false,
				'default' => false,
				'head' => "",
				'body' => ""
			);
			up_update_option('advertisement_targeting', $db_data );
		}

		up_update_option('site_active', true); //Default content added.

	}

}


