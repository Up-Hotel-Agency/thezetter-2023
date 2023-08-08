<?php
get_header();

while ( have_posts() ) : the_post();
if( get_room_single_type() == 'room_1' ) { ?>

    <main class="page-container">

        <section
        class="row container banner-block flex justify-center items-center<?php if( get_field('room_media') ): ?> theme--image<?php endif; ?>"
        >
            <?php if( get_field('room_media')  ): ?>
            <div class="block-bg-img ">
                <?php block_media( get_field('room_media'), [
                    'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                    'dynamic_mobile' => false,
                    'video_autoplay' => true,
                    'allow_aspect' => false 
                ]); ?>
            </div>
            <?php endif; ?>
            <div class="banner-content-block">
                <?php if( get_field('rooms_page', 'options') ): ?>
                    <a class="button icon-left back no-margin-right minor mb-3" href="<?php echo get_the_permalink( get_field('rooms_page', 'options') ); ?>">
                        <svg width="27" height="27" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-left</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                        Back to Rooms &amp; Suites
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
                    <?php if( get_field('price_tag') ): ?>
                        <span class="subtitle">
                            <?php the_field('price_tag'); ?>
                        </span>
                    <?php endif; ?>
                </h1>
                <?php if( get_field('link_field') ): ?>
                    <div class="buttons centered no-margin">
                        <?php block_buttons(get_field('link_field'), [
                            'class' => 'button',
                            'type'  => 'primary'
                        ]); ?>
                        <?php if( get_field('booking_telephone_number') ): ?>
                            <a class="button minor icon-left single-rooms-call-button" href="tel:<?php the_field( 'booking_telephone_number' ); ?>">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10.683 13.294A11.282 11.282 0 0 1 8.8 10.861a1.5 1.5 0 0 1 .24-1.814l.8-.8a1.5 1.5 0 0 0 0-2.121L7.728 4.005A1.5 1.5 0 0 0 5.61 4L4.439 5.175a2.955 2.955 0 0 0-.869 2.362 14.016 14.016 0 0 0 3.781 7.713 16.027 16.027 0 0 0 7.655 4.911 9.585 9.585 0 0 0 1.465.26 2.955 2.955 0 0 0 2.362-.869L20 18.381a1.5 1.5 0 0 0 0-2.118l-2.122-2.12a1.5 1.5 0 0 0-2.121 0l-.8.8a1.726 1.726 0 0 1-2.3-.042 13.357 13.357 0 0 1-1.974-1.607z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                or call <?php the_field( 'booking_telephone_number' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php the_content(); ?>

        <?php if( have_rows('more_rooms') ): ?>
            <section class="container row more-articles">
                <header data-aos="fade-up" class="text-center">
                    <?php if( get_field('more_rooms_overline') ): ?>
                        <p class="mb-1 overline color-accent" data-aos="fade-up">
                            <?php the_field('more_rooms_overline'); ?>
                        </p>
                    <?php endif; ?>
                    <h2 class="mb-10"><?php the_field('more_rooms_title'); ?></h2>
                </header>
                <div data-aos="fade-up" class="img-content-columns flex xs:flex-col">
                    <?php while ( have_rows('more_rooms') ) : the_row(); $room = get_sub_field('room'); ?>
                        <div class="img-content column">
                            <div class="img" data-aos="fade-up">
                                <?php block_media( get_field('room_media', $room), [
                                    'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                                    'default_aspect' => '1/1',
                                    'slick_dots' => false,
                                    'dynamic' => false,
                                    'allow_aspect' => false, 
                                ]); ?>
                            </div>

                            <div class="content">
                                <div class="content-inner">
                                    <header>
                                        <?php if( get_field('overline', $room) ): ?>
                                            <p class="mb-1 overline color-accent" data-aos="fade-up">
                                                <?php the_field('overline', $room); ?>
                                            </p>
                                        <?php endif; ?>

                                        <h2 data-aos="fade-up">
                                            <?php if( get_field('title', $room) ): ?>
                                                <?php the_field('title', $room); ?>
                                            <?php else: ?>
                                                <?php echo get_the_title( $room ); ?>
                                            <?php endif; ?>
                                            <?php if( get_field('price_tag', $room) ): ?>
                                                <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                                                    <?php the_field('price_tag', $room); ?>
                                                </span>
                                            <?php endif; ?>
                                        </h2>
                                    </header>

                                    <article class="content-wrap" data-aos="fade-up" data-aos-delay="150"<?php if( get_field('hide_content_on_mobile') ): ?> class="hide-mobile"<?php endif; ?>>
                                        <?php the_field('intro_content', $room); ?>
                                    </article>
                                    
                                    <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                                        <a class="button secondary" href="<?php echo get_the_permalink( $room ); ?>">
                                            Room Details
                                        </a>
                                        <?php block_buttons(get_field('link_field'), [
                                            'class' => 'button',
                                            'type'  => 'primary'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>
        <?php endif; ?>

    </main>

<?php }
if( get_room_single_type() == 'room_2' ) { ?>

    <div class="single-modal forced">
        <a href="<?php echo get_the_permalink( get_field('rooms_page', 'options') ); ?>" class="modal-close flex justify-center items-center">
            <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245L19.245 4.755"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.245 19.245L4.755 4.755"/></svg>
        </a>
        <?php if( get_field('link_field') ): ?>
            <?php block_buttons(get_field('link_field'), [
                'class' => 'modal-fixed-button button no-margin justify-center items-center',
                'type'  => 'primary'
            ]); ?>
        <?php endif; ?>
        <div class="single-modal-inner">
            <div class="modal-images theme--image">
                <?php block_media( get_field('room_media'), [
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
                    <h2>
                        <?php if( get_field('title') ): ?>
                            <?php the_field('title'); ?>
                        <?php else: ?>
                            <?php the_title(); ?>
                        <?php endif; ?>
                        <?php if( get_field('price_tag') ): ?>
                            <span class="subtitle">
                                <?php the_field('price_tag'); ?>
                            </span>
                        <?php endif; ?>
                    </h2>
                    <?php if( have_rows('features') ): ?>
                        <div class="featured-list half-items flex flex-wrap mb-8">
                            <?php $listCount = 1; while ( have_rows('features') ) : the_row(); ?>
                                <div class="featured-list-item flex items-center">
                                    <div class="list-counter flex items-center icons">
                                        <?php the_sub_field('autoloaded_icon'); ?>
                                    </div>
                                    <div class="list-content">
                                        <?php if( get_sub_field('title') ): ?><h5 class="mb-0"><?php the_sub_field('title'); ?></h5><?php endif; ?>
                                        <?php if( get_sub_field('subtitle') ): ?><p class="size-s mb-0"><?php the_sub_field('subtitle'); ?></p><?php endif; ?>
                                    </div>
                                </div>
                            <?php $listCount++; endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php if( get_field('link_field') ): ?>
                        <div class="buttons mb-10">
                            <?php block_buttons(get_field('link_field'), [
                                'class' => 'button',
                                'type'  => 'primary'
                            ]); ?>
                            <?php if( get_field('booking_telephone_number') ): ?>
                                <a class="button minor icon-left" href="tel:<?php the_field('booking_telephone_number', $room); ?>">    
                                    <svg class="xs:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10.683 13.294A11.282 11.282 0 0 1 8.8 10.861a1.5 1.5 0 0 1 .24-1.814l.8-.8a1.5 1.5 0 0 0 0-2.121L7.728 4.005A1.5 1.5 0 0 0 5.61 4L4.439 5.175a2.955 2.955 0 0 0-.869 2.362 14.016 14.016 0 0 0 3.781 7.713 16.027 16.027 0 0 0 7.655 4.911 9.585 9.585 0 0 0 1.465.26 2.955 2.955 0 0 0 2.362-.869L20 18.381a1.5 1.5 0 0 0 0-2.118l-2.122-2.12a1.5 1.5 0 0 0-2.121 0l-.8.8a1.726 1.726 0 0 1-2.3-.042 13.357 13.357 0 0 1-1.974-1.607z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                    or call <?php the_field('booking_telephone_number'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if( get_field('room_overview') ): ?>
                        <div class="modal-content-block mb-12">
                            <h4>Room Overview</h4>
                            <?php the_field('room_overview'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if( have_rows('amenities') ): ?>
                        <div class="modal-content-block mb-8">
                            <h4>Amenities</h4>
                            <div class="featured-list half-items flex flex-wrap mb-0">
                                <?php $listCount = 1; while ( have_rows('amenities') ) : the_row(); ?>
                                    <div class="featured-list-item xs-full">
                                        <div class="list-content">
                                            <?php if( get_sub_field('title') ): ?><h5 class="mb-0"><?php the_sub_field('title'); ?></h5><?php endif; ?>
                                            <?php if( get_sub_field('content') ): ?><p class="size-s mb-0"><?php the_sub_field('content'); ?></p><?php endif; ?>
                                        </div>
                                    </div>
                                <?php $listCount++; endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if( get_field('show_room_cta') ): ?>
                        <div class="modal-content-block mb-12">
                            <?php
                            $link = get_field('room_cta_link');
                            if( isLink( $link ) ):
                            ?>
                            <a href="<?php echo linkField( $link, 'url' ); ?>" class="cta<?php if( get_field('room_cta_image') ): ?> theme--image<?php else: ?> theme--standard<?php endif; ?>" <?php echo linkField( $link, 'target' ); ?>>
                            <?php else: ?>
                            <div class="cta<?php if( get_field('room_cta_image') ): ?> theme--image<?php else: ?> theme--standard<?php endif; ?>">
                            <?php endif; ?>
                                <div class="cta-inner flex items-center flex-col justify-center">
                                    <header>
                                        <?php if( get_field('room_cta_overline') ): ?>
                                            <p class="mb-1 overline color-accent">
                                                <?php the_field('room_cta_overline'); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if( get_field('room_cta_title') ): ?>
                                            <h3 class="mb-1">
                                                <?php the_field('room_cta_title'); ?>
                                            </h3>
                                        <?php endif; ?>
                                    </header>

                                    <?php if( get_field('room_cta_subheading') ): ?>
                                        <div class="cta-content">
                                            <p><?php the_field('room_cta_subheading'); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if( isLink( $link ) && linkField( $link, 'text' ) ): ?>
                                        <div class="buttons justify-center">
                                            <span class="button secondary no-margin">
                                                <?php echo linkField( $link, 'text' ); ?>
                                            </span>
                                        </div>
                                    <?php elseif( isLink( $link ) && !linkField( $link, 'text' ) ): ?>
                                        <div class="buttons justify-center">
                                            <span class="button secondary icon no-margin">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if( get_field('room_cta_image') ): echo img_sizes(get_field('room_cta_image'), ['default' => 'img_800', 'page_area' => '26', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
                            <?php if( isLink( $link ) ): ?>
                            </a>
                            <?php else: ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php }

endwhile;

get_footer();