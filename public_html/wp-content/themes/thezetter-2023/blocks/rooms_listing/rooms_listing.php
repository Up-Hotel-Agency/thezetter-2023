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
        wp_enqueue_style( 'block-acf-image-content-block', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
        wp_enqueue_style( 'block-acf-featured-list', get_template_directory_uri() . '/assets/css/featured_list/featured_list.css' );
    }
));
function rooms_listing_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="rooms-listing row spacing <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <?php
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'rooms',
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
            $roomsCount = 1;
            while ( $the_query->have_posts() ) : $the_query->the_post(); $room = get_the_ID(); ?>
                <div class="img-content container spacing <?php if( $roomsCount % 2 ): ?>text-image<?php else: ?>image-text<?php endif; ?>">
                    <div class="img" data-aos="fade-up">
                        <?php block_media( get_field('room_media', $room), [
                            'img_sizes' => array('default' => 'img_800', 'page_area' => 100, 'mobile_page_area' => 100),
                            'default_aspect' => '4/3',
                            'slick_dots' => true,
                        ]); ?>
                    </div>

                    <div class="content xs:text-left">
                        <div class="content-inner">
                            <header>
                                <?php if( get_field('overline', $room) ): ?>
                                    <p class="mb-1 overline color-accent" data-aos="fade-up">
                                        <?php the_field('overline', $room); ?>
                                    </p>
                                <?php endif; ?>

                                <h2 data-aos="fade-up">
                                    <?php if( get_field('title', $room) ): ?>
                                        <?php the_field('title', $room); ?>
                                    <?php else: ?>
                                        <?php the_title(); ?>
                                    <?php endif; ?>
                                    <?php if( get_field('price_tag', $room) ): ?>
                                        <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                                            <?php the_field('price_tag', $room); ?>
                                        </span>
                                    <?php endif; ?>
                                </h2>
                            </header>

                            <article class="content-wrap" data-aos="fade-up" data-aos-delay="150"<?php if( get_field('hide_content_on_mobile') ): ?> class="hide-mobile"<?php endif; ?>>
                                <?php the_field('intro_content', $room); ?>
                            </article>
                            
                            <?php if( have_rows('features', $room) ): ?>
                                <div class="featured-list half-items flex flex-wrap mb-8">
                                    <?php $listCount = 1; while ( have_rows('features', $room) ) : the_row(); ?>
                                        <div class="featured-list-item flex items-center" data-aos="fade-up">
                                            <div class="list-counter flex items-center icons">
                                                <?php the_sub_field('autoloaded_icon'); ?>
                                            </div>
                                            <div class="list-content">
                                                <?php if( get_sub_field('title') ): ?><p class="overline mb-0"><?php the_sub_field('title'); ?></p><?php endif; ?>
                                                <?php if( get_sub_field('subtitle') ): ?><p class="size-xs mb-0"><?php the_sub_field('subtitle'); ?></p><?php endif; ?>
                                            </div>
                                        </div>
                                    <?php $listCount++; endwhile; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                                <a class="button secondary" href="<?php echo get_the_permalink(); ?>">
                                    Room Details
                                </a>
                                <?php block_buttons(get_field('link_field', $post_id), [
                                    'class' => 'button primary '
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $roomsCount++; endwhile;
        endif; wp_reset_query(); ?>
    </section>
    <?php
}