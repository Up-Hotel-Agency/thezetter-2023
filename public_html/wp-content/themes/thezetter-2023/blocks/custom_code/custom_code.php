<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'customcode',
    'title'             => __('Custom Code'),
    'description'       => __('Custom Code'),
    'render_callback'   => 'custom_code_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'custom', 'code' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/custom_code/custom_code.css',
    'supports'          => [ 'align' => false, 'align_text' => true ]
));
function custom_code_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container content-block-container<?php if(get_field('has_patterned_background')): ?> has-patterned-background<?php endif; ?><?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <?php $customHTML = get_field('custom_html'); 
        if( $customHTML ) { ?>
            <?php echo $customHTML; ?>
        <?php } else {
            if( $is_preview ) {
                echo '<p style="opacity:0.5;">Add your custom HTML or iframe in the block settings.</p>';
            }
        } ?>

    </section>
    <?php

}