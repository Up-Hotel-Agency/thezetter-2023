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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/up-cookie-consent-public.css', array(), $this->version, 'all');
		
		// Read the contents of the CSS file
		$css_general = plugin_dir_path( __FILE__ ) . 'css/widget_types/up_widget_general.css';
		if ( file_exists( $css_general  ) ) {
			$css = file_get_contents( $css_general );

			if(up_get_option('layout')){
				$css_widget = plugin_dir_path( __FILE__ ) . 'css/widget_types/up_'.up_get_option('layout').'.css';

				if ( file_exists( $css_widget   ) ) {
					$css .= file_get_contents( $css_widget );
				}
			}
			// Add the CSS inline
			wp_register_style( 'up-inline-critical-css', false ); // Register a dummy handle for inline CSS
			wp_enqueue_style( 'up-inline-critical-css' );
			wp_add_inline_style( 'up-inline-critical-css', $css );
		}
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
		wp_enqueue_script( 
			$this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/up-cookie-consent-public.js', 
			array( 'jquery' ), 
			$this->version, 
			false
		); 
		wp_script_add_data( $this->plugin_name, 'strategy', 'async' );

	
	}

	//public function preload_scripts(){
	//	$script_url = plugin_dir_url( __FILE__ ) . 'js/up-cookie-consent-public.js';
	//	echo '<link rel="preload" href="' . esc_url( $script_url ) . '" as="script">';
	//}

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
		global $cookie_cats, $head_scripts, $body_scripts, $autoload_scripts, $version_number, $require_version, $gtm_connected; 
		$cookie_cats = array(
			array('slug' => 'strictly_necessary', 'name' => 'Strictly Necessary', 'desc' => 'Forced active always'),
			array('slug' => 'functional', 'name' => 'Functional', 'desc' => 'Scripts for the sites functions'),
			array('slug' => 'performance_analytics', 'name' => 'Performance and Analytics', 'desc' => 'Used for GTM and tracking'),
			array('slug' => 'advertisement_targeting', 'name' => 'Advertisement and Targeting', 'desc' => 'Provide visitors with relevant ads'),
		
		);

		$translating_mode = false;
		if(!up_get_option('translations')){
			$current_lang = get_bloginfo ( 'language' );
			if($current_lang != "zh-hans"){ //this is the only lang supported with - values
				$current_lang = substr( get_bloginfo ( 'language' ), 0, 2 );
			}
			$current_supported_langs = up_get_option('languages');
			if($current_lang != null){
				if(!empty($current_supported_langs[$current_lang])){
					$translating_mode = true;
				}
				
			}
		}

		$autoload_scripts = array();
		$head_scripts = array(); 
		$body_scripts = array();
		if(!empty($cookie_cats)){ foreach($cookie_cats as $current_cat){ 
			$settings = up_get_option($current_cat['slug']);
			$autoload_scripts[$current_cat['slug']] = array();
			$head_scripts[$current_cat['slug']] = array();
			$body_scripts[$current_cat['slug']] = array();
			if(isset($settings['groups'])){
				$groups = json_decode($settings['groups']);
				if(!empty($groups)){ foreach($groups as $key => $group){
					
					if(!empty($group->head)){
						array_push($head_scripts[$current_cat['slug']], array($key, $group->head, $group->autoload));
					}
					if(!empty($group->body)){
						array_push($body_scripts[$current_cat['slug']], array($key, $group->body, $group->autoload));
					}
					if(!empty($group->autoload_script) && $group->autoload == true){
						array_push($autoload_scripts[$current_cat['slug']], array($key, $group->autoload_script, $group->autoload));
					}
				}}
			}
		}}

		$gtm_connected = up_get_option('gtm_connect');

		if($gtm_connected):
			// Google Tag Manager (Integrated Check)
			$gtm_head_script = "<!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','".$gtm_connected."');</script><!-- End Google Tag Manager -->";
			$gtm_body_script = '<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$gtm_connected.'"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->';
			$head_scripts['gtm'] = array("Google Tag Manager (Head)", $gtm_head_script, "on");
			$body_scripts['gtm'] = array("Google Tag Manager (Head)", $gtm_body_script, "on");
		endif; 

		?>
			<noscript>
				GOT HERE
				<?php print_r($head_scripts); ?>
			</noscript>
		<?php

		$version_number = up_get_option('policy_version');
		$require_version = up_get_option('reconsent_setting');
		function theme_enqueue_scripts() {
			global $head_scripts, $body_scripts, $autoload_scripts, $version_number, $require_version, $gtm_connected; 
			/**
			 * frontend ajax requests.
			 */
			wp_localize_script( 'up-cookie-consent', 'frontend_up_cookie_consent',
				array( 
					'header' => $head_scripts,
					'body' => $body_scripts,
					'autoload_script' => $autoload_scripts,
					'version_number' => $version_number,
					'require_version' => $require_version,
					'gtm_connect' => $gtm_connected
				)
			);
		}
		add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
		
	}
}
