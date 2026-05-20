<?php

/**
 * Handles form submissions
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/admin/partials
 */
function handle_form() {
	$error = false;
	if(
		! isset( $_POST['cookie_form'] ) ||
		! wp_verify_nonce( $_POST['cookie_form'], 'cookie_update' )
	){ ?>
		<div class="up-ui-message error">
		   <p>Sorry, your nonce was not correct. Please try again.</p>
		</div> <?php
		exit;
	} else {
		//Update cookie database
		if(isset( $_POST['validate_license'] ) ){
			$key = $_POST['validate_license_key'] ?? false; 
			$result = up_validate_license($key);
			if(!$result){
				$error = true;
			}

		}elseif(isset( $_POST['update-scripts'] ) ){


			//Get form fields 
			$cat = $_POST['update-scripts'] ?? false;
			$desc = $_POST['up-cat-info'] ?? false;
			$groups = (array)json_decode(stripslashes($_POST['group-ids'])) ?? false;
			$groups_output = array();

			foreach($groups as $group):
				$head = $_POST['up-head-'.$group] ?? false;
				$body = $_POST['up-body-'.$group] ?? false; 
				$autoload_script = $_POST['up-autoload-script-'.$group] ?? false;
				$name = $_POST['up-group-name-'.$group] ?? "Untitled";
				$autoload = $_POST['up-autoload-'.$group] ?? false; 
				$autoload_script = $_POST['up-autoload-script-'.$group] ?? false; 
				$cookies = $_POST['up-cookies-'.$group];
				if($_POST['up-cookies-'.$group] == "[]"):
					$cookies = false;
				endif;
				$groups_output[$group] = array(
					"head" =>  $head,
					"body" =>  $body,
					"name" => $_POST['up-group-name-'.$group] ?? "Untitled",
					"autoload" => $_POST['up-autoload-'.$group] ?? false,
					"autoload_script" => $autoload_script,
					"cookies" => $cookies,
				);
			endforeach;
			
			$groups_output = json_encode($groups_output);

			$translation = "";
			if(isset($_POST['update-scripts-lang'])){

				$lang = $_POST['update-scripts-lang'];
				$translation = "_$lang";
				$toggle = false;
				$default = false;

				if($head == null){
					$head = false;
				}

				if($body == null){
					$body = false;
				}

			}else{
				if(isset($_POST['up-toggle'])){
					$toggle = $_POST['up-toggle'];
				}else{
					$toggle = false;
				}
				if(isset($_POST['up-default'])){
					$default = $_POST['up-default'];
				}else{
					$default = false;
				}
			}

			//Strictly Nescessary always enabled
			if($cat == "strictly_necessary"){
				$default = true;
				$toggle = true;
			}


			$db_data = array(
				'desc' => $desc,
				'toggle' => $toggle,
				'default' => $default,
				'groups' => $groups_output,
			);

			//Add global cookies 
			if($cat == "strictly_necessary"){
				$db_data['strictly_necessary'] = $_POST['up-cookies-strictly_necessary'];
			}

			up_update_option($cat.$translation, $db_data );

			//Update cookie policy version number (used when re-consent required) - Not required when translating
			if($translation == ""){
				date_default_timezone_set("Europe/London");
				$current_time = date("Y-m-d h:i:sa");
				if(up_get_option('policy_version')){
					$version_number = up_get_option('policy_version');
				}else{
					$version_number = array(0, "");
				}
				$current_version_number = (int)$version_number[0];
				$current_version_number++;
				$version_number = array($current_version_number, $current_time);
				up_update_option('policy_version', $version_number);
			}
		
		}elseif(isset( $_POST['disconnect-gtm'] ) ){
			up_update_option('gtm_connect', false);
			up_update_option('gtm_cookies', false);
			$up_cookie_categories = array("functional" => array(), "performance_analytics" => array(), "advertisement_targeting" => array());
			foreach($up_cookie_categories as $current_cat => $data):
				$current_cat_data = up_get_option($current_cat);
				$groups = (array)json_decode($current_cat_data['groups']);
				unset($groups['gtm']);
				$groups = json_encode($groups);	
				$current_cat_data['groups'] = $groups;	
				up_update_option($current_cat, $current_cat_data);	
			endforeach;


		}elseif(isset( $_POST['update-gtm-connect'] ) ){

			//Which function to run
			$function = $_POST['update-gtm-connect-function'];

			// Used when updating a cookie category
			if($function == "update-cookie"):

				$name = $_POST['up-cookie-name'];
				$category = $_POST['up-cookie-cat'];
				$up_cookie_categories = array();
				$new_cookie = array(array(
					'name' => $name, 
					'description' => "not_found",
					'platform' => false,
					'retention' => false,
					'gdpr' => false,
					'wildcard' => false,
					'category' => false,
				));
				$up_cookie_categories[$category] = $new_cookie;
				$orginal_gtm_cookies = json_decode(up_get_option('gtm_cookies'));
				$orginal_gtm_cookies->$name = true;


			endif; 

			// Used when connecting GTM for the first time
			if($function == "gtm-new"):

				//Get GTM ID & Cookies
				$gtm_id = $_POST['up-gtm-id'];
				$gtm_cookies = $_POST['up-gtm-cookies'] ?? array();
				if($gtm_cookies):
					$gtm_cookies = json_decode(stripslashes($gtm_cookies));
				endif;

				//Get orginal cookies caught by GTM
				$orginal_gtm_cookies = json_decode(up_get_option('gtm_cookies'));
				if(!$orginal_gtm_cookies):
					$orginal_gtm_cookies = array();
				endif;

				//Define categories map (as Open Cookie DB does not use the same naming conventions)
				$up_cookie_categories = array("functional" => array(), "performance_analytics" => array(), "advertisement_targeting" => array());
				$cookie_cats_map = array(
					"functional" => "functional",
					"personalization" => "functional",
					"analytics" => "performance_analytics",
					"marketing" => "advertisement_targeting",
					"security" => "functional" // We don't have a category for this, so for now use "functional"
				);
				//Get required groups & loop through cookies
				foreach($gtm_cookies as $cookie){

					$cookie_name = $cookie->name;
					if($cookie->wildcard){
						$cookie_name = $cookie->wildcard;
					}

					//Check if this cookie has already been assigned & proccessed
					if(!array_key_exists($cookie_name, (array)$orginal_gtm_cookies)){
						if($cookie->category):
							$orginal_gtm_cookies[$cookie_name] = true; //assigned 
						else:
							$orginal_gtm_cookies[$cookie_name] = false; //unassigned 
							continue; //We can't proccess this cookie any further 
						endif;
					}else{
						//We've already processed this cookie before
						continue;
					}
					$cookie_category = $cookie_cats_map[strtolower($cookie->category)];
					array_push($up_cookie_categories[$cookie_category], $cookie);
				}

				if(isset($gtm_id)):
					up_update_option('gtm_connect', $gtm_id);
				endif;

			endif; 

			//Now we need to add these cookies to the categories within a group called "gtm"
			foreach($up_cookie_categories as $current_cat => $data):
				//First get the cookie cat from database
				$current_cat_data = up_get_option($current_cat);

				if(is_array($data)):
					$data_to_be_added = array(
						"head" =>  "",
						"body" =>  "",
						"name" => "Google Tag Manager",
						"autoload" => false,
						"autoload_script" => "",
						"cookies" => json_encode($data),
					);
					if(isset($current_cat_data['groups'])):
						$groups = (array)json_decode($current_cat_data['groups']);
						
						//Check if the group "gtm" is within this category
						if(isset($groups['gtm'])):
							//Extract Information and merge
							$current_group_cookies = json_decode(stripslashes($groups['gtm']->cookies)) ?? array();
							$new_group_cookies = json_decode($data_to_be_added['cookies']);	
							$data_to_be_added['cookies'] = json_encode(array_merge($current_group_cookies, $new_group_cookies));
							//Remove old gtm group
							unset($groups['gtm']);
						endif;
						$groups_temp = array('gtm' => $data_to_be_added);
						$groups = array_merge($groups_temp, $groups);
						$groups = json_encode($groups);
						$current_cat_data['groups'] = $groups;	
						up_update_option($current_cat, $current_cat_data);			
					else:
						//No groups have been created, we're starting fresh
						$groups = array();
						$groups['gtm'] = $data_to_be_added;
						$groups = json_encode($groups);
						$current_cat_data['groups'] = $groups; 
						up_update_option($current_cat, $current_cat_data);	
					endif;
				endif;
			endforeach;

		//Finally update option orginal cookies
		if(isset($orginal_gtm_cookies)):
			up_update_option('gtm_cookies', json_encode($orginal_gtm_cookies));
		endif;
	
		}else if(isset( $_POST['update-intro'])){

			$translation = "";
			if(isset($_POST['update-intro-lang'])){
				$lang = $_POST['update-intro-lang'];
				$translation = "_$lang";
			}
			$intro = $_POST['up-widget-info'];
			$intro_short = $_POST['up-widget-info-short'];
			$link = $_POST['update-widget-link'];
			$title = $_POST['update-widget-title'];
			$db_data = array(
				'intro-short' => $intro_short,
				'intro' => $intro,
				'link' => $link,
				'title' => $title,
			);
			up_update_option('policy_intro'.$translation, $db_data );

		}else if(isset( $_POST['update-layout'])){

			$layout = $_POST['layout'] ?? false;
			up_update_option('layout', $layout );
		}else if(isset( $_POST['update-widget-variables'])){
			$setting_widget = $_POST['update-widget-setting-toggle'] ?? false;
			up_update_option('widget_variables', $setting_widget );
		}else if(isset( $_POST['update-widget-advert'])){
			$setting_widget = $_POST['update-widget-setting-toggle'] ?? false;
			up_update_option('widget_advert', $setting_widget );
		}else if(isset( $_POST['update-widget-font'])){
			$setting_widget = $_POST['update-widget-setting-toggle'] ?? false;
			up_update_option('widget_font', $setting_widget );
		}else if(isset( $_POST['update-widget-reject'])){
			$setting_widget = $_POST['update-widget-setting-toggle'] ?? false;
			up_update_option('widget_reject', $setting_widget );
		}else if(isset( $_POST['update-widget-setting'])){
			$setting_widget = $_POST['update-widget-setting-toggle'] ?? false;
			up_update_option('widget_setting', $setting_widget );
		}else if(isset( $_POST['update-translation-setting'])){
			$setting_widget = $_POST['update-translation-setting-toggle'] ?? false;
			up_update_option('translation_setting', $setting_widget );
		}else if(isset( $_POST['update-cookie-reconsent'])){
			$setting_widget = $_POST['update-cookie-reconsent-toggle'] ?? false;
			up_update_option('reconsent_setting', $setting_widget );
		}else if(isset( $_POST['update-multisite-setting'])){
			$setting_widget = $_POST['update-multisite-setting-toggle'] ?? false;
			up_update_option('multisite_setting', $setting_widget, up_main_site_id());
		}else if(isset( $_POST['update-dev-setting'])){
			$setting_widget = $_POST['update-dev-setting-toggle'] ?? false;
			up_update_option('dev_setting', $setting_widget);
		}else if(isset( $_POST['update-colors'])){
			$color_mode = $_POST['update-mode'];
			$background_color = $_POST['background-color'];
			$text_color = $_POST['text-color'];
			$buttons_color = $_POST['buttons-color'];
			$buttons_text_color = $_POST['buttons-text-color'];
			$color_theme =  $_POST['color-theme'] ?? false;
			$color_palette =  $_POST['color-palette'] ?? false;
			

			$db_data = array(
				'color_mode' => $color_mode,
				'color_theme' => $color_theme,
				'color_palette' => $color_palette,
				'background' => $background_color,
				'text' => $text_color,
				'button' => $buttons_color,
				'button-text' => $buttons_text_color
			);
			up_update_option('widget_colors', $db_data);
		}else if(isset( $_POST['update-custom-css'])){

			$custom_css = $_POST['up-widget-css'] ?? false;
			up_update_option('widget_css', $custom_css );

		}else if(isset($_POST['remove-lang'])){
			if(isset($_POST['up-select-lang'])){
				$selected_lang = $_POST['up-select-lang']; 
				if(up_get_option('languages')){
					$current_langs = up_get_option('languages');
					unset($current_langs[$selected_lang]);
					up_update_option('languages', $current_langs ); 
				}else{
					$error = true;
				}
			}

		}else if(isset($_POST['add-lang'])){
			if(isset($_POST['up-select-lang'])){
				
				$selected_lang = $_POST['up-select-lang']; 
				if(up_get_option('languages')){
					$current_lang = up_get_option('languages');
					if(isset($current_lang[$selected_lang])){
						$error = true;
					}else{

						$lang_array = file_get_contents(plugin_dir_url( __FILE__ ).'../languages/lang_'.$selected_lang.'.json');
						$lang_array = json_decode($lang_array , true);
						$lang_array = up_decode_html_entities($lang_array);
						$lang_array = $lang_array[$selected_lang];
						$current_lang[$selected_lang] = true;
						up_update_option('languages', $current_lang ); 
						if(up_get_option('languages_string')){
							$current_lang_strings = up_get_option('languages_string'); 
							$current_lang_strings[$selected_lang] = $lang_array;
							up_update_option('languages_string', $current_lang_strings );
						}else{
							$current_lang_strings = array();
							$current_lang_strings[$selected_lang] = $lang_array;
							up_update_option('languages_string', $current_lang_strings );
						}
					}
	
				}else{
					$current_lang[$selected_lang] = true;
					up_update_option('languages', $current_lang );

					$lang_array = file_get_contents(plugin_dir_url( __FILE__ ).'../languages/lang_'.$selected_lang.'.json');
					$lang_array = json_decode($lang_array , true);
					$lang_array = up_decode_html_entities($lang_array);
					$lang_array = $lang_array[$selected_lang];
					if(up_get_option('languages_string')){
						$current_lang_strings = up_get_option('languages_string'); 
						$current_lang_strings[$selected_lang] = $lang_array;
						up_update_option('languages_string', $current_lang_strings );
					}else{
						$current_lang_strings = array();
						$current_lang_strings[$selected_lang] = $lang_array;
						up_update_option('languages_string', $current_lang_strings );
					}
				}

			}else{
				$error = true;
			}
		}else if(isset($_POST['edit-lang'])){
			if(isset($_POST['up-select-lang'])){
				$selected_lang = $_POST['up-select-lang']; 
				if(up_get_option('languages')){
					$current_lang = up_get_option('languages');
					if(isset($current_lang[$selected_lang])){
						//CAPTURE OUR FIELDS AND ASSIGN
						$up_cookie_consent_admin = new Up_Cookie_Consent_Admin('', '');
						$language_strings = $up_cookie_consent_admin->up_language_list()[1];
						$translations = array();
						$count = 0;
						foreach($language_strings as $current_field){
							$translations[$current_field] = $_POST['up-lang-'.$count];
							$count++;
						}

						if(up_get_option('languages_string')){
							$current_lang_strings = up_get_option('languages_string'); 
							$current_lang_strings[$selected_lang] = $translations;
							up_update_option('languages_string', $current_lang_strings );
						}else{
							$current_lang_strings[$selected_lang] = $translations;
							up_update_option('languages_string', $current_lang_strings );
						}

					}else{
						$error = true;
					}
				}else{
					$error = true;
				}
			}else{
				$error = true;
			}

		}else{
			$error = true;
		}

		if($error == false){
		?> 
		<div class="up-ui-message up-success">
			<div class="up-notice-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.282 13.298l4.947 4.947 12.489-12.49"/></svg> 
			</div>
			<div class="up-notice-content">
				Update completed successfully 
				<span>Changes have been applied</span>
			</div>
		</div>
		<?php 
		}else{
		?>
		<div class="up-ui-message up-error">
			<div class="up-notice-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.437 3.283l9.383 16.949a.5.5 0 0 1-.437.742H2.617a.5.5 0 0 1-.437-.742l9.383-16.949a.5.5 0 0 1 .874 0zM12 15.618V8.389" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/><circle cx="12" cy="18.31" r="1" fill="currentColor"/></svg>
			</div>
			<div class="up-notice-content">
				Looks like something isn't right? 
				<span>Changes have not been applied</span>
			</div>
		</div>
		<?php
		}

	}
}
?>