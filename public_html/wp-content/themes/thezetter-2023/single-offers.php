<?php
get_header();

while ( have_posts() ) : the_post();
if( get_offer_single_type() == 'offer_1' ) {
    
    //Enqueue CTA Blocks styling
    wp_enqueue_style( 'block-acf-cta-blocks', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
    ?>

    <main class="page-container">

        <section
        class="row container banner-block flex justify-center items-center<?php if( has_post_thumbnail() ): ?> theme--image<?php endif; ?>"
        >
            <?php if( has_post_thumbnail() ): ?>
            <div class="block-bg-img">
                <?php block_media( get_field('offers_media'), [
                    'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                    'dynamic_mobile' => false,
                    'video_autoplay' => true,
                    'allow_aspect' => false 
                ]); ?>
            </div>
            <?php endif; ?>
            <div class="banner-content-block">
                <?php if( get_field('offers_page', 'options') ): ?>
                    <a class="button icon-left back no-margin-right minor mb-3" href="<?php echo get_the_permalink( get_field('offers_page', 'options') ); ?>">
                        <svg width="27" height="27" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-left</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                        Back to Special Offers
                    </a>
                <?php endif; ?>
                <?php if( get_field('overline') ): ?>
                    <p class="mb-2 overline color-accent">
                        <?php the_field('overline'); ?>
                    </p>
                <?php endif; ?>
                <h1 class="mb-12">
                    <?php if( get_field('title') ): ?>
                        <?php the_field('title'); ?>
                    <?php else: ?>
                        <?php the_title(); ?>
                    <?php endif; ?>
                    <?php if( get_field('subtitle') ): ?>
                        <span class="subtitle">
                            <?php the_field('subtitle'); ?>
                        </span>
                    <?php endif; ?>
                </h1>
                <?php if( get_field('link_field') ): ?>
                    <div class="buttons centered no-margin">
                        <?php block_buttons(get_field('link_field'), [
                            'class' => 'button',
                            'type'  => 'primary'
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="container offer-share">
            <div class="bordered flex items-center justify-end xs:justify-start">
                <div class="post-share flex items-center">
                    <strong>Share This Offer</strong>
                    <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php the_permalink(); ?>&amp;&p[images][0]=<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 300,300 ), false, '' ); echo $src[0]; ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>facebook</title><path class="facebook" d="M34.107,3.567a45.739,45.739,0,0,0-5.334-.281c-5.288,0-8.914,3.228-8.914,9.148v5.1H13.893v6.925h5.966V42.216h7.159V24.459H32.96l.913-6.925H27.018V13.112c0-1.989.538-3.369,3.416-3.369h3.673Z" fill="currentColor"/></svg>
                    </a>
                    <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>twitter</title><path class="twitter" d="M43.457,13.233a15.624,15.624,0,0,1-4.485,1.206A7.763,7.763,0,0,0,42.4,10.147a15.348,15.348,0,0,1-4.943,1.881,7.8,7.8,0,0,0-13.478,5.329,8.765,8.765,0,0,0,.193,1.784,22.14,22.14,0,0,1-16.059-8.15A7.8,7.8,0,0,0,10.52,21.407,7.849,7.849,0,0,1,7,20.419v.1a7.789,7.789,0,0,0,6.245,7.644,8.269,8.269,0,0,1-2.05.265,9.718,9.718,0,0,1-1.47-.121,7.8,7.8,0,0,0,7.281,5.4,15.6,15.6,0,0,1-9.668,3.328,15.963,15.963,0,0,1-1.881-.1,22,22,0,0,0,11.959,3.5c14.323,0,22.159-11.862,22.159-22.158,0-.338,0-.675-.024-1.013A16.728,16.728,0,0,0,43.457,13.233Z" fill="currentColor"/></svg>
                    </a>
                    <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>linkedin</title><g class="linkedin"><rect x="7.435" y="17.44" width="7.298" height="21.916" fill="currentColor"/><path d="M15.2,10.673a3.763,3.763,0,0,0-4.069-3.782,3.8,3.8,0,0,0-4.114,3.782,3.762,3.762,0,0,0,4.025,3.781h.045A3.777,3.777,0,0,0,15.2,10.673Z" fill="currentColor"/><path d="M40.985,26.8c0-6.723-3.583-9.864-8.382-9.864a7.222,7.222,0,0,0-6.613,3.694h.045V17.44H18.759s.088,2.057,0,21.916h7.276V27.127a5.489,5.489,0,0,1,.243-1.792,3.988,3.988,0,0,1,3.737-2.654c2.632,0,3.694,2.013,3.694,4.954V39.356h7.276Z" fill="currentColor"/></g></svg>
                    </a>
                </div>
            </div>
        </section>

        <?php the_content(); ?>

        <section class="container row more-articles">
            <header data-aos="fade-up" class="text-center">
                <p class="mb-1 overline color-accent" data-aos="fade-up">
                    Keep Exploring
                </p>
                <h3 class="mb-10">More Special Offers</h3>
            </header>
            <div data-aos="fade-up" class="cta-blocks flex flex-wrap justify-center">
                <?php
                $currentID = get_the_ID();
                $args = array(
                    'posts_per_page' => 3,
                    'post_type' => 'offers',
                    'post__not_in' => array($currentID)
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="cta theme__card--image">
                            <div class="cta-inner flex items-center flex-col justify-center">
                                <header>
                                    <?php if( get_field('overline') ): ?>
                                        <p class="mb-1 overline color-accent" data-aos="fade-up">
                                            <?php the_field('overline'); ?>
                                        </p>
                                    <?php endif; ?>
                                    <h3 class="mb-1">
                                        <?php if( get_field('title') ): ?>
                                            <?php the_field('title'); ?>
                                        <?php else: ?>
                                            <?php the_title(); ?>
                                        <?php endif; ?>
                                    </h3>
                                </header>

                                <?php if( get_field('subtitle') ): ?>
                                    <div class="cta-content">
                                        <p><?php the_field('subtitle'); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="buttons justify-center">
                                    <span class="button secondary icon no-margin">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                                    </span>
                                </div>
                            </div>

                            <?php block_media( get_field('offers_media'), [
                                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                                'dynamic' => false,
                                'aspect' => false,
                            ]); ?>
                     
                        </a>
                    <?php endwhile;
                endif; wp_reset_query(); ?>
            </div>
        </section>
    </main>

<?php }
if( get_offer_single_type() == 'offer_2' ) { ?>

    <div class="single-modal forced">
        <a href="<?php echo get_the_permalink( get_field('offers_page', 'options') ); ?>" class="modal-close overline flex justify-center items-center">
            <div class="close">Close</div>
        </a>
        <div class="single-modal-inner">
            <div class="modal-images theme--image">
                <?php block_media( get_field('offers_media'), [
                    'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                    'video_autoplay' => true,
                    'allow_aspect' => false 
                ]); ?>
            </div>
            <div class="modal-content">
                <div class="modal-content-inner">
                    <h1 class="mb-6 h4" data-aos="fade-up">
                        Special Offer
                    </h1>
                    <h2 class="h2 regular-weight">
                        <?php if( get_field('title') ): ?>
                            <?php the_field('title'); ?>
                        <?php else: ?>
                            <?php the_title(); ?>
                        <?php endif; ?>
                    </h2>
                    <div class="flex offers-actions mb-6 xs:flex-wrap">

                        <div class="buttons no-margin">

                            <?php if( get_current_blog_id() == 1 ): // Zetter main ?>
                                <?php 
                                $terms = get_the_terms( $offer, 'hotel_categories' );
                                $taxonomies = get_object_taxonomies( $offer, 'hotel_categories' );
                                foreach ( $terms as $term ) {
                                    $promoCode = get_field('promocode', $offer);?>
                                    <?php if( $term->slug == 'clerkenwell' ): // Clerkenwell ?>
                                        <?php $hotelID = 'TZTC';?>
                                    <?php elseif( $term->slug == 'marrables' ): // Marrables ?>
                                        <?php $hotelID = 'TZHC';?>
                                    <?php elseif( $term->slug == 'marylebone' ): // Marylebone ?>
                                        <?php $hotelID = 'TZTM';?>
                                    <?php elseif( $term->slug == 'bloomsbury' ): // Bloomsbury ?>
                                        <?php $hotelID = '';?>
                                    <?php else: // Group ?>
                                        <?php $hotelID = '';?>
                                    <?php endif; ?>
                                    <a class="button secondary" href="https://thezetter.com/<?php echo $term->slug;?>/book/#/booking/results?propertyId=<?php echo $hotelID; ?>&promoCode=<?php echo $promoCode; ?>&" target="_blank" rel="noopener">
                                        Book <?php echo $term->name; ?>
                                    </a><?php 
                                }
                                ?>
                            <?php else: ?>
                                <?php $promoCode = get_field('promocode');?>
                                <?php if( get_current_blog_id() == 2 ): // Clerkenwell ?>
                                    <?php $hotelID = 'TZTC';?>
                                    <?php $hotel = 'clerkenwell';?>
                                    <?php $url = "https://thezetter.com/";?>
                                <?php elseif( get_current_blog_id() == 3 ): // Marrables ?>
                                    <?php $hotelID = 'TZHC';?>
                                    <?php $hotel = '';?>
                                    <?php $url = "https://marrableshotel.com/";?>
                                <?php elseif( get_current_blog_id() == 4 ): // Marylebone ?>
                                    <?php $hotelID = 'TZTM';?>
                                    <?php $hotel = 'marylebone';?>
                                    <?php $url = "https://thezetter.com/";?>
                                <?php elseif( get_current_blog_id() == 5 ): // Bloomsbury ?>
                                    <?php $hotelID = '';?>
                                    <?php $hotel = 'bloomsbury';?>
                                    <?php $url = "https://thezetter.com/";?>
                                <?php endif; ?>
                                <a class="button secondary" href="<?php echo $url;?><?php echo $hotel;?>/book/#/booking/results?propertyId=<?php echo $hotelID; ?>&promoCode=<?php echo $promoCode; ?>&" target="_blank" rel="noopener">
                                    Book now
                                </a>
                            <?php endif; ?>
                        </div>

                        <?php block_buttons(get_field('buttons'), [
                            'class' => 'no-margin',
                            'aos' => true, 
                            'aos_delay' => '150'
                        ]); ?>
                    </div>
                    <?php the_field('content_content'); ?>
                </div>
            </div>
        </div>
    </div>

<?php }

endwhile;

get_footer();