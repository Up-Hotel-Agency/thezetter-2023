<?php

/**
 * Widget modal type "Mandatory Notice"
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

<?php function mandatory_modal_notice(){ ?>
    <?php global $widget_colors, $settings_policy; ?>
    <div popover="manual" class="upcc-cookie-widget upcc-mandatory-modal
        <?php if(isset($widget_colors['color_mode'])): ?>
            <?php if($widget_colors['color_mode'] == "auto"): ?>
                 has-background
                <?php if($widget_colors['color_theme']): ?> theme--<?php echo $widget_colors['color_theme']; ?> <?php endif; ?> 
                <?php if($widget_colors['color_palette']): ?> palette--<?php echo $widget_colors['color_palette']; ?> <?php endif; ?> 
            <?php endif; ?>
        <?php endif; ?> 
        <?php if(up_show_consent()):?> upcc-widget-open <?php endif; ?> 
        <?php if(up_get_option('widget_reject')){ ?> upcc-includes-reject <?php } ?> 
        <?php if(up_get_option('widget_font')){ echo "upcc-default-fonts"; } ?>" 
        >
        <div class="upcc-mandatory-overlay"></div>
        <div class="upcc-container">
            <?php if(isset($settings_policy['title'])){ ?>
                <h3><?php echo htmlentities(stripslashes($settings_policy['title'])); ?></h3>
            <?php } ?>
            <?php if(isset($settings_policy['intro-short'])){ ?>
                <div class="upcc-cookie-message">
                    <p><?php echo htmlentities(stripslashes($settings_policy['intro-short']));  ?></p>
                </div>
            <?php } ?>
            <div class="upcc-cookie-buttons">
                <a class="upcc-cookie-options js-upcc-view-upcc-cookie-options" href="#"><?php up_text('Options'); ?></a>
                <div class="upcc-action-buttons-wrap">
                    <?php if(up_get_option('widget_reject')){ ?>
                        <a class="upcc-button upcc-cookie-reject-all" href="#"><?php up_text('Reject All'); ?></a>
                    <?php } ?>
                    <a class="upcc-button upcc-cookie-accept" href="#"><?php up_text('Accept'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
