<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'contentinfo',
    'title'             => __('Content Info'),
    'description'       => __('Content Info'),
    'render_callback'   => 'content_info_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'content' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/content_info/content_info.css',
    'supports'          => [ 'align' => false, 'align_text' => true ]
));
function content_info_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    wp_enqueue_style( 'block-acf-content', get_template_directory_uri() . '/assets/css/content/content.css' );
    ?>
    <section
    class="row spacing col-content-info container content-block-container<?php if(get_field('has_patterned_background')): ?> has-patterned-background<?php endif; ?><?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="content-block text-align-<?php echo $block['align_text']; ?><?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <div class="content-wrap-text">
            <?php if( get_field('overline_overline') ): ?>
                <p class="mb-1 overline color-accent" data-aos="fade-up">
                    <?php the_field('overline_overline'); ?>
                </p>
            <?php endif; ?>
            <?php if( get_field('title_title') ): ?>
                <h2 class="regular-weight" data-aos="fade-up"><?php the_field('title_title'); ?>
                    <?php if( get_field('subtitle_subtitle') ): ?>
                        <span class="subtitle mt-12" data-aos="fade-up" data-aos-delay="50">
                            <?php the_field('subtitle_subtitle'); ?>
                        </span>
                    <?php endif; ?>
                </h2>
            <?php endif; ?>
            <?php if( get_field('content_content') ): ?>
                <div data-aos="fade-up">
                    <?php the_field('content_content'); ?>
                </div>
            <?php endif; ?>
            </div>
            <?php if( have_rows('buttons_buttons') ): ?>
                <div class="content-wrap-buttons">
                <?php block_buttons(get_field('buttons'), [
                    'class' => 'no-margin centered',
                    'aos' => true, 
                    'aos_delay' => '200'
                ]); ?>
                </div>
            <?php endif; ?>
            <div class="content-wrap-icon">
                <?php if(get_field('illustration')): echo img_sizes(get_field('illustration'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
            </div>
        </div>
    </section>
    <?php

}