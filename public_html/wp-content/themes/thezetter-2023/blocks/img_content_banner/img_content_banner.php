<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'imagecontentbannerblock',
    'title'             => __('Image / Content Banner Block'),
    'description'       => __('Image / Content Banner Block'),
    'render_callback'   => 'img_content_banner_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'forms', // dashicons, without the leading dashicons-
    'keywords'          => array( 'image, content, banner' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/img_content_banner/img_content_banner.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/img_content_banner/img_content_banner.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function img_content_banner_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    // the img-content-row class below is for vogue
    ?>
    <section
    class="row full-height <?php if(!get_field('no_spacings')):?>spacing<?php endif; ?> <?php if(get_field('no_side_spacing')):?>side-spacing<?php endif; ?> layout-<?php the_field('layout'); ?> <?php if(get_field('wide_image')):?>wide-image<?php endif; ?> container img-content-row<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="img-content img-content-banner <?php the_field('layout'); ?><?php if( get_field('images_bottom_mob') ): ?> mob-img-bottom<?php endif; ?>">
            <div class="img" data-aos="fade-up">
                <?php block_media( get_field('images'), [
                    'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                    'default_aspect' => '1/1',
                    'slick_dots' => true,
                ]); ?>
            </div>

            <div class="content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                <div class="content-inner">
                    <header>
                        <?php if( get_field('title_title') ): ?>
                            <h1 class="mb-6 h4" data-aos="fade-up">
                                <?php the_field('title_title'); ?>
                            </h1>
                        <?php endif; ?>

                        <?php if( get_field('content_content') ): ?>
                            <h2 data-aos="fade-up"><?php the_field('content_content', false, false); ?>
                            </h2>
                        <?php endif; ?>
                    </header>
                    
                    <?php block_buttons(get_field('buttons'), [
                        'class' => 'no-margin',
                        'aos' => true, 
                        'aos_delay' => '150'
                    ]); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}