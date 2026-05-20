<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Instagram
 * @subpackage Up_Instagram/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Up_Instagram
 * @subpackage Up_Instagram/includes
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Instagram {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Up_Instagram_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'UP_INSTAGRAM_VERSION' ) ) {
			$this->version = UP_INSTAGRAM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'up-instagram';

		add_action('wp_ajax_up_instagram_pre_auth_request', array($this, 'up_instagram_pre_auth_request'));

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Up_Instagram_Loader. Orchestrates the hooks of the plugin.
	 * - Up_Instagram_Admin. Defines all hooks for the admin area.
	 * - Up_Instagram_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-up-instagram-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-up-instagram-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-up-instagram-public.php';

		$this->loader = new Up_Instagram_Loader();
	}


	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private $plugin_admin; 

	private function define_admin_hooks() {

		$plugin_admin = new Up_Instagram_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'enqueue_display' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_ajax_hooks');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Up_Instagram_Public( $this->get_plugin_name(), $this->get_version(), $this->plugin_admin );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Up_Instagram_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Generate a JWT token.
	 *
	 * @param string $sharedKey The shared secret key.
	 * @param array  $payload   The payload data.
	 * @return string The JWT token.
	 */
	private function generateJwt($sharedKey, $payload) {
		$header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
		$body = base64_encode(json_encode($payload));
		$signature = hash_hmac('sha256', "$header.$body", $sharedKey, true);
		return "$header.$body." . base64_encode($signature);
	}

	/**
	 * Handle the AJAX request to send a pre-auth request.
	 *
	 * @since 1.0.0
	 */
	public function up_instagram_pre_auth_request() {
		
		// Generate the JWT token
		check_ajax_referer('up_instagram_nonce', 'security');
		$sharedKey = UP_INSTAGRAM_SECRET;
		$payload = [
			'timestamp' => time(),
			'nonce' => wp_create_nonce('up_instagram'),
			'site_url' => get_site_url(),
			'plugin_version' => $this->get_version()
		];
		$jwt = $this->generateJwt($sharedKey, $payload);
		$ch = curl_init('https://ig-connect.uphotel.agency');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ['up_instagram_pre_auth' => true,'token' => $jwt]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			wp_send_json_error(['message' => 'cURL error: ' . curl_error($ch)]);
			curl_close($ch);
			return;
		}
		curl_close($ch);
		if($response):
			wp_send_json_success(['response' => json_decode($response, true)]);
		else:
			wp_send_json_success(['response' => 'error']);
		endif;
	}

}
