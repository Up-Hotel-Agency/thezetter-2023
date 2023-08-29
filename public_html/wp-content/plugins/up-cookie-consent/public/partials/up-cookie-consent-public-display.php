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
    global $widget_setting, $layout_settings, $widget_colors, $settings_policy, $cookie_cats, $current_lang, $translating_mode, $current_string_translations, $widget_custom_css;

    
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
        $current_lang = substr( get_bloginfo ( 'language' ), 0, 2 );
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
        $output = '<a href="#" class="js-up-view-cookie-options-revisit">';
        $output .= up_text('Update cookie consent', true);
        $output .= '</a>';
        return $output;
    }
    add_shortcode('up_cookie_plugin', 'up_cookie_plugin_modal');

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
            $layout_settings();
            up_cookie_modal();
        }
    }

?>

<?php function  up_insert_variables(){ ?>
    <?php global $widget_colors, $widget_custom_css; ?>
    <style>
    :root{
    <?php if(isset($widget_colors['button'])){ ?>
        --up-buttons-color: <?php echo $widget_colors['button']; ?>;
    <?php }; ?>
    <?php if(isset($widget_colors['button-text'])){ ?>
        --up-buttons-color-text: <?php echo $widget_colors['button-text']; ?>;
    <?php }; ?>
    <?php if(isset($widget_colors['background'])){ ?>
        --up-background-color: <?php echo $widget_colors['background']; ?>;
    <?php }; ?>
    <?php if(isset($widget_colors['text'])){ ?>
        --up-text-color: <?php echo $widget_colors['text']; ?>;
    <?php }; ?>
    }
    </style>
    <?php if($widget_custom_css){ ?>
    <style>
        <?php echo htmlentities(stripslashes($widget_custom_css)); ?>
    </style>
    <?php } ?>
<?php } ?>

<?php function floating_notice(){ ?>
    <?php global $widget_colors, $settings_policy; ?>
    <div class="up-cookie-widget up-floating-notice <?php if(up_get_option('widget_font')){ echo "up-default-fonts"; } ?>" style="visibility: hidden; opacity: 0;">
        <div class="up-container">
            <?php if(isset($settings_policy['intro-short'])){ ?>
                <div class="cookie-message">
                    <p><?php echo htmlentities(stripslashes($settings_policy['intro-short']));  ?></p>
                </div>
            <?php } ?>
            <div class="cookie-buttons">
                <a class="cookie-options js-up-view-cookie-options" href="#"><?php up_text('View Options'); ?></a>
                <a class="up-button up-cookie-accept" href="#"><?php up_text('Accept All'); ?></a>
            </div>
        </div>
    </div>
<?php } ?>

<?php function slim_floating_notice(){ ?>
    <?php global $widget_colors, $settings_policy; ?>
    <div class="up-cookie-widget up-slim-floating-notice <?php if(up_get_option('widget_font')){ echo "up-default-fonts"; } ?>" style="visibility: hidden; opacity: 0;">
        <div class="up-container">
            <?php if(isset($settings_policy['intro-short'])){ ?>
                <div class="cookie-message">
                    <p><?php echo htmlentities(stripslashes($settings_policy['intro-short']));  ?></p>
                </div>
            <?php } ?>
            <div class="cookie-buttons">
                <a class="cookie-options js-up-view-cookie-options" href="#"><?php up_text('Options'); ?></a>
                <a class="up-button up-cookie-accept" href="#"><?php up_text('Accept'); ?></a>
            </div>
        </div>
    </div>
<?php } ?>

<?php function mandatory_modal_notice(){ ?>
    <?php global $widget_colors, $settings_policy; ?>
    <div class="up-cookie-widget up-mandatory-modal <?php if(up_get_option('widget_font')){ echo "up-default-fonts"; } ?>" style="visibility: hidden; opacity: 0;">
        <div class="up-mandatory-overlay"></div>
        <div class="up-container">
            <?php if(isset($settings_policy['title'])){ ?>
                <h3><?php echo htmlentities(stripslashes($settings_policy['title'])); ?></h3>
            <?php } ?>
            <?php if(isset($settings_policy['intro-short'])){ ?>
                <div class="cookie-message">
                    <p><?php echo htmlentities(stripslashes($settings_policy['intro-short']));  ?></p>
                </div>
            <?php } ?>
            <div class="cookie-buttons">
                <a class="cookie-options js-up-view-cookie-options" href="#"><?php up_text('Options'); ?></a>
                <a class="up-button up-cookie-accept" href="#"><?php up_text('Accept'); ?></a>
            </div>
        </div>
    </div>
<?php } ?>

