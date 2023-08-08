<?php get_header(); ?>

<?php 
    wp_enqueue_script( 'img-content', get_template_directory_uri() . '/assets/js/img_content/img_content.min.js' );
    wp_enqueue_style( 'img-content', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
?>
<header class="row side-spacing layout-text-image  container img-content-row">
    <div class="img-content text-image">
        <div class="img" data-aos="fade-up">
            <?php block_media( get_field('404_image', 'options'), [
                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                'default_aspect' => '1/1',
                'slick_dots' => true,
            ]); ?>
        </div>

        <div class="content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <div class="content-inner">
                <div>
                    <p class="mb-6 h4 color-accent" data-aos="fade-up">
                        Error 404
                    </p>

                    <h2 class="regular-weight" data-aos="fade-up" data-aos-delay="100">
                        We're sorry, the page you requested could not be found or does not exist.
                    </h2>
                </div>
                
                <div class="buttons no-margin" data-aos="fade-up" data-aos-delay="200">
                    <a class="button minor" href="<?php echo get_bloginfo( 'url' ); ?>">
                        Return to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<?php get_footer(); ?>
