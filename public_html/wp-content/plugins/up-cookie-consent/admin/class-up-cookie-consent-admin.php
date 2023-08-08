<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Cookie_Consent
 * @subpackage Up_Cookie_Consent/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Up_Cookie_Consent
 * @subpackage Up_Cookie_Consent/admin
 * @author     UP Hotel Agency <dev@uphotel.agency>
 */
class Up_Cookie_Consent_Admin {

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


	public function up_language_list(){
		$languages_list = array(
			"af" => "Afrikaans",
			"sq" => "Albanian - shqip",
			"am" => "Amharic - አማርኛ",
			"ar" => "Arabic - العربية",
			"an" => "Aragonese - aragonés",
			"hy" => "Armenian - հայերեն",
			"ast" => "Asturian - asturianu",
			"az" => "Azerbaijani - azərbaycan dili",
			"eu" => "Basque - euskara",
			"be" => "Belarusian - беларуская",
			"bn" => "Bengali - বাংলা",
			"bs" => "Bosnian - bosanski",
			"br" => "Breton - brezhoneg",
			"bg" => "Bulgarian - български",
			"ca" => "Catalan - català",
			"ckb" => "Central Kurdish - کوردی (دەستنوسی عەرەبی)",
			"zh" => "Chinese - 中文",
			"zh-HK" => "Chinese (Hong Kong) - 中文（香港）",
			"zh-CN" => "Chinese (Simplified) - 中文（简体）",
			"zh-TW" => "Chinese (Traditional) - 中文（繁體）",
			"co" => "Corsican",
			"hr" => "Croatian - hrvatski",
			"cs" => "Czech - čeština",
			"da" => "Danish - dansk",
			"nl" => "Dutch - Nederlands",
			"en" => "English",
			"en-AU" => "English (Australia)",
			"en-CA" => "English (Canada)",
			"en-IN" => "English (India)",
			"en-NZ" => "English (New Zealand)",
			"en-ZA" => "English (South Africa)",
			"en-GB" => "English (United Kingdom)",
			"en-US" => "English (United States)",
			"eo" => "Esperanto - esperanto",
			"et" => "Estonian - eesti",
			"fo" => "Faroese - føroyskt",
			"fil" => "Filipino",
			"fi" => "Finnish - suomi",
			"fr" => "French - français",
			"fr-CA" => "French (Canada) - français (Canada)",
			"fr-FR" => "French (France) - français (France)",
			"fr-CH" => "French (Switzerland) - français (Suisse)",
			"gl" => "Galician - galego",
			"ka" => "Georgian - ქართული",
			"de" => "German - Deutsch",
			"de-AT" => "German (Austria) - Deutsch (Österreich)",
			"de-DE" => "German (Germany) - Deutsch (Deutschland)",
			"de-LI" => "German (Liechtenstein) - Deutsch (Liechtenstein)",
			"de-CH" => "German (Switzerland) - Deutsch (Schweiz)",
			"el" => "Greek - Ελληνικά",
			"gn" => "Guarani",
			"gu" => "Gujarati - ગુજરાતી",
			"ha" => "Hausa",
			"haw" => "Hawaiian - ʻŌlelo Hawaiʻi",
			"he" => "Hebrew - עברית",
			"hi" => "Hindi - हिन्दी",
			"hu" => "Hungarian - magyar",
			"is" => "Icelandic - íslenska",
			"id" => "Indonesian - Indonesia",
			"ia" => "Interlingua",
			"ga" => "Irish - Gaeilge",
			"it" => "Italian - italiano",
			"it-IT" => "Italian (Italy) - italiano (Italia)",
			"it-CH" => "Italian (Switzerland) - italiano (Svizzera)",
			"ja" => "Japanese - 日本語",
			"kn" => "Kannada - ಕನ್ನಡ",
			"kk" => "Kazakh - қазақ тілі",
			"km" => "Khmer - ខ្មែរ",
			"ko" => "Korean - 한국어",
			"ku" => "Kurdish - Kurdî",
			"ky" => "Kyrgyz - кыргызча",
			"lo" => "Lao - ລາວ",
			"la" => "Latin",
			"lv" => "Latvian - latviešu",
			"ln" => "Lingala - lingála",
			"lt" => "Lithuanian - lietuvių",
			"mk" => "Macedonian - македонски",
			"ms" => "Malay - Bahasa Melayu",
			"ml" => "Malayalam - മലയാളം",
			"mt" => "Maltese - Malti",
			"mr" => "Marathi - मराठी",
			"mn" => "Mongolian - монгол",
			"ne" => "Nepali - नेपाली",
			"no" => "Norwegian - norsk",
			"nb" => "Norwegian Bokmål - norsk bokmål",
			"nn" => "Norwegian Nynorsk - nynorsk",
			"oc" => "Occitan",
			"or" => "Oriya - ଓଡ଼ିଆ",
			"om" => "Oromo - Oromoo",
			"ps" => "Pashto - پښتو",
			"fa" => "Persian - فارسی",
			"pl" => "Polish - polski",
			"pt" => "Portuguese - português",
			"pt-BR" => "Portuguese (Brazil) - português (Brasil)",
			"pt-PT" => "Portuguese (Portugal) - português (Portugal)",
			"pa" => "Punjabi - ਪੰਜਾਬੀ",
			"qu" => "Quechua",
			"ro" => "Romanian - română",
			"mo" => "Romanian (Moldova) - română (Moldova)",
			"rm" => "Romansh - rumantsch",
			"ru" => "Russian - русский",
			"gd" => "Scottish Gaelic",
			"sr" => "Serbian - српски",
			"sh" => "Serbo - Croatian",
			"sn" => "Shona - chiShona",
			"sd" => "Sindhi",
			"si" => "Sinhala - සිංහල",
			"sk" => "Slovak - slovenčina",
			"sl" => "Slovenian - slovenščina",
			"so" => "Somali - Soomaali",
			"st" => "Southern Sotho",
			"es" => "Spanish - español",
			"es-AR" => "Spanish (Argentina) - español (Argentina)",
			"es-419" => "Spanish (Latin America) - español (Latinoamérica)",
			"es-MX" => "Spanish (Mexico) - español (México)",
			"es-ES" => "Spanish (Spain) - español (España)",
			"es-US" => "Spanish (United States) - español (Estados Unidos)",
			"su" => "Sundanese",
			"sw" => "Swahili - Kiswahili",
			"sv" => "Swedish - svenska",
			"tg" => "Tajik - тоҷикӣ",
			"ta" => "Tamil - தமிழ்",
			"tt" => "Tatar",
			"te" => "Telugu - తెలుగు",
			"th" => "Thai - ไทย",
			"ti" => "Tigrinya - ትግርኛ",
			"to" => "Tongan - lea fakatonga",
			"tr" => "Turkish - Türkçe",
			"tk" => "Turkmen",
			"tw" => "Twi",
			"uk" => "Ukrainian - українська",
			"ur" => "Urdu - اردو",
			"ug" => "Uyghur",
			"uz" => "Uzbek - o‘zbek",
			"vi" => "Vietnamese - Tiếng Việt",
			"wa" => "Walloon - wa",
			"cy" => "Welsh - Cymraeg",
			"fy" => "Western Frisian",
			"xh" => "Xhosa",
			"yi" => "Yiddish",
			"yo" => "Yoruba - Èdè Yorùbá",
			"zu" => "Zulu - isiZulu"
		);
		$language_strings = array(
			"Accept All",
			"View Options",
			"Accept",
			"Options",
			"Back",
			"View More",
			"Accept Selected",
			"View our Cookie Policy",
			"Enabled",
			"Disabled",
			"Close",
			"Strictly Necessary",
			"Functional",
			"Performance and Analytics",
			"Advertisement and Targeting",
		);
		return array($languages_list, $language_strings);
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/up-cookie-consent-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name."_code_mirror", plugin_dir_url( __FILE__ ) . 'js/code_mirror.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/up-cookie-consent-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the Settings for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_display() {
		$version = $this->version;
		add_menu_page( 'UP Cookie Consent Settings', 'UP Cookie Consent', 'manage_options', 'up-cookie-consent', 'page_admin', 'dashicons-privacy', 6  );
		function page_admin($version){
			include( plugin_dir_path( __FILE__ ) . 'handler-up-cookie-consent-admin.php' );
			if( isset($_POST['updated']) && $_POST['updated'] === 'true' ){
				handle_form();
			} 
			include( plugin_dir_path( __FILE__ ) . 'partials/up-cookie-consent-admin-display.php' );
		}

	}

}
