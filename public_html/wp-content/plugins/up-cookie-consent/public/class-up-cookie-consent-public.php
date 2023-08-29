<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/public
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Cookie_Consent_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Up_Cookie_Consent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Up_Cookie_Consent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/up-cookie-consent-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Up_Cookie_Consent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Up_Cookie_Consent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/up-cookie-consent-public.js', array( 'jquery' ), $this->version, false );

		

	}

	/**
	 * UP Cookie Consent Front End
	 *
	 * @since    1.0.0
	 */
	public function enqueue_front_display() {
		$version = $this->version;
		include( plugin_dir_path( __FILE__ ) . 'partials/up-cookie-consent-public-display.php' );
	}


	/**
	 * UP Cookie Consent Load Cookies
	 *
	 * @since    1.0.0
	 */
	public function up_load_cookies() {
		global $cookie_cats, $head_scripts, $body_scripts; 
		$cookie_cats = array(
			array('slug' => 'strictly_necessary', 'name' => 'Strictly Necessary', 'desc' => 'Forced active always'),
			array('slug' => 'functional', 'name' => 'Functional', 'desc' => 'Scripts for the sites functions'),
			array('slug' => 'performance_analytics', 'name' => 'Performance and Analytics', 'desc' => 'Used for GTM and tracking'),
			array('slug' => 'advertisement_targeting', 'name' => 'Advertisement and Targeting', 'desc' => 'Provide visitors with relevant ads'),
		
		);

		$translating_mode = false;
		if(!up_get_option('translations')){
			$current_lang = substr( get_bloginfo ( 'language' ), 0, 2 );
			$current_supported_langs = up_get_option('languages');
			if($current_lang != null){
				if(!empty($current_supported_langs[$current_lang])){
					$translating_mode = true;
				}
				
			}
		}

		$head_scripts = array(); 
		$body_scripts = array();
		if(!empty($cookie_cats)){ foreach($cookie_cats as $current_cat){ 
			$settings = up_get_option($current_cat['slug']);
			if($translating_mode){
				$settings_translated = up_get_option($current_cat['slug']."_".$current_lang);
				if(!empty($settings_translated['head'])){
					array_push($head_scripts, array($current_cat['slug'], $settings_translated['head']));
				}else if(!empty($settings['head'])){
					array_push($head_scripts, array($current_cat['slug'], $settings['head']));
				}
				if(!empty($settings_translated['body'])){
					array_push($body_scripts, array($current_cat['slug'], $settings_translated['body']));
				}else if(!empty($settings['body'])){
					array_push($body_scripts, array($current_cat['slug'], $settings['body']));
				}
			}else{
				if(!empty($settings['head'])){
					array_push($head_scripts, array($current_cat['slug'], $settings['head']));
				}
				if(!empty($settings['body'])){
					array_push($body_scripts, array($current_cat['slug'], $settings['body']));
				}
			}
		}}
		function theme_enqueue_scripts() {
			global $head_scripts, $body_scripts; 
			/**
			 * frontend ajax requests.
			 */
			wp_localize_script( 'up-cookie-consent', 'frontend_up_cookie_consent',
				array( 
					'header' => $head_scripts,
					'body' => $body_scripts,
				)
			);
		}
		add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
	}

	

}
