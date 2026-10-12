<section class="row container banner-block flex justify-center items-center<?php if( has_post_thumbnail() || get_field('featured_image__video') ): ?> theme--image<?php endif; ?>">
    <div class="block-bg-img">
        <?php if(get_blog_listing() == "blog_1"): ?>
            <?php echo img_sizes(get_post_thumbnail_id(), ['default' => 'img_1920', 'lazy_load' => true]); ?>
        <?php else: ?>
        <?php block_media( get_field('featured_image__video'), [
                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                'allow_aspect' => false, 
                'dynamic_mobile' => false,
                'video_autoplay' => true
            ]); ?>
        <?php endif; ?>
    </div>
    <div class="banner-content-block">
        <a class="button icon-left back no-margin" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">
            <svg width="27" height="27" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-left</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
            Back to Blog
        </a>
        <h1 class="mb-12" data-aos="fade-up">
            <?php the_title(); ?>
            <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                <?php the_date(); ?>
            </span>
        </h1>
    </div>
</section>

<header
class="post-details container flex justify-between items-center xs:flex-col xs:items-start
<?php if( get_field('excerpt') ): ?>
    has-excerpt
<?php endif; ?>
">
    <div class="post-info">
        <p><strong>Published</strong> <?php echo get_the_date(); ?></p>
        <p><strong>Category</strong> <?php
            $categories = get_the_category();
            $catOutput = '';
            if ($categories) {
                foreach ($categories as $category) {
                    $catOutput .= '<a href="' . get_category_link($category->term_id) . '" class="cat-link">' . $category->cat_name . '</a>';
                }
                echo trim($catOutput);
            }
        ?></p>
        <p><strong>Tags</strong> <?php
            $tags = get_the_tags();
            $tagOutput = '';
            if ($tags) {
                foreach ($tags as $tag) {
                    $tagOutput .= '<a href="' . get_tag_link($tag->term_id) . '" class="cat-link">' . $tag->name . '</a>';
                }
                echo trim($tagOutput);
            }
        ?></p>
        <div class="post-share flex items-center">
            <strong>Share</strong>
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
    <?php if( get_field('excerpt') ): ?>
    <div class="post-excerpt">
        <p class="size-l mb-0"><?php the_field('excerpt'); ?></p>
    </div>
    <?php endif; ?>
</header>