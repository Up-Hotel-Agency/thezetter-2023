<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'roomslisting',
    'title'             => __('Rooms Listing'),
    'description'       => __('Rooms Listing'),
    'render_callback'   => 'rooms_listing_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'building', // dashicons, without the leading dashicons-
    'keywords'          => array( 'rooms' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/img_content/img_content.min.js',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => true
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_style( 'block-acf-image-content-block', get_template_directory_uri() . '/assets/css/content/content.css' );
        // wp_enqueue_style( 'block-acf-featured-list', get_template_directory_uri() . '/assets/css/featured_list/featured_list.css' );
    }
));
function rooms_listing_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="rooms-listing row container spacing <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="content-block featured-content text-align-center<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <div class="featured-content-image" data-aos="fade-up">
                <?php if(get_field('illustration')): echo img_sizes(get_field('illustration'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
            </div>
            <?php if( get_field('title_title') ): ?>
                <h2 class="h3 mb-8" data-aos="fade-up">
                    <?php the_field('title_title'); ?>
                </h2>
            <?php endif; ?>
            <?php if( get_field('content_content') ): ?>
                <div class="mb-12 size-l" data-aos="fade-up">
                    <?php the_field('content_content', false, false); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'rooms',
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
            $roomsCount = 1; ?>
            <div class="posts-grid flex flex-wrap">
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); $room = get_the_ID(); ?>
                    
                
                

                <div class="post-item mb-12 two xs:flex xs:items-center" data-aos="fade-up">
                    <a href="<?php the_permalink(); ?>" class="post-item-img mb-6">
                        <?php block_media( get_field('room_media', $room), [
                            'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                            'default_aspect' => '16/9',
                            'video_aspect' => '16/9',
                            'slick_dots' => false,
                            'dynamic_mobile' => false
                        ]); ?>
                    </a>
                    <div class="post-item-content">
                        <h4 class="mb-4" data-aos="fade-up" data-aos-delay="100"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <p class="mb-4 size-s" data-aos="fade-up" data-aos-delay="150">
                            <?php echo get_field('intro_content', $room, false); ?>
                        </p>

                        <?php if(get_field('sleeps', $room) || get_field('bed_size', $room) || get_field('average_size', $room)): ?>
                            <div class="post-item-items mb-2 flex flex-row">
                                <?php if(get_field('sleeps', $room)): ?>
                                    <div class="item">
                                        <?php the_field('sleeps', $room); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(get_field('bed_size', $room)): ?>
                                    <div class="item">
                                        <?php the_field('bed_size', $room); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(get_field('average_size', $room)): ?>
                                    <div class="item"> 
                                        <?php the_field('average_size', $room); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                            <a class="button secondary" href="<?php echo get_the_permalink(); ?>">
                                More information
                            </a>
                            <?php block_buttons(get_field('link_field', $room), [
                                'class' => 'button primary '
                            ]); ?>
                        </div>
                    </div>
                </div>







                
                
                
                
                    
                <?php $roomsCount++; endwhile; ?>
            </div>
        <?php endif; wp_reset_query(); ?>
    </section>
    <?php
}