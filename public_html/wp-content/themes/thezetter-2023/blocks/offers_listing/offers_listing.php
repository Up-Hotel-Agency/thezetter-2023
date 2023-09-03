<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'offerslisting',
    'title'             => __('Offers Listing'),
    'description'       => __('Offers Listing'),
    'render_callback'   => 'offers_listing_render_callback',
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
        wp_enqueue_style( 'block-acf-offers-grid', get_template_directory_uri() . '/assets/css/offers_grid/offers_grid.css' );
        wp_enqueue_style( 'block-acf-image-content-block', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
    }
));
function offers_listing_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

            $current_site = get_current_blog_id(); 
            
        ?>
        <?php
        if($current_site == 1):
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'offers',
            );
        else:
            if(get_field('list_global_offers')):
                switch_to_blog(1); 
                $terms = get_terms(array(
                    'taxonomy'   => 'hotel_categories',
                ));

                foreach($terms as $term):
                    $id = $term->term_id;
                endforeach;

                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'offers',
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'tax_query' => array(
                        'relation' => 'AND',
                            array(
                                'taxonomy' => 'hotel_categories', 
                                'field' => 'id',
                                'terms' => $hotel
                            ),
                        ),
                );
                restore_current_blog(); 
            else:
                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'offers',
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                );
            endif; 
        endif; 
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
            $offersCount = 1;
            while ( $the_query->have_posts() ) : $the_query->the_post(); $offer = get_the_ID(); ?>
                <div class="img-content img-content-banner <?php if($offersCount == 1): ?> theme--accent <?php endif; ?><?php if( $offersCount % 2 ): ?>text-image<?php else: ?>image-text<?php endif; ?>">
                    <div class="img" data-aos="fade-up">
                        <?php block_media( get_field('offers_media', $offer), [
                            'img_sizes' => array('default' => 'img_800', 'page_area' => 100, 'mobile_page_area' => 100),
                            'default_aspect' => '4/3',
                            'allow_aspect' => false,
                            'slick_dots' => true,
                        ]); ?>
                    </div>

                    <div class="content">
                        <div class="content-inner">

                            <?php if($offersCount == 1): ?>
                                <h1 class="mb-6 h4" data-aos="fade-up">
                                    Special Offer
                                </h1>
                                <h2 class="regular-weight" data-aos="fade-up">
                                    <?php if( get_field('title', $offer) ): ?>
                                        <?php the_field('title', $offer); ?>
                                    <?php else: ?>
                                        <?php the_title(); ?>
                                    <?php endif; ?>
                                </h2>
                                <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                                    <a class="button minor" href="<?php echo get_the_permalink(); ?>">
                                        Learn More
                                    </a>
                                    <?php block_buttons(get_field('link_field', $offer), [
                                        'class' => 'button minor '
                                    ]); ?>
                                </div>

                            <?php else: ?>
                                <header>
                                    <h2 data-aos="fade-up">
                                        <?php if( get_field('title', $offer) ): ?>
                                            <?php the_field('title', $offer); ?>
                                        <?php else: ?>
                                            <?php the_title(); ?>
                                        <?php endif; ?>
                                    </h2>
                                </header>

                                <?php if(get_field('content_content', $offer)): ?>
                                    <article class="content-wrap" data-aos="fade-up" data-aos-delay="150">
                                        <?php the_field('content_content', $offer); ?>
                                    </article>
                                <?php endif; ?>
                                
                                <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                                    <a class="button minor" href="<?php echo get_the_permalink(); ?>">
                                        Let's go
                                    </a>
                                    <?php block_buttons(get_field('link_field', $offer), [
                                        'class' => 'button minor '
                                    ]); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php $offersCount++; endwhile;
        endif; wp_reset_query(); ?>
    </section>
    <?php
}