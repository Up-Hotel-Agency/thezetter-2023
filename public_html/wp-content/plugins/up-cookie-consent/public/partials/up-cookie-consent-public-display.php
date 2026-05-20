<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/public/partials
 */
?>

<?php 

    //Load required options
    global $widget_setting, $layout_settings, $widget_colors, $widget_default_variables, $settings_policy, $cookie_cats, $current_lang, $translating_mode, $current_string_translations, $widget_custom_css, $version_number, $gtm_connected;

    //Variables function
    include( plugin_dir_path( __FILE__ ) . '/up-cookie-consent-public-variables.php' ); 
    
    //Translation function
    function up_text($text, $return = false){
        global $translating_mode, $current_string_translations, $current_lang;
        if($translating_mode){
            if(isset($current_string_translations[$current_lang][$text])){
                if($return){
                    return htmlentities(stripslashes($current_string_translations[$current_lang][$text]));
                }else{
                    echo htmlentities(stripslashes($current_string_translations[$current_lang][$text]));
                }
            }else{
                if($return){
                    return $text;
                }else{
                    echo $text;
                }
            }
        }else{
            if($return){
                return $text;
            }else{
                echo $text;
            }
        }
    }

    //Get current language setting
    $translating_mode = false;
    if(up_get_option('translation_setting')){
        $current_lang = get_bloginfo ( 'language' );
        if($current_lang != "zh-hans"){ //this is the only lang supported with - values
            $current_lang = substr( get_bloginfo ( 'language' ), 0, 2 );
        }
        $current_string_translations = up_get_option('languages_string');
        $current_supported_langs = up_get_option('languages');
        if($current_lang != null){
            if(isset($current_supported_langs[$current_lang])){
                $translating_mode = true;
            }
            
        }
    }

    //Define options
    $widget_setting = up_get_option('widget_setting');
    $layout_settings = up_get_option('layout');
    $widget_colors = up_get_option('widget_colors');
    $widget_default_variables = up_get_option('widget_variables');
    $widget_custom_css = up_get_option('widget_css');
    $dev_mode = up_get_option('dev_setting');
    if($translating_mode){
        if(up_get_option('policy_intro_'.$current_lang)){
            $settings_policy = up_get_option('policy_intro_'.$current_lang);
            $settings_policy = up_decode_html_entities($settings_policy);
        }else{
            $settings_policy = up_get_option('policy_intro');
            $settings_policy = up_decode_html_entities($settings_policy);
        }
    }else{
        $settings_policy = up_get_option('policy_intro');
        $settings_policy = up_decode_html_entities($settings_policy);
    }

    //Define cookie categories
    $cookie_cats = array(
        array('slug' => 'strictly_necessary', 'name' => 'Strictly Necessary', 'desc' => 'Forced active always'),
        array('slug' => 'functional', 'name' => 'Functional', 'desc' => 'Scripts for the sites functions'),
        array('slug' => 'performance_analytics', 'name' => 'Performance and Analytics', 'desc' => 'Used for GTM and tracking'),
        array('slug' => 'advertisement_targeting', 'name' => 'Advertisement and Targeting', 'desc' => 'Provide visitors with relevant ads'),
    
    );

    //Add shortcode to update Cookie Preferences
    function up_cookie_plugin_modal(){
        $output = '<a href="#" class="js-upcc-view-upcc-cookie-options-revisit">';
        $output .= up_text('Update cookie consent', true);
        $output .= '</a>';
        return $output;
    }
    add_shortcode('up_cookie_plugin', 'up_cookie_plugin_modal');


    //Add shortcode to list cookies and categorises table
    function up_cookie_plugin_list(){

        global $translating_mode, $cookie_cats, $version_number;

        $output = "<div class='upcc-cookie-list'>";
        $output .= "<p><a href='#' class='js-upcc-view-upcc-cookie-options-revisit'>".up_text('Update cookie consent', true)."</a></p>";

        foreach($cookie_cats as $current_cat):

            //Define variables 
            $settings = up_get_option($current_cat['slug']);
            $cat_groups = $settings['groups'] ?? false;
            $cat_desc = $settings['desc'] ?? "";
            $cookies_count = 0;
            $output_cookies = "";
            $output_cat = "";
            $output_cookies_table_start = "";
            $output_cookies_table_end = "";

            //If translating, check for language
            if($translating_mode): 
                if(up_get_option($current_cat['slug'].'_'.$current_lang)):
                    $settings_translated = up_get_option($current_cat['slug'].'_'.$current_lang);
                    $cat_desc = $settings_translated['desc'] ?? "";
                    $cat_groups = $settings_translated['groups'] ?? $cat_groups;
                endif;
            endif;

            if($cat_groups):
                $cat_groups = (array)json_decode($cat_groups);
            endif;

            if($cat_groups):
                foreach($cat_groups as $group):
                    $group = (array)$group;
                    if($group['cookies']):
                        $cookies = json_decode(stripslashes($group['cookies']));
                        foreach($cookies as $cookie):
                            $cookieName = $cookie->name;
                            if($cookie->wildcard):
                                $cookieName = "$cookie->wildcard*ID*";
                            endif;
                            if(str_contains($cookie->gdpr, "http")):
                                $cookiePolicy = "<a href='$cookie->gdpr' rel='noopener' target='_blank'>$cookie->gdpr</a>";
                            else:
                                $cookiePolicy = $cookie->gdpr;
                            endif;
                            $output_cookies .= "<tr>";
                            $output_cookies .= "
                            <td>$cookieName</td>
                            <td>$cookie->retention</td>
                            <td>$cookie->description</td>
                            <td>$cookie->platform</td>
                            <td>$cookiePolicy</td>
                            ";
                            $output_cookies .= "</tr>";
                        $cookies_count++; endforeach;
                    endif;
                endforeach;
            endif;
            
            $output_cat .= " 
            <p class='upcc-cat-title'><b>".up_text($current_cat['name'], true)." ($cookies_count)</b></p>
            <p class='upcc-cat-desc'>$cat_desc</p>
            ";

            if($cookies_count):
                $output_cookies_table_start = "
                <table class='upcc-cat-table'>
                <tr>
                    <th>".up_text('Cookie', true)."</th>
                    <th>".up_text('Duration', true)."</th>
                    <th>".up_text('Description', true)."</th>
                    <th>".up_text('Vendor', true)."</th>
                    <th>".up_text('Privacy Policy', true)."</th>
                </tr>";
                 $output_cookies_table_end = "</table>";
            endif;
            $output .= "<div class='upcc-cookie-cat-details'>".$output_cat.$output_cookies_table_start.$output_cookies.$output_cookies_table_end."</div>";
        endforeach;

        if($version_number):
            $output .= "<p>";
                if(isset($version_number[0])): 
                    $output .= "V: ".$version_number[0];
                endif;
                if(isset($version_number[1])):
                    $output .= " - ".$version_number[1];
                endif;
            $output .= "</p>"; 
        endif;

        $output .= "<p class='upcc-cookie-list-logo'><a href='https://uphotel.agency' rel='noopener' target='_blank'>".up_text('Powered by', true)." UP Hotel Agency</a></p>";
        $output .= "</div>";
        return $output;
    }
    add_shortcode('up_cookie_list', 'up_cookie_plugin_list');

    //Start front end view
    if(isset($widget_setting) && $widget_setting == true){
        if($dev_mode){
            if ( !current_user_can( 'manage_options' ) ) {
                return;
            }
        }
        //Get widget style 
        if(isset($layout_settings)){
            up_insert_variables();
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/widget_types/up_cookie_modal.php';
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/widget_types/up_'.$layout_settings.'.php';
            $layout_settings();
            up_cookie_modal();
        }
    }

    //Check for cookie to show consent
    //Currently upsupported due cross env cookie issue
    function up_show_consent(){
        return false;
        if(isset($_COOKIE['up-cookie-consent'])){
            if($_COOKIE['up-cookie-consent'] != "true"){
                return true;
            }
        }else{
            return true;
        }
    }
     
?>