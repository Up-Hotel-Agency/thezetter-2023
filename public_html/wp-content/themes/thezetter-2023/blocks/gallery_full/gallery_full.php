<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'galleryfullscreen',
    'title'             => __('Gallery Full Screen'),
    'description'       => __('Gallery Full Screen'),
    'render_callback'   => 'gallery_full_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'fullscreen-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'gallery' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/gallery_full/gallery_full.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/gallery_full/gallery_full.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function gallery_full_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row gallery-full-container <?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
    id="<?php if( array_key_exists('anchor', $block) && !empty($block['anchor'])): echo esc_attr($block['anchor']); else: echo $block['id']; endif ?>"
    >

        <div class="gallery-full js-gallery-full">
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
                        $link = get_sub_field('optional_button_link');
                        if ( !empty($image) ): 
                            // add image properties and related data to main images array
                            $images[] = array(
                                'image' => $image,
                                'caption' => $caption,
                                'galleryCount' => $galleryCount,
                                'link' => $link,
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
            <div class="gallery-full-slide cat-<?php echo $img['galleryCount']; ?>">
                <?php echo img_sizes($img['image'], ['default' => 'img_1920', 'lazy_load' => true]); ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="gallery-full-controls flex">
            <div class="gallery-cat-select">
                <label for="gallery-cat">Category</label>
                <select class="js-gallery-cat" id="gallery-cat">
                    <option value="all">All</option>
                    <?php
                    $args = array(
                        'post_type' => 'gallery',
                        'posts_per_page' => -1
                    );
                    $loop = new WP_Query( $args ); ?>

                    <?php $catCount = 1; while ( $loop->have_posts() ) : $loop->the_post(); ?>
                        <option value="cat-<?php echo $catCount; ?>"><?php the_title(); ?></option>
                    <?php $catCount++; endwhile; wp_reset_query(); ?>
                </select>
            </div>
            <div class="gallery-controls flex flex-grow items-center sm:justify-center">
                <a href="#" class="button icon secondary js-gallery-full-prev">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.842 17.685L9.158 12 14.842 6.315"/></svg>
                </a>
                <a href="#" class="button icon secondary js-gallery-full-next">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.158 6.315L14.842 12 9.158 17.685"/></svg>
                </a>
                <div class="counter js-gallery-full-counter">1/12</div>
                <div class="gallery-image-details">
                    <div class="js-gallery-image-details">
                        <?php foreach($images as $img): ?>
                            <div class="gallery-image-details-slide cat-<?php echo $img['galleryCount']; ?> justify-between items-center sm:flex-col sm:justify-start">
                                <p class="no-margin"><?php echo $img['caption']; ?></p>
                                <?php
                                $link = $img['link'];
                                if( isLink( $link ) ):
                                ?>
                                    <a class="button primary" href="<?php echo linkField( $link, 'url' ); ?>" <?php echo linkField( $link, 'target' ); ?>>
                                        <?php echo linkField( $link, 'text' ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <a href="#" class="hide-gallery js-hide-gallery flex justify-center items-center sm:hidden"><span class="hide">Hide Menu</span><span class="show">Show Menu</span></a>
        </div>
        
    </section>
    <?php
}