<?php function up_cookie_modal(){ ?>
<?php 
    global $widget_setting, $layout_settings, $widget_colors, $settings_policy, $cookie_cats, $translating_mode, $current_lang;
?>
    <div class="up-cookie-modal-container <?php if(up_get_option('widget_font')){ echo "up-default-fonts"; } ?>" style="visibility: hidden; opacity: 0;">
        <div class="cookie-modal">
            <div class="cookie-modal-content">
                <a class="up-cookie-modal-close" href="#"><?php up_text('Close'); ?></a>
                <div class="cookie-modal-title">
                    <h2><?php up_text('Cookie Preferences'); ?></h2>
                </div>
                <div class="cookie-modal-details">
                    <p><?php if(isset($settings_policy['intro'])){ echo htmlentities(stripslashes($settings_policy['intro'])); } ?></p>
                </div>
                <a class="cookie-modal-view-more" href="#"><span class="up-open"><?php up_text('View More'); ?></span><span class="up-close"><?php up_text('Show Less'); ?></span></a>
                <div class="cookie-modal-accordian">
                    <div class="cookie-accordian-buttons">
                        <?php if(isset($settings_policy['link'])){ ?>
                            <a class="cookie-modal-view-policy" href="<?php echo $settings_policy['link']; ?>"><?php up_text('View our Cookie Policy'); ?></a>
                        <?php } ?>
                        <a class="cookie-modal-accept-all" href="#">
                            <label class="switch">
                                <p><?php up_text('Accept All'); ?></p>
                                <input type="checkbox" id="select-all">
                                <span class="slider"></span>
                            </label>
                        </a>
                    </div>
                    <?php if(isset($cookie_cats)){ foreach($cookie_cats as $current_cat){ 

                        $settings = up_get_option($current_cat['slug']);

                        $cat_name = $current_cat['name'] ?? "";
                        $default = $settings['default'] ?? false;
                        $cat_desc = $settings['desc'] ?? "";   
                        $cat_slug = $current_cat['slug'] ?? "";    
                        
                        //Check if user has already set cookies 
                        if(!empty($_COOKIE['up-cookie-consent'])){
                            if(isset($_COOKIE['up-cookie-consent-options'])){
                                if(in_array($cat_slug, json_decode(stripslashes($_COOKIE['up-cookie-consent-options'])))){
                                    $default = true;
                                }
                            }
                        }
                        
                        if($translating_mode){ 
                            if(up_get_option($current_cat['slug'].'_'.$current_lang)){
                                $settings_translated = up_get_option($current_cat['slug'].'_'.$current_lang);
                                $cat_desc = $settings_translated['desc'] ?? "";
                            }
                        }

                        if(!$settings){
                            continue;
                        }
                        if($settings['toggle'] == false){
                            continue;
                        }
                 
                    ?>
                    <div class="cookie-modal-accordian-section">
                        <div class="cookie-modal-accordian-section-header">
                            <a class="cookie-accordian-open-button" href="#"><?php echo up_text($cat_name); ?></a>
                            <?php if($cat_slug == "strictly_necessary"){ ?>
                                <span class="switch-text"><p><?php up_text('Always Enabled'); ?></p></span>
                            <?php }else{ ?>
                                <?php 

                                    if($default){
                                        $toggleText = "Enabled";
                                        $toggleCheck = "checked";
                                        $parentToggle = "toggle-on";
                                    }else{
                                        $toggleText = "Disabled";
                                        $toggleCheck = "";
                                        $parentToggle = "";
                                    }

                                ?>
                                <label class="switch <?php echo $parentToggle; ?>"><span class="switch-text off"><p><?php up_text('Disabled'); ?></p></span><span class="switch-text on"><p><?php up_text('Enabled'); ?></p></span>
                                    <input class="up-selected-cookies" name="<?php echo $current_cat['slug']; ?>" <?php echo $toggleCheck; ?> id="isEnabled" type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            <?php } ?>
                        </div>
                        <div class="cookie-modal-accordian-content">
                            <p><?php echo htmlentities(stripslashes($cat_desc)); ?></p>
                        </div>  
                    </div>
                    <?php }} ?>
                </div>
                <div class="cookie-buttons">
                    <a class="cookie-options up-cookie-reject-all" href="#"><?php up_text('Reject All'); ?></a>
                    <a class="up-button up-cookie-accept up-selectable" href="#"><?php up_text('Accept Selected'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


