<?php get_header();

global $post; 
$post = get_post( get_option('page_for_posts', true) );
setup_postdata( $post );

wp_reset_postdata();
?>

<section class="row container banner-block blog-header flex justify-center items-center">
    <h1 class="mb-0 text-center" data-aos="fade-up"><?php echo get_the_archive_title(); ?></h1>
</section>

<div class="in-page-nav-wrap mb-8">
    <div class="in-page-nav flex flex-wrap justify-center text-center">
        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">All</a>
        <?php
        $args = array(
            'orderby' => 'name',
            'parent' => 0
        );
        $categories = get_categories( $args );
        foreach ( $categories as $category ) {
        $thisTrueCat = get_category( get_query_var( 'cat' ) ); ?>
            <a href="/category/<?php echo $category->slug; ?>/" <?php if ($thisTrueCat->term_id == $category->term_id) { ?> class="active" <?php } ?>>
                <?php echo $category->name; ?>
            </a>
        <?php } ?>
    </div>
</div>

<div class="row container">
    <div class="posts-grid flex flex-wrap js-post-ajax">
        <?php while ( have_posts() ) : the_post(); ?>

            <div class="post-item mb-12 third xs:flex xs:items-center" data-aos="fade-up">
                <a href="<?php the_permalink(); ?>" class="post-item-img mb-6">
                    <?php if(get_blog_listing() == "blog_1"): ?>
                        <?php echo img_sizes(get_post_thumbnail_id(), ['default' => 'img_800', 'lazy_load' => true]); ?>
                    <?php else: ?>
                        <?php block_media( get_field('featured_image__video'), [
                            'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                            'default_aspect' => '4/3',
                            'video_aspect' => '4/3',
                            'slick_dots' => false,
                            'dynamic_mobile' => false
                        ]); ?>
                    <?php endif; ?>
                </a>
                <div class="post-item-content">
                    <p class="overline mb-1 xs:hidden"><?php
                        $categories = get_the_category();
                        $output = '';
                        if ($categories) {
                            foreach ($categories as $category) {
                                $output .= '<a href="' . get_category_link($category->term_id) . '" class="cat-link">' . $category->cat_name . '</a>';
                            }
                            echo trim($output);
                        }
                    ?></p>
                    <h3 class="mb-1 xs:size-m"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="no-margin xs:size-xs">
                        <?php echo get_the_date(); ?>
                    </p>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>

<?php if( $wp_the_query->post_count > '9' ): ?>
<div class="loadmore-wrapper text-center">
    <a href="#" class="button secondary" id="loadmore" data-posts-per-page="12" data-count-posts="<?php echo wp_count_posts('post')->publish ?>">
        Load More Posts
    </a>
</div>
<?php endif; ?>

<?php get_footer(); ?>