<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/admin/partials
 */
?>
<?php 


global $cookie_cats, $tab, $cat, $cookie_layouts, 
$widget_setting, $layout_settings, $widget_colors, 
$settings_policy, $languages_list, $language_strings,
$lang, $current_string_translations, $current_supported_langs, 
$translation_setting, $multisite_setting, $dev_setting;

$menu_items = array(
    array('slug' => 'dashboard', 'name' => 'Dashboard'),
    array('slug' => 'layout', 'name' => 'Widget Settings'),
    array('slug' => 'cookies_scripts', 'name' => 'Cookies / Scripts'),
    array('slug' => 'up_settings', 'name' => 'Settings'),
);
$cookie_cats = array(
    array('slug' => 'strictly_necessary', 'name' => 'Strictly Necessary', 'desc' => 'Forced active always'),
    array('slug' => 'functional', 'name' => 'Functional', 'desc' => 'Scripts for the sites functions'),
    array('slug' => 'performance_analytics', 'name' => 'Performance and Analytics', 'desc' => 'Used for GTM and tracking'),
    array('slug' => 'advertisement_targeting', 'name' => 'Advertisement and Targeting', 'desc' => 'Provide visitors with relevant ads'),

);

$cookie_layouts = array(
    array('slug' => 'floating_notice', 'name' => 'Floating Notice', 'desc' => 'Appears on bottom left', 'image_src' => plugin_dir_url( __FILE__ ).'../../assets/img/floating_notice.png'),
    array('slug' => 'slim_floating_notice', 'name' => 'Slim Floating Notice', 'desc' => 'Forced active always', 'image_src' => plugin_dir_url( __FILE__ ).'../../assets/img/slim_notice.png'),
    array('slug' => 'mandatory_modal_notice', 'name' => 'Mandatory Modal Notice', 'desc' => 'Users must interactive', 'image_src' => plugin_dir_url( __FILE__ ).'../../assets/img/cookie_modal.png'),

);

$up_cookie_consent_admin = new Up_Cookie_Consent_Admin('', '');
$languages_list = $up_cookie_consent_admin->up_language_list()[0];
$language_strings = $up_cookie_consent_admin->up_language_list()[1];

$multisite_setting = up_get_option('multisite_setting', up_main_site_id()) ?? false; 
$dev_setting = up_get_option('dev_setting') ?? false; 

$widget_setting = up_get_option('widget_setting') ?? false;
$layout_settings = up_get_option('layout') ?? false;
$widget_colors = up_get_option('widget_colors') ?? false;
$settings_policy = up_get_option('policy_intro') ?? false;

$translation_setting = up_get_option('translation_setting') ?? false;
$current_string_translations = up_get_option('languages_string') ?? false;
$current_supported_langs = up_get_option('languages') ?? false;

$tab = ( isset($_GET['tab']) ) ? sanitize_text_field($_GET['tab']) : 'dashboard';
$cat = ( isset($_GET['cat']) ) ? sanitize_text_field($_GET['cat']) : '';
$lang = ( isset($_GET['lang']) ) ? sanitize_text_field($_GET['lang']) : '';

function up_status($status){
    if(!up_check_license()){
        $status = false;
    }
    if($status == true){
        return '
        <div class="up-staus">
        <p>Active</p>
        <div class="status-icon active"></div>
        </div> ';

    }else{
        return '
        <div class="up-staus">
        <p>Inactive</p>
        <div class="status-icon inactive"></div>
        </div> ';
    }
}

function up_activate_notice(){
?>
    <div class="up-content-title spacing">
        <h2>Plugin not activated. Please activate your UP Cookie Consent Plugin.
            <span>Visit the settings page and enter your license key provided by UP Hotel Agency</span>
        </h2>
        <div class="up-option-group">
            <a href="?page=up-cookie-consent&tab=up_settings" class="up-custom-submit">Activate plugin</a>
        </div>
    </div>
<?php
}

