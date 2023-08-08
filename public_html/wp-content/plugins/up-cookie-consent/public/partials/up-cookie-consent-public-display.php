<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.0.0
 *
 * @package    Up_Cookie_Consent
 * @subpackage Up_Cookie_Consent/public/partials
 */
?>

<?php 

    //Load required options
    global $widget_setting, $layout_settings, $widget_colors, $settings_policy, $cookie_cats;
    $widget_setting = get_option('up_cookie_consent_widget_setting');
    $layout_settings = get_option('up_cookie_consent_layout');
    $widget_colors = get_option('up_cookie_consent_widget_colors');
    $settings_policy = get_option('up_cookie_consent_policy_intro');

    $cookie_cats = array(
        array('slug' => 'strictly_necessary', 'name' => 'Strictly Necessary', 'desc' => 'Forced active always'),
        array('slug' => 'functional', 'name' => 'Functional', 'desc' => 'Scripts for the sites functions'),
        array('slug' => 'performance_analytics', 'name' => 'Performance and Analytics', 'desc' => 'Used for GTM and tracking'),
        array('slug' => 'advertisement_targeting', 'name' => 'Advertisement and Targeting', 'desc' => 'Provide visitors with relevant ads'),
    
    );

    if(isset($widget_setting) && $widget_setting == true){
        
        //Get widget style 
        if(isset($layout_settings)){
            up_insert_variables();
            $layout_settings();
            up_cookie_modal();
        }
    }

?>
<?php function  up_insert_variables(){ ?>
    <?php global $widget_colors; ?>
    <style>
    :root{
    <?php if(isset($widget_colors['button'])){ ?>
        --up-buttons-color: <?php echo $widget_colors['button']; ?>;
    <?php }; ?>
    <?php if(isset($widget_colors['button-text'])){ ?>
        --up-buttons-color-text: <?php echo $widget_colors['button-text']; ?>;
    <?php }; ?>
    <?php if(isset($widget_colors['accent'])){ ?>
        --up-accent-color: <?php echo $widget_colors['accent']; ?>;
    <?php }; ?>
    }
    </style>
<?php } ?>

<?php function floating_notice(){ ?>
    <?php global $widget_colors, $settings_policy; ?>
    <div class="up-cookie-widget up-floating-notice">
        <div class="container">
            <?php if(isset($settings_policy['intro-short'])){ ?>
                <div class="cookie-message">
                    <p><?php echo $settings_policy['intro-short'];  ?></p>
                </div>
            <?php } ?>
            <div class="cookie-buttons">
                <a class="cookie-options js-up-view-cookie-options" href="">View Options</a>
                <a class="up-button up-cookie-accept" href="">Accept All</a>
            </div>
        </div>
    </div>
<?php } ?>

<?php function slim_floating_notice(){ ?>
    <?php global $widget_colors, $settings_policy; ?>
    <div class="up-cookie-widget up-slim-floating-notice">
        <div class="container">
            <?php if(isset($settings_policy['intro-short'])){ ?>
                <div class="cookie-message">
                    <p><?php echo $settings_policy['intro-short'];  ?></p>
                </div>
            <?php } ?>
            <div class="cookie-buttons">
                <a class="cookie-options js-up-view-cookie-options" href="">Options</a>
                <a class="up-button up-cookie-accept" href="">Accept</a>
            </div>
        </div>
    </div>
<?php } ?>

<?php function mandatory_modal_notice(){ ?>
    <?php global $widget_colors, $settings_policy; ?>
    <div class="up-mandatory-overlay"></div>
    <div class="up-cookie-widget up-mandatory-modal">
        <div class="container">
            <?php if(isset($settings_policy['title'])){ ?>
                <h3><?php echo $settings_policy['title']; ?></h3>
            <?php } ?>
            <?php if(isset($settings_policy['intro-short'])){ ?>
                <div class="cookie-message">
                    <p><?php echo $settings_policy['intro-short'];  ?></p>
                </div>
            <?php } ?>
            <div class="cookie-buttons">
                <a class="cookie-options js-up-view-cookie-options" href="">View Options</a>
                <a class="up-button up-cookie-accept" href="">Accept All</a>
            </div>
        </div>
    </div>
<?php } ?>

