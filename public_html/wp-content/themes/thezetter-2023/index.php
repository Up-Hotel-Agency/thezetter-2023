<?php get_header(); ?>

<?php 
    wp_enqueue_script( 'img-content', get_template_directory_uri() . '/assets/js/img_content/img_content.min.js' );
    wp_enqueue_style( 'img-content', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
?>
<section class="row side-spacing layout-text-image  container img-content-row theme--accent">
    <div class="img-content img-content-banner text-image">
        <div class="img" data-aos="fade-up">
            <?php block_media( get_field('posts_image', get_option( 'page_for_posts' )), [
                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                'default_aspect' => '1/1',
            ]); ?>
        </div>

        <div class="content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <div class="content-inner">
                <div>
                    <?php if(get_field('posts_page_title', get_option( 'page_for_posts' ))): ?>
                        <h1 class="mb-6 h4 color-accent" data-aos="fade-up">
                            <?php the_field('posts_page_title', get_option( 'page_for_posts' )); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if(get_field('posts_page_content', get_option( 'page_for_posts' ))): ?>
                        <h2 class="regular-weight" data-aos="fade-up" data-aos-delay="100">
                            <?php the_field('posts_page_content', get_option( 'page_for_posts' )); ?>
                        </h2>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </div>
</section>

<section class="header-blog flex flex-col items-center">
    <?php if(get_field('posts_page_general_title', get_option( 'page_for_posts' ))): ?>
        <h3 class="mb-4 color-accent" data-aos="fade-up">
            <?php the_field('posts_page_general_title', get_option( 'page_for_posts' )); ?>
        </h3>
    <?php endif; ?>

    <?php if(get_field('posts_page_general_subtitle', get_option( 'page_for_posts' ))): ?>
        <div class="size-l mb-0" data-aos="fade-up" data-aos-delay="100">
            <?php the_field('posts_page_general_subtitle', get_option( 'page_for_posts' )); ?>
        </div>
    <?php endif; ?>
</section>
<?php 
//Include required listing format
if( get_blog_listing() == 'blog_1' ): 
    include 'templates/blog_listing_1.php'; 
elseif( get_blog_listing() == 'blog_2' ):
    include 'templates/blog_listing_2.php'; 
endif;
?>

<?php global $wp_query;
if( $wp_query->found_posts > '9' ): ?>
<p class="loadmore-wrapper buttons centered mb-16">
    <a href="#" class="button secondary" id="loadmore" data-posts-per-page="9" data-count-posts="<?php echo wp_count_posts('post')->publish ?>">
        Load More Articles
    </a>
</p>
<?php endif; ?>

<?php get_footer(); ?>