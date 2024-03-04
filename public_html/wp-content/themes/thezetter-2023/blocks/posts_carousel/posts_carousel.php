<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'postscarousel',
    'title'             => __('Posts Carousel'),
    'description'       => __('Posts Carousel'),
    'render_callback'   => 'posts_carousel_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'slides', // dashicons, without the leading dashicons-
    'keywords'          => array( 'image, content' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/posts_carousel/posts_carousel.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/posts_carousel/posts_carousel.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function posts_carousel_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing posts_carousel spacing <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        <div class="posts_carousel_content <?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            
            <div class="cta-career-header">
                <header>
                    <?php if( get_field('overline_overline') ): ?>
                        <div class="overline mb-12"><?php echo get_field('overline_overline'); ?></div>
                    <?php endif; ?>
                    <?php if( get_field('title_title') ): ?>
                        <div class="container header-title">
                            <h2 class="h3 no-margin" data-aos="fade-up">
                                <?php the_field('title_title'); ?>
                            </h2>
                            <?php
                            $link = get_field('link_link');
                            if( isLink( $link ) ):  ?>
                                <div class="buttons justify-end">
                                    <a class="button primary no-margin" href="<?php echo linkField( $link, 'url' ); ?>" <?php echo linkField( $link, 'target' ); ?>>
                                        <?php echo linkField( $link, 'text' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if( get_field('content_content') ): ?>
                            <div class="header-content">
                                <?php the_field('content_content'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </header>
            </div>

            <div class="posts">
            <?php
                $today = date('Ymd');
                $event_args = get_posts( array(
                    'posts_per_page' => 6,
                    'post_type' => 'post',
                    'orderby' => 'date',
                    'order' => 'ASC'
                ));
                $event_query = new WP_Query($event_args);
                $cont=0; 
                $count_post = wp_count_posts( 'post' )->publish;?>
                <div class="posts-carousel js-posts-carousel flex">
                    <?php
                    while ( $event_query->have_posts() ) : $event_query->the_post(); $event = get_the_ID(); ?>
                        <div class="img-content mb-0" data-aos="fade-up" >
                            <a class="no-margin flex justify-end" href="<?php the_permalink( $event ); ?>">
                                <div class="img">
                                    <div class="image-carousel">
                                        
                                        <?php block_media( get_field('featured_image__video', $event), [
                                            'img_sizes' => array('default' => 'img_1367', 'page_area' => 42, 'mobile_page_area' => 85)
                                        ]); ?>
                                    </div>
                                </div>
                            </a>
                            <div class="content xs:text-left">
                                <div class="content-inner">
                                    <article class="content-wrap mb-4">
                                        <h4 class="no-margin">
                                                <?php echo substr(get_the_title(), 0, 38) . "..."; ?>
                                        </h4>
                                    </article>
                                    <a class="button secondary no-margin flex justify-end" href="<?php the_permalink( $event ); ?>">
                                        Read Article
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php $cont++; endwhile;
                    wp_reset_query(); ?>
                </div>
                <?php if( $count_post > 1 ): ?>
                        <div class="slick-controls flex justify-center items-center">
                            <div class="slick-controls-arrows flex justify-center items-center" dir="ltr">
                                <a href="#" class="js-img-prev slick-control" title="Previous slide"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Previous</title><g clip-path="url(#clip0_1939_4820)"> <rect width="48" height="48" fill="black" fill-opacity="0.5"/> <g clip-path="url(#clip1_1939_4820)"> <g clip-path="url(#clip2_1939_4820)"> <path d="M26.842 29.6854L21.158 24.0004L26.842 18.3154" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g> <rect x="0.5" y="0.5" width="47" height="47" stroke="white"/> </g> </g> <defs> <clipPath id="clip0_1939_4820"> <rect width="48" height="48" fill="white"/> </clipPath> <clipPath id="clip1_1939_4820"> <rect width="48" height="48" fill="white"/> </clipPath> <clipPath id="clip2_1939_4820"> <rect width="24" height="24" fill="white" transform="translate(12 12)"/> </clipPath> </defs> </svg></a>
                                <a href="#" class="js-img-next slick-control" title="Next slide"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Next</title><g clip-path="url(#clip0_1939_4789)"> <rect width="48" height="48" fill="black" fill-opacity="0.5"/> <g clip-path="url(#clip1_1939_4789)"> <g clip-path="url(#clip2_1939_4789)"> <path d="M21.158 18.3154L26.842 24.0004L21.158 29.6854" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g> <rect x="0.5" y="0.5" width="47" height="47" stroke="white"/> </g> </g> <defs> <clipPath id="clip0_1939_4789"> <rect width="48" height="48" fill="white"/> </clipPath> <clipPath id="clip1_1939_4789"> <rect width="48" height="48" fill="white"/> </clipPath> <clipPath id="clip2_1939_4789"> <rect width="24" height="24" fill="white" transform="translate(12 12)"/> </clipPath> </defs> </svg></a>
                            </div>
                        </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}