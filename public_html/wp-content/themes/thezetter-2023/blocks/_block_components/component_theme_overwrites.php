<?php

//Capture Theme Overide Fields
function set_theme_override_values() {
    $theme_values = [];

    $theme = '';
    if( get_field('override_page_theme') ):
        $themeField = get_field('block_theme_theme');
        $theme_values['themeField'] = $themeField;
        $theme = $themeField['theme_select'];
        $theme_values['theme'] = $theme;
        if ( $theme == 'seasonal' ):
            foreach ($themeField['seasonal_images'] as $seasonal_image) {
                $start_ts = DateTime::createFromFormat('d/m/Y', $seasonal_image['start_date'])->getTimestamp();
                $end_ts = DateTime::createFromFormat('d/m/Y', $seasonal_image['end_date'])->getTimestamp();
                $current_ts = time();

                if (($current_ts >= $start_ts) && ($end_ts <= $end_ts)) {
                    $theme_values['themeImg'] = $seasonal_image['image'];
                }
            }
        endif;
        if( $theme == 'video' ):
            $theme_values['themeVid'] = $themeField['background_video'];
        endif;
        if( $theme == 'custom' ):
            $theme_values['custom_text'] = $themeField['custom_text_colour'];
            $theme_values['custom_bg'] = $themeField['custom_background_colour'];
            $theme_values['custom_bg_alt'] = $themeField['custom_background_colour_alt'];
            $theme_values['custom_accent'] = $themeField['custom_accent_colour'];
            $theme_values['custom_accent_reverse'] = $themeField['custom_accent_reverse_colour'];
        endif;
    endif;

    return $theme_values;
}
