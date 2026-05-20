<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Instagram
 * @subpackage Up_Instagram/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Up_Instagram
 * @subpackage Up_Instagram/admin
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Instagram_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/up-instagram-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/up-instagram-admin.js', array( 'jquery' ), $this->version, false );
		
		wp_localize_script(
			$this->plugin_name, 
			'upInstagramAjax', 
			array(
				'ajaxurl' => admin_url('admin-ajax.php'), 
				'security' => wp_create_nonce('up_instagram_nonce'),
			)
		);
	}

	/**
	 * Register the Settings for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_display() {
		$version = $this->version;
	
		// Add the settings page under the "Settings" menu
		add_options_page(
			'UP Instagram Settings',      
			'UP Instagram',         
			'manage_options',   
			'up-instagram',        
			[$this, 'page_admin']         
		);
	}
	
	public function page_admin() {
		$admin_instance = $this;
		include(plugin_dir_path(__FILE__) . 'partials/up-instagram-admin-display.php');
	}

	public function up_instagram_curl_request($account = [], $endpoint = false) {

		$url = "";
		if($endpoint == "basic"){
			$url = "https://graph.instagram.com/v17.0/".$account['user_id']."?fields=username,profile_picture_url,followers_count,follows_count,media_count&access_token=".$account['access_token'];
		}elseif($endpoint == "refresh_token"){
			$url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=".$account['access_token'];
		}elseif($endpoint == "media"){
			$url = "https://graph.instagram.com/".$account['user_id']."/media?fields=media_url,thumbnail_url,caption,id,media_type,timestamp,username,comments_count,like_count,permalink,children%7Bmedia_url,id,media_type,timestamp,permalink,thumbnail_url%7D&limit=10&access_token=".$account['access_token'];
		}

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
		if(!$data): $data = $response; endif;
		return $data;
	}

	/**
	 * Connect to instagram graph API to get basic account details
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_basic_details($key = false, $userId = false) {

		$data = $this->up_instagram_curl_request(array(
			'access_token' => $key,
			'user_id' => $userId
			),
			'basic'
		);
		return $data;
	}

	/**
	 * Refresh user access token using Instagram API
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_refresh_token($key = false) {

		$data = $this->up_instagram_curl_request(array(
			'access_token' => $key,
			'user_id' => false
			),
			'refresh_token'
		);
		return $data;
	}

	/**
	 * Get registered accounts
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_accounts($username = false) {
		$accounts = up_ig_get_option('accounts');
		if($username):
			$accounts = array($accounts[$username]);
		endif; 
		if(!$accounts): $accounts = array(); endif;
		return $accounts;
	}



	/**
	 * Delete cached files from user directory 
	 * 
	 * Removes entire user dir or post dir
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_delete_cache_folder($username = false, $postID = false) {
		if(!$username): return false; endif;
		if($postID): 
			$dir = WP_CONTENT_DIR . '/up-instagram-cache/' . sanitize_file_name($username) . '/' . $postID;
		else:
			$dir = WP_CONTENT_DIR . '/up-instagram-cache/' . sanitize_file_name($username);
		endif;
		if (!is_dir($dir)) {
			return false;
		}
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($files as $fileinfo) {
			$todo = ($fileinfo->isDir()) ? 'rmdir' : 'unlink';
			$todo($fileinfo->getRealPath());
		}
		return rmdir($dir);
	}
	
	/**
	 * Download profile photo from Instagram
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_download_profile_photo($image_url = false, $username = false) {
		
		$username = sanitize_file_name($username);
		$upload_dir = WP_CONTENT_DIR . '/up-instagram-cache/' . $username;
		$upload_url = content_url('up-instagram-cache/' . $username);
		$file_path = $upload_dir . '/profile.jpg';
	
		if (!wp_mkdir_p($upload_dir)) {
			return false;
		}

		$temp_file = download_url($image_url);
		if (is_wp_error($temp_file)) {
			return false;
		}
	
		if (!@rename($temp_file, $file_path)) {
			@unlink($temp_file); 
			return false;
		}
	
		return $upload_url . '/profile.jpg'; 
	}
	


	/**
	 * Download image posts from instagram
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_download_post_image($image_url = false, $image_id = false, $username = false) {
		$upload_dir = WP_CONTENT_DIR . '/up-instagram-cache/' . sanitize_file_name($username) . '/' . $image_id;
		$upload_url = content_url('up-instagram-cache/' . sanitize_file_name($username) . '/' . $image_id);
		
		if (!wp_mkdir_p($upload_dir)) {
			return false;
		}
		
		$temp_file = download_url($image_url);
		if (is_wp_error($temp_file)) {
			return false;
		}
		
		$file_name = basename(parse_url($image_url, PHP_URL_PATH));
		$file_ext = "." . pathinfo($file_name, PATHINFO_EXTENSION);
		$file_path = $upload_dir . '/original' . $file_ext;
		
		$move_result = rename($temp_file, $file_path);
		if (!$move_result) {
			@unlink($temp_file);
			return false;
		}

		// Generate image sizes
		$editor = wp_get_image_editor($file_path);
		if (is_wp_error($editor)) {
			return false;
		}
		
		$sizes = array(
			array('width' => 150, 'height' => 150, 'crop' => true, 'quality' => 'low'),
			array('width' => 300, 'height' => 300, 'crop' => false, 'quality' => 'medium'),
			array('width' => 1024, 'height' => 1024, 'crop' => false, 'quality' => 'high'),
		);
		
		$generated_sizes = array();
		
		foreach ($sizes as $size) {
			$editor->resize($size['width'], $size['height'], $size['crop']);
			$resized_file_path = $upload_dir . '/' . $size['quality'] . $file_ext;
			$resized = $editor->save($resized_file_path);
			
			if (is_wp_error($resized)) {
				return false;
			}
			
			$generated_sizes[] = $upload_url . '/' . $size['quality'] . $file_ext;
			
			// Reload the original image for the next resize
			$editor = wp_get_image_editor($file_path);
			if (is_wp_error($editor)) {
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Download media from API response
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_download_post($post = false) {
		if($post):
			if(isset($post['username'])):
				$username = $post['username'];
				if($post['media_type'] === 'IMAGE'):
					$response = $this->up_instagram_download_post_image($post['media_url'], $post['id'], $username);
					if($response):
						return array('image', $post['id']);
					endif;
				endif;
				if($post['media_type'] === 'VIDEO'):
					$response = $this->up_instagram_download_post_image($post['thumbnail_url'], $post['id'], $username);
					if($response):
						return array('image', $post['id']);
					endif;
				endif;
				if($post['media_type'] === 'CAROUSEL_ALBUM'):
					if(isset($post['children']['data'][0]['media_url'])):
						$response = $this->up_instagram_download_post_image($post['children']['data'][0]['media_url'], $post['id'], $username);
						if($response):
							return array('image', $post['id']);
						endif;
					endif; 
				endif;
			endif;
		endif;
		return false;
	}

	/**
	 * Handle errors for accounts
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_handle_error($username = false, $error = false) {
	
	}

	/**
	 * Get instagram account details from API
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_fetch_account_details($username = false) {
		$accounts = $this->up_instagram_accounts();
		foreach($accounts as $name=>$account):
			if ($username && $username != $name) continue;
			$data = $this->up_instagram_basic_details($account['access_token'], $account['user_id']);
			if(!isset($data['username'])):  
				$accounts[$name]['connected'] = false;
				$accounts[$name]['error'] = $data;
				continue;
			endif;
			$pp_url = $this->up_instagram_download_profile_photo($data['profile_picture_url'], $data['username']);
			$accounts[$name]['last_sync'] = date('d/m/Y H:i');
			$accounts[$name]['profile_photo'] = $pp_url ?? false;
			$accounts[$name]['posts'] = $data['media_count'] ?? false;
			$accounts[$name]['followers'] = $data['followers_count'] ?? false;
			$accounts[$name]['following'] = $data['follows_count'] ?? false;
		endforeach;
		up_ig_update_option('accounts', $accounts);
	}

	/**
	 * Get instagram posts from API
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_fetch_posts($username = false) {
		$accounts = $this->up_instagram_accounts();
		foreach($accounts as $name=>$account):
			if ($username && $username != $name) continue;
			$data = $this->up_instagram_curl_request(array(
				'access_token' => $account['access_token'],
				'user_id' => $account['user_id'],
				),
				'media'
			);
			if(isset($data['data'])):
				$media = $accounts[$name]['media'] ?? array();
				foreach($data['data'] as $post):
					$response = false;
					//Only download if required
					if(!isset($media[$post['id']])):
						$response = $this->up_instagram_download_post($post);
					else:
						$response = true;
					endif;
					if($response):
						$media[$post['id']] = array(
							"type" => $post['media_type'] ?? false,
							"caption" => $post['caption'] ?? false,
							"permalink" => $post['permalink'] ?? false,
							"like_count" => $post['like_count'] ?? 0,
							"comments_count" => $post['comments_count'] ?? 0,
							"timestamp" => $post['timestamp'] ?? false
						);
					endif;
				endforeach;

				//Checking for valid posts 
				$valid_ids = array_column($data['data'], 'id');
				$remove_post_ids = array_diff(array_keys($media), $valid_ids);
				$media = array_intersect_key($media, array_flip($valid_ids));

				if($remove_post_ids && is_array($remove_post_ids)):
					foreach($remove_post_ids as $postID):
						$this->up_instagram_delete_cache_folder($name, $postID);
					endforeach;
				endif;

				if($media && $name):
					$accounts[$name]['media'] = $media;
					$accounts[$name]['last_sync'] = date('d/m/Y H:i');
					up_ig_update_option('accounts', $accounts);
				endif;
			endif;
		endforeach;
	}


	/**
	 * Removes a instagram account using username
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_remove_account($username = false) {
		$accounts = up_ig_get_option('accounts');
		if(!$accounts){ $accounts = array(); }
		if($username){
			if(isset($accounts[$username])){
				unset($accounts[$username]);
				$this->up_instagram_delete_cache_folder($username);
				up_ig_update_option('accounts', $accounts);
				return true;
			}
		}
		return false;
	}

	/**
	 * Adds a new instagram account using access token 
	 *
	 * @since    1.0.0
	*/
	public function up_instagram_add_account($key = false, $userId = false) {

		$accounts = up_ig_get_option('accounts');
		if(!$accounts){ $accounts = array(); }

		$data = $this->up_instagram_basic_details($key, $userId);
		if(!isset($data['username'])): return false; endif; 

		$pp_url = $this->up_instagram_download_profile_photo($data['profile_picture_url'], $data['username']);

		$accounts[$data['username']] = array(
			"connected" => true,
			"last_sync" => date('d/m/Y H:i'),
			"access_token" => $key,
			"access_token_last_refreshed" => time(),
			"user_id" => $userId,
			"profile_photo" => $pp_url ?? false,
			"posts" => $data['media_count'] ?? false,
			"followers" => $data['followers_count'] ?? false,
			"following" => $data['follows_count'] ?? false,
			"media" => array(),
			"error" => false
		);

		up_ig_update_option('accounts', $accounts);

		return $data['username']; 
		
	}

	/**
	 * URL hooks for accepting new access tokens from ig-connect
	 *
	 * @since    1.0.0
	*/
	public function handle_query_parameters() {

		if(isset($_GET['testing'])):
			$this->up_instagram_fetch_posts();
		//	$this->up_instagram_fetch_account_details('uphotelagency');
		endif; 

		if (isset($_GET['page']) && $_GET['page'] === 'up-instagram') {
			if (isset($_GET['add_new_key']) && $_GET['add_new_key'] == 1 && isset($_GET['key']) && isset($_GET['nonce']) && isset($_GET['userid'])) {
		
				$key = sanitize_text_field($_GET['key']);
				$userId = sanitize_text_field($_GET['userid']);
				$nonce = sanitize_text_field($_GET['nonce']);

				if (!wp_verify_nonce($nonce, 'up_instagram')) {
					wp_die(__('Invalid nonce. Please try again.', 'plugin-name-textdomain'));
				}
				$username = $this->up_instagram_add_account($key, $userId);
				$this->up_instagram_fetch_posts($username);
				wp_redirect(admin_url('options-general.php?page=up-instagram'));
				exit;
			}
		}
	}


	/**
	 * WP Cron functions for mantaining feeds and access 
	 *
	 * @since    1.0.0
	*/

	public function run_cron_update_posts() {
		$this->up_instagram_fetch_posts();
		$this->up_instagram_fetch_account_details();
	}

	public function run_cron_token_refresh() {
		$accounts = up_ig_get_option('accounts');
		if(!$accounts){ $accounts = array(); }
		foreach($accounts as $name=>$account):
			if(isset($accounts[$name]['access_token_last_refreshed'])):
				if($accounts[$name]['access_token_last_refreshed'] > strtotime('-25 days')):
					continue; //Skip if already completed less than 25 days ago
				endif;
			endif;
			$response = $this->up_instagram_refresh_token($account['access_token']);
			if($response):
				$accounts[$name]['access_token_last_refreshed'] = time();
			endif;
		endforeach;
		up_ig_update_option('accounts', $accounts);
	}

	/**
	 * WP Ajax Admin for front end admin requests
	 *
	 * @since    1.0.0
	*/

	public function register_ajax_hooks() {
		add_action('wp_ajax_up_instagram_ajax_request', array($this, 'up_instagram_handle_ajax_request'));
	}

	public function up_instagram_handle_ajax_request() {
		if(isset($_REQUEST)):
			if(isset($_REQUEST['account']) && isset($_REQUEST['request'])):
				if($_REQUEST['request'] == "sync"):
					$this->up_instagram_fetch_posts($_REQUEST['account']);
					$this->up_instagram_fetch_account_details($_REQUEST['account']);
					wp_send_json_success();
				endif;
				if($_REQUEST['request'] == "remove"):
					$response = $this->up_instagram_remove_account($_REQUEST['account']);
					if($response):
					wp_send_json_success();
					endif;
				endif;
			endif;
			if(isset($_REQUEST['display_accounts'])):
				ob_start(); 
				$this->up_instagram_display_accounts();
				$html_output = ob_get_clean(); 
				wp_send_json_success(array('html' => $html_output));
			endif;
		endif;
		wp_send_json_error();
		die();
	}

	public function up_instagram_display_accounts(){
		$accounts = $this->up_instagram_accounts() ?? array();
		$error = false;
		if(is_array($accounts)):
			foreach($accounts as $account):
				if($account['error']): $error = true; endif;
			endforeach;
		endif;
		?>
			<?php if($error): ?>
				<div class="up-instagram-notices">
					<div class="up-instagram-notice up-notice-error">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.437 3.283l9.383 16.949a.5.5 0 0 1-.437.742H2.617a.5.5 0 0 1-.437-.742l9.383-16.949a.5.5 0 0 1 .874 0zM12 15.618V8.389" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><circle cx="12" cy="18.31" r="1" fill="currentColor"/></svg>
						<p><b>Some of your accounts weren't able to sync with Instagram.</b><br> To resolve this issue, review the list below or contact support. In the meantime, we'll still display posts that were previosuly collected.</p>
					</div>
				</div>
			<?php endif; ?>
			<div class="up-instagram-accounts-wrap">
				<div class="up-instagram-accounts">
					<?php if(!$accounts): ?>
					<div class="up-instagram-account-first">
						<div class="up-instagram-graphic">
							<svg xmlns="http://www.w3.org/2000/svg" width="720" height="722.539" viewBox="0 0 720 722.539" xmlns:xlink="http://www.w3.org/1999/xlink" role="img" artist="Katerina Limpitsouni" source="https://undraw.co/">  <g id="Group_64" data-name="Group 64" transform="translate(-600.001 -166)">    <g id="Group_63" data-name="Group 63" transform="translate(39.127 -21.613)">      <path id="Path_1-824" data-name="Path 1" d="M275.321,690.449,270.949,673.2a223.916,223.916,0,0,0-23.758-8.524l-.552,8.015-2.238-8.83c-10.012-2.862-16.824-4.121-16.824-4.121s9.2,34.987,28.5,61.735l22.486,3.95-17.469,2.519a90.608,90.608,0,0,0,7.811,8.28c28.072,26.057,59.34,38.013,69.838,26.7s-3.749-41.6-31.822-67.656c-8.7-8.078-19.635-14.56-30.579-19.664Z" transform="translate(417.297 140.418)" fill="#f2f2f2"/>      <path id="Path_2-825" data-name="Path 2" d="M345.1,652.214l5.171-17.023a223.933,223.933,0,0,0-15.931-19.578l-4.615,6.576,2.648-8.716c-7.093-7.623-12.273-12.221-12.273-12.221s-10.208,34.706-7.516,67.579l17.207,15-16.259-6.874a90.606,90.606,0,0,0,2.409,11.128c10.562,36.817,31.149,63.214,45.982,58.958s18.295-37.551,7.732-74.368c-3.274-11.414-9.283-22.614-16.013-32.638Z" transform="translate(389.102 159.921)" fill="#f2f2f2"/>    </g>    <g id="Group_62" data-name="Group 62" transform="translate(44.037 -0.462)">      <path id="Path_22-826" data-name="Path 22" d="M734.978,247.559h-3.956V139.187A62.725,62.725,0,0,0,668.3,76.462H438.687a62.725,62.725,0,0,0-62.725,62.725V733.736a62.725,62.725,0,0,0,62.725,62.725H668.3a62.725,62.725,0,0,0,62.724-62.724V324.7h3.956Z" transform="translate(360 90)" fill="#e6e6e6"/>      <path id="Path_23-827" data-name="Path 23" d="M671.423,93.336H641.454a22.255,22.255,0,0,1-20.607,30.659H489.306A22.254,22.254,0,0,1,468.7,93.335H440.708a46.843,46.843,0,0,0-46.843,46.843V733.864a46.843,46.843,0,0,0,46.843,46.843H671.423a46.843,46.843,0,0,0,46.843-46.843h0V140.177a46.843,46.843,0,0,0-46.842-46.842Z" transform="translate(359.405 89.439)" fill="#fff"/>      <path id="Path_6-828" data-name="Path 6" d="M530.421,337.151a23.626,23.626,0,0,1,11.827-20.472,23.637,23.637,0,1,0,0,40.939,23.621,23.621,0,0,1-11.823-20.467Z" transform="translate(355.65 82.117)" fill="#ccc"/>      <path id="Path_7-829" data-name="Path 7" d="M561.158,337.151a23.625,23.625,0,0,1,11.827-20.472,23.637,23.637,0,1,0,0,40.939,23.621,23.621,0,0,1-11.823-20.467Z" transform="translate(354.627 82.117)" fill="#ccc"/>      <circle id="Ellipse_1" data-name="Ellipse 1" cx="23.637" cy="23.637" r="23.637" transform="translate(921.189 395.631)" fill="#1b556d"/>      <path id="Path_8-830" data-name="Path 8" d="M627.963,409.252H490.2a4.953,4.953,0,0,1-4.947-4.947V266.543A4.953,4.953,0,0,1,490.2,261.6H627.963a4.953,4.953,0,0,1,4.947,4.947V404.3a4.953,4.953,0,0,1-4.947,4.947ZM490.2,263.576a2.971,2.971,0,0,0-2.968,2.968V404.306a2.971,2.971,0,0,0,2.968,2.968H627.963a2.971,2.971,0,0,0,2.968-2.968V266.544a2.971,2.971,0,0,0-2.968-2.968Z" transform="translate(356.366 83.844)" fill="#ccc"/>      <rect id="Rectangle_1" data-name="Rectangle 1" width="211.284" height="1.979" transform="translate(803.805 598.696)" fill="#ccc"/>      <circle id="Ellipse_2" data-name="Ellipse 2" cx="6.672" cy="6.672" r="6.672" transform="translate(803.805 572.996)" fill="#1b556d"/>      <rect id="Rectangle_2" data-name="Rectangle 2" width="211.284" height="1.979" transform="translate(803.805 665.417)" fill="#ccc"/>      <circle id="Ellipse_3" data-name="Ellipse 3" cx="6.672" cy="6.672" r="6.672" transform="translate(803.805 639.718)" fill="#1b556d"/>      <path id="Path_977-831" data-name="Path 977" d="M658.244,670.068H591.472a4.355,4.355,0,0,1-4.35-4.35v-23.4a4.355,4.355,0,0,1,4.35-4.35h66.772a4.355,4.355,0,0,1,4.35,4.35v23.4a4.355,4.355,0,0,1-4.35,4.35Z" transform="translate(352.978 71.328)" fill="#1b556d"/>      <circle id="Ellipse_7" data-name="Ellipse 7" cx="6.672" cy="6.672" r="6.672" transform="translate(825.57 572.996)" fill="#1b556d"/>      <circle id="Ellipse_8" data-name="Ellipse 8" cx="6.672" cy="6.672" r="6.672" transform="translate(847.335 572.996)" fill="#1b556d"/>      <circle id="Ellipse_9" data-name="Ellipse 9" cx="6.672" cy="6.672" r="6.672" transform="translate(825.57 639.718)" fill="#1b556d"/>      <circle id="Ellipse_10" data-name="Ellipse 10" cx="6.672" cy="6.672" r="6.672" transform="translate(847.335 639.718)" fill="#1b556d"/>    </g><g id="Group_61" data-name="Group 61" transform="translate(-21145.078 -2078.104)">      <path id="Path_92-833" data-name="Path 92" d="M893.722,361.268l-16.8,33.257L826.7,417.359c-5.364,9.065-22.409,9.759-23.649,3.9-1.391-6.576,20.7-17.161,20.7-17.161l42.012-28.416,3.676-24.463Z" transform="translate(21477.109 2335.737)" fill="#ffb9b9"/>      <path id="Path_93-834" data-name="Path 93" d="M742.662,464.215,745.76,489l-17.969,1.24-1.858-26.023Z" transform="translate(21626.188 2455.967)" fill="#ffb9b9"/>      <path id="Path_94-835" data-name="Path 94" d="M900.869,676.83a48.641,48.641,0,0,0,4.434-5.422c2.575-3.564,4.86,14.716,4.86,14.716s2.479,7.435,1.859,11.153-14.87,3.718-17.349,3.1-14.87,0-14.87,0H861.215c-16.11-7.435,0-12.392,0-12.392,4.957-.62,21.686-16.11,21.686-16.11l3.718-6.815c2.478-.62,4.957,8.674,4.957,8.674Z" transform="translate(21465.504 2264.419)" fill="#090814"/>      <path id="Path_95-836" data-name="Path 95" d="M802.8,464.616l3.1,24.784-17.969,1.24-1.859-26.024Z" transform="translate(21612.521 2455.876)" fill="#ffb9b9"/>      <path id="Path_96-837" data-name="Path 96" d="M961.005,677.231a48.7,48.7,0,0,0,4.434-5.422c2.575-3.564,4.86,14.716,4.86,14.716s2.478,6.816,1.859,10.533-14.87,3.717-17.349,3.1-14.87.62-14.87.62H921.351c-16.11-7.435,0-12.392,0-12.392,4.957-.62,21.686-16.11,21.686-16.11l3.718-6.815c2.478-.62,4.957,8.674,4.957,8.674Z" transform="translate(21451.836 2264.328)" fill="#090814"/>      <path id="Path_97-838" data-name="Path 97" d="M930.929,446.165c2.479,3.1,1.239,13.631,1.239,13.631s4.337,34.078,2.478,37.176,1.239,5.576,3.1,9.914,3.718,14.87,3.718,14.87c10.533,8.674,9.914,48.329,9.914,48.329l3.717,35.317c-1.239,3.718-18.588,4.337-21.066,3.718s-9.914-56.384-9.914-56.384l-16.729-31.6s1.239,84.265,1.239,87.983-16.729,1.859-20.447,1.859-3.718-61.96-3.718-61.96l-3.718-16.109-19.827-73.732V450.5l3.1-4.337S928.451,443.067,930.929,446.165Z" transform="translate(21463.943 2314.471)" fill="#090814"/>      <circle id="Ellipse_11" data-name="Ellipse 11" cx="19.208" cy="19.208" r="19.208" transform="translate(22348.404 2581.572)" fill="#ffb9b9"/>      <path id="Path_98-839" data-name="Path 98" d="M901.99,251.326c3.893,8.67,1.588,20.779-6.2,34.078l31.6-14.87-4.957-4.337,1.239-12.392Z" transform="translate(21456.018 2358.437)" fill="#ffb9b9"/>      <path id="Path_99-840" data-name="Path 99" d="M894.154,275.527c-4.138,2.46-6.613,6.98-8.034,11.58a109.735,109.735,0,0,0-4.716,26.218l-1.5,26.64L861.316,410.6c16.109,13.631,25.4,10.533,47.089-.62S932.57,413.7,932.57,413.7s1.859-.62,0-2.478,0,0,1.859-1.859,0,0-.62-1.859,0-.62.62-1.239-2.478-6.2-2.478-6.2l4.957-46.47,6.2-65.677c-7.435-9.294-28.5-17.349-28.5-17.349L895.394,284.2c-6.2,2.478-1.239-7.435-1.239-7.435Z" transform="translate(21463.852 2354.064)" fill="#1b556d"/>      <path id="Path_100-841" data-name="Path 100" d="M968.242,343.937l2.478,37.176-31.6,45.231c0,10.533-5.576,13.012-5.576,13.012a81.9,81.9,0,0,1-5.576-10.533c-3.1-6.816,1.859-12.392,1.859-12.392l21.686-45.85-9.294-22.925Z" transform="translate(21448.936 2337.39)" fill="#ffb9b9"/>      <path id="Path_101-842" data-name="Path 101" d="M960.1,293.046c10.533,3.718,12.392,43.992,12.392,43.992-12.392-6.816-27.262,4.337-27.262,4.337s-3.1-10.533-6.816-24.164a23.68,23.68,0,0,1,4.957-22.306S949.563,289.329,960.1,293.046Z" transform="translate(21446.549 2349.247)" fill="#1b556d"/>      <path id="Path_102-843" data-name="Path 102" d="M928.148,237.734c-2.445-1.956-5.781,1.6-5.781,1.6l-1.956-17.606s-12.226,1.467-20.051-.489-9.047,7.091-9.047,7.091a62.8,62.8,0,0,1-.245-11c.489-4.4,6.847-8.8,18.095-11.737s17.116,9.781,17.116,9.781C934.1,219.283,930.593,239.691,928.148,237.734Z" transform="translate(21457.121 2368.931)" fill="#090814"/>    </g>  </g></svg>
						</div>
						<div class="up-instagram-content-inner">
							<h2><span class="up-instagram-accent">Connect</span> your first account</h2>
							<p class="up-instagram-subtitle">Seamlessly connect your Instagram account with this website.</p>
							<p class="up-instagram-terms">To setup, simply login to your Instagram account with the button below and allow this app permissions to view your posts and data. You can withdraw consent at any point below or via the Instagram App.</p>
							<button class="up-ig-connect js-up-instagram-add-account">
								Connect Account
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.583 4.496h6.59v15.008h-6.59M14.337 12H2.827m7.206-4.329L14.362 12l-4.329 4.329"/></svg>
							</button>
						</div>
					</div>
					<?php else: ?>
						<?php 
							$count = 0;
							if(is_array($accounts)): 
								$count = count($accounts);
							endif;
						?>
						<?php foreach($accounts as $name=>$account): 
							$account_error_text = "n/a";
							$account_username = $name;
							if(!$account_username): continue; endif;
							$account_follows = $account['following'] ?? $account_error_text;
							$account_followers = $account['followers'] ?? $account_error_text;
							$account_posts = $account['posts'] ?? $account_error_text;
							$account_pp_url = $account['profile_photo'] ?? $account_error_text;
							$account_connected = $account['connected'] ?? false;
							$account_sync = $account['last_sync'] ?? $account_error_text;
							$account_error = $account['error'] ?? true;
						?>
						<div class="up-instagram-account" data-name="<?php echo $account_username; ?>">
							<div class="up-instagram-account-container">
								<?php if($count > 1): ?>
									<div class="up-instagram-account-drag">
										<span></span>
										<span></span>
										<span></span>
									</div>
								<?php endif; ?>
								<div class="up-instagram-account-img">
									<img src="<?php echo $account_pp_url; ?>">
								</div>
								<div class="up-instagram-account-info">
									<div class="up-instagram-status-wrap">
										<?php if($account_connected): ?>
											<p class="up-instagram-status color-success">Connected</p>
										<?php else: ?>
											<p class="up-instagram-status color-error">Disconnected</p>
										<?php endif; ?>
										<p class="up-instagram-status color-notice">Last Sync: <?php echo $account_sync; ?></p>
									</div>
									<h3><?php echo $account_username; ?></h3>
									<p><b><?php echo $account_posts; ?></b> Posts <b><?php echo $account_followers; ?></b> Followers <b><?php echo $account_follows; ?></b> Following</p>
								</div>
								<div class="up-instagram-account-actions">
									<?php if($account_error): ?>
										<button class="js-up-instagram-add-account" data-type="repair">
										<svg fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title/><path d="M11.588,16.369l10.018,10.85a3.869,3.869,0,0,0,2.763,1.271h.1a3.851,3.851,0,0,0,3.846-3.933,3.879,3.879,0,0,0-1.261-2.773L16.2,11.768A7,7,0,0,0,6.493,3.381a1,1,0,0,0-.269,1.607L9.515,8.271,8.1,9.687,4.806,6.4A1,1,0,0,0,3.2,6.676a6.993,6.993,0,0,0,8.389,9.693ZM4.562,8.983l2.832,2.825a1,1,0,0,0,1.413,0l2.83-2.83a1,1,0,0,0,0-1.415L8.8,4.736a5,5,0,0,1,5.308,6.919,1,1,0,0,0,.241,1.129L25.707,23.26a1.853,1.853,0,0,1,.612,1.342,1.827,1.827,0,0,1-.543,1.348l0,0a1.867,1.867,0,0,1-1.353.537,1.844,1.844,0,0,1-1.337-.619L12.6,14.522a1,1,0,0,0-1.131-.24,5,5,0,0,1-6.912-5.3Z"/></svg>
											<span>Repair</span>
										</button>
									<?php else: ?>
									<button class="js-account-action" data-type="sync">
										<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M18.43 4.25C18.2319 4.25259 18.0426 4.33244 17.9025 4.47253C17.7625 4.61263 17.6826 4.80189 17.68 5V7.43L16.84 6.59C15.971 5.71363 14.8924 5.07396 13.7067 4.73172C12.5209 4.38948 11.2673 4.35604 10.065 4.63458C8.86267 4.91312 7.7515 5.49439 6.83703 6.32318C5.92255 7.15198 5.23512 8.20078 4.84001 9.37C4.79887 9.46531 4.77824 9.56821 4.77947 9.67202C4.7807 9.77583 4.80375 9.87821 4.84714 9.97252C4.89052 10.0668 4.95326 10.151 5.03129 10.2194C5.10931 10.2879 5.20087 10.3392 5.30001 10.37C5.38273 10.3844 5.4673 10.3844 5.55001 10.37C5.70646 10.3684 5.85861 10.3186 5.98568 10.2273C6.11275 10.136 6.20856 10.0078 6.26001 9.86C6.53938 9.0301 7.00847 8.27681 7.63001 7.66C8.70957 6.58464 10.1713 5.98085 11.695 5.98085C13.2188 5.98085 14.6805 6.58464 15.76 7.66L16.6 8.5H14.19C13.9911 8.5 13.8003 8.57902 13.6597 8.71967C13.519 8.86032 13.44 9.05109 13.44 9.25C13.44 9.44891 13.519 9.63968 13.6597 9.78033C13.8003 9.92098 13.9911 10 14.19 10H18.43C18.5289 10.0013 18.627 9.98286 18.7186 9.94565C18.8102 9.90844 18.8934 9.85324 18.9633 9.78333C19.0333 9.71341 19.0885 9.6302 19.1257 9.5386C19.1629 9.44699 19.1814 9.34886 19.18 9.25V5C19.18 4.80109 19.101 4.61032 18.9603 4.46967C18.8197 4.32902 18.6289 4.25 18.43 4.25Z" fill="currentColor"/>
										<path d="M18.68 13.68C18.5837 13.6422 18.4808 13.6244 18.3774 13.6277C18.274 13.6311 18.1724 13.6555 18.0787 13.6995C17.9851 13.7435 17.9015 13.8062 17.8329 13.8836C17.7643 13.9611 17.7123 14.0517 17.68 14.15C17.4006 14.9799 16.9316 15.7332 16.31 16.35C15.2305 17.4254 13.7688 18.0291 12.245 18.0291C10.7213 18.0291 9.25957 17.4254 8.18001 16.35L7.34001 15.51H9.81002C10.0089 15.51 10.1997 15.431 10.3403 15.2903C10.481 15.1497 10.56 14.9589 10.56 14.76C10.56 14.5611 10.481 14.3703 10.3403 14.2297C10.1997 14.089 10.0089 14.01 9.81002 14.01H5.57001C5.47115 14.0086 5.37302 14.0271 5.28142 14.0643C5.18982 14.1016 5.1066 14.1568 5.03669 14.2267C4.96677 14.2966 4.91158 14.3798 4.87436 14.4714C4.83715 14.563 4.81867 14.6611 4.82001 14.76V19C4.82001 19.1989 4.89903 19.3897 5.03968 19.5303C5.18034 19.671 5.3711 19.75 5.57001 19.75C5.76893 19.75 5.95969 19.671 6.10034 19.5303C6.241 19.3897 6.32001 19.1989 6.32001 19V16.57L7.16001 17.41C8.02901 18.2864 9.10761 18.926 10.2934 19.2683C11.4791 19.6105 12.7327 19.6439 13.935 19.3654C15.1374 19.0869 16.2485 18.5056 17.163 17.6768C18.0775 16.848 18.7649 15.7992 19.16 14.63C19.1926 14.5362 19.2061 14.4368 19.1995 14.3377C19.1929 14.2386 19.1664 14.1418 19.1216 14.0532C19.0768 13.9645 19.0146 13.8858 18.9387 13.8217C18.8629 13.7576 18.7749 13.7094 18.68 13.68Z" fill="currentColor"/>
										</svg>
										<span>Sync</span>
									</button>
									<?php endif; ?>
									<button class="js-account-action" data-type="remove">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245l14.49-14.49m0 14.49L4.755 4.755"/></svg>
										<span>Remove</span>
									</button>
								</div>
							</div>
							<?php if($account_error): ?>
								<div class="up-instagram-account-notice">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path d="M42.12 16.472c-.143-2.921-.808-5.51-2.945-7.647s-4.726-2.8-7.647-2.945c-2.517-.142-5.011-.119-7.528-.119s-5.011-.023-7.528.119c-2.921.143-5.51.808-7.647 2.945s-2.8 4.726-2.945 7.647c-.142 2.517-.119 5.011-.119 7.528s-.023 5.011.119 7.528c.143 2.921.808 5.51 2.945 7.647s4.726 2.8 7.647 2.945c2.517.142 5.011.119 7.528.119s5.011.023 7.528-.119c2.921-.143 5.51-.808 7.647-2.945s2.8-4.726 2.945-7.647c.142-2.517.119-5.011.119-7.528s.023-5.011-.119-7.528zm-3.895 18.286a6.212 6.212 0 0 1-3.467 3.467c-2.4.95-8.1.736-10.758.736s-8.359.214-10.758-.736a6.212 6.212 0 0 1-3.467-3.467c-.95-2.4-.736-8.1-.736-10.758s-.214-8.359.736-10.758a6.212 6.212 0 0 1 3.467-3.467c2.4-.95 8.1-.736 10.758-.736s8.359-.214 10.758.736a6.212 6.212 0 0 1 3.467 3.467c.95 2.4.736 8.1.736 10.758s.214 8.359-.736 10.758z" fill="currentColor"/><path d="M33.737 12.078a2.185 2.185 0 1 0 2.185 2.185 2.18 2.18 0 0 0-2.185-2.185zM24 14.643A9.357 9.357 0 1 0 33.357 24 9.345 9.345 0 0 0 24 14.643zm0 15.437A6.08 6.08 0 1 1 30.08 24 6.092 6.092 0 0 1 24 30.08z" fill="currentColor"/></svg>
									<span>
									<?php 
										if(isset($account_error)):
											if(isset($account_error['error']['message'])):
												echo $account_error['error']['message'];
											endif;
										else:
											echo $account_error;
										endif;
									?>
									</span>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<?php if($accounts): ?>
					<div class="up-instagram-account js-add-account js-up-instagram-add-account">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20V4m-8 8h16"/></svg>
						<h3>Add Account</h3>
					</div>
				<?php endif; ?>
			</div>
		<?php 
	}
	
}
