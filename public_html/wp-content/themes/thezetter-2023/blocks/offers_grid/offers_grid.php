<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'offersgrid',
    'title'             => __('Offers Grid'),
    'description'       => __('Offers Grid'),
    'render_callback'   => 'offers_grid_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'tickets-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'offers' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_style( 'block-acf-cta-blocks', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
        wp_enqueue_style( 'block-acf-offers-grid', get_template_directory_uri() . '/assets/css/offers_grid/offers_grid.css' );
    }
));
function offers_grid_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing offers-grid js-category-filter-group <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="in-page-nav-wrap mb-8">
            <div class="in-page-nav js-category-nav flex flex-wrap justify-center text-center">
                <a href="#" class="active" data-cat="all">All</a>
                <?php $args = array (
                    'post_type' => 'offers',
                    'taxonomy' => 'offers-categories',
                    'orderby' => 'name',
                    'order' => 'ASC'
                );
                $categories = get_categories( $args );
                foreach ($categories as $category) {
                    $post_by_cat = get_posts(array('cat' => $category->term_id)); ?>
                    <a href="#" data-cat="<?php echo $category->slug; ?>" class="<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>
                <?php } ?>
            </div>
        </div>

        <?php
        $offers_args = array(
            'posts_per_page' => -1,
            'post_type' => 'offers',
        );
        $offers_query = new WP_Query( $offers_args );
        if ( $offers_query->have_posts() ) :
            $offersCount = 1; ?>
            <div class="container">
                <div class="cta-blocks" data-aos="fade-up">
                    <?php while ( $offers_query->have_posts() ) : $offers_query->the_post(); $offer = get_the_ID();
                    $taxonomy = 'offers-categories';
                    $terms = get_the_terms( $offer, $taxonomy ); ?>
                        <a href="#"
                        data-type="offer"
                        data-id="<?php echo $offer; ?>"
                        class="
                            js-single-modal-trigger-ajax cta
                            <?php if( has_post_thumbnail() ): ?> theme__card--image<?php else: ?> theme__card--standard<?php endif; ?>
                            js-category-target all <?php if( $terms ): foreach ($terms as $term): echo $term->slug . " "; endforeach; endif; ?>
                        "
                        data-modal="modal-<?php echo $offersCount; ?>">
                            <div class="cta-inner flex items-center flex-col justify-center">
                                <header>
                                    <?php if( get_field('overline', $offer) ): ?>
                                        <p class="mb-1 overline color-accent">
                                            <?php the_field('overline', $offer); ?>
                                        </p>
                                    <?php endif; ?>
                                    <h3 class="mb-1">
                                        <?php if( get_field('title', $offer) ): ?>
                                            <?php the_field('title', $offer); ?>
                                        <?php else: ?>
                                            <?php the_title(); ?>
                                        <?php endif; ?>
                                    </h3>
                                </header>

                                <?php if( get_field('subtitle', $offer) ): ?>
                                    <div class="cta-content">
                                        <p><?php the_field('subtitle', $offer); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="buttons justify-center">
                                    <span class="button secondary icon no-margin">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                                    </span>
                                </div>
                            </div>
                            <?php block_media( get_field('offers_media', $offer), [
                                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                                'default_aspect' => '1/1',
                                'slick_dots' => false,
                                'dynamic' => false
                            ]); ?>
                        </a>
                    <?php $offersCount++; endwhile; ?>
                </div>
            </div>
        <?php endif; wp_reset_query(); ?>
    </section>
    <?php
}

//Modal for ajax request 

function ajax_load_modal_offers() {
    if ( isset($_REQUEST) ):
       
    if ( isset($_REQUEST['id'])){
        $post_id = $_REQUEST['id'];
    }else{
        return;
    }

    //Modal content 
    ?>
    <div class="modal-images theme--image">
        <?php block_media( get_field('offers_media', $post_id), [
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
        <h2 class="h1">
            <?php if( get_field('title', $offer) ): ?>
                <?php the_field('title', $post_id); ?>
            <?php else: ?>
                <?php echo get_the_title( $post_id ); ?>
            <?php endif; ?>
            <?php if( get_field('subtitle', $post_id) ): ?>
                <span class="subtitle">
                    <?php the_field('subtitle', $post_id); ?>
                </span>
            <?php endif; ?>
        </h2>
        <div class="flex offers-actions mb-12 xs:flex-wrap">
            <?php block_buttons(get_field('link_field', $post_id), [
                'class' => 'button primary no-margin '
            ]); ?>
            <div class="post-share flex items-center">
                <strong>Share</strong>
                <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo get_the_permalink( get_field('offers_page', 'options') ); ?>&amp;&p[images][0]=<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), array( 300,300 ), false, '' ); echo $src[0]; ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>facebook</title><path class="facebook" d="M34.107,3.567a45.739,45.739,0,0,0-5.334-.281c-5.288,0-8.914,3.228-8.914,9.148v5.1H13.893v6.925h5.966V42.216h7.159V24.459H32.96l.913-6.925H27.018V13.112c0-1.989.538-3.369,3.416-3.369h3.673Z" fill="currentColor"/></svg>
                </a>
                <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://twitter.com/share?url=<?php echo get_the_permalink( get_field('offers_page', 'options') ); ?>&text=<?php echo urlencode(get_the_title($post_id)); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>twitter</title><path class="twitter" d="M43.457,13.233a15.624,15.624,0,0,1-4.485,1.206A7.763,7.763,0,0,0,42.4,10.147a15.348,15.348,0,0,1-4.943,1.881,7.8,7.8,0,0,0-13.478,5.329,8.765,8.765,0,0,0,.193,1.784,22.14,22.14,0,0,1-16.059-8.15A7.8,7.8,0,0,0,10.52,21.407,7.849,7.849,0,0,1,7,20.419v.1a7.789,7.789,0,0,0,6.245,7.644,8.269,8.269,0,0,1-2.05.265,9.718,9.718,0,0,1-1.47-.121,7.8,7.8,0,0,0,7.281,5.4,15.6,15.6,0,0,1-9.668,3.328,15.963,15.963,0,0,1-1.881-.1,22,22,0,0,0,11.959,3.5c14.323,0,22.159-11.862,22.159-22.158,0-.338,0-.675-.024-1.013A16.728,16.728,0,0,0,43.457,13.233Z" fill="currentColor"/></svg>
                </a>
                <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink( get_field('offers_page', 'options') ); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>linkedin</title><g class="linkedin"><rect x="7.435" y="17.44" width="7.298" height="21.916" fill="currentColor"/><path d="M15.2,10.673a3.763,3.763,0,0,0-4.069-3.782,3.8,3.8,0,0,0-4.114,3.782,3.762,3.762,0,0,0,4.025,3.781h.045A3.777,3.777,0,0,0,15.2,10.673Z" fill="currentColor"/><path d="M40.985,26.8c0-6.723-3.583-9.864-8.382-9.864a7.222,7.222,0,0,0-6.613,3.694h.045V17.44H18.759s.088,2.057,0,21.916h7.276V27.127a5.489,5.489,0,0,1,.243-1.792,3.988,3.988,0,0,1,3.737-2.654c2.632,0,3.694,2.013,3.694,4.954V39.356h7.276Z" fill="currentColor"/></g></svg>
                </a>
            </div>
        </div>
        <?php the_field('intro_content', $post_id); ?>
    </div>
    </div>


    <?php

    endif;
    die();
}
add_action( 'wp_ajax_get_offer_modal', 'ajax_load_modal_offers' );
add_action( 'wp_ajax_nopriv_get_offer_modal', 'ajax_load_modal_offers' );
