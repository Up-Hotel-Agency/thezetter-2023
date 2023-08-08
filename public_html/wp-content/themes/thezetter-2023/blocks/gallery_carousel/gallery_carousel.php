<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'gallerycarousel',
    'title'             => __('Gallery Carousel'),
    'description'       => __('Gallery Carousel'),
    'render_callback'   => 'gallery_carousel_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'slides', // dashicons, without the leading dashicons-
    'keywords'          => array( 'gallery', 'carousel' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/gallery_carousel/gallery_carousel.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/gallery_carousel/gallery_carousel.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function gallery_carousel_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing gallery-carousel-row<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        <div class="gallery-title">
            <?php if( get_field('title_title') ): ?>
                <h3 class="flex justify-center" data-aos="fade-up">
                    <?php the_field('title_title'); ?>
            </h3>
            <?php endif; ?>
        </div>
        <div class="gallery-carousel-wrapper<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>" data-aos="fade-up">
            <a href="#" class="gallery-carousel-control gallery-carousel-prev js-gallery-prev"></a>
            <a href="#" class="gallery-carousel-control gallery-carousel-next js-gallery-next"></a>
            <div class="gallery-carousel js-gallery-carousel">
                <?php while ( have_rows('images_images') ) : the_row(); ?>
                    <?php if (get_sub_field('use_seasonal_images')): ?>
                        <?php $start_ts = DateTime::createFromFormat('d/m/Y', get_sub_field('start_date'))->getTimestamp(); ?>
                        <?php $end_ts = DateTime::createFromFormat('d/m/Y', get_sub_field('end_date'))->getTimestamp(); ?>
                        <?php $current_ts = time(); ?>
                        <?php if (($current_ts >= $start_ts) && ($end_ts <= $end_ts)): ?>
                            <div class="gallery-carousel-slide<?php if( get_sub_field('caption') ): ?> has-caption<?php endif; ?>">
                                <div class="gallery-carousel-slide-img img-abs">
                                    <?php echo img_sizes(get_sub_field('image'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true, 'object_fit' => get_sub_field('image_object_fit')]); ?>
                                </div>
                                <?php if( get_sub_field('caption') ): ?>
                                    <p class="caption mb-0 size-s">
                                        <?php the_sub_field('caption'); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!get_sub_field('use_seasonal_images')): ?>
                        <div class="gallery-carousel-slide<?php if( get_sub_field('caption') ): ?> has-caption<?php endif; ?>">
                            <div class="gallery-carousel-slide-img img-abs">
                                <?php echo img_sizes(get_sub_field('image'), ['default' => 'img_1367', 'page_area' => '82', 'mobile_page_area' => '85', 'lazy_load' => true, 'object_fit' => get_sub_field('image_object_fit')]); ?>
                            </div>
                            <?php if( get_sub_field('caption') ): ?>
                                <p class="caption mb-0 size-s">
                                    <?php the_sub_field('caption'); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>

            <div class="slick-controls flex justify-center items-center">
                <a href="#" class="js-gallery-prev slick-control" title="Previous slide"><svg width="11" height="22" viewBox="0 0 11 22" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Previous</title> <path d="M9.70508 1L1.00023 11.2129L10.4891 20.7017" stroke="black" stroke-linecap="round"/> </svg></a>
                <a href="#" class="js-gallery-next slick-control" title="Next slide"><svg width="11" height="22" viewBox="0 0 11 22" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Next</title> <path d="M1.48926 20.7021L10.1941 10.4893L0.705234 1.0004" stroke="black" stroke-linecap="round"/> </svg></a>
            </div>
        </div>
    </section>
    <?php
}