<div class="row container">
    <div class="posts-grid flex flex-wrap js-post-ajax">
        <?php while ( have_posts() ) : the_post(); ?>

            <?php //Standard listing (Column content) ?>

            <div class="post-item mb-12 two xs:flex xs:items-center" data-aos="fade-up">
                <a href="<?php the_permalink(); ?>" class="post-item-img mb-6">
                    <?php block_media( get_field('featured_image__video'), [
                        'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                        'default_aspect' => '16/9',
                        'video_aspect' => '16/9',
                        'slick_dots' => false,
                        'dynamic_mobile' => false
                    ]); ?>
                </a>
                <div class="post-item-content">
                    <h4 class="mb-4" data-aos="fade-up" data-aos-delay="100"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <p class="mb-4 size-s" data-aos="fade-up" data-aos-delay="150">
                        <?php echo get_the_date(); ?>
                    </p>
                    <div class="buttons no-margin" data-aos="fade-up" data-aos-delay="200">
                        <a class="button secondary" href="<?php the_permalink(); ?>">
                            Read more
                        </a>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>