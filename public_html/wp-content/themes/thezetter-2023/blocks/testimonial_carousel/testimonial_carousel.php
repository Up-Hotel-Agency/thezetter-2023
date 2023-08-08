<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'testimonialcarousel',
    'title'             => __('Testimonial Carousel'),
    'description'       => __('Testimonial Carousel'),
    'render_callback'   => 'testimonial_carousel_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'slides', // dashicons, without the leading dashicons-
    'keywords'          => array( 'testimonial', 'carousel' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/testimonial_carousel/testimonial_carousel.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/testimonial_carousel/testimonial_carousel.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function testimonial_carousel_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="
    row spacing
    testimonial-block
    <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?>
    <?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>
    <?php if( get_field('display_image') ): ?>
        with-img
        flex
        xs:flex-col
        <?php the_field('layout'); ?>
    <?php endif; ?>
    "
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

        <div class="
        testimonial-carousel-wrapper
        <?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>
        <?php if( get_field('display_image') ): ?>
        flex justify-center flex-col
        <?php endif; ?>
        " data-aos="fade-up">
            <div class="testimonial-carousel js-testimonial-carousel">
                <?php while ( have_rows('slide') ) : the_row();
                $slideCount = count(get_field('slide')); ?>

                    <div
                    class="testimonial-carousel-slide"
                    >
                        <div class="testimonial-carousel-slide-inner centered">
                            
                            <?php if( get_sub_field('testimonial') ): ?>
                                <p class="size-xl xs:size-l mb-6 bold">“<?php the_sub_field('testimonial'); ?>”</p>
                            <?php endif; ?>

                            <?php if( get_sub_field('author') ): ?>
                                <p class="mb-6 color-body-50"><?php the_sub_field('author'); ?></p>
                            <?php endif; ?>

                        </div>

                    </div>
                <?php endwhile; ?>
            </div>
            <?php if( $slideCount > 1 ): ?>
                <div class="slick-controls flex justify-center items-center">
                    <a href="#" class="js-testimonial-prev slick-control" title="Previous slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Previous</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                    <div class="slick-dots testimonial-dots"></div>
                    <a href="#" class="js-testimonial-next slick-control" title="Next slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Next</title><g class="caret-right"><polyline class="arrowhead" points="18.982 11.964 31.018 24 18.982 36.036" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                </div>
            <?php endif; ?>
        </div>
        <?php if( get_field('display_image') ): ?>
            <?php block_media( get_field('image'), [
                'img_sizes' => array('default' => 'img_1367', 'page_area' => 50, 'mobile_page_area' => 100),
                'default_aspect' => '1/1',
                'slick_dots' => false,
            ]); ?>
        <?php endif; ?>
    </section>
    <?php
}