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
            <a class="button icon no-margin size-s" href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php the_permalink(); ?>&amp;&p[images][0]=<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 300,300 ), false, '' ); echo $src[0]; ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>facebook</title><path class="facebook" d="M34.107,3.567a45.739,45.739,0,0,0-5.334-.281c-5.288,0-8.914,3.228-8.914,9.148v5.1H13.893v6.925h5.966V42.216h7.159V24.459H32.96l.913-6.925H27.018V13.112c0-1.989.538-3.369,3.416-3.369h3.673Z" fill="currentColor"/></svg>
            </a>
            <a class="button icon no-margin size-s" href="#" onclick="window.open('http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on Twitter">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>twitter</title><path class="twitter" d="M43.457,13.233a15.624,15.624,0,0,1-4.485,1.206A7.763,7.763,0,0,0,42.4,10.147a15.348,15.348,0,0,1-4.943,1.881,7.8,7.8,0,0,0-13.478,5.329,8.765,8.765,0,0,0,.193,1.784,22.14,22.14,0,0,1-16.059-8.15A7.8,7.8,0,0,0,10.52,21.407,7.849,7.849,0,0,1,7,20.419v.1a7.789,7.789,0,0,0,6.245,7.644,8.269,8.269,0,0,1-2.05.265,9.718,9.718,0,0,1-1.47-.121,7.8,7.8,0,0,0,7.281,5.4,15.6,15.6,0,0,1-9.668,3.328,15.963,15.963,0,0,1-1.881-.1,22,22,0,0,0,11.959,3.5c14.323,0,22.159-11.862,22.159-22.158,0-.338,0-.675-.024-1.013A16.728,16.728,0,0,0,43.457,13.233Z" fill="currentColor"/></svg>
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