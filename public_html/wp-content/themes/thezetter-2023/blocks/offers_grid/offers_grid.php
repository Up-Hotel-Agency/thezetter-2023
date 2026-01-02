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
                        <a href="<?php echo get_the_permalink(); ?>"
                        data-type="offer"
                        data-id="<?php echo $offer; ?>"
                        class="
                            cta
                            <?php if( has_post_thumbnail() ): ?> theme__card--image<?php else: ?> theme__card--standard<?php endif; ?>
                            js-category-target all <?php if( $terms ): foreach ($terms as $term): echo $term->slug . " "; endforeach; endif; ?>
                        ">
                            <div class="cta-inner flex items-center flex-col justify-center">
                                <header>
                                    <h3 class="mb-1">
                                        <?php if( get_field('title', $offer) ): ?>
                                            <?php the_field('title', $offer); ?>
                                        <?php else: ?>
                                            <?php the_title(); ?>
                                        <?php endif; ?>
                                    </h3>
                                </header>

                                <?php if( get_field('description', $offer) ): ?>
                                    <div class="cta-content">
                                        <p><?php the_field('description', $offer, false, false); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                                    <div class="button minor">
                                        Let's go
                                    </div>
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