?>
<section class="up-admin-container">
    <div class="up-top-banner">
        <div class="up-logo-wrap">
            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 287 278" width="287" height="278">
                <title>up-logo-landscape-white-svg</title>
                <style>
                    .s0 { fill: #ffffff } 
                </style>
                <path id="Layer" class="s0" d="m335.3 119.5h20.8v27.6h23.7v-27.6h20.7v72.2h-20.7v-28.4h-23.7v28.4h-20.8z"/>
                <path id="Layer" fill-rule="evenodd" class="s0" d="m407.5 166v-0.8c0-17 12.6-27.7 29-27.7 16.2 0 28.7 10.4 28.7 27.2v0.8c0 17.2-12.6 27.5-28.8 27.5-16.3 0-28.9-9.9-28.9-27zm39.4-0.3v-0.8c0-8.9-3.6-13.8-10.4-13.8-6.8 0-10.5 4.7-10.5 13.6v0.8c0 9.1 3.5 14 10.5 14 6.7 0 10.4-5 10.4-13.8z"/>
                <path id="Layer" class="s0" d="m475.5 174.8v-23.5h-6.3v-12.4h6.3v-11h18.1v11h10.4v12.4h-10.4v21.8c0 3.8 1.9 5.5 5.4 5.5q0.6 0 1.3 0 0.6-0.1 1.3-0.2 0.6-0.1 1.3-0.3 0.6-0.2 1.2-0.4v13.7q-1.2 0.4-2.5 0.7-1.2 0.2-2.4 0.4-1.3 0.2-2.6 0.3-1.2 0.1-2.5 0.2c-11.9 0-18.6-5.8-18.6-18.2z"/>
                <path id="Layer" fill-rule="evenodd" class="s0" d="m509.5 166v-0.8c0-17 12.7-27.7 28.6-27.7 14.5 0 26.9 8.3 26.9 27.3v4.7h-37.2c0.5 7 4.6 11 11 11 6 0 8.5-2.7 9.2-6.2h17c-1.6 11.9-10.8 18.7-26.8 18.7-16.5 0-28.7-9.7-28.7-27zm37.9-6.7c-0.3-6.3-3.4-9.9-9.3-9.9-5.4 0-9.2 3.6-10.1 9.9z"/>
                <path id="Layer" class="s0" d="m573.3 115.7h17.9v76h-17.9z"/>
                <path id="Layer" fill-rule="evenodd" class="s0" d="m645.9 119.5h26.8l22.9 72.2h-21.9l-3.8-13.4h-24l-3.8 13.4h-19.3zm4.1 44.6h15.8l-7.9-27.8z"/>
                <path id="Layer" fill-rule="evenodd" class="s0" d="m698.8 191.7h18c0.8 3.9 3.1 6.9 9.7 6.9 8 0 11.2-4.5 11.2-11.1v-8.1q-1.2 2.2-2.9 4-1.8 1.9-3.9 3.1-2.2 1.3-4.6 2-2.4 0.6-4.9 0.6c-12.4 0-22.5-9.1-22.5-25.3v-0.8c0-15.6 10-25.5 22.5-25.5 8.3 0 13.3 3.6 16.3 8.9v-7.5h18.1v48.4c0 15.8-10.4 24-29.3 24-18 0-26.2-7.5-27.7-19.6zm39.4-28v-0.7c0-7.3-3.7-11.9-10.4-11.9-6.7 0-10.4 4.7-10.4 12v0.8c0 7.3 3.9 11.9 10.3 11.9 6.5 0 10.5-4.7 10.5-12.1z"/>
                <path id="Layer" fill-rule="evenodd" class="s0" d="m763.7 166v-0.8c0-17 12.6-27.7 28.5-27.7 14.5 0 26.9 8.3 26.9 27.3v4.7h-37.2c0.5 7 4.6 11 11 11 6 0 8.5-2.7 9.2-6.2h17c-1.6 11.9-10.8 18.7-26.8 18.7-16.5 0-28.6-9.7-28.6-27zm37.8-6.7c-0.3-6.3-3.4-9.9-9.3-9.9-5.4 0-9.2 3.6-10.1 9.9z"/>
                <path id="Layer" class="s0" d="m826.9 138.9h18v8.5c2.9-5.4 8.6-9.9 17.4-9.9 10.2 0 17.3 6.4 17.3 19.9v34.3h-18.1v-30.7c0-5.9-2.3-8.8-7.6-8.8-5.3 0-9 3.2-9 10v29.5h-18z"/>
                <path id="Layer" class="s0" d="m887 166v-0.8c0-17.6 12.6-27.7 28.2-27.7 12.9 0 24.8 5.7 25.8 21.7h-16.9c-0.8-4.9-3.3-7.6-8.5-7.6-6.4 0-10.1 4.5-10.1 13.4v0.8c0 9.2 3.5 13.9 10.4 13.9 5 0 8.6-3 9.2-8.8h16.2c-0.5 13.4-9.5 22.1-26.5 22.1-15.8 0-27.8-9.2-27.8-27z"/>
                <path id="Layer" class="s0" d="m963.3 186.4l-21.1-47.5h19.5l10.9 28.2 10.1-28.2h17.3l-28.3 70.5h-17.2z"/>
                <path id="Layer" fill-rule="evenodd" class="s0" d="m133.9 16.8v143.2l-98.9 50.5-33-16.8v-143.1l33-16.9 33 16.9v-33.7l32.9-16.9zm-8.1 12.5l-24.9 12.7 0.1 101.1-41.2 21v-101.1l-24.8 12.7v101.1 25.4l66-33.7 24.8-12.7zm-90.8 38l24.8-12.6-24.8-12.7-24.9 12.7zm33 84.2l24.8-12.7-24.8-12.7zm57.8-130.6l-24.8-12.7-24.8 12.7 24.8 12.7z"/>
                <path id="Layer" fill-rule="evenodd" class="s0" d="m266.5 118.3v75l-66.6 34.1v33.7l-32.8 16.9-33.2-16.9v-75.8l57.8-29.5-24.8-12.7v-42l33-16.9zm-33.6 16.6l24.8-12.7-57.9-29.6-24.8 12.7zm24.8-4.3l-24.8 12.6v33.7l-66 33.8v59l24.8-12.7v-33.7l66-33.7z"/>
            </svg>
            <h1>Cookie Consent
                <span>Version: <?php echo UP_COOKIE_CONSENT_VERSION; ?></span>
            </h1>
        </div>
        <div class="up-banner-cookie">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"  viewBox="0 0 48 48" enable-background="new 0 0 48 48" xml:space="preserve">
                <circle fill="#D87B00" cx="29" cy="19" r="13"/>
                <circle fill="#FFB300" cx="19" cy="29" r="13"/>
                <g>
                    <circle fill="#683529" cx="17.5" cy="28.5" r="2.5"/>
                    <circle fill="#683529" cx="19.5" cy="21.5" r="1.5"/>
                    <circle fill="#683529" cx="23" cy="34" r="2"/>
                    <circle fill="#683529" cx="11.5" cy="30.5" r="1.5"/>
                    <circle fill="#683529" cx="25.501" cy="27.499" r="1.5"/>
                    <circle fill="#683529" cx="16" cy="36" r="1"/>
                </g>
                <g>
                    <circle fill="#4C2114" cx="26" cy="12" r="2"/>
                    <circle fill="#4C2114" cx="31.499" cy="16.499" r="1.5"/>
                    <circle fill="#4C2114" cx="32.499" cy="10.5" r="1.5"/>
                    <circle fill="#4C2114" cx="36" cy="21" r="1"/>
                </g>
            </svg>
        </div>
    </div>
    <?php if($dev_setting && up_check_license()){  ?>
        <div class="up-dev-banner">Attention: You are currently in development mode, which means the cookie widget won't be visible to front-end users. To turn off this mode, please go to the settings tab.</div>
    <?php } ?>
    <div class="up-content">
        <div class="up-menu">
            <?php foreach($menu_items as $item){ ?>
                <a href="?page=up-cookie-consent&tab=<?php if(isset($item['slug'])){  echo $item['slug']; }?>" class="<?php if(isset($item['slug'])){if($tab == $item['slug']){ echo "active"; }} ?>"><?php if(isset($item['name'])){ echo $item['name']; } ?></a>
            <?php } ?>
        </div>
        <div class="up-dashboard">
                <?php if(!up_check_license() && !in_array($tab, array("dashboard", "up_settings"))){  ?>
                    <?php up_activate_notice(); ?>
                <?php }else{ 
                    $tab();
                } ?>
                <div class="up-info">
                    Plugin by <a href="https://uphotel.agency"> UP Hotel Agency </a>
                </div>
        </div>
    </div>
</section>

<?php function dashboard(){ ?>
    <?php 
        global $widget_setting, $translation_setting, $multisite_setting;
        if(!isset($widget_setting)){
            $widget_setting = false;
        }
        $user = wp_get_current_user(); 
    ?>
    <div class="up-content-title">
        <h2>Welcome <?php echo $user->display_name; ?>, to the UP Cookie Consent plugin
            <span>This page shows the general status of your consent widget. Use the menu to update settings.</span>
        </h2>
    </div>
    <div class="up-admin-cards">
        <div class="up-card">
            <h3 class="up-card-title">Widget Status
                <span class="up-card-desc">Showing on the front end of site</span>
            </h3>
            <?php echo up_status($widget_setting); ?>
        </div>
        <div class="up-card">
            <h3 class="up-card-title">Site Registered
                <span class="up-card-desc">API key connected to plugin</span>
            </h3>
            <?php echo up_status(up_check_license()); ?>
        </div>
        <div class="up-card">
            <h3 class="up-card-title">Translations
                <span class="up-card-desc">Showing different languages info</span>
            </h3>
            <?php echo up_status($translation_setting); ?>
        </div>
        <div class="up-card">
            <h3 class="up-card-title">Multisite Sync
                <span class="up-card-desc">Settings are synced across all sites</span>
            </h3>
            <?php echo up_status($multisite_setting); ?>
        </div>
    </div>
    <?php if(!up_check_license()){ up_activate_notice(); } ?>
<?php } ?>


<?php function layout(){ ?>
    <?php
        $current_widget = 1;
        global $cookie_layouts, $widget_setting, $layout_settings;  
        if(!isset($widget_setting)){
            $widget_setting = false;
        }
        if(!isset($cookie_layouts)){
            $cookie_layouts = array(); 
        }
        if(!isset($layout_settings)){
            $layout_settings = false;
        }
    ?>

    <div class="up-content-title">
        <h2>Activate or disable widget
            <span>Select if you want to show the widget</span>
        </h2>
        <form method="POST" class="js-widget-setting">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-widget-setting" value="true" />
            <div class="toggle">
                <input type="checkbox" <?php if($widget_setting == 'on'){ echo "checked"; } ?> class="js-form-submit" name="update-widget-setting-toggle">
                <label></label> 
            </div>
        </form>
    </div>

    <div class="up-content-title up-section-container-top">
        <h2>Widget layout and style
            <span>Select your cookie consent widget layout and update colours</span>
        </h2>
    </div>
    <div class="layout-widget">
        <div class="layout-banner">
            Preview
        </div>
        <img src="<?php echo plugin_dir_url( __FILE__ ) ?>../../assets/img/desktop.png">
        <?php foreach($cookie_layouts as $current_layout){ ?>
            <img class="<?php if($layout_settings == $current_layout['slug']){ echo " selected "; } ?><?php echo $current_layout['slug']; ?> layout-option" src="<?php echo $current_layout['image_src']; ?>" data-layout="<?php echo $current_layout['slug']; ?>">
        <?php } ?>
    </div>
    <form method="POST" class="js-layout">
    <div class="up-admin-cards selectable">
        <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
        <input type="hidden" name="updated" value="true" />
        <input type="hidden" name="update-layout" value="true" />
        <input type="hidden" name="layout" value="" />
        <?php foreach($cookie_layouts as $current_layout){ ?>
            <?php if($layout_settings == $current_layout['slug']){ 
                    $selected = true;
                }else{
                    $selected = false;
                }
            ?>
            <div class="up-card <?php if($layout_settings == $current_layout['slug']){ echo "selected"; } ?>" data-value="<?php echo $current_layout['slug']; ?>">
                <h3 class="up-card-title"><?php echo $current_layout['name']; ?>
                    <span class="up-card-desc"><?php echo $current_layout['desc']; ?></span>
                </h3>
                <?php echo up_status($selected); ?>
            </div>

        <?php } ?>
    </div>
    </form>
    <div class="up-section-container-top">
    <div class="up-content-title">
        <h2>Use default fonts
            <span>Choose whether you prefer to utilize the pre-existing fonts and styles or your custom ones. </span>
        </h2>
        <form method="POST" class="js-widget-setting">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-widget-font" value="true" />
            <div class="toggle">
                <input type="checkbox" <?php if(up_get_option('widget_font') == true){ echo "checked"; } ?> class="js-form-submit" name="update-widget-setting-toggle">
                <label></label> 
            </div>
        </form>
    </div>
    <div class="up-content-title spacing">
        <h2>Widget colours
            <span>Update the colours of the widget</span>
        </h2>
    </div>
    <?php 
    global $widget_colors;
    ?>
    <form method="POST" class="up-option-group">
    <div class="widget-color-selectors">
        <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
        <input type="hidden" name="updated" value="true" />
        <input type="hidden" name="update-colors" value="true" />
        <div class="color-selector">
            <label for="background-color">Widget background colour</label>
            <div class="color-picker">
                <input class="color-picker-input" type="color" id="background-color" name="background-color" value="<?php if(isset($widget_colors['background'])){ echo $widget_colors['background']; } ?>">
                <label class="text-picker" for="background-color"></label>
            </div>
            <input type="text" id="hex-code" class="hex-code" value="<?php if(isset($widget_colors['background'])){ echo $widget_colors['background']; } ?>">
        </div>
        <div class="color-selector">
            <label for="text-color">Widget text colour</label>
            <div class="color-picker">
                <input class="color-picker-input" type="color" id="text-color" name="text-color" value="<?php if(isset($widget_colors['text'])){ echo $widget_colors['text']; } ?>">
                <label class="text-picker" for="text-color"></label>
            </div>
            <input type="text" id="hex-code" class="hex-code" value="<?php if(isset($widget_colors['text'])){ echo $widget_colors['text']; } ?>">
        </div>
        <div class="color-selector">
            <label for="buttons-color">Button color</label>
            <div class="color-picker">
                <input class="color-picker-input" type="color" id="buttons-color" name="buttons-color" value="<?php if(isset($widget_colors['button'])){ echo $widget_colors['button']; }?>">
                <label class="text-picker" for="buttons-color"></label>
            </div>
            <input type="text" id="hex-code" class="hex-code" value="<?php if(isset($widget_colors['button'])){ echo $widget_colors['button']; } ?>">
        </div>
        <div class="color-selector">
            <label for="buttons-text-color">Button text color</label>
            <div class="color-picker">
                <input class="color-picker-input" type="color" id="buttons-text-color" name="buttons-text-color" value="<?php if(isset($widget_colors['button-text'])){ echo $widget_colors['button-text']; } ?>">
                <label class="text-picker" for="buttons-text-color"></label>
            </div>
            <input type="text" id="hex-code" class="hex-code" value="<?php if(isset($widget_colors['button-text'])){ echo $widget_colors['button-text']; } ?>">
        </div>
    </div>
    <input class="up-custom-submit" type="submit" value="Update widget colours">
    </form>
    </div>
    <div class="up-section-container">
    <div class="up-content-title spacing  ">
        <h2>Custom CSS
            <span>Apply custom css to the widget. Warning this is for advanced users only</span>
        </h2>
    </div>
    <?php 
    global $widget_colors;
    ?>
    <div class="up-option-group">
    <form method="POST" class="up-option-group">
        <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
        <input type="hidden" name="updated" value="true" />
        <input type="hidden" name="update-custom-css" value="true" />
        <label for="up-widget-css">CSS Only: (HTML Style tags are not requird)</label>
        <textarea class="code-editor css-code-editor" name="up-widget-css" rows="10" cols="50"><?php if(up_get_option('widget_css')){ echo htmlentities(stripslashes(up_get_option('widget_css'))); } ?></textarea>
    <input class="up-custom-submit" type="submit" value="Update custom CSS">
    </form>
    </div>
    </div>
<?php } ?>


<?php function up_edit_lang(){ ?>
    <?php 
        global $language_strings, $languages_list, $lang, $current_string_translations, $current_supported_langs;
        if(!$lang){ 
            exit;
        }
        if(!isset($current_supported_langs[$lang])){
            echo "Language not yet supported";
            exit;
        }
    ?>
    <div class="up-content-title spacing no-margin-bottom">
        <h2> Plugin strings translation (currently editing: <b><?php echo strtoupper($lang); ?></b>)
            <span>Translate the plugin UI elements</span>
        </h2>
    </div>
    <div class="up-option-group">
    <form method="POST">
        <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
        <input type="hidden" name="updated" value="true" /> 
        <input type="hidden" name="edit-lang" value="true" />
        <input type="hidden" name="up-select-lang" value="<?php echo $lang; ?>" />
        <?php $count = 0; foreach($language_strings as $string){ ?>
        <label for="up-lang-<?php echo $string; ?>"><b>Text: </b><?php echo $string; ?></label>
        <input required type="text" name="up-lang-<?php echo $count; ?>" value="<?php if(isset($current_string_translations[$lang][$string]) && $current_string_translations[$lang][$string] != ""){ echo htmlentities(stripslashes($current_string_translations[$lang][$string])); } ?>" placeholder="Please type translation">
        <?php $count++; } ?>
        <input class="up-custom-submit" type="submit" value="Update Language Information">
    </form>
    </div>

<?php } ?>

<?php function up_add_lang($passed = false){ ?>
    <?php 
        global $language_strings, $languages_list, $current_supported_langs;
    ?>
    <div class="up-content-title">
        <?php  if($passed){ ?>
        <h2> Setup <?php echo $languages_list[$passed]; ?> with this plugin first.
          <span>Language setup for Cookie Translations</span>
        </h2>
        <?php }else{ ?>
        <h2> Langauge Setup 
            <span>Language setup for Cookie Translations</span>
        </h2>
        <?php } ?>
        
    </div>
    <div class="up-option-group">
        <?php 
        //get current settings
        global $settings_policy;
        ?>
        <form method="POST">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="add-lang" value="true" />
            <label for="up-select-lang">Select language:</label>
            <select name="up-select-lang" id="up-select-lang">
                <option value="default" default>Please select...</option>
                <?php foreach($languages_list as $key => $lang){ ?>
                <option <?php if($passed == $key){ echo "selected"; } ?> value="<?php echo $key;?>"><?php echo $lang;?> [ <?php echo $key;?> ]</option>
                <?php } ?>
            </select>
            <input class="up-custom-submit" type="submit" value="Add language">
        </form>
    </div>
<?php } ?> 

<?php function up_remove_lang(){ ?>
    <?php 
        global $language_strings, $languages_list,  $current_supported_langs;
    ?>
    <div class="up-content-title">
        <h2> Remove a langauge 
            <span>Language setup for Cookie Translations</span>
        </h2>
    </div>
    <div class="up-option-group">
        <?php 
        //get current settings
        global $settings_policy;
        ?>
        <form method="POST">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="remove-lang" value="true" />
            <label for="up-select-lang">Select language:</label>
            <select name="up-select-lang" id="up-select-lang">
                <option value="default" default>Please select...</option>
                <?php foreach($current_supported_langs as $key => $lang){ ?>
                <option value="<?php echo $key;?>"><?php echo $languages_list[$key];?> [ <?php echo $key;?> ]</option>
                <?php } ?>
            </select>
            <input class="up-custom-submit" type="submit" value="Remove language">
        </form>
    </div>
<?php } ?> 

<?php function up_lang_notice($languages_list, $lang){ ?>
    <div class="up-notice-language">
        <div class="up-notice-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.282 13.298l4.947 4.947 12.489-12.49"/></svg> 
        </div>
        <div class="up-notice-content">
            Currently translating content for (<?php echo $languages_list[$lang]; ?>)
            <span>English content will copy if no translation available</span> 
        </div>
    </div>
<?php } ?>


<?php function cookies_scripts(){ 
 
        // Get the global variables
        global $cookie_cats, $tab, $cat, $current_supported_langs, $languages_list, $lang, $translation_setting; 

        // Set $cookie_cats to an empty array if it's not set
        $cookie_cats = $cookie_cats ?? array();

        // Check if we are in translating mode
        $translating_mode = false;
        if($translation_setting && $lang != null){
            if($lang == "en"){
                //Default lang don't do anything
            }else{
            if(!isset($current_supported_langs[$lang])){
                up_add_lang($lang);
                exit;
            }
            $translating_mode = true;
            }
        }

    ?>
    <div class="up-section-col">
        <div class="up-content-inner">
        <div class="up-content-title">
            <h2> Cookie widget setup
                <span>Setting for your cookies, scripts and user information</span>
            </h2>
            <div class="up-notices-section">
                <div class="up-notice-language up-hint-box spacing">
                    <div class="up-notice-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>lightbulb</title><g class="lightbulb"><path d="M30.764,30.884c0-2.445,3.585-6.879,3.585-6.879a12.58,12.58,0,1,0-20.7,0s3.585,4.434,3.585,6.879" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M19.153,10.22A8.479,8.479,0,0,0,17.232,12.1a8.381,8.381,0,0,0-1.646,5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M24,8.685a8.468,8.468,0,0,0-1.292.1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><rect x="17.236" y="30.884" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><rect x="17.236" y="34.876" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M22.557,43.226l-5.321-4.358H30.777l-5.49,4.377A2.168,2.168,0,0,1,22.557,43.226Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                    </div>
                    <div class="up-notice-content">
                    Hint: To allow users to update their consent
                    <span>You can use the <b>[up_cookie_plugin]</b> shortcode within your sites pages. This will open up the consent modal when clicked.</span>
                    </div> 
                </div>
                <?php if($translating_mode){ up_lang_notice($languages_list, $lang); } ?>
            </div>
        </div>
        <div class="up-option-group">
            <?php 
            //get current settings
            if(!$translating_mode){ 
                global $settings_policy;
            }else{
                if(up_get_option('policy_intro_'.$lang)){
                    $settings_policy = up_get_option('policy_intro_'.$lang);
                }else{
                    global $settings_policy;
                }
            }
            ?>
            <form method="POST">
                <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                <input type="hidden" name="updated" value="true" />
                <input type="hidden" name="update-intro" value="true" />
                <?php if($translating_mode){ ?>
                    <input type="hidden" name="update-intro-lang" value="<?php echo $lang; ?>" />
                <?php } ?>
                <label for="update-widget-title">Widget title:</label>
                <input type="text" name="update-widget-title" value="<?php if(isset($settings_policy['title'])){ echo htmlentities(stripslashes($settings_policy['title'])); }?>" placeholder="Example: This website uses cookies to improve your experience">
                <label for="up-widget-info-short">Widget notice information:</label>
                <textarea id="up-widget-info-short" name="up-widget-info-short" rows="5" cols="50"><?php if(isset($settings_policy['intro-short'])){ echo htmlentities(stripslashes($settings_policy['intro-short'])); }else{ ?> Please update this before activating <?php } ?></textarea>
                <label for="up-widget-info">Cookie policy introduction:</label>
                <textarea id="up-widget-info" name="up-widget-info" rows="10" cols="50"><?php if(isset($settings_policy['intro'])){ echo htmlentities(stripslashes($settings_policy['intro'])); }else{ ?> Please update this before activating <?php } ?></textarea>
                <label for="update-widget-link">Cookie policy link:</label>
                <input type="text" name="update-widget-link" value="<?php if(isset($settings_policy['link'])){ echo htmlentities(stripslashes($settings_policy['link'])); }?>" placeholder="Example: https://yoursite.com/policy">
                <input class="up-custom-submit" type="submit" value="Update Policy Information">
            </form>
        </div>
        </div>
        <?php if($translation_setting){ ?>
        <div class="up-content-inner-widget translation-widget">
            <div class="up-widget-banner">Translations</div>
            <div class="up-widget-content">
                <p>Added translations:</p>
                <?php if($current_supported_langs != null){ ?> 
                    <?php foreach($current_supported_langs as $lang_loop => $active){ 
                        if($active == false){
                            continue;
                        }    
                    ?>
                    <div class="up-lang-group">
                        <p><?php echo $languages_list[$lang_loop]; ?></p>  
                        <div class="up-lang-inner">
                        <a href="?page=up-cookie-consent&tab=page=up-cookie-consent&tab=cookies_scripts&lang=<?php echo $lang_loop; ?>">
                        <?php if($translating_mode && $lang_loop == $lang){ 
                            echo "Selected";
                        }else{ 
                            echo "Select";
                        } ?>
                        </a> 
                        <a href="?page=up-cookie-consent&tab=up_edit_lang&lang=<?php echo $lang_loop; ?>">Translate widget strings</a>
                        </div>
                    </div>
                    <?php } ?>
                <?php }else{ echo "<p>No translations added</p>"; } ?>
                <div class="up-lang-options"><a href="?page=up-cookie-consent&tab=up_add_lang" class="js-up-add-translations">Add language</a><a href="?page=up-cookie-consent&tab=up_remove_lang" class="js-up-remove-translations">Remove language</a></div>
            </div>
            <?php if($translating_mode){ ?>
                    <a class="up-button-return" href="?page=up-cookie-consent&tab=cookies_scripts">Return to English settings</a>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <div class="up-content-title spacing">
        <h2>Select which cookie category to edit</h2>
    </div>
    <div class="up-select-cookie-cat up-admin-cards selectable">
        <?php $cookie_cats_count = 0; foreach($cookie_cats as $current_cat){ ?>
            <?php 
            //Get current settings
            $settings_loop = up_get_option($current_cat['slug']);
            
            if(!isset($settings_loop['toggle'])){
                $settings_loop = array();
                $settings_loop['toggle'] = false;
            }

            if($translating_mode){
                if($settings_loop['toggle'] == false){
                    continue;
                }
            }

            ?>
            <a href="?page=up-cookie-consent&tab=<?php echo $tab; ?>&cat=<?php if(isset($current_cat['slug'])){ echo $current_cat['slug']; }?><?php if($translating_mode){ echo "&lang=$lang"; } ?>#edit" class="up-card <?php if(isset($current_cat['slug'])){ if($cat && $cat == $current_cat['slug']){ echo "selected"; }} ?>">
                <h3 class="up-card-title"><?php if(isset($current_cat['name'])){ echo $current_cat['name']; }?>
                    <span class="up-card-desc"><?php if(isset($current_cat['desc'])){ echo $current_cat['desc']; } ?></span>
                </h3>
                <?php echo up_status($settings_loop['toggle']); ?>
            </a>
        <?php  $cookie_cats_count++; }; ?>
        <?php if($translating_mode && $cookie_cats_count == 0){ echo "No cookie categories are currently enabled within English. Please create them within the default language first."; } ?>
    </div>

    <?php if($cat){
        edit_scripts($cat); 
    }
    ?>
<?php } ?> 

<?php function edit_scripts($cat){ ?>
    <?php 
        global $cookie_cats, $current_supported_langs, $lang;
        if(!isset($cookie_cats)){
            $cookie_cats = array();
        }
        foreach($cookie_cats as $key => $value){
            if(in_array($cat,$value)){
                $key;
                break;
            }
        }


        $translating_mode = false;
        if($lang != null){
            if(!isset($current_supported_langs[$lang])){
                exit;
            }
            $translating_mode = true;
        }

        //Get current settings
        if(!$translating_mode){ 
            $settings = up_get_option($cookie_cats[$key]['slug']);
        }else{
            if(up_get_option($cookie_cats[$key]['slug'].'_'.$lang)){
                $settings = up_get_option($cookie_cats[$key]['slug'].'_'.$lang);
            }else{
                $settings = up_get_option($cookie_cats[$key]['slug']);
            }
        }

        if(!isset($key)){
            exit;
        }
        if(!is_array($settings)){
            $settings = array();
        }
        if(!isset($settings['toggle'])){
            $settings['toggle'] = false;
        };
        if(!isset($settings['default'])){
            $settings['default'] = false;
        };
        if(!isset($settings['desc'])){
            $settings['desc'] = false;
        };
        if(!isset($settings['head'])){
            $settings['head'] = false;
        };
        if(!isset($settings['body'])){
            $settings['body'] = false;
        };

    ?>
    <div class="edit-scripts" id="edit">
        <div class="up-content-title spacing">
            <h2>Editing: <?php echo $cookie_cats[$key]['name']; ?>
                <span><?php echo $cookie_cats[$key]['desc']; ?></span>
            </h2>
        </div>
        <div class="edit-section-col">
            <div class="up-option-group">
                <form method="POST" class="js-up-edit-scripts" >
                    <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                    <input type="hidden" name="updated" value="true" />
                    <input type="hidden" name="update-scripts" value="<?php echo $cookie_cats[$key]['slug']; ?>" />
                    <?php if($translating_mode && $lang){ ?>
                        <input type="hidden" name="update-scripts-lang" value="<?php echo $lang; ?>" />
                    <?php } ?>
                    
                    <div <?php if($translating_mode || $cat == "strictly_necessary"){ echo "style='display:none;'"; }?>>
                        <label for="up-toggle">Show this cookie category</label>
                        <div class="toggle">
                            <input type="checkbox" <?php if($settings['toggle'] == 'on' || $cat == "strictly_necessary"){ echo "checked"; } ?> name="up-toggle">
                            <label></label> 
                        </div>

                        <label for="up-default">Default consent setting</label>
                        <div class="toggle">
                            <input type="checkbox" <?php if($settings['default'] == 'on' || $cat == "strictly_necessary"){ echo "checked"; } ?> name="up-default">
                            <label></label>
                        </div>
                    </div>

                    <label for="up-cat-info"><?php echo $cookie_cats[$key]['name']; ?> description:</label>
                    <textarea  name="up-cat-info" rows="10" cols="50"><?php if($settings['desc']){ echo htmlentities(stripslashes($settings['desc'])); } ?></textarea>

                    <?php if($translating_mode){ ?>

                        <div class="up-notice-language up-hint-box spacing">
                            <div class="up-notice-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>lightbulb</title><g class="lightbulb"><path d="M30.764,30.884c0-2.445,3.585-6.879,3.585-6.879a12.58,12.58,0,1,0-20.7,0s3.585,4.434,3.585,6.879" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M19.153,10.22A8.479,8.479,0,0,0,17.232,12.1a8.381,8.381,0,0,0-1.646,5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M24,8.685a8.468,8.468,0,0,0-1.292.1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><rect x="17.236" y="30.884" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><rect x="17.236" y="34.876" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M22.557,43.226l-5.321-4.358H30.777l-5.49,4.377A2.168,2.168,0,0,1,22.557,43.226Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                            </div>
                            <div class="up-notice-content">
                                Hint: Your currently translating (<?php echo $cookie_cats[$key]['name']; ?>)
                                <span>If you want to use the default English scripts, leave the script tags empty. Alternatively, you can update the script tags with your preferred language to customise the scripts.</span> 
                            </div>
                        </div>

                    <?php } ?>

                    <label for="up-head">HEAD Scripts:</label>
                    <textarea class="code-editor" name="up-head" rows="10" cols="50"><?php if($settings['head']){ echo htmlentities(stripslashes($settings['head'])); } ?></textarea>

                    <label for="up-body">BODY Scripts:</label>
                    <textarea class="code-editor" name="up-body" rows="10" cols="50"><?php if($settings['body']){ echo htmlentities(stripslashes($settings['body'])); } ?></textarea>
                </form>
            </div>
            <div class="up-option-widget">
                <div class="up-widget-banner">
                    Editing: <?php echo $cookie_cats[$key]['name']; if($translating_mode){ echo " [$lang]"; } ?>
                </div>
                <div class="up-widget-content">
                    <p>Don't forget to save your changes each time</p>
                    <a class="js-up-save-changes">Save changes</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php function up_settings(){ ?>
    <?php 
        global $language_strings, $languages_list;
    ?>
    <div class="up-content-title">
        <h2> UP Cookie Consent: Settings & Registration
            <span>Manage plugin configuration and access advanced settings.</span>
        </h2>
    </div>
    <div class="up-option-group">
        <?php 
        //get current settings
        global $settings_policy, $dev_setting, $translation_setting, $multisite_setting;
        ?>
        <form method="POST" class="js-licence-key-wrapper">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="validate_license" value="true" />

            <div class="up-licence-info <?php if(up_check_license()){?> activated <?php }else{ ?> deactivated <?php } ?>">
                <div class="licence-icon">
                <?php if(up_check_license()){?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.282 13.298l4.947 4.947 12.489-12.49"/></svg> 
                <?php }else{ ?>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.437 3.283l9.383 16.949a.5.5 0 0 1-.437.742H2.617a.5.5 0 0 1-.437-.742l9.383-16.949a.5.5 0 0 1 .874 0zM12 15.618V8.389" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/><circle cx="12" cy="18.31" r="1" fill="currentColor"/></svg>
                <?php } ?>
                </div>
                <div class="licence-text">
                    <?php if(up_check_license()){?>
                        Licence active<span>You have a current active licence that expires <b><?php echo up_check_license(true)[1][1]; ?></b></span>
                    <?php }else{ ?>
                     Plugin Licence not activated<span> Please activate your Cookie Plugin licence. Enter the registeration key provided by UP Hotel Agency below.</span>
                    <?php } ?>
                </div>
            </div>

            <label for="validate_license_key">Plugin licence key: Dashes will be added automatically.</label>
            <input type="text" class="js-licence-key" maxlength="14" placeholder="XXX-XXX-XXX" name="validate_license_key" value="<?php if(isset(up_check_license(true)[0])){ echo up_check_license(true)[0]; } ?>">
            <input class="up-custom-submit" type="submit" value="Update licence">
        </form>
    </div>
    <?php if(up_check_license()){ ?>
    <div class="up-content-title  up-section-container-top">
        <h2> Cookie Translations
            <span>Toggle the option to enable or disable translated content.</span>
        </h2>
    </div>
    <div class="up-option-group">
        <form method="POST">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-translation-setting" value="true" />
            <div class="toggle">
                <input type="checkbox" <?php if($translation_setting == 'on'){ echo "checked"; } ?> class="js-form-submit" name="update-translation-setting-toggle">
                <label></label> 
            </div>
        </form>
    </div>
    <div class="up-content-title  up-section-container-top">
        <h2> Multisite Sync
            <span>Site-specific settings. When enabled, settings will apply globally. Otherwise, settings will apply only to current site.</span>
        </h2>
    </div>
    <div class="up-option-group">
        <form method="POST">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-multisite-setting" value="true" />
            <div class="toggle">
                <input type="checkbox" <?php if($multisite_setting == 'on'){ echo "checked"; } ?> class="js-form-submit" name="update-multisite-setting-toggle">
                <label></label> 
            </div>
        </form>
    </div>
    <div class="up-content-title  up-section-container-top">
        <h2> Development Mode
            <span>Toggle this mode on/off to control visibility of the cookie widget and its associated cookies. When in development mode, only front-end admin users who are logged in will be able to see them.</span>
        </h2>
    </div>
    <div class="up-option-group">
        <form method="POST">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-dev-setting" value="true" />
            <div class="toggle">
                <input type="checkbox" <?php if($dev_setting == 'on'){ echo "checked"; } ?> class="js-form-submit" name="update-dev-setting-toggle">
                <label></label> 
            </div>
        </form>
    </div>
    <?php } ?>
<?php } ?> 