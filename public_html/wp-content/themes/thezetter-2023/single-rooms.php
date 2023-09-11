<?php
get_header();

while ( have_posts() ) : the_post(); ?>

    <div class="single-modal forced">
        <a href="javascript: history.go(-1)" class="modal-close overline flex justify-center items-center">
            <div class="close color-body">Close</div>
        </a>
        <div class="single-modal-inner">
            <div class="modal-images">
                <?php block_media( get_field('room_media'), [
                    'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                    'video_autoplay' => true,
                    'allow_aspect' => false,
                    'slick_dots' => true
                ]); ?>
            </div>
            <div class="modal-content">
                <div class="modal-content-inner">
                    <h2>
                        <?php if( get_field('title') ): ?>
                            <?php the_field('title'); ?>
                        <?php else: ?>
                            <?php the_title(); ?>
                        <?php endif; ?>
                        <?php if( get_field('price_tag') ): ?>
                            <div class="mt-2 subtitle-2">
                                <?php the_field('price_tag'); ?>
                            </div>
                        <?php endif; ?>
                    </h2>
                    <?php if( get_field('content') ): ?>
                        <div class="modal-content-block modal-content-block--line size-m mb-12">
                            <p><?php the_field('content', false, false); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if( have_rows('features') ): ?>
                        <div class="modal-content-block mb-8">
                        <?php while ( have_rows('features') ) : the_row(); ?>
                            <?php if(get_sub_field('title')): ?>
                                <p class="feature-title size-m mt-4"><?php the_sub_field('title'); ?></p>
                            <?php endif; ?>
                            <div class="featured-list-full flex flex-col mb-0">
                                <?php while ( have_rows('list_features') ) : the_row(); ?>
                                    <div class="list-content">
                                        <?php if( get_sub_field('feature') ): ?><div class="button-text mb-2"><?php the_sub_field('feature'); ?></div><?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(get_field('additional_booking_information')): ?>
                        <div class="modal-content-block mb-4">
                            <?php the_field('additional_booking_information', false, false); ?>
                        </div>
                    <?php endif; ?>
                    <?php if( get_field('link_field') ): ?>
                        <div class="buttons mb-10">
                            <?php block_buttons(get_field('link_field'), [
                                'class' => 'button',
                                'type'  => 'primary'
                            ]); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


<?php 
endwhile;

get_footer();