<?php
if(!function_exists('get_blog_listing')){
    // wrap in an if statement in case set in a child theme
    function get_blog_listing() {
        $blog_listing_type = 'blog_2'; // set the blog listing type here
        return $blog_listing_type;
    }
}
if(!function_exists('get_blog_single')){
    // wrap in an if statement in case set in a child theme
    function get_blog_single() {
        $blog_single_type = 'blog_1'; // set the blog single type here
        return $blog_single_type;
    }
}


// Remove default image or ACF image based on blog number
if(get_blog_listing() == "blog_2"){

    add_action('init','remove_thumbnail_support');
    function remove_thumbnail_support(){
        remove_post_type_support('post','thumbnail');
    }

}else{

    function hide_field_acf_featured_image( $field ) {
       return false;
    }
    add_filter( 'acf/prepare_field/name=featured_image__video', 'hide_field_acf_featured_image' );

}

add_action( 'wp_enqueue_scripts', 'enqueue_single_post_styles' );

function enqueue_single_post_styles() {
    if ( get_post_type() === 'post' || is_404() ) {
        wp_enqueue_style( 'block-acf-cta-blocks', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
    }
}

/**
* @desc blog page ajax load more
* @desc modify the main blog query
*/
// function modify_blog_query( $query ) {
//     if ( $query->is_home() && $query->is_main_query() ) { // Run only on the homepage
//         $query->query_vars['posts_per_page'] = 13; // Show only 5 posts on the homepage only
//     }
// }
// // Hook my above function to the pre_get_posts action
// add_action( 'pre_get_posts', 'modify_blog_query' );

// ajax load more posts
function ajax_load_more() {
    if ( isset($_REQUEST) ):
        $offset = (empty($_REQUEST['offset'])) ? 10 : $_REQUEST['offset'];
        $args = array( 'post_type' => 'post', 'posts_per_page' => 6, 'offset' => $offset, 'post_status' => 'publish' );

        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            if( get_blog_listing() == 'blog_1' ): ?>
                <a href="<?php the_permalink(); ?>" class="cta theme__card--image">
                    <div class="cta-inner flex items-center flex-col justify-center">
                        <header>
                            <p class="mb-1 overline color-accent">
                                <?php
                                    $categories = get_the_category();
                                    $output = '';
                                    if ($categories) {
                                        foreach ($categories as $category) {
                                            $output .= '<span class="cat-link">' . $category->cat_name . '</span>';
                                        }
                                        echo trim($output);
                                    }
                                ?>
                            </p>
                            <h3 class="mb-1">
                                <?php the_title(); ?>
                            </h3>
                        </header>

                        <div class="cta-content">
                            <p><?php echo get_the_date(); ?></p>
                        </div>
                        <div class="buttons justify-center">
                            <span class="button secondary icon no-margin">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                            </span>
                        </div>
                    </div>
                    <?php if( has_post_thumbnail() ): echo img_sizes(get_post_thumbnail_id(), ['default' => 'img_800', 'lazy_load' => true]); endif; ?>
                </a>
            <?php endif;
            if( get_blog_listing() == 'blog_2' ): ?>

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
                            'dynamic_mobile' => false,
                            'ajax' => true
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

            <?php endif;
        endwhile;
    endif;
    die();
}
add_action( 'wp_ajax_get_more', 'ajax_load_more' );
add_action( 'wp_ajax_nopriv_get_more', 'ajax_load_more' );


