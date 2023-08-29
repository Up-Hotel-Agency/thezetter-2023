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
			$head = $_POST['up-head'] ?? false;
			$body = $_POST['up-body'] ?? false; 

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
				'head' => $head,
				'body' => $body
			);

			up_update_option($cat.$translation, $db_data );


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

		}else if(isset( $_POST['update-widget-font'])){
			$setting_widget = $_POST['update-widget-setting-toggle'] ?? false;
			up_update_option('widget_font', $setting_widget );
		}else if(isset( $_POST['update-widget-setting'])){
			$setting_widget = $_POST['update-widget-setting-toggle'] ?? false;
			up_update_option('widget_setting', $setting_widget );
		}else if(isset( $_POST['update-translation-setting'])){
			$setting_widget = $_POST['update-translation-setting-toggle'] ?? false;
			up_update_option('translation_setting', $setting_widget );
		}else if(isset( $_POST['update-multisite-setting'])){
			$setting_widget = $_POST['update-multisite-setting-toggle'] ?? false;
			up_update_option('multisite_setting', $setting_widget, up_main_site_id());
		}else if(isset( $_POST['update-dev-setting'])){
			$setting_widget = $_POST['update-dev-setting-toggle'] ?? false;
			up_update_option('dev_setting', $setting_widget);
		}else if(isset( $_POST['update-colors'])){
			$background_color = $_POST['background-color'];
			$text_color = $_POST['text-color'];
			$buttons_color = $_POST['buttons-color'];
			$buttons_text_color = $_POST['buttons-text-color'];

			$db_data = array(
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