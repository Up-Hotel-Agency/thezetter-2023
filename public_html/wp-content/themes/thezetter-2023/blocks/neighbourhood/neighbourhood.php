<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'neighbourhood',
    'title'             => __('Neighbourhood'),
    'description'       => __('Neighbourhood'),
    'render_callback'   => 'neighbourhood_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'location-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'google map', 'neighbourhood' ),
    'enqueue_assets' => function(){
        wp_enqueue_style( 'block-acf-neighbourhood', get_template_directory_uri() . '/assets/css/neighbourhood/neighbourhood.css', );
        wp_enqueue_style( 'block-acf-cta-block', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
        wp_enqueue_script( 'block-acf-neighbourhood-js', get_template_directory_uri() . '/assets/js/neighbourhood/neighbourhood.min.js' );
    },
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => true
                                )
));
function neighbourhood_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    data-aos="fade-up" data-aos-id="neighbourhood"
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

        <div class="explore-locations">
            <div class="explore-nav-wrapper flex justify-between xs:items-center" data-aos="fade-up">
                <h2 class="h3 no-margin"><?php the_field('title'); ?></h2>
                <div class="explore-nav xs:hidden">
                    <a href="#" data-cat="all" class="active js-explore-category-filter">All</a>
                    <?php $catCount = 1; while ( have_rows('location_categories') ) : the_row(); ?>
                        <a href="#" data-cat="category-<?php echo $catCount; ?>" class="js-explore-category-filter"><?php the_sub_field('category_name'); ?></a>
                    <?php $catCount++; endwhile; ?>
                </div>
                <a href="#" class="explore-mob-close js-mob-explore-toggle hidden xs:flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>cross</title><line class="tick" x1="9.511" y1="38.489" x2="38.489" y2="9.511" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><line class="tick-2" data-name="tick" x1="38.489" y1="38.489" x2="9.511" y2="9.511" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                </a>
            </div>
            <div class="explore-map-carousels flex xs:flex-col" data-aos="fade-up">
                <div class="explore-map-container">
                    <div class="explore-map">
                        <?php $locations = array();

                        $catCount = 1; while ( have_rows('location_categories') ) : the_row();
                            $catName = get_sub_field('category_name');
                            while ( have_rows('locations') ) : the_row();
                                $location = get_sub_field('location');
                                $title = get_sub_field('title');
                                $subtitle = get_sub_field('subtitle');
                                $content = get_sub_field('content');
                                $image = get_sub_field('image');
                                $link = get_sub_field('link');

                                $locations[] = array(
                                    'catCount' => $catCount,
                                    'catName' => $catName,
                                    'lat' => $location['lat'],
                                    'lng' => $location['lng'],
                                    'title' => $title,
                                    'subtitle' => $subtitle,
                                    'content' => $content,
                                    'link' => $link,
                                    'image' => $image
                                );
                            endwhile;
                        $catCount++; endwhile;

                        $locationCount = 0;
                        foreach($locations as $location): ?>
                            <div
                                class="marker"
                                data-cat="category-<?php echo $location['catCount']; ?>"
                                data-count="<?php echo $locationCount; ?>"
                                data-lat="<?php echo esc_attr($location['lat']); ?>"
                                data-lng="<?php echo esc_attr($location['lng']); ?>">
                            </div>
                        <?php $locationCount++; endforeach; ?>
                        <?php $hotelLocation = get_field('hotel_location'); ?>
                        <div
                            class="marker"
                            data-cat="hotel"
                            data-lat="<?php echo esc_attr($hotelLocation['lat']); ?>"
                            data-lng="<?php echo esc_attr($hotelLocation['lng']); ?>">
                        </div>
                    </div>
                </div>
                <div class="hidden xs:flex explore-nav-mob">
                    <div class="explore-nav">
                        <a href="#" data-cat="all" class="active js-explore-category-filter">All</a>
                        <?php $catCount = 1; while ( have_rows('location_categories') ) : the_row(); ?>
                            <a href="#" data-cat="category-<?php echo $catCount; ?>" class="js-explore-category-filter"><?php the_sub_field('category_name'); ?></a>
                        <?php $catCount++; endwhile; ?>
                    </div>
                </div>
                <div class="explore-carousels">
                    <div class="explore-carousel theme--image">
                        <?php $locationCount = 0;
                        foreach($locations as $location): ?>
                            <div class="explore-carousel-slide category-<?php echo $location['catCount']; ?>" data-cat="category-<?php echo $location['catCount']; ?>" data-count="<?php echo $locationCount; ?>">
                                <div class="slide-inner flex justify-center items-center flex-col">
                                    <p class="overline mb-1 xs:hidden"><?php echo $location['catName']; ?></p>
                                    <h3>
                                        <?php echo $location['title']; ?>
                                        <span class="subtitle"><?php echo $location['subtitle']; ?></span>
                                    </h3>
                                    <?php echo $location['content']; ?>
                                    <?php
                                    $link = $location['link'];
                                    if( isLink( $link ) ):
                                    ?>
                                        <a class="button secondary" href="<?php echo linkField( $link, 'url' ); ?>" <?php echo linkField( $link, 'target' ); ?>>
                                            <?php echo linkField( $link, 'text' ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?php echo img_sizes($location['image'], ['default' => 'img_800', 'page_area' => '35', 'tablet_page_area' => '40', 'mobile_page_area' => '75', 'lazy_load' => true]); ?>
                            </div>
                        <?php $locationCount++;
                        endforeach; ?>
                    </div>
                    <div class="explore-controls flex align-center justify-center theme--image xs:hidden">
                        <a href="#" class="explore-nav explore-prev"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Previous</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                        <div class="slick-dots explore-dots"></div>
                        <a href="#" class="explore-nav explore-next"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Next</title><g class="caret-right"><polyline class="arrowhead" points="18.982 11.964 31.018 24 18.982 36.036" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden cta theme--image full-width xs:flex items-center justify-center not-square" data-aos="fade-up">
            <div class="cta-inner flex items-center flex-col justify-center">
                <header>
                    <?php if( get_field('mobile_cta_overline') ): ?>
                        <p class="mb-1 overline color-accent" data-aos="fade-up">
                            <?php the_field('mobile_cta_overline'); ?>
                        </p>
                    <?php endif; ?>

                    <?php if( get_field('mobile_cta_title') ): ?>
                        <h2 class="h1" data-aos="fade-up"><?php the_field('mobile_cta_title'); ?>
                            <?php if( get_field('mobile_cta_subtitle') ): ?><span class="subtitle" data-aos="fade-up" data-aos-delay="50"><?php the_field('mobile_cta_subtitle'); ?></span><?php endif; ?>
                        </h2>
                    <?php endif; ?>
                </header>

                <?php if( get_field('mobile_cta_content') ): ?>
                    <article class="mb-6" data-aos="fade-up">
                        <?php the_field('mobile_cta_content'); ?>
                    </article>    
                <?php endif; ?>

                <div class="buttons centered" data-aos="fade-up" data-aos-delay="200">
                    <a class="button secondary js-mob-explore-toggle" href="#">
                        <?php the_field('mobile_cta_button_text'); ?>
                    </a>
                </div>
            </div>
            <?php echo img_sizes(get_field('mobile_cta_image'), ['default' => 'img_375', 'page_area' => '100', 'mobile_page_area' => '100', 'lazy_load' => true]); ?>
        </div>
    </section>
    <?php
}