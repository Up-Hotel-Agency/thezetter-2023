<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'googlemap',
    'title'             => __('Google Map'),
    'description'       => __('Google Map'),
    'render_callback'   => 'google_map_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'location-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'google map' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_script( 'block-acf-googlemap', get_template_directory_uri() . '/assets/js/google_map/google_map.min.js' );
        wp_enqueue_style( 'block-acf-googlemap', get_template_directory_uri() . '/assets/css/google_map/google_map.css' );
        wp_enqueue_style( 'block-acf-column-content', get_template_directory_uri() . '/assets/css/column_content/column_content.css' );
        wp_enqueue_style( 'block-acf-accordion', get_template_directory_uri() . '/assets/css/accordion/accordion.css' );
    }
));
function google_map_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    data-aos="fade-up" data-aos-id="googlemap"
    class="
        row spacing
        <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?>
        <?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>
        <?php if( get_field('display_content') ): ?> 
            map-lockup
            flex
            justify-between
            sm:flex-col
            <?php the_field('layout'); ?>
        <?php endif; ?>
    "
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
        
        <div class="map-container">
            <?php $location = get_field('google_map'); ?>
            <div
                class="marker"
                data-pin-type="pin-logo"
                data-lat="<?php echo esc_attr($location['lat']); ?>"
                data-lng="<?php echo esc_attr($location['lng']); ?>">
            </div>
        </div>
        <?php if( get_field('display_content') ): ?>
            <div class="content-lockup-wrapper flex justify-center items-center container<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                <div class="content-lockup">
                    <?php if( get_field('overline_overline') ): ?>
                        <p class="mb-1 overline color-accent" data-aos="fade-up">
                            <?php the_field('overline_overline'); ?>
                        </p>
                    <?php endif; ?>

                    <?php if( get_field('title_title') ): ?>
                        <h2 class="mb-6" data-aos="fade-up"><?php the_field('title_title'); ?>
                            <?php if( get_field('subtitle_subtitle') ): ?>
                                <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                                    <?php the_field('subtitle_subtitle'); ?>
                                </span>
                            <?php endif; ?>
                        </h2>
                    <?php endif; ?>

                    <div data-aos="fade-up">    
                        <?php the_field('content_content'); ?>
                    </div>
                    <?php block_buttons(get_field('buttons'), [
                        'class' => 'buttons ',
                        'aos' => true, 
                        'aos_delay' => '150'
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <?php
}