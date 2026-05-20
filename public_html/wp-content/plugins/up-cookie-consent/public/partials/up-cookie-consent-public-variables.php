<?php

/**
 * Setup public-facing variables for this plugin
 *
 * This file is used to provide variables to the front end display and fallbacks
 *
 * @link       https://uphotel.agency
 * @since      1.1.0
 *
 * @package    up_cookie_consent
 * @subpackage Up_Cookie_Consent/public/partials
 */

function  up_insert_variables(){ 
    global $widget_colors, $widget_custom_css, $widget_default_variables, $gtm_connected; 

    $upcc_spaces = array(
        "3xs" => "4",
        "2xs" => "8",
        "xs" => "12",

        "s" => "16",
        "m" => "24",
        "l" => "32",
        
        "xl" => "48",
        "2xl" => "64",
        "3xl" => "96",
    )
    ?>
    <style>
        .upcc-cookie-widget, .upcc-cookie-modal-container, .upcc-cookie-list{
            <?php 
                foreach($upcc_spaces as $space_key => $space):

                    //Work out quick rem value
                    $space = $space / 16;

                    //Check if force use of default variables
                    if($widget_default_variables == true):
                        echo "--upcc-space-$space_key:".$space."rem;";
                    else:
                        //Use themes spacing variables & include fallback
                        echo "--upcc-space-$space_key: var(--space-$space_key, ".$space."rem);";
                    endif;

                endforeach; 
            ?>
        }
    </style>

    <?php if(up_get_option('widget_font')): ?>
        <style>
            @font-face {
                font-family:'Outfit';
                src: url('/wp-content/plugins/up-cookie-consent/assets/fonts/Outfit-VariableFont_wght.ttf');
                font-style: normal;
                font-display: swap;
            }
        </style>
    <?php endif; ?>

    <?php if($widget_custom_css): ?>
        <style>
            <?php echo htmlentities(stripslashes($widget_custom_css)); ?>
        </style>
    <?php endif; ?>

    <style>
        .upcc-cookie-widget, .upcc-cookie-modal-container{
        <?php if(isset($widget_colors['button'])){ ?>
            --upcc-buttons-color: <?php echo $widget_colors['button']; ?>;
        <?php }; ?>
        <?php if(isset($widget_colors['button-text'])){ ?>
            --upcc-buttons-color-text: <?php echo $widget_colors['button-text']; ?>;
        <?php }; ?>
        <?php if(isset($widget_colors['background'])){ ?>
            --upcc-background-color: <?php echo $widget_colors['background']; ?>;
        <?php }; ?>
        <?php if(isset($widget_colors['text'])){ ?>
            --upcc-text-color: <?php echo $widget_colors['text']; ?>;
        <?php }; ?>
        }
    </style>

    <?php 
    if(isset($widget_colors['color_mode'])): 
        if($widget_colors['color_mode'] == "auto"):
            ?>
            <style>
                .upcc-cookie-widget, .upcc-cookie-modal-container{
                    --upcc-buttons-color: var(--color-accent-primary);
                    --upcc-buttons-color-text: var(--color-accent-primary-reverse, var(--color-accent-reverse-alt));
                    --upcc-background-color: var(--color-background);
                    --upcc-text-color: var(--color-body);
                }
            </style>
            <?php   
        endif;
    endif;
    ?>

<?php } ?>