<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'logocollection',
    'title'             => __('Logo Collection'),
    'description'       => __('Logo Collection'),
    'render_callback'   => 'logo_collection_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'grid-view', // dashicons, without the leading dashicons-
    'keywords'          => array( 'logo', 'logos', 'collection' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/logo_collection/logo_collection.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/logo_collection/logo_collection.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => true
                                )
));
function logo_collection_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="logo-grid flex flex-wrap justify-center nopadd-mob<?php if( get_field('desktop_layout') == 'ticker' ): ?> js-logo-grid-desktop-slider<?php else: ?> container<?php endif; ?><?php if( get_field('mobile_layout') == 'ticker' ): ?> js-logo-grid-mob-slider<?php endif; ?><?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>" data-aos="fade-up">
            <?php while ( have_rows('logos') ) : the_row(); ?>
                <div class="logo-grid-item flex-col items-center justify-center">
                    <div class="logo-wrapper flex justify-center items-center mb-6">
                        <?php if( get_sub_field('logo') ):
                            $imgURL = wp_get_attachment_url( get_sub_field('logo') );
                            $fileType = pathinfo($imgURL, PATHINFO_EXTENSION);
                            if( $fileType == 'svg' ): ?>
                                <img src="<?php echo $imgURL; ?>" class="lazyload object-fit contain" alt="<?php echo get_the_title( get_sub_field('logo') ); ?>" width="100%" height="64">
                            <?php else:
                                echo img_sizes(get_sub_field('logo'), ['default' => 'img_188', 'page_area' => '11', 'tablet_page_area' => '16', 'mobile_page_area' => '38', 'lazy_load' => true, 'object_fit' => 'contain']);
                            endif;
                        endif; ?>
                    </div>
                    <?php if( get_sub_field('title') ): ?>
                        <p class="no-margin mb-1"><?php the_sub_field('title'); ?></p>
                    <?php endif; ?>
                    <?php if( get_sub_field('caption') ): ?>
                        <p class="no-margin size-xs color-body-50"><?php the_sub_field('caption'); ?></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
    <?php
}