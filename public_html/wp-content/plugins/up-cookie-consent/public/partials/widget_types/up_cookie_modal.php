<?php

/**
 * Main Cookie Settings Modal
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://uphotel.agency
 * @since      1.1.0
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/public/partials/widget_types/
 */
?>

<?php function up_cookie_modal(){ ?>
<?php 
    global $widget_setting, $layout_settings, $widget_colors, $settings_policy, $cookie_cats, $translating_mode, $current_lang, $version_number, $gtm_connected;
?>
    <div popover="manual" class="upcc-cookie-modal-container 
        <?php if(isset($widget_colors['color_mode'])): ?>
            <?php if($widget_colors['color_mode'] == "auto"): ?>
                 has-background
                <?php if($widget_colors['color_theme']): ?> theme--<?php echo $widget_colors['color_theme']; ?> <?php endif; ?> 
                <?php if($widget_colors['color_palette']): ?> palette--<?php echo $widget_colors['color_palette']; ?> <?php endif; ?> 
            <?php endif; ?>
        <?php endif; ?>
        <?php if(up_get_option('widget_font')){ echo "upcc-default-fonts"; } ?>" 
        >
        <div class="upcc-cookie-modal">
            <div class="upcc-cookie-modal-content">
                <a class="upcc-cookie-modal-close" href="#"><?php up_text('Close'); ?></a>
                <div class="upcc-cookie-modal-title">
                    <h2><?php up_text('Cookie Preferences'); ?></h2>
                </div>
                <div class="upcc-cookie-modal-details">
                    <p><?php if(isset($settings_policy['intro'])){ echo htmlentities(stripslashes($settings_policy['intro'])); } ?></p>
                </div>
                <a class="upcc-cookie-modal-view-more" href="#"><span class="upcc-open"><?php up_text('View More'); ?></span><span class="upcc-close"><?php up_text('Show Less'); ?></span></a>
                <div class="upcc-cookie-modal-accordian">
                    <div class="upcc-cookie-accordian-buttons">
                        <?php if(isset($settings_policy['link'])){ ?>
                            <a class="upcc-cookie-modal-view-policy" href="<?php echo $settings_policy['link']; ?>"><?php up_text('View our Cookie Policy'); ?></a>
                        <?php } ?>
                        <span class="upcc-cookie-modal-accept-all" href="#">
                            <label class="upcc-switch">
                                <p><?php up_text('Accept All'); ?></p>
                                <input type="checkbox" id="select-all">
                                <span class="upcc-slider"></span>
                            </label>
                        </span>
                    </div>
                    <?php if(isset($cookie_cats)){ foreach($cookie_cats as $current_cat){ 

                        $settings = up_get_option($current_cat['slug']);

                        $cat_name = $current_cat['name'] ?? "";
                        $default = $settings['default'] ?? false;
                        $cat_desc = $settings['desc'] ?? "";   
                        $cat_groups = $settings['groups'] ?? false;
                        $cat_slug = $current_cat['slug'] ?? "";  

                        //If translating, check for language
                        if($translating_mode){ 
                            if(up_get_option($current_cat['slug'].'_'.$current_lang)){
                                $settings_translated = up_get_option($current_cat['slug'].'_'.$current_lang);
                                $cat_desc = $settings_translated['desc'] ?? "";
                                $cat_groups = $settings_translated['groups'] ?? $cat_groups;
                            }
                        }

                        if($cat_groups){
                            $cat_groups = (array)json_decode($cat_groups);
                        }

                        if($cat_slug == "strictly_necessary"){
                            if(isset($settings['strictly_necessary'])){
                                $cat_groups['strictly_necessary']['cookies'] = $settings['strictly_necessary'];

                                //If translating, check for language
                                if($translating_mode){
                                    if(up_get_option($current_cat['slug'].'_'.$current_lang)){
                                        $settings_translated = up_get_option($current_cat['slug'].'_'.$current_lang);
                                        $cat_groups['strictly_necessary']['cookies'] = $settings_translated['strictly_necessary'];
                                    }
                                }
                            }
                        }
                        
                        //Check if user has already set cookies 
                        if(!empty($_COOKIE['up-cookie-consent'])){
                            if(isset($_COOKIE['up-cookie-consent-options'])){
                                if(in_array($cat_slug, json_decode(stripslashes($_COOKIE['up-cookie-consent-options'])))){
                                    $default = true;
                                }
                            }
                        }

                        
                        if(!$gtm_connected): 
                            if(!$settings){
                                continue;
                            }
                            if($settings['toggle'] == false){
                                continue;
                            }
                        endif; 
                 
                    ?>
                    <div class="upcc-cookie-modal-accordian-section">
                        <div class="upcc-cookie-modal-accordian-section-header">
                            <a class="upcc-cookie-accordian-open-button" href="#"><?php echo up_text($cat_name); ?></a>
                            <?php if($cat_slug == "strictly_necessary"){ ?>
                                <span class="upcc-switch-text"><p><?php up_text('Always Enabled'); ?></p></span>
                            <?php }else{ ?>
                                <?php 

                                    if($default){
                                        $toggleText = "Enabled";
                                        $toggleCheck = "checked";
                                        $parentToggle = "upcc-toggle-on";
                                    }else{
                                        $toggleText = "Disabled";
                                        $toggleCheck = "";
                                        $parentToggle = "";
                                    }

                                ?>
                                <label class="upcc-switch <?php echo $parentToggle; ?>"><span class="upcc-switch-text upcc-off"><p><?php up_text('Disabled'); ?></p></span><span class="upcc-switch-text upcc-on"><p><?php up_text('Enabled'); ?></p></span>
                                    <input class="upcc-selected-cookies" name="<?php echo $current_cat['slug']; ?>" <?php echo $toggleCheck; ?> id="isEnabled" type="checkbox">
                                    <span class="upcc-slider"></span>
                                </label>
                            <?php } ?>
                        </div>
                        <div class="upcc-cookie-modal-accordian-content">
                            <p class="upcc-font-medium"><?php echo htmlentities(stripslashes($cat_desc)); ?></p>
                            <?php 
                                if($cat_groups){
                                    foreach($cat_groups as $group){
                                        echo "<div class='upcc-cookie-group'>";
                                        $group = (array)$group;
                                        if($group['cookies']){
                                            $cookies = json_decode(stripslashes($group['cookies']));
                                            foreach($cookies as $cookie){
                                                $cookieName = $cookie->name;
                                                if($cookie->wildcard){
                                                    $cookieName = "$cookie->wildcard*ID*";
                                                }
                                                if(str_contains($cookie->gdpr, "http")){
                                                    $cookiePolicy = "<a href='$cookie->gdpr' rel='noopener' target='_blank'>$cookie->gdpr</a>";
                                                }else{
                                                    $cookiePolicy = $cookie->gdpr;
                                                }
                                                ?>
                                                    <ul class='upcc-font-small'>
                                                        <li>
                                                            <div><?php up_text('Cookie'); ?></div>
                                                            <div><?php echo $cookieName; ?></div>
                                                        </li>
                                                        <li>
                                                            <div><?php up_text('Duration'); ?></div>
                                                            <div><?php echo $cookie->retention; ?></div>
                                                        </li>
                                                        <li>
                                                            <div><?php up_text('Description'); ?></div>
                                                            <div><?php echo $cookie->description; ?></div>
                                                        </li>
                                                        <li>
                                                            <div><?php up_text('Vendor'); ?></div>
                                                            <div><?php echo $cookie->platform; ?></div>
                                                        </li>
                                                    
                                                        <li>
                                                            <div><?php up_text('Privacy Policy'); ?></div>
                                                            <div><?php echo $cookiePolicy; ?></div>
                                                        </li>
                                                    </ul>
                                                <?php
                                            }
                                        }
                                        echo "</div>";
                                    }
                                }
                            ?>
                            <?php if($version_number): ?>
                                <p class="upcc-cookie-version upcc-font-small">
                                <?php if(isset($version_number[0])): ?>
                                    <span>V:<?php echo $version_number[0]; ?>
                                <?php endif; ?>
                                <?php if(isset($version_number[1])): ?>
                                    <span>- <?php echo $version_number[1]; ?>
                                <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        </div>  
                    </div>
                    <?php }} ?>
                </div>
                <div class="upcc-cookie-buttons">
                    <a class="upcc-cookie-options upcc-cookie-reject-all" href="#"><?php up_text('Reject All'); ?></a>
                    <a class="upcc-button upcc-cookie-accept upcc-selectable" href="#"><?php up_text('Accept Selected'); ?></a>
                </div>
            </div>
            <?php if(up_get_option('widget_advert')){ ?>
                <div class="upcc-cookie-advert">
                    <a href="https://uphotel.agency" target="_blank" rel="noopener">
                        <p class="upcc-font-small"><?php up_text('Powered by'); ?></p>
                        <div class="upcc-cookie-advert-logo">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 278"><title>UP Hotel Agency</title><path d="M335.3,119.55h20.8v27.566h23.728V119.55h20.7v72.192h-20.7V163.271H356.1v28.471H335.3Z" fill="currentColor"/><path d="M407.478,166v-.808c0-16.962,12.62-27.663,28.98-27.663,16.253,0,28.775,10.4,28.775,27.159v.808c0,17.165-12.62,27.465-28.877,27.465S407.478,183.058,407.478,166Zm39.378-.3v-.808c0-8.885-3.534-13.834-10.4-13.834-6.765,0-10.5,4.746-10.5,13.631v.808c0,9.088,3.534,14.033,10.5,14.033C443.224,179.524,446.856,174.476,446.856,165.694Z" fill="currentColor"/><path d="M475.524,174.78V151.255h-6.359V138.936h6.359V127.931H493.6v11.005H504v12.319H493.6v21.807c0,3.838,1.919,5.556,5.351,5.556a13.736,13.736,0,0,0,5.149-.911v13.732a37.817,37.817,0,0,1-10,1.517C482.191,192.956,475.524,187.2,475.524,174.78Z" fill="currentColor"/><path d="M509.547,166v-.808c0-16.962,12.621-27.663,28.575-27.663,14.436,0,26.856,8.278,26.856,27.26v4.745H527.822c.5,6.969,4.543,11.007,11,11.007,5.957,0,8.483-2.726,9.188-6.261h16.963c-1.616,11.916-10.8,18.681-26.758,18.681C521.663,192.956,509.547,183.263,509.547,166Zm37.861-6.663c-.3-6.361-3.431-9.895-9.286-9.895-5.454,0-9.189,3.534-10.1,9.895Z" fill="currentColor"/><path d="M573.252,115.715h17.971v76.027H573.252Z" fill="currentColor"/><path d="M645.939,119.55H672.7l22.92,72.192H673.705l-3.833-13.428H645.939l-3.833,13.428H622.818Zm4.039,44.528h15.855l-7.876-27.766Z" fill="currentColor"/><path d="M698.839,191.742H716.81c.808,3.838,3.133,6.864,9.693,6.864,7.979,0,11.21-4.543,11.21-11.1v-8.078a18.523,18.523,0,0,1-16.356,9.693c-12.321,0-22.415-9.086-22.415-25.343v-.808c0-15.55,10-25.443,22.415-25.443,8.377,0,13.326,3.532,16.356,8.885v-7.473h18.074V187.3c0,15.753-10.4,24.032-29.284,24.032C708.532,211.329,700.254,203.756,698.839,191.742Zm39.378-28.07v-.7c0-7.269-3.735-11.915-10.4-11.915-6.765,0-10.4,4.746-10.4,12.016v.807c0,7.27,3.838,11.913,10.3,11.913S738.217,171.145,738.217,163.672Z" fill="currentColor"/><path d="M763.655,166v-.808c0-16.962,12.62-27.663,28.574-27.663,14.436,0,26.856,8.278,26.856,27.26v4.745H781.929c.5,6.969,4.543,11.007,11,11.007,5.957,0,8.483-2.726,9.188-6.261h16.963c-1.616,11.916-10.8,18.681-26.758,18.681C775.771,192.956,763.655,183.263,763.655,166Zm37.86-6.663c-.3-6.361-3.431-9.895-9.286-9.895-5.454,0-9.189,3.534-10.1,9.895Z" fill="currentColor"/><path d="M826.854,138.936h18.074v8.481c2.825-5.451,8.582-9.893,17.364-9.893,10.2,0,17.266,6.361,17.266,19.889v34.329H861.484V161.048c0-5.957-2.32-8.885-7.573-8.885-5.35,0-8.983,3.231-8.983,10v29.583H826.854Z" fill="currentColor"/><path d="M887.024,166v-.808c0-17.567,12.62-27.663,28.168-27.663,12.924,0,24.839,5.654,25.848,21.708H924.077c-.807-4.949-3.231-7.676-8.479-7.676-6.363,0-10.1,4.545-10.1,13.431v.807c0,9.187,3.535,13.935,10.4,13.935,5.047,0,8.581-3.03,9.184-8.787h16.257c-.5,13.33-9.492,22.014-26.553,22.014C899.038,192.956,887.024,183.767,887.024,166Z" fill="currentColor"/><path d="M963.25,186.391l-21.1-47.455h19.586l10.907,28.17,10.094-28.17H1000L971.729,209.41H954.463Z" fill="currentColor"/><path d="M100.948,0,67.966,16.851v33.7L34.983,33.7,2,50.552V193.677l32.983,16.851,98.934-50.56.027-143.124ZM67.972,126.281l24.806,12.695L67.972,151.643ZM10.142,54.712,34.983,42.021l24.84,12.691L34.983,67.4Zm115.627,75.757v25.387l-24.807,12.71v-.035L35.016,202.225l-.033-25.406.026-.014L34.983,75.722l24.84-12.691V164.137l41.132-21-.026-101.074,24.84-12.691Zm-24.84-96.8L76.088,20.979,100.929,8.288l24.84,12.691Z" fill="currentColor"/><path d="M199.876,84.243,166.91,101.1l0,42.023,24.8,12.679-57.767,29.525L133.9,261.1,167.108,278l32.765-16.932.029-33.687L266.533,193.3V118.275Zm-24.849,21.012,24.859-12.7,57.832,29.555-24.809,12.717Zm82.721,84.208-66.037,33.75V256.9l-24.786,12.69V210.569L232.9,176.837V143.122l24.847-12.653Z" fill="currentColor"/></svg>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>