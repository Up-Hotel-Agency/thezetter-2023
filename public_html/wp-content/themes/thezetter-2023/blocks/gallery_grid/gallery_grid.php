<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'gallerygrid',
    'title'             => __('Gallery Grid'),
    'description'       => __('Gallery Grid'),
    'render_callback'   => 'gallery_grid_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'grid-view', // dashicons, without the leading dashicons-
    'keywords'          => array( 'gallery' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_script( 'block-acf-gallery-grid', get_template_directory_uri() . '/assets/js/gallery_grid/gallery_grid.min.js' );
        wp_enqueue_style( 'block-acf-gallery-grid', get_template_directory_uri() . '/assets/css/gallery_grid/gallery_grid.css' );
        wp_enqueue_style( 'block-acf-content', get_template_directory_uri() . '/assets/css/content/content.css' );
    }
));
function gallery_grid_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing js-category-filter-group <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="container banner-block flex justify-center items-center flex-col gallery-grid-banner-block<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?>">
            <div class="banner-content-block">
                <?php if( get_field('overline_overline') ): ?>
                    <p class="mb-2 overline color-accent" data-aos="fade-up">
                        <?php the_field('overline_overline'); ?>
                    </p>
                <?php endif; ?>
                <?php if( get_field('title_title') ): ?>
                    <h1 class="mb-12" data-aos="fade-up"><?php the_field('title_title'); ?>
                        <?php if( get_field('subtitle_subtitle') ): ?>
                            <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                                <?php the_field('subtitle_subtitle'); ?>
                            </span>
                        <?php endif; ?>
                    </h1>
                <?php endif; ?>
            </div>
        </div>

        <div class="in-page-nav-wrap mb-8">
            <div class="in-page-nav js-category-nav flex flex-wrap justify-center text-center">
                <a href="#" class="active" data-cat="all">All</a>
                <?php
                $args = array(
                    'post_type' => 'gallery',
                    'posts_per_page' => -1
                );
                $loop = new WP_Query( $args ); ?>

                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <a href="#" data-cat="<?php echo get_post_field( 'post_name', get_post() ); ?>"><?php the_title(); ?></a>
                <?php endwhile; wp_reset_query(); ?>
            </div>
        </div>

        <div class="container nopadd-tablet">
            <div class="gallery-grid flex flex-wrap">
                <?php 
                $args = array(
                    'post_type' => 'gallery',
                    'posts_per_page' => '-1',
                );
                $the_query = new WP_Query( $args );

                if ( $the_query->have_posts() ) :
                    $images = array();
                    $galleryCount = 1;
                    while ( $the_query->have_posts() ) : $the_query->the_post(); 
                    $gallery = get_the_ID();
                        if( have_rows('images', $gallery) ) : 
                            $imgCount = 1;
                            while( have_rows('images', $gallery) ) : the_row();
                            $image = get_sub_field('image');
                            $caption = get_sub_field('caption');
                            if ( !empty($image) ): 
                                // add image properties and related data to main images array
                                $images[] = array(
                                    'image' => $image,
                                    'caption' => $caption,
                                    'galleryCount' => $galleryCount,
                                    'imgCount' => $imgCount,
                                    'postdata' => array(
                                        'id' => get_the_ID(),
                                        'title' => get_the_title(),
                                        'permalink' => get_permalink()
                                    )
                                );
                            endif;
                            $imgCount++;
                            endwhile; // while(have_rows('images'))
                        endif; // have_rows('images')
                        $galleryCount ++;
                    endwhile; // end of loop
                    wp_reset_postdata();
                endif; // $the_query->have_posts

                // Loop through the images array and output html for each image
                shuffle($images); // Randomize the order of the images
                $count = 1;
                foreach($images as $img):
                ?>
                <a href="#"<?php if( $img['caption'] ): ?> title="<?php echo $img['caption']; ?>"<?php endif; ?> class="theme--image js-category-target js-gallery-modal-trigger <?php echo get_post_field( 'post_name', $img['postdata']['id'] ); ?>" data-modal="gallery-<?php echo $img['galleryCount']; ?>" data-modal-slide="<?php echo $img['imgCount']; ?>">
                    <figure>
                        <?php echo img_sizes($img['image'], ['default' => 'img_800', 'lazy_load' => true]); ?>
                        <figcaption class="flex items-center justify-center flex-col">
                            <span class="button no-margin secondary icon expand-icon"><svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><g><line x1="4.205" y1="19.778" x2="10.518" y2="13.464" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><polyline points="8.94 19.792 4.191 19.792 4.191 15.043" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></g><g><line x1="19.795" y1="4.222" x2="13.482" y2="10.536" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><polyline points="15.06 4.208 19.809 4.208 19.809 8.957" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></g></g></svg></span>
                            <?php if( $img['caption'] ): ?><p class="no-margin"><?php echo $img['caption']; ?></p><?php endif; ?>
                        </figcaption>
                    </figure>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
    </section>

    <?php
    $args = array(
        'post_type' => 'gallery',
        'posts_per_page' => -1
    );
    $loop = new WP_Query( $args );
    if( $loop->have_posts() ): ?>
        <?php $galleryModal = 1; while ( $loop->have_posts() ) : $loop->the_post(); $gallery = get_the_ID(); ?>
            <div class="gallery-modal js-gallery-modal flex sm:flex-col gallery-<?php echo $galleryModal; ?>">
                <div class="gallery-modal-images">
                    <div class="gallery-modal-slider js-gallery-modal-slider">
                    <?php if( have_rows('images', $gallery) ): while ( have_rows('images', $gallery) ) : the_row(); ?>
                        <div class="gallery-modal-slide theme--image">
                            <?php echo img_sizes(get_sub_field('image'), ['default' => 1920, 'lazy_load' => true, 'page_area' => 100]); ?>
                            <?php if( get_sub_field('caption') ): ?>
                                <p class="no-margin caption"><?php the_sub_field('caption'); ?></p>
                            <?php endif; ?>
                            <?php block_buttons(get_field('optional_button'), [
                                'class' => 'button',
                                'type'  => 'primary'
                            ]); ?>
                        </div>
                    <?php endwhile; endif; ?>
                </div>
            </div>
            <div class="gallery-modal-sidebar flex flex-col sm:flex-row items-center justify-between">
                <a class="js-modal-close gallery-close button icon secondary no-margin" href="#"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><line x1="4.755" y1="19.245" x2="19.245" y2="4.755" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><line x1="19.245" y1="19.245" x2="4.755" y2="4.755" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></g></svg></a>
                <div class="gallery-modal-controls sm:flex sm:items-center">
                    <button class="js-gallery-modal-next button icon secondary no-margin"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="9.158 6.315 14.842 12 9.158 17.685" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg></button>
                    <button class="js-gallery-modal-prev button icon secondary no-margin"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="14.842 17.685 9.158 12 14.842 6.315" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg></button>
                    <p class="no-margin gallery-modal-counter js-gallery-modal-counter">1<span class="slash">/</span>1</p>
                </div>
            </div>
            </div>
        <?php $galleryModal++; endwhile; ?>
    <?php endif; ?>
    <?php
}