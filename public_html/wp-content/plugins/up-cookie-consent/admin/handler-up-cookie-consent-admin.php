<?php

/**
 * Handles form submissions
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Cookie_Consent
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
		//Passed 
		$db_name = "up_cookie_consent";

		//Update cookie database
		if(isset( $_POST['update-scripts'] ) ){

			//Get form fields 
			$cat = $_POST['update-scripts'];
			$desc = $_POST['up-cat-info'];
			$toggle = $_POST['up-toggle'];
			$default = $_POST['up-default'];
			$head = $_POST['up-head'];
			$body = $_POST['up-body'];

			$db_data = array(
				'desc' => $desc,
				'toggle' => $toggle,
				'default' => $default,
				'head' => $head,
				'body' => $body
			);

			update_option( $db_name.'_'.$cat, $db_data );


		}else if(isset( $_POST['update-intro'])){

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
			update_option( $db_name.'_policy_intro', $db_data );

		}else if(isset( $_POST['update-layout'])){

			$layout = $_POST['layout'];
			update_option( $db_name.'_layout', $layout );

		}else if(isset( $_POST['update-widget-setting'])){

			$setting_widget = $_POST['update-widget-setting-toggle'];
			update_option( $db_name.'_widget_setting', $setting_widget );

		}else if(isset( $_POST['update-colors'])){
			$accent_color = $_POST['accent-color'];
			$buttons_color = $_POST['buttons-color'];
			$buttons_text_color = $_POST['buttons-text-color'];

			$db_data = array(
				'accent' => $accent_color,
				'button' => $buttons_color,
				'button-text' => $buttons_text_color
			);

			update_option( $db_name.'_widget_colors', $db_data );

		}else if(isset($_POST['add-lang'])){
			if(isset($_POST['up-select-lang'])){
				
				$selected_lang = $_POST['up-select-lang']; 
				if(get_option($db_name.'_languages')){
					$current_lang = get_option($db_name.'_languages');
					if(isset($current_lang[$selected_lang])){
						$error = true;
					}else{
						$current_lang[$selected_lang] = true;
						update_option( $db_name.'_languages', $current_lang );

						if(get_option($db_name.'_languages_string')){
							$current_lang_strings = get_option($db_name.'_languages_string'); 
							$current_lang_strings[$selected_lang] = false;
							update_option( $db_name.'_languages_string', $current_lang_strings );
						}else{
							$current_lang_strings[$selected_lang] = false;
							update_option( $db_name.'_languages_string', $current_lang_strings );
						}
					}
	
				}else{
					$current_lang[$selected_lang] = true;
					update_option( $db_name.'_languages', $current_lang );
				}

			}else{
				$error = true;
			}
		}else if(isset($_POST['edit-lang'])){
			if(isset($_POST['up-select-lang'])){
				$selected_lang = $_POST['up-select-lang']; 
				if(get_option($db_name.'_languages')){
					$current_lang = get_option($db_name.'_languages');
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

						if(get_option($db_name.'_languages_string')){
							$current_lang_strings = get_option($db_name.'_languages_string'); 
							$current_lang_strings[$selected_lang] = $translations;
							update_option( $db_name.'_languages_string', $current_lang_strings );
						}else{
							$current_lang_strings[$selected_lang] = $translations;
							update_option( $db_name.'_languages_string', $current_lang_strings );
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
		?><div class="up-ui-message success"><p>Update completed successfully </p></div><?php
		}else{
		?><div class="up-ui-message error"><p>Update failed. Something went wrong.</p></div><?php
		}

	}
}
?>