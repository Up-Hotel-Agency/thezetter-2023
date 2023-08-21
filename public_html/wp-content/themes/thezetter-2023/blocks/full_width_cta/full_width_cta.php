<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'fullwidthcta',
    'title'             => __('Full Width CTA'),
    'description'       => __('Full Width CTA'),
    'render_callback'   => 'full_width_cta_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-expand', // dashicons, without the leading dashicons-
    'keywords'          => array( 'cta', 'call to action', 'full', 'width' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_style( 'block-acf-full-width-cta', get_template_directory_uri() . '/assets/css/full_width_cta/full_width_cta.css' );
        wp_enqueue_style( 'block-acf-cta', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
    }
));
function full_width_cta_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row full-width-cta<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( get_field('contained') ):?> container<?php endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="theme--image full-width-cta__wrapper flex items-center justify-center not-square img-abs" data-aos="fade-up">
            <div class="full-width-cta__inner text-left flex items-start flex-col justify-start">
                <header>
                    <?php if( get_field('overline_overline') ): ?>
                        <p class="mb-1 overline color-accent">
                            <?php the_field('overline_overline'); ?>
                        </p>
                    <?php endif; ?>

                    <?php if( get_field('title_title') ): ?>
                        <h2 class="h3"><?php the_field('title_title'); ?>
                            <?php if( get_field('subtitle_subtitle') ): ?><span class="subtitle"><?php the_field('subtitle_subtitle'); ?></span><?php endif; ?>
                        </h2>
                    <?php endif; ?>
                </header>

                <?php if( get_field('content_content') || have_rows('buttons_buttons') ): ?>
                    <article>
                        <?php the_field('content_content'); ?>
                        <?php block_buttons(get_field('buttons'), [
                            'class' => 'no-margin'
                        ]); ?>
                    </article>    
                <?php endif; ?>

            </div>
            <?php if( get_field('contained') ):
                //Serve smaller page areas if set to contained
                echo img_sizes(get_field('image'), ['default' => 'img_1920', 'page_area' => '83', 'mobile_page_area' => '85', 'lazy_load' => true]);
            else :
                //Serve full-width page areas if not set to contained
                echo img_sizes(get_field('image'), ['default' => 'img_1920', 'page_area' => '100', 'tablet_page_area' => '100', 'mobile_page_area' => '100', 'lazy_load' => true]);
            endif; ?>
        </div>
    </section>
    <?php
}