<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'imagecontentrow',
    'title'             => __('Image Content Row'),
    'description'       => __('Image Content Row'),
    'render_callback'   => 'image_content_row_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'content', 'featured' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/image_content_row/image_content_row.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function image_content_row_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="image-content-block flex flex-row text-align-<?php echo get_field('align'); ?><?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <div class="featured-content-image" data-aos="fade-up">
                <?php if(get_field('image')): echo img_sizes(get_field('image'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
            </div>
            <div class="content">
                <?php if( get_field('description_content') ): ?>
                    <div class="mb-8 h2 regular-weight" data-aos="fade-up">
                        <?php the_field('description_content', false, false); ?>
                    </div>
                <?php endif; ?>

                <?php block_buttons(get_field('buttons'), [
                    'class' => 'no-margin items-center',
                    'type'  => 'primary'
                ]); ?>
            </div>

        </div>
    </section>
    <?php
}