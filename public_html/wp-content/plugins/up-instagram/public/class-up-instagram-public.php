<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Instagram
 * @subpackage Up_Instagram/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Up_Instagram
 * @subpackage Up_Instagram/public
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Instagram_Public {

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
	 * The admin functions 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_admin The admin functions of this plugin
	 */
	private $plugin_admin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_admin ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_admin = $plugin_admin;
		add_action('up_instagram_cron_update_posts', [$this, 'handle_cron_update_posts']);
		add_action('up_instagram_cron_token_refresh', [$this, 'handle_cron_token_refresh']);
		add_filter('acf/load_field/name=up_instagram', [$this,  'up_instagram_accounts_acf']);
		add_action( 'init', [ $this, 'register_shortcodes' ] );
		add_action( 'init', [ $this, 'register_block_assets' ] );

	}

	/**
	 * Handle the feed sync cron job
	 *
	 * @since 1.0.0
	*/
	public function handle_cron_update_posts() {
        if ( $this->plugin_admin ) {
            $this->plugin_admin->run_cron_update_posts();
        }
    }

	/**
	 * Handle the token refresh cron job
	 *
	 * @since 1.0.0
	*/
	public function handle_cron_token_refresh() {
        if ( $this->plugin_admin ) {
            $this->plugin_admin->run_cron_token_refresh();
        }
	}

	/**
	 * Register Gutenberg block for instagram feed
	 *
	 * @since 1.0.0
	*/
	public function register_block_assets() {
		$account_options = array();
		$accounts = up_ig_get_option('accounts');
		if($accounts && is_array($accounts)){
				array_push($account_options, 
					array(
						'label' => __('Select an account', 'up-instagram' ), 
						'value' => ''
					)
				);
			foreach($accounts as $name=>$account){
				array_push($account_options, 
					array(
						'label' => __($name, 'up-instagram' ), 
						'value' => $name 
					)
				);
			}
		}else{
			array_push($account_options, 
				array(
					'label' => __('Please add an account first', 'up-instagram' ), 
					'value' => ''
				)
			);
		}

		wp_register_script(
			'up-instagram-block-js',
			plugin_dir_url( __FILE__ ) . 'js/up-instagram-public.js',
			[ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ],
			filemtime( plugin_dir_path( __FILE__ ) . 'js/up-instagram-public.js' ),
			true
		);

		wp_register_style(
			'up-instagram-block-style',
			plugin_dir_url( __FILE__ ) . 'css/up-instagram-public.css',
			array(),
			filemtime( plugin_dir_path( __FILE__ ) . 'css/up-instagram-public.css' )
		);

		wp_localize_script( 'up-instagram-block-js', 'up_instagram_account_options', $account_options );
	
		register_block_type( 'up-instagram/up-instagram-block', [
			'style'           => 'up-instagram-block-style', 
			'editor_script'   => 'up-instagram-block-js',
			'render_callback' => [ $this, 'render_account_block' ],
			'attributes'      => [
				'selectedAccount' => [
					'type'    => 'string',
					'default' => '',
				],
			],
		] );
	}

	/**
	 * Markup for instagram block
	 *
	 * @since 1.0.0
	*/
	public function instagram_block($data = []){
		if(!isset($data)): return; endif;
		$feed = isset($data['feed']) ? $data['feed'] : array();
		$account = isset($data['account']) ? $data['account'] : '';
		$class = isset($data['class']) ? $data['class'] : '';
		$count = 0;
		?>
			<section class="up-instagram-block <?php echo $class; ?>" data-account="<?php echo $account; ?>">
				<?php foreach($feed as $posts): ?>
					<?php if($count > 3): break; endif; ?>
					<a rel="noopener" target="_blank" href="<?php echo $posts['permalink']; ?>" class="up-instagram-post">
						<img class="up-instagram-image" src ="<?php echo $posts['src']; ?>">
						<div class="up-instagram-caption">
							<p class="up-instagram-caption-content">
								<?php echo $posts['caption']; ?>
							</p>
						</div>
					</a>
				<?php $count++; endforeach; ?>
			</section>
		<?php
	}
		
	/**
	 * Handle the block rendering within Gutenberg
	 *
	 * @since 1.0.0
	*/
	public function render_account_block( $attributes ) {
		$selected_account = isset( $attributes['selectedAccount'] ) ? $attributes['selectedAccount'] : '';
		$feed = up_instagram($selected_account);
		$count=0;
		if(!$feed): return; endif;
		$data = array(
			"account" => $selected_account,
			"feed" => $feed,
			"class" => $attributes['className'] ?? false
		);
		ob_start();
			$this->instagram_block($data);
		return ob_get_clean();
	}


	/**
	 * Handle the shortcode for rendering feed
	 *
	 * @since 1.0.0
	*/
	public function up_instagram_account_shortcode( $atts ) {
        $atts = shortcode_atts(
			array(
                'account' => '', 
				'class' => '', 
            ),
            $atts,
            'up_instagram_account' 
        );
		$account = sanitize_text_field( $atts['account'] );
		$class = sanitize_text_field( $atts['class'] );

		if (!empty($account)){
			$feed = up_instagram($account);
			$data = array(
				"account" => $account,
				"feed" => $feed,
				"class" => $class,
			);
			ob_start();
				$this->instagram_block($data);
			return ob_get_clean();
		}
		return 'No account selected';
	}
	

	public function register_shortcodes() {
        add_shortcode( 'up_instagram', [ $this, 'up_instagram_account_shortcode' ] );
    }

	/**
	 * Handle ACF fields for account names.
	 *
	 * @since 1.0.0
	*/
	public function up_instagram_accounts_acf($field){
		$field['choices'] = array();
		$accounts = up_ig_get_option('accounts');
		if($accounts && is_array($accounts)):
			foreach($accounts as $name=>$data):
				$field['choices'][ $name ] = $name;
			endforeach;
			return $field;
		endif;
	}
}
