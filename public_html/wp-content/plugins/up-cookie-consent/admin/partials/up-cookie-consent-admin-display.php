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
$translation_setting, $multisite_setting, $dev_setting, $reconsent_setting;

$menu_items = array(
    array('slug' => 'dashboard', 'name' => 'Dashboard', 'description' => 'Review status of cookie manager and any actions', 'icon' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><circle cx="4.856" cy="5.751" r="1.5"/><path d="m9.98 5.751h10"/><circle cx="4.856" cy="12" r="1.5"/><path d="m9.98 12h10"/><circle cx="4.856" cy="18.249" r="1.5"/><path d="m9.98 18.249h6.404"/></g></svg>'),
    array('slug' => 'layout', 'name' => 'Theming', 'description' => 'Configure appearance of consent widget & features', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.416 14.438l-3.3 3.3a2.067 2.067 0 0 0 0 2.924 2.069 2.069 0 0 0 2.925 0l3.3-3.3 1.55 1.551a1.95 1.95 0 0 0 2.751 0l1.558-1.549-8.784-8.779-1.551 1.551a1.952 1.952 0 0 0 0 2.751z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.195 17.364l5.853-5.853-8.779-8.779-5.853 5.853m12.681.975l-1.951 1.951m-1.951-5.852L13.244 7.61m3.902 0l-.975.975m4.92 8.356l-1.018-1.528-1.019 1.528a2.386 2.386 0 0 0-.4 1.3 1.414 1.414 0 0 0 1.415 1.415 1.415 1.415 0 0 0 1.415-1.415 2.4 2.4 0 0 0-.393-1.3z"/></svg>'),
    array('slug' => 'cookies_scripts', 'name' => 'Cookies / Scripts', 'description' => 'Configure scripts, policies and consent categories', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="2.589" y="3.669" width="18.822" height="16.663" rx="2" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M2.589 6.994h18.822m-5.584 9.169l2.237-2.245a.375.375 0 0 0 0-.528l-2.237-2.245m-7.654 5.018l-2.237-2.245a.375.375 0 0 1 0-.528l2.237-2.245m2.505 6.198l2.636-7.954" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>'),
    array('slug' => 'up_settings', 'name' => 'Settings', 'description' => 'Manage plugin configuration and access advanced settings.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12.005" r="2.562" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M18.049 15.547a2.551 2.551 0 0 1 2.5-1.258.733.733 0 0 0 .788-.6 9.063 9.063 0 0 0 .022-3.26.734.734 0 0 0-.8-.609 2.546 2.546 0 0 1-2.344-4.062.752.752 0 0 0-.108-1.03A9.471 9.471 0 0 0 15.3 3.091a.753.753 0 0 0-.951.422 2.545 2.545 0 0 1-4.69 0 .753.753 0 0 0-.959-.422 9.471 9.471 0 0 0-2.815 1.633.752.752 0 0 0-.108 1.03 2.546 2.546 0 0 1-2.344 4.062.734.734 0 0 0-.8.609 9.063 9.063 0 0 0 .022 3.26.733.733 0 0 0 .788.6A2.551 2.551 0 0 1 5.825 18.3a.752.752 0 0 0 .126 1.016 9.456 9.456 0 0 0 2.8 1.6.752.752 0 0 0 .938-.4 2.554 2.554 0 0 1 4.63 0 .752.752 0 0 0 .938.4 9.456 9.456 0 0 0 2.8-1.6.752.752 0 0 0 .126-1.016 2.553 2.553 0 0 1-.134-2.753z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>'),
);
$cookie_cats = array(
    array('slug' => 'strictly_necessary', 'name' => 'Strictly Necessary', 'desc' => 'Forced active always'),
    array('slug' => 'functional', 'name' => 'Functional', 'desc' => 'Scripts for the sites functions'),
    array('slug' => 'performance_analytics', 'name' => 'Performance and Analytics', 'desc' => 'Used for performance and statistics'),
    array('slug' => 'advertisement_targeting', 'name' => 'Advertisement and Targeting', 'desc' => 'Provide visitors with relevant ads'),

);

$cookie_layouts = array(
    array('slug' => 'floating_notice', 'name' => 'Floating Notice', 'desc' => 'Appears on bottom left', 'image_src' => plugin_dir_url( __FILE__ ).'../../assets/img/floating_notice.png'),
    array('slug' => 'slim_floating_notice', 'name' => 'Slim Floating Notice', 'desc' => 'Less intrusive notice', 'image_src' => plugin_dir_url( __FILE__ ).'../../assets/img/slim_notice.png'),
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

$reconsent_setting = up_get_option('reconsent_setting') ?? false;
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
        <div class="up-dev-banner">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="2.589" y="3.669" width="18.822" height="16.663" rx="2" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"></rect><path d="M2.589 6.994h18.822m-5.584 9.169l2.237-2.245a.375.375 0 0 0 0-.528l-2.237-2.245m-7.654 5.018l-2.237-2.245a.375.375 0 0 1 0-.528l2.237-2.245m2.505 6.198l2.636-7.954" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
            <span>Attention: You are currently in development mode, which means the cookie widget won't be visible to front-end users. To turn off this mode, please go to the settings tab.</span>
        </div>
    <?php } ?>
    <div class="up-content">
        <div class="up-menu">
            <div class="up-menu-sticky">
                <?php foreach($menu_items as $item){ ?>
                    <a href="?page=up-cookie-consent&tab=<?php if(isset($item['slug'])){  echo $item['slug']; }?>" class="<?php if(isset($item['slug'])){if($tab == $item['slug']){ echo "active"; }} ?>">
                        <div class="up-menu-icon">
                            <?php if(isset($item['icon'])){ echo $item['icon']; } ?>
                        </div>
                        <div class="up-menu-name">
                            <span><?php if(isset($item['name'])){ echo $item['name']; } ?></span>
                            <span><?php if(isset($item['description'])){ echo $item['description']; } ?></span>
                        </div>
                    </a>
                <?php } ?>
            </div>
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

<?php up_legacy_check(); ?>

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

    <?php
        $master_key = false;
        $theme_options = false;
        $theme_choices = false;
        $palette_choices = false;
        if ( class_exists( 'acf' ) ): 
            $groups = acf_get_field_groups();
            if(is_array($groups)):
                foreach($groups as $group):
                    if($group['title'] == "Master Fields"):
                        $master_key = $group['key'];
                    endif; 
                endforeach;
            endif;

            if($master_key):
                $theme_options = acf_get_fields($master_key);
                $theme_options = $theme_options[0]['sub_fields'];
                if(is_array($theme_options)):
                    foreach($theme_options as $option):

                        //Theme
                        if($option['name'] == "theme_select"):
                            if(isset($option['choices'])):
                                $theme_choices = $option['choices'];
                            endif;
                        endif;

                        //Paletter (if supported)
                        if($option['name'] == "palette_select"):
                            if(isset($option['choices'])):
                                $palette_choices = $option['choices'];
                            endif;
                        endif;

                    endforeach;
                endif;
            endif;
        endif;

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
            <span>Choose whether you prefer to utilize the pre-existing fonts and styles or your themes custom ones. </span>
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
    <?php if($palette_choices): ?>
        <div class="up-content-title">
            <h2>Use default spacing variables
                <span>We have detected that this theme may support it's own variables. Disable overwrites here.</span>
            </h2>
            <form method="POST" class="js-widget-setting">
                <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                <input type="hidden" name="updated" value="true" />
                <input type="hidden" name="update-widget-variables" value="true" />
                <div class="toggle">
                    <input type="checkbox" <?php if(up_get_option('widget_variables') == true){ echo "checked"; } ?> class="js-form-submit" name="update-widget-setting-toggle">
                    <label></label> 
                </div>
            </form>
        </div>
    <?php endif; ?>
    <div class="up-content-title">
        <h2>Show a reject all button on the initial popup  
            <span>Allow users to decline all cookies except necessary without opening the full options view </span>
        </h2>
        <form method="POST" class="js-widget-setting">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-widget-reject" value="false" />
            <div class="toggle">
                <input type="checkbox" <?php if(up_get_option('widget_reject') == true){ echo "checked"; } ?> class="js-form-submit" name="update-widget-setting-toggle">
                <label></label> 
            </div>
        </form>
    </div>
    <div class="up-content-title">
        <h2>Show 'UP Hotel Agency' provider credit
            <span>A small credit shown at the bottom of the cookie consent widget</span>
        </h2>
        <form method="POST" class="js-widget-setting">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-widget-advert" value="true" />
            <div class="toggle">
                <input type="checkbox" <?php if(up_get_option('widget_advert') == true){ echo "checked"; } ?> class="js-form-submit" name="update-widget-setting-toggle">
                <label></label> 
            </div>
        </form>
    </div>
    </div>
    <div class="up-section-container-top">
    <?php global $widget_colors; ?>
    <div class="up-content-title no-spacing">
        <h2>Widget colours
            <span>Update the colours of the widget. </span>
        </h2>
        <?php if($theme_choices): ?>
            <div class="up-notice">
                <div class="up-notice-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.282 13.298l4.947 4.947 12.489-12.49"></path></svg> 
                </div>
                <div class="up-notice-content">
                    Site colour themes available
                    <span>We've detected this site may support auto colour detection & themes</span> 
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if($theme_choices): ?>

        <div class="up-option-selector up-js-color-mode">
            <div class="up-option-select <?php if(isset($widget_colors['color_mode'])): if($widget_colors['color_mode'] == "auto"): ?> active <?php endif; endif;?>" data-mode="auto">
                Auto Detect
            </div>
            <div class="up-option-select <?php if(isset($widget_colors['color_mode'])): if($widget_colors['color_mode'] == "manual"): ?> active <?php endif; else: ?> active <?php endif;?>" data-mode="manual">
                Manual Selection
            </div>
        </div>
    <?php endif; ?>
    <?php
    ?>
    <form method="POST" class="up-option-group">
    <div class="widget-color-selectors">
        <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
        <input type="hidden" name="updated" value="true" />
        <input type="hidden" name="update-colors" value="true" />
        <input type="hidden" name="update-mode" value="<?php if(isset($widget_colors['color_mode'])): echo $widget_colors['color_mode']; else: ?>manual<?php endif; ?>" />
        <div class="up-color-type <?php if(isset($widget_colors['color_mode'])): if($widget_colors['color_mode'] == "manual"): ?> active <?php endif; else: ?> active <?php endif;?>" data-type="manual">
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
        <?php if($theme_choices): ?>
            <div class="up-color-type <?php if(isset($widget_colors['color_mode'])): if($widget_colors['color_mode'] == "auto"): ?> active <?php endif; endif;?>" data-type="auto">
                <div class="up-options-wrap">
                    <label>Theme preview:</label>
                    <div class="up-theme-preview js-up-theme-preview"></div>
                </div>
                <?php if($palette_choices): ?>
                    <div class="up-options-wrap">
                        <label for="color-palette">Colour Palette:</label>
                        <select class="up-js-color-theme" name="color-palette">
                            <?php
                            foreach( $palette_choices as $theme_value => $theme_choice):
                                if($theme_choice == "Video" || $theme_choice == "Image" || $theme_choice == "Custom"):
                                    continue;
                                endif;
                                ?>
                                <option 
                                <?php if(isset($widget_colors['color_palette'])): if($widget_colors['color_palette'] == $theme_value): ?> selected <?php endif; endif; ?>
                                value="<?php echo $theme_value;?>">Palette <?php echo $theme_choice; ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="up-options-wrap">
                    <label for="color-theme">Colour Theme:</label>
                    <select class="up-js-color-theme" name="color-theme">
                        <?php
                        foreach($theme_choices as $theme_value => $theme_choice):
                            if($theme_choice == "Video" || $theme_choice == "Image" || $theme_choice == "Custom"):
                                continue;
                            endif;
                            ?>
                            <option
                            <?php if(isset($widget_colors['color_theme'])): if($widget_colors['color_theme'] == $theme_value): ?> selected <?php endif; endif; ?>
                            value="<?php echo $theme_value;?>">Theme <?php echo $theme_choice; ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
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
    <div class="up-notice">
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

        //Check if GTM has already been connected
        $gtm_connected = up_get_option('gtm_connect');

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

    <script>
        var up_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>

    <div class="up-section-col">
        <div class="up-content-inner">
        <div class="up-content-title">
            <h2> Cookie widget setup
                <span>Setting for your cookies, scripts and user information</span>
            </h2>
            <div class="up-notices-section">
                <div class="up-notice up-hint-box spacing">
                    <div class="up-notice-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>lightbulb</title><g class="lightbulb"><path d="M30.764,30.884c0-2.445,3.585-6.879,3.585-6.879a12.58,12.58,0,1,0-20.7,0s3.585,4.434,3.585,6.879" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M19.153,10.22A8.479,8.479,0,0,0,17.232,12.1a8.381,8.381,0,0,0-1.646,5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M24,8.685a8.468,8.468,0,0,0-1.292.1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><rect x="17.236" y="30.884" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><rect x="17.236" y="34.876" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M22.557,43.226l-5.321-4.358H30.777l-5.49,4.377A2.168,2.168,0,0,1,22.557,43.226Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                    </div>
                    <div class="up-notice-content">
                    Hint: To display details about this policy and enable re-consent on your pages.
                    <span>You can use the <b>[up_cookie_list]</b> shortcode on your site’s pages to display your policy information and give users the option to re-consent.</span>
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
        <h2>Select which cookie category to <?php if(!$translating_mode): ?>edit<?php else: ?>translate<?php endif; ?></h2>
    </div>
    <?php if(!$translating_mode): ?>
        <div class="up-gtm-connect up-admin-cards selectable">
            <?php if($gtm_connected == false): ?>
                <div class="up-gtm-card up-card" status="false">
                    <svg width="50px" height="50px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">    <g>        <polygon fill="#8AB4F8" points="150.261818 245.516364 105.825455 202.185455 201.258182 104.730909 247.265455 149.821818"></polygon>        <path d="M150.450909,53.9381818 L106.174545,8.73090909 L9.36,104.629091 C-3.12,117.109091 -3.12,137.341818 9.36,149.836364 L104.72,245.821818 L149.810909,203.64 L77.1563636,127.232727 L150.450909,53.9381818 Z" fill="#4285F4"></path>        <path d="M246.625455,105.370909 L150.625455,9.37090909 C138.130909,-3.12363636 117.869091,-3.12363636 105.374545,9.37090909 C92.88,21.8654545 92.88,42.1272727 105.374545,54.6218182 L201.374545,150.621818 C213.869091,163.116364 234.130909,163.116364 246.625455,150.621818 C259.12,138.127273 259.12,117.865455 246.625455,105.370909 Z" fill="#8AB4F8"></path>        <circle fill="#246FDB" cx="127.265455" cy="224.730909" r="31.2727273"></circle>    </g></svg>
                    <span> Connect your Google Tag Manger Account</span>
                    <div class="up-gtm-card-add">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20V4m-8 8h16"></path></svg>
                    </div>
                </div>
            <?php else: ?>
                <div class="up-gtm-card up-card" status="true">
                    <svg width="50px" height="50px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">    <g>        <polygon fill="#8AB4F8" points="150.261818 245.516364 105.825455 202.185455 201.258182 104.730909 247.265455 149.821818"></polygon>        <path d="M150.450909,53.9381818 L106.174545,8.73090909 L9.36,104.629091 C-3.12,117.109091 -3.12,137.341818 9.36,149.836364 L104.72,245.821818 L149.810909,203.64 L77.1563636,127.232727 L150.450909,53.9381818 Z" fill="#4285F4"></path>        <path d="M246.625455,105.370909 L150.625455,9.37090909 C138.130909,-3.12363636 117.869091,-3.12363636 105.374545,9.37090909 C92.88,21.8654545 92.88,42.1272727 105.374545,54.6218182 L201.374545,150.621818 C213.869091,163.116364 234.130909,163.116364 246.625455,150.621818 C259.12,138.127273 259.12,117.865455 246.625455,105.370909 Z" fill="#8AB4F8"></path>        <circle fill="#246FDB" cx="127.265455" cy="224.730909" r="31.2727273"></circle>    </g></svg>
                        <div class="up-gtm-connected-logo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3.282 13.298l4.947 4.947 12.489-12.49"/></svg>
                        </div>
                    <span> Connected to your GTM Account <span class="up-gtm-label">(<?php echo $gtm_connected; ?>)</span></span>
                    <button class="up-gtm-settings">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12.005" r="2.562" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M18.049 15.547a2.551 2.551 0 0 1 2.5-1.258.733.733 0 0 0 .788-.6 9.063 9.063 0 0 0 .022-3.26.734.734 0 0 0-.8-.609 2.546 2.546 0 0 1-2.344-4.062.752.752 0 0 0-.108-1.03A9.471 9.471 0 0 0 15.3 3.091a.753.753 0 0 0-.951.422 2.545 2.545 0 0 1-4.69 0 .753.753 0 0 0-.959-.422 9.471 9.471 0 0 0-2.815 1.633.752.752 0 0 0-.108 1.03 2.546 2.546 0 0 1-2.344 4.062.734.734 0 0 0-.8.609 9.063 9.063 0 0 0 .022 3.26.733.733 0 0 0 .788.6A2.551 2.551 0 0 1 5.825 18.3a.752.752 0 0 0 .126 1.016 9.456 9.456 0 0 0 2.8 1.6.752.752 0 0 0 .938-.4 2.554 2.554 0 0 1 4.63 0 .752.752 0 0 0 .938.4 9.456 9.456 0 0 0 2.8-1.6.752.752 0 0 0 .126-1.016 2.553 2.553 0 0 1-.134-2.753z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                        Settings
                    </button>
                    <form method="POST" class="js-gtm-disconnect-form">
                        <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                        <input type="hidden" name="updated" value="true" />
                        <input type="hidden" name="disconnect-gtm" value="true" />
                    </form>
                </div>
            <?php endif; ?>

            <?php 

                $gtm_setup_steps = array(
                    array(
                        "id" => "add_gtm",
                        "title" => "Add GTM ID",
                    ),
                    array(
                        "id" => "check_gtm",
                        "title" => "Validate GTM",
                    ),
                    array(
                        "id" => "gtm_scan",
                        "title" => "Cookie Scan",
                    ),
                    array(
                        "id" => "finish_gtm",
                        "title" => "Finish Setup",
                    ),
                )

            ?>
            <div class="up-gtm-setup-container">
                <div class="up-gtm-setup-modal">
                    <header class="up-gtm-modal-header">
                        <div class="up-header-title">
                            <svg class="up-gtm-logo" width="50px" height="50px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">    <g>        <polygon fill="#8AB4F8" points="150.261818 245.516364 105.825455 202.185455 201.258182 104.730909 247.265455 149.821818"></polygon>        <path d="M150.450909,53.9381818 L106.174545,8.73090909 L9.36,104.629091 C-3.12,117.109091 -3.12,137.341818 9.36,149.836364 L104.72,245.821818 L149.810909,203.64 L77.1563636,127.232727 L150.450909,53.9381818 Z" fill="#4285F4"></path>        <path d="M246.625455,105.370909 L150.625455,9.37090909 C138.130909,-3.12363636 117.869091,-3.12363636 105.374545,9.37090909 C92.88,21.8654545 92.88,42.1272727 105.374545,54.6218182 L201.374545,150.621818 C213.869091,163.116364 234.130909,163.116364 246.625455,150.621818 C259.12,138.127273 259.12,117.865455 246.625455,105.370909 Z" fill="#8AB4F8"></path>        <circle fill="#246FDB" cx="127.265455" cy="224.730909" r="31.2727273"></circle>    </g></svg>
                            <?php if(!$gtm_connected): ?>
                                <span>Google Tag Manger - Setup</span>
                            <?php else: ?>
                                <span>Google Tag Manger - Settings</span>
                                <span class="up-gtm-connected">Connected</span>
                            <?php endif; ?>
                            <span class="up-gtm-modal-close">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245l14.49-14.49m0 14.49L4.755 4.755"/></svg>
                            </span>
                        </div>
                        <div class="up-gtm-setup-progress-container  <?php if(!$gtm_connected): ?>active <?php endif; ?>">
                            <div class="up-gtm-setup-steps">
                                <?php foreach($gtm_setup_steps as $step): ?>
                                    <div class="up-gtm-step <?php if($step['id'] == "add_gtm"): ?> active <?php endif; ?>" step-id="<?php echo $step['id']; ?>">
                                        <div class="up-gtm-step-icon"></div>
                                        <span><?php echo $step['title']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </header>
                    <div class="up-gtm-setup-content">

                            <div class="up-gtm-step-container <?php if(!$gtm_connected): ?> view-fixed active <?php endif; ?>" step-id="add_gtm">
                                <h2>Enter your GTM ID
                                    <span>You can find your ID within the Google Tag Manager dashboard</span>
                                </h2>
                                <form method="POST" class="js-gtm-connect-form">
                                    <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                                    <input type="hidden" name="updated" value="true" />
                                    <input type="hidden" name="update-gtm-connect" value="true" />
                                    <input type="hidden" name="update-gtm-connect-function" value="gtm-new" />
                                    <input type="hidden" name="up-gtm-cookies" value="false" />
                                    <input name="up-gtm-id" type="text" placeholder="GTM-XXXXX" <?php if($gtm_connected): ?> value="<?php echo $gtm_connected; ?>" <?php endif; ?>>
                                </form>
                                <button class="up-gtm-setup-button">
                                    <span>Continue</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.982 12h-16m10.351-5.685L20.018 12l-5.685 5.685"/></svg>
                                </button>
                            </div>
                            <div class="up-gtm-step-container" step-id="all">
                        
                            </div>
                        <?php if($gtm_connected): ?>
                            <?php
                                $gtm_cookies = (array)json_decode(up_get_option('gtm_cookies'));
                                if(!is_array($gtm_cookies)):
                                    $gtm_cookies = array(); // Empty
                                endif;
                            ?>
                            <div class="up-gtm-step-container view-fixed active" step-id="settings">
                                <h2>Your GTM is connected
                                    <span>We've detected <?php echo count($gtm_cookies); ?> cookies that were loaded within (<?php echo $gtm_connected; ?>)</span>
                                </h2>
                                <?php 
                                    //Check for unassigned cookies 
                                    $unassigned_cookies = array();
                                    foreach($gtm_cookies as $cookie_name => $assignment):
                                        if(!$assignment){
                                            array_push($unassigned_cookies, $cookie_name);
                                        }
                                    endforeach;
                                    if($unassigned_cookies):
                                        ?>
                                        <div class="up-gtm-unassigned-cookies">
                                            <p><?php echo count($unassigned_cookies); ?> cookie(s) weren't able to be automatically assigned to a category</p>
                                            <?php foreach($unassigned_cookies as $u_cookie): ?>
                                                <div class="up-gtm-unassigned-cookie js-assign-cookie" data-cookie-name="<?php echo $u_cookie; ?>">
                                                    <div class="up-gtm-unassigned-content"> 
                                                        <span>Cookie Name: <b><?php echo $u_cookie; ?></b></span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.685 9.158L12 14.842 6.315 9.158"/></svg>
                                                    </div>
                                                    <div class="up-gtm-unassigned-dropdown">
                                                        <form method="POST" class="js-gtm-connect-form">
                                                            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                                                            <input type="hidden" name="updated" value="true" />
                                                            <input type="hidden" name="update-gtm-connect" value="true">
                                                            <input type="hidden" name="update-gtm-connect-function" value="update-cookie"/>
                                                            <input type="hidden" name="up-cookie-name" value="<?php echo $u_cookie; ?>" />
                                                            <select name="up-cookie-cat">
                                                                <?php foreach($cookie_cats as $x): ?>
                                                                    <?php if($x['slug'] == "strictly_necessary"): continue; endif; ?>
                                                                    <option value="<?php echo $x['slug']; ?>"><?php echo $x['name'];?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <input type="submit" value="Save">
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php
                                    endif; 
                                ?>
                                <div class="up-gtm-actions">
                                    <button class="up-gtm-disconnect">
                                        <svg width="50px" height="50px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.617 3.844a2.87 2.87 0 0 0-.451-.868l1.354-1.36L13.904 1l-1.36 1.354a2.877 2.877 0 0 0-.868-.452 3.073 3.073 0 0 0-2.14.075 3.03 3.03 0 0 0-.991.664L7 4.192l4.327 4.328 1.552-1.545c.287-.287.508-.618.663-.992a3.074 3.074 0 0 0 .075-2.14zm-.889 1.804a2.15 2.15 0 0 1-.471.705l-.93.93-3.09-3.09.93-.93a2.15 2.15 0 0 1 .704-.472 2.134 2.134 0 0 1 1.689.007c.264.114.494.271.69.472.2.195.358.426.472.69a2.134 2.134 0 0 1 .007 1.688zm-4.824 4.994l1.484-1.545-.616-.622-1.49 1.551-1.86-1.859 1.491-1.552L6.291 6 4.808 7.545l-.616-.615-1.551 1.545a3 3 0 0 0-.663.998 3.023 3.023 0 0 0-.233 1.169c0 .332.05.656.15.97.105.31.258.597.459.862L1 13.834l.615.615 1.36-1.353c.265.2.552.353.862.458.314.1.638.15.97.15.406 0 .796-.077 1.17-.232.378-.155.71-.376.998-.663l1.545-1.552-.616-.615zm-2.262 2.023a2.16 2.16 0 0 1-.834.164c-.301 0-.586-.057-.855-.17a2.278 2.278 0 0 1-.697-.466 2.28 2.28 0 0 1-.465-.697 2.167 2.167 0 0 1-.17-.854 2.16 2.16 0 0 1 .642-1.545l.93-.93 3.09 3.09-.93.93a2.22 2.22 0 0 1-.711.478z"/></svg>
                                        Disconnect
                                    </button>
                                    <form method="POST" class="js-gtm-disconnect-form">
                                        <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                                        <input type="hidden" name="updated" value="true" />
                                        <input type="hidden" name="disconnect-gtm" value="true" />
                                    </form>
                                    <button class="up-gtm-re-scan js-rescan-gtm-cookies" data-gtm="<?php echo $gtm_connected; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.39 20.39l-7.48-7.48"/><circle cx="9.059" cy="9.059" r="5.449" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                        Re-scan
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="up-select-cookie-cat up-admin-cards selectable">
        <?php $cookie_cats_count = 0; foreach($cookie_cats as $current_cat){ ?>
            <?php 
            //Get current settings
            $settings_loop = up_get_option($current_cat['slug']);
            
            if(!isset($settings_loop['toggle'])){
                $settings_loop = array();
                $settings_loop['toggle'] = false;
            }

            if($gtm_connected):
                $settings_loop['toggle'] = true;
            endif; 

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
                <div class="up-toggle-wrap">
                    <?php if($gtm_connected && $current_cat['slug'] != "strictly_necessary"): ?>
                        <div class="up-gtm-connected-status">
                            <svg width="50px" height="50px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">    <g>        <polygon fill="#8AB4F8" points="150.261818 245.516364 105.825455 202.185455 201.258182 104.730909 247.265455 149.821818"></polygon>        <path d="M150.450909,53.9381818 L106.174545,8.73090909 L9.36,104.629091 C-3.12,117.109091 -3.12,137.341818 9.36,149.836364 L104.72,245.821818 L149.810909,203.64 L77.1563636,127.232727 L150.450909,53.9381818 Z" fill="#4285F4"></path>        <path d="M246.625455,105.370909 L150.625455,9.37090909 C138.130909,-3.12363636 117.869091,-3.12363636 105.374545,9.37090909 C92.88,21.8654545 92.88,42.1272727 105.374545,54.6218182 L201.374545,150.621818 C213.869091,163.116364 234.130909,163.116364 246.625455,150.621818 C259.12,138.127273 259.12,117.865455 246.625455,105.370909 Z" fill="#8AB4F8"></path>        <circle fill="#246FDB" cx="127.265455" cy="224.730909" r="31.2727273"></circle>    </g></svg>
                        </div>
                    <?php endif; ?>
                    <?php echo up_status($settings_loop['toggle']); ?>
                </div>
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

        //Check if GTM has already been connected
        $gtm_connected = up_get_option('gtm_connect');

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

        if(!isset($settings['groups'])){
            $groups = array();
            $group_ids = json_encode(array());
        }else{
            $groups = (array)json_decode($settings['groups']);
            $group_ids = json_encode(array_keys((array)json_decode($settings['groups'])));
        }

        if($cat == "strictly_necessary"){
            $strictly_necessary = $settings['strictly_necessary'] ?? false; 
        }

        //Groups translations sync
        if($translating_mode){
            $og_settings = up_get_option($cookie_cats[$key]['slug']);
            if(isset($og_settings['groups'])){
                $og_groups = (array)json_decode($og_settings['groups']);
                $og_group_ids = json_encode(array_keys((array)json_decode($og_settings['groups'])));
                $synced_groups = array();

                //Create a synced list of groups
                foreach(json_decode($og_group_ids) as $id){
                    //If this group exists within the translations
                    if(in_array($id, json_decode($group_ids))){

                        //Add the translated group
                        $synced_groups[$id] = $groups[$id];
                    }else{

                        //Add the og group
                        $synced_groups[$id]= $og_groups[$id];
                    }
                }


                //Use synced list of groups to check cookies 
                foreach($synced_groups as $id => $group){

                    $synced_cookies = array();

                    //Check that the synced group contains the same cookies 
                    if($group->cookies){
                        $cookies = json_decode(stripslashes($group->cookies));

                        //Get the og groups cookies
                        $og_cookies = json_decode(stripslashes($og_groups[$id]->cookies));

                        foreach($og_cookies as $og_cookie){                            
                            $found = false;
                            foreach ($cookies as $cookie) {
                                if ($og_cookie->name == $cookie->name) {
                                    $found = true;
                                    array_push($synced_cookies, $cookie);
                                    break;
                                }
                            }
                            if($found == false){
                                array_push($synced_cookies, $og_cookie);
                            }
                        }
                        $group->cookies = json_encode($synced_cookies);
                    }

                }

                //Check Strictly Necessary
                if($cat == "strictly_necessary"): 
                    $og_cookies = json_decode(stripslashes($og_settings["strictly_necessary"]));
                    $cookies = json_decode(stripslashes($strictly_necessary));
                    $synced_cookies = array();

                    foreach($og_cookies as $og_cookie){                            
                        $found = false;
                        foreach ($cookies as $cookie) {
                            if ($og_cookie->name == $cookie->name) {
                                $found = true;
                                array_push($synced_cookies, $cookie);
                                break;
                            }
                        }
                        if($found == false){
                            array_push($synced_cookies, $og_cookie);
                        }
                    }

                    $strictly_necessary = json_encode($synced_cookies);

                endif; 
            
                //Finish up
                $groups = $synced_groups;
                $group_ids = $og_group_ids;
            }
        }

        if(!isset($settings['head'])){
            $settings['head'] = false;
        };
        if(!isset($settings['body'])){
            $settings['body'] = false;
        };
    ?>

    <div class="up-cookie-info-modal" cookie-name>
        <div class="up-cookie-info-modal-container up-option-group">
            <h2>Editing Cookie: <span class="js-up-cookie-name"></span></h2>
            <div class="up-close-cookie-info-modal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.523 16.477l8.954-8.954m0 8.954L7.523 7.523"/></svg>
            </div>
            <form class="up-cookie-info-form">
                <label for="up-cookie-name">Cookie Name:</label>
                <input type="text" disabled name="up-cookie-name"></input>
                <label for="up-cookie-description">Cookie Description:</label>
                <input type="text" name="up-cookie-description"></input>
                <label for="up-cookie-description">Cookie Platform:</label>
                <input type="text" name="up-cookie-platform"></input>
                <label for="up-cookie-retention">Cookie Retention Period:</label>
                <input type="text" name="up-cookie-retention"></input>
                <label for="up-cookie-gdpr">Cookie User Privacy & GDPR Rights Portals:</label>
                <input type="text" name="up-cookie-gdpr"></input>
                <input type="submit" class="up-custom-submit" value="Update Cookie Information">
            </form>
        </div>
    </div>
    
    <div class="edit-scripts" id="edit">
        <?php 
            $version_number = up_get_option('policy_version');
            if(!$version_number){
                $version_number = array(0, "Not recorded");
            }
        ?>
        <div class="up-content-title spacing no-spacing-bottom">
            <h2><?php if(!$translating_mode): ?>Editing: <?php else: ?> Translating: <?php endif; ?>  <?php echo $cookie_cats[$key]['name']; ?>
                <span><?php echo $cookie_cats[$key]['desc']; ?></span>
                <span class="up-version-widget">Current version: <?php if(isset($version_number[0])): echo $version_number[0]; endif; ?> <?php if(isset($version_number[1])): echo "- Last updated: ".$version_number[1]; endif; ?></span>
            </h2>
        </div>
        <div class="edit-section-col">
            <div class="up-option-group">
                <form method="POST" class="js-up-edit-scripts" >
                    <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
                    <input type="hidden" name="updated" value="true" />
                    <input type="hidden" name="update-scripts" value="<?php echo $cookie_cats[$key]['slug']; ?>" />
                    <input type="hidden" name="group-ids" value='<?php echo $group_ids; ?>' />

                    <?php if($translating_mode && $lang){ ?>
                        <input type="hidden" name="update-scripts-lang" value="<?php echo $lang; ?>" />
                    <?php } ?>
                    
                    <div <?php if($translating_mode || $cat == "strictly_necessary"){ echo "style='display:none;'"; }?>>
                        <?php if(!$gtm_connected): ?>
                            <label for="up-toggle">Show this cookie category</label>
                            <div class="toggle">
                                <input type="checkbox" <?php if($settings['toggle'] == 'on' || $cat == "strictly_necessary"){ echo "checked"; } ?> name="up-toggle">
                                <label></label> 
                            </div>
                        <?php endif; ?>

                        <label for="up-default">Default consent setting</label>
                        <div class="toggle">
                            <input type="checkbox" <?php if($settings['default'] == 'on' || $cat == "strictly_necessary"){ echo "checked"; } ?> name="up-default">
                            <label></label>
                        </div>
                    </div>

                    <label for="up-cat-info"><?php echo $cookie_cats[$key]['name']; ?> description:</label>
                    <textarea  name="up-cat-info" rows="10" cols="50"><?php if($settings['desc']){ echo htmlentities(stripslashes($settings['desc'])); } ?></textarea>

                    <?php if($translating_mode){ ?>

                        <div class="up-notice up-hint-box spacing">
                            <div class="up-notice-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>lightbulb</title><g class="lightbulb"><path d="M30.764,30.884c0-2.445,3.585-6.879,3.585-6.879a12.58,12.58,0,1,0-20.7,0s3.585,4.434,3.585,6.879" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M19.153,10.22A8.479,8.479,0,0,0,17.232,12.1a8.381,8.381,0,0,0-1.646,5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><path d="M24,8.685a8.468,8.468,0,0,0-1.292.1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><rect x="17.236" y="30.884" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><rect x="17.236" y="34.876" width="13.542" height="3.992" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M22.557,43.226l-5.321-4.358H30.777l-5.49,4.377A2.168,2.168,0,0,1,22.557,43.226Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                            </div>
                            <div class="up-notice-content">
                                Hint: Your currently translating (<?php echo $cookie_cats[$key]['name']; ?>)
                                <span>You can translate information about a cookie, and provide different URLS for privicy polices </span> 
                            </div>
                        </div>

                    <?php } ?>

                    <div class="up-accordion-container <?php if($translating_mode): ?> up-accordion-translations <?php endif; ?>">
                        <?php if($cat == "strictly_necessary"): ?>

                            <?php
                                $id = "strictly_necessary";
                            ?>

                            <div class="up-accordion default-active" group-id="<?php echo $id; ?>">
                                <div class="up-accordion-header">
                                    <div class="up-accordion-desc-container">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><ellipse cx="12" cy="12" rx="3.144" ry="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12h19M4.069 6.771h15.862M4.069 17.229h15.862"/></svg>
                                        <h2>Strictly Necessary</h2> 
                                    </div>
                                    <div class="up-accordion-actions-wrap">
                                        <div class="up-group-validation">
                                            <?php if($strictly_necessary): ?>
                                                <span class="up-valid">Validated</span>
                                            <?php else: ?>
                                                <span class="up-not-valid">Awaiting Validation</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>  
                                <div class="up-accordion-content">
                                    <div class="up-content-title no-spacing">
                                        <h2>
                                            Site necessary cookies
                                            <span>Detect cookies that are always loaded and are required for site functionality</span>
                                        </h2>
                                    </div>
                                    <div class="up-accordion-cookies">
                                        <div class="up-accordion-cookies-header js-up-scan up-found-cookies <?php if($strictly_necessary): ?>active<?php endif; ?>">
                                            <div class="up-accordion-cookies-wrap">
                                                <svg fill="currentColor" height="800px" width="800px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 	 viewBox="0 0 299.049 299.049" xml:space="preserve"><g>	<g>		<g>			<path d="M289.181,206.929c-13.5-12.186-18.511-31.366-12.453-48.699c1.453-4.159-0.94-8.686-5.203-9.82				c-27.77-7.387-41.757-38.568-28.893-64.201c2.254-4.492-0.419-9.898-5.348-10.837c-26.521-5.069-42.914-32.288-34.734-58.251				c1.284-4.074-1.059-8.414-5.178-9.57C184.243,1.867,170.626,0,156.893,0C74.445,0,7.368,67.076,7.368,149.524				s67.076,149.524,149.524,149.524c57.835,0,109.142-33.056,133.998-83.129C292.4,212.879,291.701,209.204,289.181,206.929z				 M156.893,283.899c-74.095,0-134.374-60.281-134.374-134.374S82.799,15.15,156.893,15.15c9.897,0,19.726,1.078,29.311,3.21				c-5.123,29.433,11.948,57.781,39.41,67.502c-9.727,29.867,5.251,62.735,34.745,74.752c-4.104,19.27,1.49,39.104,14.46,53.365				C251.758,256.098,207.229,283.899,156.893,283.899z"/>			<path d="M76.388,154.997c-13.068,0-23.7,10.631-23.7,23.701c0,13.067,10.631,23.7,23.7,23.7c13.067,0,23.7-10.631,23.7-23.7				C100.087,165.628,89.456,154.997,76.388,154.997z M76.388,187.247c-4.715,0-8.55-3.835-8.55-8.55s3.835-8.551,8.55-8.551				c4.714,0,8.55,3.836,8.55,8.551S81.102,187.247,76.388,187.247z"/>			<path d="M173.224,90.655c0-14.9-12.121-27.021-27.02-27.021s-27.021,12.121-27.021,27.021c0,14.898,12.121,27.02,27.021,27.02				C161.104,117.674,173.224,105.553,173.224,90.655z M134.334,90.655c0-6.545,5.325-11.871,11.871-11.871				c6.546,0,11.87,5.325,11.87,11.871s-5.325,11.87-11.87,11.87S134.334,97.199,134.334,90.655z"/>			<path d="M169.638,187.247c-19.634,0-35.609,15.974-35.609,35.61c0,19.635,15.974,35.61,35.609,35.61				c19.635,0,35.61-15.974,35.61-35.61C205.247,203.221,189.273,187.247,169.638,187.247z M169.638,243.315				c-11.281,0-20.458-9.178-20.458-20.46s9.178-20.46,20.458-20.46c11.281,0,20.46,9.178,20.46,20.46				S180.92,243.315,169.638,243.315z"/>		</g>	</g></g></svg>
                                                <span>Found <?php if($strictly_necessary): echo count(json_decode(stripslashes($strictly_necessary))); endif; ?> cookies</span>  
                                            </div>
                                            <div class="up-accordion-cookies-wrap up-cookies-toggle">
                                                Details
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.685 9.158L12 14.842 6.315 9.158"/></svg> 
                                            </div> 
                                        </div>                            
                                        <div class="up-accordion-cookies-header js-up-scan up-no-cookies <?php if(!$strictly_necessary): ?>active<?php endif; ?>">
                                            <div class="up-accordion-cookies-wrap">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9.856v7.229"/><circle cx="12" cy="6.915" r="1" fill="currentColor"/></svg>
                                                <span> No cookies found (awaiting validation) </span>    
                                            </div>
                                        </div>    
                                        <ul class="up-accordion-cookies-info">
                                            <?php 
                                                if($strictly_necessary): 
                                                    $cookies = json_decode(stripslashes($strictly_necessary));
                                                    foreach($cookies as $cookie):
                                                        ?>
                                                            <li group-id="<?php echo $id; ?>" cookie-name="<?php echo $cookie->name; ?>">
                                                                <?php if($cookie->wildcard): ?>
                                                                    <span><?php echo "$cookie->wildcard*ID*"; ?></span>
                                                                <?php else: ?>
                                                                    <span><?php echo $cookie->name; ?></span>
                                                                <?php endif; ?>
                                                                <span><?php echo $cookie->description;?></span>
                                                                <span><?php echo $cookie->platform; ?></span>
                                                                <?php if(!$translating_mode): ?>
                                                                    <span class='delete-cookie-info'>Delete</span>
                                                                <?php endif; ?>
                                                                <span class='edit-cookie-info'><?php if(!$translating_mode): ?>Edit<?php else:?>Translate<?php endif;?></span>
                                                            </li>
                                                        <?php 
                                                    endforeach;
                                                endif; 
                                            ?>
                                        </ul>
                                        <input type="hidden" name="up-cookies-<?php echo $id; ?>" value="<?php if($strictly_necessary): echo htmlspecialchars(stripslashes($strictly_necessary)); else: echo "[]"; endif;?>">
                                    </div>
                                    <?php if(!$translating_mode): ?>
                                        <div class="up-cookies-add">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 17.5v-11m5.5 5.5h-11"/></svg>
                                            Manually add cookies
                                        </div>
                                        <div class="up-accordion-actions">
                                            <div class="up-accordion-scan js-up-scan up-accordion-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.39 20.39l-7.48-7.48"/><circle cx="9.059" cy="9.059" r="5.449" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                                <span> Scan for cookies (Validate) </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endif; ?>
                        <?php $count=0; foreach($groups as $id => $group): ?>
                            
                            <?php 
                                //Make sure that ID "GTM" Always shows something
                                if($id == "gtm"): 
                                    if(!$group->cookies):
                                        $group->cookies = "[]";
                                    endif;
                                endif; 
                            ?>

                            <div class="up-accordion<?php if($count == 0): ?> active <?php endif; ?>  <?php if($id == "gtm"): ?> default-active group-cookies-only <?php endif; ?>" group-id="<?php echo $id; ?>">
                                <?php if(!$translating_mode): ?>
                                    <div class="up-accordion-header">
                                        <div class="up-accordion-desc-container">
                                            <?php if($id == "gtm"): ?>
                                                <h2>Google Tag Manager</h2> 
                                            <?php else: ?>
                                                <h2>Script Container </h2> 
                                                <div class="up-accordion-desc">
                                                    <span id="up-container-name">Name: <?php echo $group->name; ?></span>
                                                    <span id="up-container-id">Container ID: <?php echo $id; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="up-accordion-actions-wrap">
                                            <div class="up-group-validation">
                                                <?php if($group->cookies): ?>
                                                    <span class="up-valid">Validated</span>
                                                <?php else: ?>
                                                    <span class="up-not-valid">Awaiting Validation</span>
                                                <?php endif; ?>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.685 9.158L12 14.842 6.315 9.158"/></svg>
                                        </div>
                                    </div>
                                <?php endif; ?> 
                                <div class="up-accordion-content">
                                    <?php if(!$translating_mode): ?>
                                    <div class="up-option-group">
                                        <label for="up-group-name-<?php echo $id; ?>">Name this script</label>
                                        <input type="text"  <?php if($translating_mode): ?> disabled <?php endif; ?> name="up-group-name-<?php echo $id; ?>" value="<?php echo $group->name; ?>" placeholder="Example: Google Tag Manger">
                                    </div>
                                    <?php endif; ?>
                                    <div class="up-accordion-cookies <?php if($id == "gtm"): ?> default-active <?php endif; ?>">
                                        <div class="up-accordion-cookies-header js-up-scan up-found-cookies <?php if($group->cookies): ?>active<?php endif; ?>">
                                            <div class="up-accordion-cookies-wrap">
                                                <?php if($id == "gtm"): ?>
                                                    <div class="up-gtm-logo">
                                                        <svg width="50px" height="50px" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid">    <g>        <polygon fill="#8AB4F8" points="150.261818 245.516364 105.825455 202.185455 201.258182 104.730909 247.265455 149.821818"></polygon>        <path d="M150.450909,53.9381818 L106.174545,8.73090909 L9.36,104.629091 C-3.12,117.109091 -3.12,137.341818 9.36,149.836364 L104.72,245.821818 L149.810909,203.64 L77.1563636,127.232727 L150.450909,53.9381818 Z" fill="#4285F4"></path>        <path d="M246.625455,105.370909 L150.625455,9.37090909 C138.130909,-3.12363636 117.869091,-3.12363636 105.374545,9.37090909 C92.88,21.8654545 92.88,42.1272727 105.374545,54.6218182 L201.374545,150.621818 C213.869091,163.116364 234.130909,163.116364 246.625455,150.621818 C259.12,138.127273 259.12,117.865455 246.625455,105.370909 Z" fill="#8AB4F8"></path>        <circle fill="#246FDB" cx="127.265455" cy="224.730909" r="31.2727273"></circle>    </g></svg>
                                                    </div>
                                                    <span>There are <?php if($group->cookies): echo count(json_decode(stripslashes($group->cookies))); endif; ?> cookies for this category within Google Tag Manager</span>  
                                                <?php else: ?>
                                                    <svg fill="currentColor" height="80px" width="80px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 	 viewBox="0 0 299.049 299.049" xml:space="preserve"><g>	<g>		<g>			<path d="M289.181,206.929c-13.5-12.186-18.511-31.366-12.453-48.699c1.453-4.159-0.94-8.686-5.203-9.82				c-27.77-7.387-41.757-38.568-28.893-64.201c2.254-4.492-0.419-9.898-5.348-10.837c-26.521-5.069-42.914-32.288-34.734-58.251				c1.284-4.074-1.059-8.414-5.178-9.57C184.243,1.867,170.626,0,156.893,0C74.445,0,7.368,67.076,7.368,149.524				s67.076,149.524,149.524,149.524c57.835,0,109.142-33.056,133.998-83.129C292.4,212.879,291.701,209.204,289.181,206.929z				 M156.893,283.899c-74.095,0-134.374-60.281-134.374-134.374S82.799,15.15,156.893,15.15c9.897,0,19.726,1.078,29.311,3.21				c-5.123,29.433,11.948,57.781,39.41,67.502c-9.727,29.867,5.251,62.735,34.745,74.752c-4.104,19.27,1.49,39.104,14.46,53.365				C251.758,256.098,207.229,283.899,156.893,283.899z"/>			<path d="M76.388,154.997c-13.068,0-23.7,10.631-23.7,23.701c0,13.067,10.631,23.7,23.7,23.7c13.067,0,23.7-10.631,23.7-23.7				C100.087,165.628,89.456,154.997,76.388,154.997z M76.388,187.247c-4.715,0-8.55-3.835-8.55-8.55s3.835-8.551,8.55-8.551				c4.714,0,8.55,3.836,8.55,8.551S81.102,187.247,76.388,187.247z"/>			<path d="M173.224,90.655c0-14.9-12.121-27.021-27.02-27.021s-27.021,12.121-27.021,27.021c0,14.898,12.121,27.02,27.021,27.02				C161.104,117.674,173.224,105.553,173.224,90.655z M134.334,90.655c0-6.545,5.325-11.871,11.871-11.871				c6.546,0,11.87,5.325,11.87,11.871s-5.325,11.87-11.87,11.87S134.334,97.199,134.334,90.655z"/>			<path d="M169.638,187.247c-19.634,0-35.609,15.974-35.609,35.61c0,19.635,15.974,35.61,35.609,35.61				c19.635,0,35.61-15.974,35.61-35.61C205.247,203.221,189.273,187.247,169.638,187.247z M169.638,243.315				c-11.281,0-20.458-9.178-20.458-20.46s9.178-20.46,20.458-20.46c11.281,0,20.46,9.178,20.46,20.46				S180.92,243.315,169.638,243.315z"/>		</g>	</g></g></svg>
                                                    <span>Found <?php if($group->cookies): echo count(json_decode(stripslashes($group->cookies))); endif; ?> cookies</span>  
                                                <?php endif; ?>
                                            </div>
                                            <div class="up-accordion-cookies-wrap up-cookies-toggle">
                                                Details
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.685 9.158L12 14.842 6.315 9.158"/></svg> 
                                            </div> 
                                        </div>
                                    
                                        <div class="up-accordion-cookies-header js-up-scan up-no-cookies <?php if(!$group->cookies): ?>active<?php endif; ?>">
                                            <div class="up-accordion-cookies-wrap">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9.856v7.229"/><circle cx="12" cy="6.915" r="1" fill="currentColor"/></svg>
                                                <span> No cookies found (awaiting validation) </span>    
                                            </div>
                                        </div>    
                                        <ul class="up-accordion-cookies-info">
                                            <?php 
                                                if($group->cookies): 
                                                    $cookies = json_decode(stripslashes($group->cookies));
                                                    foreach($cookies as $cookie):
                                                        ?>
                                                            <li group-id="<?php echo $id; ?>" cookie-name="<?php echo $cookie->name; ?>">
                                                                <?php if($cookie->wildcard): ?>
                                                                    <span><?php echo "$cookie->wildcard*ID*"; ?></span>
                                                                <?php else: ?>
                                                                    <span><?php echo $cookie->name; ?></span>
                                                                <?php endif; ?>
                                                                <span><?php echo $cookie->description;?></span>
                                                                <span><?php echo $cookie->platform; ?></span>
                                                                <?php if(!$translating_mode): ?>
                                                                    <span class='delete-cookie-info'>Delete</span>
                                                                <?php endif; ?>
                                                                <span class='edit-cookie-info'><?php if(!$translating_mode): ?>Edit<?php else:?>Translate<?php endif;?></span>
                                                            </li>
                                                        <?php 
                                                    endforeach;
                                                endif; 
                                            ?>
                                        </ul>
                                        <input type="hidden" name="up-cookies-<?php echo $id; ?>" value="<?php if($group->cookies): echo htmlspecialchars(stripslashes($group->cookies)); else: echo "[]"; endif;?>">
                                    </div>
                                    
                                    <?php if(!$translating_mode): ?>
                                        <div class="up-cookies-add">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 17.5v-11m5.5 5.5h-11"/></svg>
                                            Manually add cookies
                                        </div>

                                        <?php if(isset($group->head) || isset($group->body) || isset($group->autoload)): 

                                            $data_to_search = $group->head.$group->body.$group->autoload;
                                            if(str_contains(stripslashes($data_to_search), 'www.googletagmanager.com/gtm.js')):
                                                ?>
                                                <div class="up-notices-section">
                                                    <div class="up-notice spacing up-warning">
                                                        <div class="up-notice-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.437 3.283l9.383 16.949a.5.5 0 0 1-.437.742H2.617a.5.5 0 0 1-.437-.742l9.383-16.949a.5.5 0 0 1 .874 0zM12 15.618V8.389" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"/><circle cx="12" cy="18.31" r="1" fill="currentColor"/></svg>
                                                        </div>
                                                        <div class="up-notice-content">
                                                        Warning: It looks like you've added Google Tag Manager here.
                                                        <span>To take full advantage of Consent Mode V2. Connect your GTM via the dedicated setup wizard and remove this script</span>
                                                        </div> 
                                                    </div>
                                                    <?php if($translating_mode){ up_lang_notice($languages_list, $lang); } ?>
                                                </div>
                                                <?php
                                            endif;

                                        endif; ?>
                                    
                                        <label for="up-autoload-<?php echo $id; ?>">Load this script before user consent</label>
                                        <div class="toggle up-autoload-toggle">
                                            <input type="checkbox" name="up-autoload-<?php echo $id; ?>" <?php if($group->autoload): ?> checked <?php endif; ?>>
                                            <label></label> 
                                        </div>
                                        <div class="up-autoload <?php if($group->autoload): ?> active <?php endif; ?> <?php if($count == 0): ?> default-active <?php endif; ?>">
                                            <label for="up-autoload-script-<?php echo $id; ?>">Script to fire after user consent (optional)</label>
                                            <textarea class="code-editor-scripts" name="up-autoload-script-<?php echo $id; ?>" rows="5" cols="50"><?php if($group->autoload_script){ echo htmlentities(stripslashes($group->autoload_script)); } ?></textarea>
                                        </div>

                                        <label for="up-head-<?php echo $id; ?>">HEAD Scripts:</label>
                                        <textarea class="code-editor-scripts" name="up-head-<?php echo $id; ?>" rows="10" cols="50"><?php if($group->head){ echo htmlentities(stripslashes($group->head)); } ?></textarea>

                                        <label for="up-body-<?php echo $id; ?>">BODY Scripts:</label>
                                        <textarea class="code-editor-scripts" name="up-body-<?php echo $id; ?>" rows="10" cols="50"><?php if($group->body){ echo htmlentities(stripslashes($group->body)); } ?></textarea>
                                        
                                        <div class="up-accordion-actions">
                                            <div class="up-accordion-scan js-up-scan up-accordion-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.39 20.39l-7.48-7.48"/><circle cx="9.059" cy="9.059" r="5.449" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                                <span> Scan for cookies (Validate) </span>
                                            </div>
                                            <div class="up-accordion-delete up-accordion-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245l14.49-14.49m0 14.49L4.755 4.755"/></svg>
                                                <span> Remove this script </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php $count++; endforeach; ?>
                        <?php if(!$translating_mode): ?>
                            <div class="up-accordion-add">
                                <h3>Add a script</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20V4m-8 8h16"/></svg>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="up-option-widget">
                <div class="up-widget-banner">
                <?php if(!$translating_mode): ?>Editing:<?php else: ?>Translating:<?php endif; ?> <?php echo $cookie_cats[$key]['name']; if($translating_mode){ echo " [$lang]"; } ?>
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
        global $settings_policy, $dev_setting, $translation_setting, $multisite_setting, $reconsent_setting;
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
        <?php 
            $version_number = up_get_option('policy_version');
            if(!$version_number){
                $version_number = array(0, "Not recorded");
            }
        ?>
        <h2> Re-consent upon policy or cookie updates
            <span>Require users to re-consent and show the widget after updates are made, even if users have previously consented. 
                <span class="up-version-widget">Current version: <?php if(isset($version_number[0])): echo $version_number[0]; endif; ?> <?php if(isset($version_number[1])): echo "- Last updated: ".$version_number[1]; endif; ?></span>
            </span>
        </h2>
    </div>
    <div class="up-option-group">
        <form method="POST">
            <?php wp_nonce_field( 'cookie_update', 'cookie_form' ); ?>
            <input type="hidden" name="updated" value="true" />
            <input type="hidden" name="update-cookie-reconsent" value="true" />
            <div class="toggle">
                <input type="checkbox" <?php if($reconsent_setting == "on"){ echo "checked"; } ?> class="js-form-submit" name="update-cookie-reconsent-toggle">
                <label></label> 
            </div>
        </form>
    </div>
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

<?php
//Update version 1.1.0 checks
function up_legacy_check(){
    if(up_get_option('performance_analytics')){

        $data = up_get_option('performance_analytics');
        //Check for content with the body scripts
        $head = false;
        $body = false; 
        if(isset($data['head'])){	
            if($data['head']){
                $head = $data['head'];
                $data['head'] = false;
            }
        }
        if(isset($data['body'])){
            if($data['body']){
                $body = $data['body'];
                $data['body'] = false;
            }
        }

        if($head || $body){
            //Create new script container
            $groups_output = array();

            $groups_output["legacy"] = array(
                "head" =>  $head,
                "body" =>  $body,
                "name" => "GTM (Legacy Import)",
                "autoload" => false,
                "autoload_script" => false,
                "cookies" => "[]",
            );
            $data['groups'] = json_encode($groups_output);
            up_update_option('performance_analytics', $data );
            
        }

    }

}
?>