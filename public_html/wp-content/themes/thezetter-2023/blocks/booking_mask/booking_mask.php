<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'bookingmask',
    'title'             => __('Booking Mask'),
    'description'       => __('Booking Mask'),
    'render_callback'   => 'booking_mask_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'booking mask' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_script( 'flatpickr-js', get_template_directory_uri() . '/assets/js/flatpickr.min.js' );
        wp_enqueue_script( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/js/booking_mask/booking_mask.min.js' );
        wp_enqueue_style( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/css/booking_mask/booking_mask.css' );
        wp_enqueue_style( 'flatpickr', get_template_directory_uri() . '/assets/css/utilities/flatpickr.css' );
        wp_enqueue_style( 'flatpickr-custom', get_template_directory_uri() . '/assets/css/utilities/flatpickr_custom.css' );
    }
));
function booking_mask_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container flex justify-center<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
    id="<?php if( array_key_exists('anchor', $block) && !empty($block['anchor'])): echo esc_attr($block['anchor']); else: echo $block['id']; endif ?>"
    data-aos="fade-up"
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
        
        <?PHP include(get_template_directory() . '/templates/bookingmask.php'); ?>

    </section>
    <?php
}