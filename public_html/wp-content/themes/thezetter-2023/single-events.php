<?php
get_header();

while ( have_posts() ) : the_post();
if( get_event_single_type() == 'event_1' ) { 

    //Enqueue CTA Blocks styling
    wp_enqueue_style( 'block-acf-cta-blocks', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
    ?>


    <main class="page-container">

        <section
        class="row container banner-block flex justify-center items-center<?php if( has_post_thumbnail() ): ?> theme--image<?php endif; ?>"
        >
            <?php if( has_post_thumbnail() ): ?>
            <div class="block-bg-img<?php if( $themeField['disable_overlay'] ): ?> no-overlay<?php endif; ?>">
                <?php echo img_sizes(get_post_thumbnail_id(), ['default' => 'img_1920', 'lazy_load' => true]); ?>
            </div>
            <?php endif; ?>
            <div class="banner-content-block">
                <?php if( get_field('events_page', 'options') ): ?>
                    <a class="button icon-left back no-margin-right minor mb-3" href="<?php echo get_the_permalink( get_field('events_page', 'options') ); ?>">
                        <svg width="27" height="27" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-left</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                        Back to What's On
                    </a>
                <?php endif; ?>
                <?php if( get_field('date') ): ?>
                    <p class="mb-2 overline color-accent">
                        <?php echo date_format( date_create(get_field('date')), "l jS F"); ?>
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
            <div class="bordered flex items-center justify-between xs:justify-start xs:flex-col xs:items-start">
                <div title="Add to Calendar" class="addeventatc" data-google-api="false" data-styling="none">
                    <div class="atc-button flex items-center">
                        Add to Calendar
                    </div>
                    <span class="start"><?php echo date_format( date_create(get_field('date')), "d-m-Y"); ?></span>
                    <span class="all_day_event">true</span>
                    <span class="timezone">Europe/London</span>
                    <span class="title"><?php the_title(); ?></span>
                    <span class="description"><?php the_field('subtitle'); ?></span>
                    <span class="location">London, UK</span>
                </div>
                <div class="post-share flex items-center">
                    <strong>Share This Event</strong>
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

        <header
        class="post-details event-details container flex justify-between items-center xs:flex-col xs:items-start
        <?php if( get_field('intro_content') ): ?>
            has-excerpt
        <?php endif; ?>
        ">
            <div class="post-info">
                <?php if( get_field('date') ): ?><p><strong>Date</strong> <?php echo date_format( date_create(get_field('date')), "D jS F"); ?></p><?php endif; ?>
                <?php if( get_field('time') ): ?><p><strong>Time</strong> <?php the_field('time'); ?></p><?php endif; ?>
                <?php if( get_field('location') ): ?><p><strong>Location</strong> <?php the_field('location'); ?></p><?php endif; ?>
                <?php if( get_field('cost') ): ?><p><strong>Cost</strong> <?php the_field('cost'); ?></p><?php endif; ?>
            </div>
            <?php if( get_field('intro_content') ): ?>
            <div class="post-excerpt intro-content">
                <?php the_field('intro_content'); ?>
            </div>
            <?php endif; ?>
        </header>

        <?php the_content(); ?>

        <section class="container row more-articles">
            <header data-aos="fade-up" class="text-center">
                <p class="mb-1 overline color-accent" data-aos="fade-up">
                    Keep Exploring
                </p>
                <h3 class="mb-10">More Upcoming Events</h3>
            </header>
            <div data-aos="fade-up" class="cta-blocks flex flex-wrap justify-center">
                <?php
                $currentID = get_the_ID();
                $today = date('Ymd');
                $args = array(
                    'posts_per_page' => 3,
                    'post_type' => 'events',
                    'post__not_in' => array($currentID),
                    'meta_key'  => 'date',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                    'meta_query' => array(
                    array(
                            'key'		=> 'date',
                            'compare'	=> '>',
                            'value'		=> $today,
                        )
                    )
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="cta theme__card--image">
                            <div class="cta-inner flex items-center flex-col justify-center">
                                <header>
                                    <?php if( get_field('date') ): ?>
                                        <p class="mb-1 overline color-accent">
                                            <?php echo date_format( date_create(get_field('date')), "l jS F"); ?>
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
                            <?php if( has_post_thumbnail() ): echo img_sizes(get_post_thumbnail_id(), ['default' => 'img_800', 'lazy_load' => true]); endif; ?>
                        </a>
                    <?php endwhile;
                endif; wp_reset_query(); ?>
            </div>
        </section>
    </main>

<?php }
if( get_event_single_type() == 'event_2' ) { ?>

    <div class="single-modal forced">
        <a href="<?php echo get_the_permalink( get_field('events_page', 'options') ); ?>" class="modal-close flex justify-center items-center">
            <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245L19.245 4.755"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.245 19.245L4.755 4.755"/></svg>
        </a>
        <div class="single-modal-inner">

            <div class="modal-images theme--image">
                <?php block_media( get_field('event_media'), [
                        'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                        'video_autoplay' => true,
                        'allow_aspect' => false 
                ]); ?>
            </div>

            <div class="modal-content">
                <div class="modal-content-inner">
                    <?php if( get_field('overline') ): ?>
                        <p class="mb-1 overline color-accent">
                            <?php the_field('overline'); ?>
                        </p>
                    <?php endif; ?>
                    <h2 class="h1">
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
                    </h2>
                    <div class="flex items-center events-actions mb-8 xs:flex-wrap">
                        <?php block_buttons(get_field('link_field'), [
                            'class' => 'button no-margin',
                            'type'  => 'primary'
                        ]); ?>
                        <div title="Add to Calendar" class="addeventatc" data-google-api="false" data-styling="none">
                            <div class="atc-button flex items-center">
                                Add to Calendar
                            </div>
                            <span class="start"><?php echo date_format( date_create(get_field('date')), "d-m-Y"); ?></span>
                            <span class="all_day_event">true</span>
                            <span class="timezone">Europe/London</span>
                            <span class="title"><?php the_title(); ?></span>
                            <span class="description"><?php the_field('subtitle'); ?></span>
                            <span class="location">London, UK</span>
                        </div>
                    </div>
                    <div class="post-share flex items-center mb-8">
                        <strong>Share</strong>
                        <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo get_the_permalink(); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>facebook</title><path class="facebook" d="M34.107,3.567a45.739,45.739,0,0,0-5.334-.281c-5.288,0-8.914,3.228-8.914,9.148v5.1H13.893v6.925h5.966V42.216h7.159V24.459H32.96l.913-6.925H27.018V13.112c0-1.989.538-3.369,3.416-3.369h3.673Z" fill="currentColor"/></svg>
                        </a>
                        <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://twitter.com/share?url=<?php echo get_the_permalink(); ?>&text=<?php echo urlencode(get_the_title()); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on Twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>twitter</title><path class="twitter" d="M43.457,13.233a15.624,15.624,0,0,1-4.485,1.206A7.763,7.763,0,0,0,42.4,10.147a15.348,15.348,0,0,1-4.943,1.881,7.8,7.8,0,0,0-13.478,5.329,8.765,8.765,0,0,0,.193,1.784,22.14,22.14,0,0,1-16.059-8.15A7.8,7.8,0,0,0,10.52,21.407,7.849,7.849,0,0,1,7,20.419v.1a7.789,7.789,0,0,0,6.245,7.644,8.269,8.269,0,0,1-2.05.265,9.718,9.718,0,0,1-1.47-.121,7.8,7.8,0,0,0,7.281,5.4,15.6,15.6,0,0,1-9.668,3.328,15.963,15.963,0,0,1-1.881-.1,22,22,0,0,0,11.959,3.5c14.323,0,22.159-11.862,22.159-22.158,0-.338,0-.675-.024-1.013A16.728,16.728,0,0,0,43.457,13.233Z" fill="currentColor"/></svg>
                        </a>
                        <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink(); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>linkedin</title><g class="linkedin"><rect x="7.435" y="17.44" width="7.298" height="21.916" fill="currentColor"/><path d="M15.2,10.673a3.763,3.763,0,0,0-4.069-3.782,3.8,3.8,0,0,0-4.114,3.782,3.762,3.762,0,0,0,4.025,3.781h.045A3.777,3.777,0,0,0,15.2,10.673Z" fill="currentColor"/><path d="M40.985,26.8c0-6.723-3.583-9.864-8.382-9.864a7.222,7.222,0,0,0-6.613,3.694h.045V17.44H18.759s.088,2.057,0,21.916h7.276V27.127a5.489,5.489,0,0,1,.243-1.792,3.988,3.988,0,0,1,3.737-2.654c2.632,0,3.694,2.013,3.694,4.954V39.356h7.276Z" fill="currentColor"/></g></svg>
                        </a>
                    </div>
                    <div class="flex flex-wrap single-event-details mb-10">
                        <?php if( get_field('date') ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3.893" y="5.001" width="16.213" height="15.167" rx=".5" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.906 8.561L20.107 8.561"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.845 3.831L16.845 6.07"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.431 3.831L7.431 6.07"/><circle cx="12.047" cy="11.404" r="1" fill="currentColor"/><circle cx="16.047" cy="11.404" r="1" fill="currentColor"/><circle cx="12.047" cy="14.404" r="1" fill="currentColor"/><circle cx="16.047" cy="14.404" r="1" fill="currentColor"/><circle cx="12.047" cy="17.404" r="1" fill="currentColor"/><circle cx="16.047" cy="17.404" r="1" fill="currentColor"/><circle cx="8.047" cy="14.404" r="1" fill="currentColor"/><circle cx="8.047" cy="17.404" r="1" fill="currentColor"/></svg>
                                <?php echo date_format( date_create(get_field('date')), "D jS F"); ?>
                            </p>
                        <?php endif; ?>
                        <?php if( get_field('time') ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L12 6"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L15.119 15.119"/></svg>
                                <?php the_field('time'); ?>
                            </p>
                        <?php endif; ?>
                        <?php if( get_field('location') ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.774 9.429c0 3.223-5.026 9.94-6.42 11.741a.446.446 0 0 1-.708 0c-1.394-1.8-6.42-8.518-6.42-11.741a6.774 6.774 0 0 1 13.548 0z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><circle cx="12" cy="8.655" r="1.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                <?php the_field('location'); ?>
                            </p>
                        <?php endif; ?>
                        <?php if( get_field('cost') ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M8.59 17.359c0-1.212 1.517-1.346 1.517-1.346M15 8.949c.059-2.331-4.159-3.479-5.274-.6-.892 2.3 1.224 5.018.381 7.666a5.863 5.863 0 0 1 1.907.673 3.11 3.11 0 0 0 1.884.429 1.845 1.845 0 0 0 1.593-1.817" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.59 12.08L13.578 12.08"/></svg>
                                <?php the_field('cost'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php the_field('intro_content'); ?>
                </div>
            </div>
        </div>
    </div>


<?php }

endwhile;

get_footer();