<?php function up_cookie_modal(){ ?>
<?php 
    global $widget_setting, $layout_settings, $widget_colors, $settings_policy, $cookie_cats;
?>
    <div class="up-cookie-modal-container">
        <div class="cookie-modal">
            <div class="cookie-modal-content">
                <a class="up-cookie-modal-close" href="#">Close</a>
                <div class="cookie-modal-title">
                    <h2>Cookie Preferences</h2>
                </div>
                <div class="cookie-modal-details">
                    <p><?php if(isset($settings_policy['intro'])){ echo $settings_policy['intro']; } ?></p>
                </div>
                <a class="cookie-modal-view-more" href="#"><span class="up-open">View More</span><span class="up-close">Show Less</span></a>
                <div class="cookie-modal-accordian">
                    <div class="cookie-accordian-buttons">
                        <?php if(isset($settings_policy['link'])){ ?>
                            <a class="cookie-modal-view-policy" href="<?php echo $settings_policy['link']; ?>">View our Cookie Policy</a>
                        <?php } ?>
                        <a class="cookie-modal-accept-all" href="#">Accept All
                            <label class="switch">
                                <input type="checkbox" id="select-all">
                                <span class="slider"></span>
                            </label>
                        </a>
                    </div>
                    <?php if(isset($cookie_cats)){ foreach($cookie_cats as $current_cat){ 
                        
                        $settings = get_option('up_cookie_consent_'.$current_cat['slug']);

                        if(!$settings){
                            continue;
                        }
                        if($settings['toggle'] == false){
                            continue;
                        }

                        $cat_name = $current_cat['name'];
                        $default = $settings['default'];
                        $cat_desc = $settings['desc'];   
                        $cat_slug = $current_cat['slug'];                     
                    ?>
                    <div class="cookie-modal-accordian-section">
                        <div class="cookie-modal-accordian-section-header">
                            <a class="cookie-accordian-open-button" href="#"><?php echo $cat_name; ?></a>
                            <?php if($cat_slug == "strictly_necessary"){ ?>
                                <span class="switch-text">Always Enabled</span>
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
                                <label class="switch <?php echo $parentToggle; ?>"><span class="switch-text off">Disabled</span><span class="switch-text on">Enabled</span>
                                    <input class="up-selected-cookies" name="<?php echo $current_cat['slug']; ?>" <?php echo $toggleCheck; ?> id="isEnabled" type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            <?php } ?>
                        </div>
                        <div class="cookie-modal-accordian-content">
                            <p><?php echo $cat_desc; ?></p>
                        </div>  
                    </div>
                    <?php }} ?>
                </div>
                <div class="cookie-buttons">
                    <a class="cookie-options" href="">Reject All</a>
                    <a class="up-button up-cookie-accept up-selectable" href="">Accept Selected</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php function up_cookie_scripts(){ ?>
<?php 
    global $cookie_cats, $head_scripts, $body_scripts; 
    $head_scripts = array(); 
    $body_scripts = array();
    if(isset($cookie_cats)){ foreach($cookie_cats as $current_cat){ 
        $settings = get_option('up_cookie_consent_'.$current_cat['slug']);
        if(isset($settings['head'])){
            array_push($head_scripts, array($current_cat['slug'], $settings['head']));
        }
        if(isset($settings['body'])){
            array_push($body_scripts, array($current_cat['slug'], $settings['body']));
        }
    }}
    function theme_enqueue_scripts() {
        global $head_scripts, $body_scripts; 
        /**
         * frontend ajax requests.
         */
        wp_localize_script( 'up-cookie-consent', 'frontend_up_cookie_consent',
            array( 
                'header' => $head_scripts,
                'body' => $body_scripts,
            )
        );
    }
    add_action( 'wp_head', 'theme_enqueue_scripts' );
    ?>
<?php } ?>

