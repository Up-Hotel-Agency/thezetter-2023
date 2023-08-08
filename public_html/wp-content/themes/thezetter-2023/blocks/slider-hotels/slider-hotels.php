<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'sliderhotels',
    'title'             => __('Slider Hotels'),
    'description'       => __('Slider Hotels'),
    'render_callback'   => 'slider_hotels_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'slider', 'hotels' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/slider-hotels/slider-hotels.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/slider-hotels/slider-hotels.css',
    'supports'          => [ 'align' => false, 'align_text' => true ]
));
function slider_hotels_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row content-block-container<?php if(get_field('has_patterned_background')): ?> has-patterned-background<?php endif; ?><?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="slide-hotels-block <?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <div class="slide-hotels-content spacing container">
                <?php if( get_field('title_title') ): ?>
                    <h3 data-aos="fade-up"><?php the_field('title_title'); ?></h3>
                <?php endif; ?>
                <?php if( get_field('content_content') ): ?>
                    <div class="subtitle" data-aos="fade-up">
                        <?php the_field('content_content'); ?>
                    </div>
                <?php endif; ?>

                <div class="hotels-list flex flex-col items-start" data-aos="fade-up">
                    <?php $hoteID=1;while ( have_rows('hotel') ) : the_row(); ?>
                        <div class="hotel-list-item flex flex-col items-start" data-aos="fade-up">
                            <div class="img img-hotel img-hotel-single img-hotel-single-mobile" data-aos="fade-up">
                                <?php if( have_rows('hotel_images') ): ?>
                                    <div class="image-carousel js-image-carousel img-abs">
                                        <?php while ( have_rows('hotel_images') ) : the_row(); ?>
                                                <?php echo img_sizes(get_sub_field('image'), ['default' => 'img_1367', 'page_area' => '50', 'mobile_page_area' => '85', 'lazy_load' => true, 'object_fit' => 'cover']); ?>
                                        <?php endwhile; ?>
                                    </div>
                                    
                                    <?php $count = count((array) get_sub_field('hotel_images'));
                                    if( $count > 1 ): ?>
                                        <div class="slick-controls flex justify-center items-center">
                                            <a href="#" class="js-img-prev slick-control" title="Previous slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Previous</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                                            <div class="slick-dots img-content-dots"></div>
                                            <a href="#" class="js-img-next slick-control" title="Next slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Next</title><g class="caret-right"><polyline class="arrowhead" points="18.982 11.964 31.018 24 18.982 36.036" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            
                            <?php if( get_sub_field('title_title') ): ?>
                                <h4 class="mb-0" data-aos="fade-up">
                                    <?php the_sub_field('title_title'); ?>
                                </h4>
                            <?php endif; ?>
                            <?php if( get_sub_field('subtitle_subtitle') ): ?>
                                <div class="subtitle-2" data-aos="fade-up">
                                    <?php the_sub_field('subtitle_subtitle'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if( have_rows('buttons_buttons') ): ?>
                                <div class="buttons" data-aos="fade-up" data-aos-delay="150">
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
                                    <?php $hoteID++; endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="slide-hotels-img">
                <div class="img img-hotel active" data-aos="fade-up">
                    <?php if( have_rows('default_images') ): ?>
                        <div class="image-carousel js-image-carousel img-abs">
                            <?php while ( have_rows('default_images') ) : the_row(); ?>
                                    <?php echo img_sizes(get_sub_field('image'), ['default' => 'img_1367', 'page_area' => '50', 'mobile_page_area' => '85', 'lazy_load' => true, 'object_fit' => 'cover']); ?>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php $count = count((array) get_field('default_images'));
                        if( $count > 1 ): ?>
                            <div class="slick-controls flex justify-center items-center">
                                <a href="#" class="js-img-prev slick-control" title="Previous slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Previous</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                                <div class="slick-dots img-content-dots"></div>
                                <a href="#" class="js-img-next slick-control" title="Next slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Next</title><g class="caret-right"><polyline class="arrowhead" points="18.982 11.964 31.018 24 18.982 36.036" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php $hoteID=1; while ( have_rows('hotel') ) : the_row(); ?>
                    <div class="img img-hotel img-hotel-single img-hotel-single-<?php echo $hoteID; ?>" data-aos="fade-up" data-id="<?php echo $hoteID; ?>">
                        <?php if( have_rows('hotel_images') ): ?>
                            <div class="image-carousel js-image-carousel img-abs">
                                <?php while ( have_rows('hotel_images') ) : the_row(); ?>
                                        <?php echo img_sizes(get_sub_field('image'), ['default' => 'img_1367', 'page_area' => '50', 'mobile_page_area' => '85', 'lazy_load' => true, 'object_fit' => 'cover']); ?>
                                <?php endwhile; ?>
                            </div>
                            
                            <?php $count = count((array) get_sub_field('hotel_images'));
                            if( $count > 1 ): ?>
                                <div class="slick-controls flex justify-center items-center">
                                    <a href="#" class="js-img-prev slick-control" title="Previous slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Previous</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                                    <div class="slick-dots img-content-dots"></div>
                                    <a href="#" class="js-img-next slick-control" title="Next slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Next</title><g class="caret-right"><polyline class="arrowhead" points="18.982 11.964 31.018 24 18.982 36.036" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php $hoteID++; endwhile; ?>
            </div>
        </div>
    </section>
    <?php

}