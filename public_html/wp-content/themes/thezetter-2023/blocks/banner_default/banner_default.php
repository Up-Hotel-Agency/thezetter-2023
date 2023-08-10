<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'upbannerdefault',
    'title'             => __('UP Banner - Default'),
    'description'       => __('UP Banner - Default'),
    'render_callback'   => 'banner_default_render_callback',
    'category'          => 'upcore-banners',
    'icon'              => 'laptop', // dashicons, without the leading dashicons-
    'keywords'          => array( 'banner, default' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'       => false,
                                    'anchor'      => true,
                                    'mode'        => false,
                                    'full_height' => true,
                                )
));
function banner_default_render_callback( $block, $content = '', $is_preview = false ) {
    if( get_field('booking_mask') ):
        wp_enqueue_script( 'atc-js', get_template_directory_uri() . '/assets/js/atc.min.js' );
        wp_enqueue_script( 'flatpickr-js', get_template_directory_uri() . '/assets/js/flatpickr.min.js' );
        wp_enqueue_script( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/js/booking_mask/booking_mask.min.js' );
        wp_enqueue_style( 'flatpickr', get_template_directory_uri() . '/assets/css/utilities/flatpickr.css' );
        wp_enqueue_style( 'flatpickr-custom', get_template_directory_uri() . '/assets/css/utilities/flatpickr_custom.css' );
        wp_enqueue_style( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/css/booking_mask/booking_mask.css' );
    endif;
    extract(set_theme_override_values());
    ?>
    <section
    class="row container full-height banner-block flex justify-center items-center flex-col<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?><?php if(array_key_exists('full_height', $block) && $block['full_height'] != false): echo ' full-height'; endif; ?>"
    id="<?php if( array_key_exists('anchor', $block) && !empty($block['anchor'])): echo esc_attr($block['anchor']); else: echo $block['id']; endif ?>"
    <?php if( get_field('override_page_theme') && $theme == 'custom' ): ?>
    style="
        <?php if( $custom_text ): ?>--color-body: <?php echo $custom_text; ?>;<?php endif; ?>
        <?php if( $custom_bg ): ?>--color-background: <?php echo $custom_bg; ?>;<?php endif; ?>
        <?php if( $custom_bg_alt ): ?>--color-background-alt: <?php echo $custom_bg_alt; ?>;<?php endif; ?>
        <?php if( $custom_accent ): ?>--color-accent-primary: <?php echo $custom_accent; ?>;<?php endif; ?>
        <?php if( $custom_accent_reverse ): ?>--color-accent-reverse: <?php echo $custom_accent_reverse; ?>;<?php endif; ?>
        "
    <?php endif; ?>
    >
        <?php block_background_media(); ?>
        <div class="banner-content-block<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <?php global $post; if($post->post_parent): ?>
                <a class="button icon-left back no-margin minor" href="<?php echo get_the_permalink( $post->post_parent ); ?>">
                    <svg width="27" height="27" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-left</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                    <?php echo get_the_title( $post->post_parent ); ?>
                </a>
            <?php endif; ?>
            
            <?php if( get_field('title_title') ): ?>
                <h1 class="mb-12"><?php the_field('title_title'); ?></h1>
            <?php endif; ?>
            <?php block_buttons(get_field('buttons'), [
                'class' => 'no-margin items-center centered',
                'type'  => 'primary'
            ]); ?>
        </div>
        <?php if( get_field('display_scroll_button') ): ?>
            <a href="#" class="js-scroll-next-block banner-default-continue flex items-center no-margin">
                <div class="overline"><?php echo get_field('scroll_button_text'); ?></div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>Continue</title><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.685 9.158L12 14.842 6.315 9.158"/></svg>            
            </a>
        <?php endif; ?>
    </section>
    <?php
}