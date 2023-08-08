<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'roomsgrid',
    'title'             => __('Rooms Grid'),
    'description'       => __('Rooms Grid'),
    'render_callback'   => 'rooms_grid_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'building', // dashicons, without the leading dashicons-
    'keywords'          => array( 'rooms' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/img_content/img_content.min.js',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_style( 'block-acf-image-content-block', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
        wp_enqueue_style( 'block-acf-featured-list', get_template_directory_uri() . '/assets/css/featured_list/featured_list.css' );
    }
));
function rooms_grid_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="rooms-grid row container <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div data-aos="fade-up" class="img-content-columns flex flex-wrap xs:flex-col container nopadd-md">
            <?php
            $rooms_args = array(
                'posts_per_page' => -1,
                'post_type' => 'rooms',
            );
            $rooms_query = new WP_Query( $rooms_args );
            if ( $rooms_query->have_posts() ) :
                $roomsCount = 1;
                while ( $rooms_query->have_posts() ) : $rooms_query->the_post(); $room = get_the_ID(); ?>
                    <div class="img-content column">
                        <div class="img" data-aos="fade-up">
                            <?php block_media( get_field('room_media', $room), [
                                'img_sizes' => array('default' => 'img_800', 'page_area' => 100, 'mobile_page_area' => 100),
                                'default_aspect' => '4/3',
                                'slick_dots' => true,
                            ]); ?>
                        </div>

                        <div class="content">
                            <div class="content-inner">
                                <header>
                                    <?php if( get_field('overline', $room) ): ?>
                                        <p class="mb-1 overline color-accent" data-aos="fade-up">
                                            <?php the_field('overline', $room); ?>
                                        </p>
                                    <?php endif; ?>

                                    <h2 class="h1" data-aos="fade-up">
                                        <?php if( get_field('title', $room) ): ?>
                                            <?php the_field('title', $room); ?>
                                        <?php else: ?>
                                            <?php echo get_the_title( $room ); ?>
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
                                
                                <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                                    <a class="button secondary  js-single-modal-trigger-ajax"  data-type="room" data-id="<?php echo $room; ?>" data-modal="modal-<?php echo $roomsCount; ?>" href="#">
                                        Room Details
                                    </a>
                                    <?php block_buttons(get_field('link_field_link', $room), [
                                        'class' => 'button',
                                        'type'  => 'primary'
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $roomsCount++; endwhile;
            endif; wp_reset_query(); ?>
        </div>
    </section>
<?php
}

//Modal for ajax request 

function ajax_load_modal_rooms() {
    if ( isset($_REQUEST) ):     
        if ( isset($_REQUEST['id'])){
            $post_id = $_REQUEST['id'];
        }else{
            return;
        }

        //Modal content 
        ?>
        <div class="modal-images theme--image">
            <?php block_media( get_field('room_media', $post_id), [
                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                'video_autoplay' => true,
                'allow_aspect' => false, 
                'ajax' => true,
            ]); ?>
        </div>
        <div class="modal-content">
            <div class="modal-content-inner">
                <?php if( get_field('overline', $post_id) ): ?>
                    <p class="mb-1 overline color-accent">
                        <?php the_field('overline', $post_id); ?>
                    </p>
                <?php endif; ?>
                <h2 data-aos="fade-up">
                    <?php if( get_field('title', $post_id) ): ?>
                        <?php the_field('title', $post_id); ?>
                    <?php else: ?>
                        <?php echo get_the_title( $post_id ); ?>
                    <?php endif; ?>
                    <?php if( get_field('price_tag', $post_id) ): ?>
                        <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                            <?php the_field('price_tag', $post_id); ?>
                        </span>
                    <?php endif; ?>
                </h2>
                <?php if( have_rows('features', $post_id) ): ?>
                    <div class="featured-list half-items flex flex-wrap mb-8">
                        <?php $listCount = 1; while ( have_rows('features', $post_id) ) : the_row(); ?>
                            <div class="featured-list-item flex items-center" data-aos="fade-up">
                                <div class="list-counter flex items-center icons">
                                    <?php the_sub_field('autoloaded_icon'); ?>
                                </div>
                                <div class="list-content">
                                    <?php if( get_sub_field('title') ): ?><h5 class="mb-0"><?php the_sub_field('title'); ?></h5><?php endif; ?>
                                    <?php if( get_sub_field('subtitle') ): ?><p class="size-s mb-0"><?php the_sub_field('subtitle'); ?></p><?php endif; ?>
                                </div>
                            </div>
                        <?php $listCount++; endwhile; ?>
                    </div>
                <?php endif; ?>
                <?php if( get_field('link_field', $post_id) ): ?>
                    <div class="buttons mb-10">
                        <?php block_buttons(get_field('link_field_link', $post_id), [
                            'class' => 'button',
                            'type'  => 'primary'
                        ]); ?>
                        <?php if( get_field('booking_telephone_number', $post_id) ): ?>
                            <a class="button minor icon-left" href="tel:<?php the_field('booking_telephone_number', $post_id); ?>">    
                                <svg class="xs:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10.683 13.294A11.282 11.282 0 0 1 8.8 10.861a1.5 1.5 0 0 1 .24-1.814l.8-.8a1.5 1.5 0 0 0 0-2.121L7.728 4.005A1.5 1.5 0 0 0 5.61 4L4.439 5.175a2.955 2.955 0 0 0-.869 2.362 14.016 14.016 0 0 0 3.781 7.713 16.027 16.027 0 0 0 7.655 4.911 9.585 9.585 0 0 0 1.465.26 2.955 2.955 0 0 0 2.362-.869L20 18.381a1.5 1.5 0 0 0 0-2.118l-2.122-2.12a1.5 1.5 0 0 0-2.121 0l-.8.8a1.726 1.726 0 0 1-2.3-.042 13.357 13.357 0 0 1-1.974-1.607z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                or call <?php the_field('booking_telephone_number', $post_id); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if( get_field('room_overview', $post_id) ): ?>
                    <div class="modal-content-block mb-12">
                        <h4>Room Overview</h4>
                        <?php the_field('room_overview', $post_id); ?>
                    </div>
                <?php endif; ?>
                <?php if( have_rows('amenities', $post_id) ): ?>
                    <div class="modal-content-block mb-8">
                        <h4>Amenities</h4>
                        <div class="featured-list half-items flex flex-wrap mb-0">
                            <?php $listCount = 1; while ( have_rows('amenities', $post_id) ) : the_row(); ?>
                                <div class="featured-list-item xs-full">
                                    <div class="list-content">
                                        <?php if( get_sub_field('title') ): ?><h5 class="mb-0"><?php the_sub_field('title'); ?></h5><?php endif; ?>
                                        <?php if( get_sub_field('content') ): ?><p class="size-s mb-0"><?php the_sub_field('content'); ?></p><?php endif; ?>
                                    </div>
                                </div>
                            <?php $listCount++; endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if( get_field('show_room_cta', $post_id) ): ?>
                    <div class="modal-content-block mb-12">
                        <?php
                        $link = get_field('room_cta_link', $post_id);
                        if( isLink( $link ) ):
                        ?>
                        <a href="<?php echo linkField( $link, 'url' ); ?>" class="cta<?php if( get_field('room_cta_image', $post_id) ): ?> theme--image<?php else: ?> theme--standard<?php endif; ?>" <?php echo linkField( $link, 'target' ); ?>>
                        <?php else: ?>
                        <div class="cta<?php if( get_field('room_cta_image', $post_id) ): ?> theme--image<?php else: ?> theme--standard<?php endif; ?>">
                        <?php endif; ?>
                            <div class="cta-inner flex items-center flex-col justify-center">
                                <header>
                                    <?php if( get_field('room_cta_overline', $post_id) ): ?>
                                        <p class="mb-1 overline color-accent">
                                            <?php the_field('room_cta_overline', $post_id); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if( get_field('room_cta_title', $post_id) ): ?>
                                        <h3 class="mb-1">
                                            <?php the_field('room_cta_title', $post_id); ?>
                                        </h3>
                                    <?php endif; ?>
                                </header>

                                <?php if( get_field('room_cta_subheading', $post_id) ): ?>
                                    <div class="cta-content">
                                        <p><?php the_field('room_cta_subheading', $post_id); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if( isLink( $link ) && linkField( $link, 'text' ) ): ?>
                                    <div class="buttons justify-center">
                                        <span class="button secondary no-margin">
                                            <?php echo linkField( $link, 'text' ); ?>
                                        </span>
                                    </div>
                                <?php elseif( isLink( $link ) && !linkField( $link, 'text' ) ): ?>
                                    <div class="buttons justify-center">
                                        <span class="button secondary icon no-margin">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if( get_field('room_cta_image', $post_id) ): echo img_sizes(get_field('room_cta_image', $post_id), ['default' => 'img_800', 'page_area' => '26', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
                        <?php if( isLink( $link ) ): ?>
                        </a>
                        <?php else: ?>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php
  endif;
  die();
}
add_action( 'wp_ajax_get_room_modal', 'ajax_load_modal_rooms' );
add_action( 'wp_ajax_nopriv_get_room_modal', 'ajax_load_modal_rooms' );
