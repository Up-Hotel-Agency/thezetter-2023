<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'imagecontentblock',
    'title'             => __('Image / Content Block'),
    'description'       => __('Image / Content Block'),
    'render_callback'   => 'img_content_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'forms', // dashicons, without the leading dashicons-
    'keywords'          => array( 'image, content' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/img_content/img_content.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/img_content/img_content.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function img_content_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    // the img-content-row class below is for vogue
    ?>
    <section
    class="row <?php if(get_field('enable_map_style')):?> map-style-block <?php endif; ?><?php if(get_field('content_text_list_style')): ?> content-style-list <?php endif; ?> <?php if(get_field('no_side_spacing') && get_field('no_spacings')): ?> image-fill-content <?php endif; ?> <?php if(!get_field('no_spacings')):?>spacing<?php endif; ?> <?php if(get_field('no_side_spacing')):?>side-spacing<?php endif; ?> layout-<?php the_field('layout'); ?> <?php if(get_field('wide_image')):?>wide-image container-small<?php endif; ?> container img-content-row<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="img-content <?php the_field('layout'); ?><?php if( get_field('images_bottom_mob') ): ?> mob-img-bottom<?php endif; ?>">
            <div class="img" data-aos="fade-up">
                <?php block_media( get_field('images'), [
                    'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                    'default_aspect' => '1/1',
                    'slick_dots' => true,
                ]); ?>
            </div>

            <div class="content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                <div class="content-inner mobile-<?php echo get_field('mobile_text_alignment'); ?>">
                    <header>
                        <?php if( get_field('overline_overline') ): ?>
                            <p class="mb-6 h4 color-accent" data-aos="fade-up">
                                <?php the_field('overline_overline'); ?>
                            </p>
                        <?php endif; ?>

                        <?php if( get_field('title_title') ): ?>
                            <h2 data-aos="fade-up"  data-aos-delay="100"><?php the_field('title_title'); ?>
                                <?php if( get_field('subtitle_subtitle') ): ?>
                                    <div class="subtitle-2" data-aos="fade-up" data-aos-delay="150">
                                        <?php the_field('subtitle_subtitle'); ?>
                                    </div>
                                <?php endif; ?>
                            </h2>
                        <?php endif; ?>
                    </header>

                    <article class="content-wrap mb-4 <?php if(get_field('overide_font')): the_field('content_text_font'); endif ?> <?php if(get_field('content_text_size_small')): ?> content-text-small <?php endif; ?>" data-aos="fade-up" data-aos-delay="150"<?php if( get_field('hide_content_on_mobile') ): ?> class="hide-mobile"<?php endif; ?>>
                        <?php the_field('content_content'); ?>
                    </article>
                    <?php while ( have_rows('items') ) : the_row(); ?>
                        <div class="item mb-8" data-aos="fade-up" data-aos-delay="150">
                            <?php if( have_rows('buttons_buttons') ): ?>
                                <div class="buttons" >
                                    <?php while ( have_rows('buttons_buttons') ) : the_row(); ?>
                                        <?php
                                        $class = get_sub_field('button_type');
                                        $link = get_sub_field('link_field_link');
                                        if( isLink( $link ) ):
                                        ?>
                                            <a class="button <?php echo $class; ?>" href="<?php echo linkField( $link, 'url' ); ?>" <?php echo linkField( $link, 'target' ); ?>>
                                                <?php echo linkField( $link, 'text' ); ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                            <?php if(get_sub_field('description')): ?>
                                <div class="subtitle-2">
                                    <?php the_sub_field('description'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                    
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