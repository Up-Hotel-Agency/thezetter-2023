<?php
get_header();

while ( have_posts() ) : the_post(); ?>


<?php 
//Include required single format
if( get_blog_single() == 'blog_1' ): 
    include 'templates/blog_single_1.php'; 
elseif( get_blog_single() == 'blog_2' ):
    include 'templates/blog_single_2.php'; 
endif;
?>


<main class="page-container blog-post" data-aos="fade-up">
    <?php the_content(); ?>
</main>

<?php if ( get_post_type() === 'post' ) { ?>
<section class="container">
    <div class="post-actions flex justify-end xs:justify-start">
        <div data-aos="fade-up" class="post-share flex items-center">
            <span class="bold">Share This Article</span>
            <a class="button icon no-margin size-s" href="#" onclick="window.open('https://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php the_permalink(); ?>&amp;&p[images][0]=<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 300,300 ), false, '' ); echo $src[0]; ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>facebook</title><path class="facebook" d="M34.107,3.567a45.739,45.739,0,0,0-5.334-.281c-5.288,0-8.914,3.228-8.914,9.148v5.1H13.893v6.925h5.966V42.216h7.159V24.459H32.96l.913-6.925H27.018V13.112c0-1.989.538-3.369,3.416-3.369h3.673Z" fill="currentColor"/></svg>
            </a>
            <a class="button icon no-margin size-s" href="#" onclick="window.open('https://x.com/share?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on X">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <title>X</title>
                    <path fill="currentColor" transform="translate(3 8) scale(1.5)" d="M18.901 1.153h3.308l-7.227 8.26 8.502 11.434h-6.657l-5.214-6.817-5.964 6.817H2.339l7.73-8.835L1.913 1.153h6.826l4.713 6.231zm-1.161 17.68h1.833L7.084 3.058H5.117"/>
                </svg>
            </a>
            <a class="button icon no-margin size-s" href="#" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on LinkedIn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>linkedin</title><g class="linkedin"><rect x="7.435" y="17.44" width="7.298" height="21.916" fill="currentColor"/><path d="M15.2,10.673a3.763,3.763,0,0,0-4.069-3.782,3.8,3.8,0,0,0-4.114,3.782,3.762,3.762,0,0,0,4.025,3.781h.045A3.777,3.777,0,0,0,15.2,10.673Z" fill="currentColor"/><path d="M40.985,26.8c0-6.723-3.583-9.864-8.382-9.864a7.222,7.222,0,0,0-6.613,3.694h.045V17.44H18.759s.088,2.057,0,21.916h7.276V27.127a5.489,5.489,0,0,1,.243-1.792,3.988,3.988,0,0,1,3.737-2.654c2.632,0,3.694,2.013,3.694,4.954V39.356h7.276Z" fill="currentColor"/></g></svg>
            </a>
        </div>
    </div>
</section>

<section class="container nopadd-mob">
    <div class="flex justify-between posts-nav xs:flex-col">
        <?php $previous = get_previous_post();
        $next = get_next_post();
        if ( get_next_post() ): ?>
            <a class="prev bold size-l flex items-center" href="<?php echo get_permalink( $next->ID ); ?>">
                <span class="button icon no-margin">
                    <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>arrow-left</title><g class="arrow-right"><line class="arrow-stem" x1="8.036" y1="23.964" x2="40.036" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="20 36 7.964 23.964 20 11.929" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                </span>
                <?php echo apply_filters( 'the_title', $next->post_title ); ?>
            </a>
        <?php else: // empty span to get justify-between working ?>
            <span></span>
        <?php endif; ?>
        <?php if ( get_previous_post() ): ?>
            <a class="next bold size-l flex items-center xs:justify-end" href="<?php echo get_permalink( $previous->ID ); ?>">
                <?php echo apply_filters( 'the_title', $previous->post_title ); ?>
                <span class="button icon no-margin">
                    <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                </span>
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="container row more-articles">
    <header data-aos="fade-up" class="text-center">
        <p class="mb-1 overline color-accent" data-aos="fade-up">More articles like this</p>
        <h3 class="mb-10" data-aos="fade-up" data-aos-delay="50"><?php echo get_cat_name( wp_get_post_categories( get_queried_object_id())[0] ); ?> Articles</h3>
    </header>
    <div data-aos="fade-up" class="cta-blocks flex flex-wrap justify-center">
        <?php
        $args = array(
            'category__in' => wp_get_post_categories( get_queried_object_id() ),
            'posts_per_page' => 3,
            'orderby'       => 'rand',
            'post__not_in' => array( get_queried_object_id() )
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
            while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="cta theme__card--image">
                    <div class="cta-inner flex items-center flex-col justify-center">
                        <header>
                            <p class="mb-1 overline color-accent" data-aos="fade-up">
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
                            <h3 class="mb-1" data-aos="fade-up" data-aos-delay="100">
                                <?php the_title(); ?>
                            </h3>
                        </header>

                        <div class="cta-content" data-aos="fade-up" data-aos-delay="150">
                            <p><?php echo get_the_date(); ?></p>
                        </div>
                        <div class="buttons justify-center" data-aos="fade-up" data-aos-delay="200">
                            <span class="button icon no-margin">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                            </span>
                        </div>
                    </div>

                    <?php if(get_blog_listing() == "blog_1"): ?>
                        <?php echo img_sizes(get_post_thumbnail_id(), ['default' => 'img_800', 'lazy_load' => true]); ?>
                    <?php else: ?>
                        <?php block_media( get_field('featured_image__video'), [
                            'img_sizes' => array('default' => 'img_800', 'page_area' => 100, 'mobile_page_area' => 100),
                            'dynamic' => false,
                            'aspect' => false
                        ]); ?>
                    <?php endif; ?>
                </a>
            <?php endwhile;
        endif; ?>
    </div>
</section>
<?php } ?>

<?php endwhile;

get_footer();