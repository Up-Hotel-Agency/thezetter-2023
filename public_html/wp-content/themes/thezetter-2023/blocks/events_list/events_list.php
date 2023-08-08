<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'eventslist',
    'title'             => __('Events List'),
    'description'       => __('Events List'),
    'render_callback'   => 'events_list_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'calendar-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'event', 'events' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_script( 'atc-js', get_template_directory_uri() . '/assets/js/atc.min.js' );
        wp_enqueue_style( 'block-acf-events-list', get_template_directory_uri() . '/assets/css/events_list/events_list.css' );
        wp_enqueue_style( 'block-acf-image-content-block', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
    }
));
function events_list_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container events-list<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
    id="<?php if( array_key_exists('anchor', $block) && !empty($block['anchor'])): echo esc_attr($block['anchor']); else: echo $block['id']; endif ?>"
    data-aos="fade-up"
    <?php if( get_field('override_page_theme') && $theme == 'custom' ): ?>
    style="
        <?php if( $custom_text ): ?>--color-body: <?php echo $custom_text; ?>;<?php endif; ?>
        <?php if( $custom_bg ): ?>--color-background: <?php echo $custom_bg; ?>;<?php endif; ?>
        <?php if( $custom_bg_alt ): ?>--color-background-alt: <?php echo $custom_bg_alt; ?>;<?php endif; ?>
        <?php if( $custom_accent ): ?>--color-accent-primary: <?php echo $custom_accent; ?>;<?php endif; ?>
        <?php if( $custom_accent_reverse ): ?>--color-accent-reverse: <?php echo $custom_accent_reverse; ?>;<?php endif; ?>
        "
    <?php endif; ?>
    >
        <?php block_background_media(); ?>
        
        <?php
        $today = date('Ymd');
        $event_args = array(
            'posts_per_page' => -1,
            'post_type' => 'events',
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
        $event_query = new WP_Query($event_args);

        if ( $event_query->have_posts() ) :
            $firstEvent = 1;
            while ( $event_query->have_posts() ) : $event_query->the_post(); $event = get_the_ID(); 
                if( $firstEvent == '1'):
                ?>
                    <div class="img-content mb-24">
                        <div class="img" data-aos="fade-up">
                            <?php block_media( get_field('event_media', $event), [
                                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                                'slick_dots' => true,
                                'default_aspect' => '4/5'
                            ]); ?>
                        </div>

                        <div class="content xs:text-left">
                            <div class="content-inner">
                                <header>
                                    <p class="mb-1 overline color-accent" data-aos="fade-up">
                                        Next Event
                                    </p>

                                    <h2 class="mb-8" data-aos="fade-up"><?php the_title(); ?></h2>
                                </header>

                                <div class="flex flex-wrap single-event-details mb-4">
                                    <?php if( get_field('date', $event) ): ?>
                                        <p class="flex items-center">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3.893" y="5.001" width="16.213" height="15.167" rx=".5" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.906 8.561L20.107 8.561"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.845 3.831L16.845 6.07"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.431 3.831L7.431 6.07"/><circle cx="12.047" cy="11.404" r="1" fill="currentColor"/><circle cx="16.047" cy="11.404" r="1" fill="currentColor"/><circle cx="12.047" cy="14.404" r="1" fill="currentColor"/><circle cx="16.047" cy="14.404" r="1" fill="currentColor"/><circle cx="12.047" cy="17.404" r="1" fill="currentColor"/><circle cx="16.047" cy="17.404" r="1" fill="currentColor"/><circle cx="8.047" cy="14.404" r="1" fill="currentColor"/><circle cx="8.047" cy="17.404" r="1" fill="currentColor"/></svg>
                                            <?php echo date_format( date_create(get_field('date', $event)), "D jS F"); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if( get_field('time', $event) ): ?>
                                        <p class="flex items-center">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L12 6"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L15.119 15.119"/></svg>
                                            <?php the_field('time', $event); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if( get_field('location', $event) ): ?>
                                        <p class="flex items-center">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.774 9.429c0 3.223-5.026 9.94-6.42 11.741a.446.446 0 0 1-.708 0c-1.394-1.8-6.42-8.518-6.42-11.741a6.774 6.774 0 0 1 13.548 0z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><circle cx="12" cy="8.655" r="1.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                            <?php the_field('location', $event); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if( get_field('cost', $event) ): ?>
                                        <p class="flex items-center">
                                            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M8.59 17.359c0-1.212 1.517-1.346 1.517-1.346M15 8.949c.059-2.331-4.159-3.479-5.274-.6-.892 2.3 1.224 5.018.381 7.666a5.863 5.863 0 0 1 1.907.673 3.11 3.11 0 0 0 1.884.429 1.845 1.845 0 0 0 1.593-1.817" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.59 12.08L13.578 12.08"/></svg>
                                            <?php the_field('cost', $event); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <article class="content-wrap mb-4" data-aos="fade-up" data-aos-delay="150"<?php if( get_field('hide_content_on_mobile') ): ?> class="hide-mobile"<?php endif; ?>>
                                    <?php the_field('intro_content', $event); ?>
                                </article>
                                
                                <div class="flex items-center events-actions xs:flex-wrap">
                                    <a class="button primary no-margin js-single-modal-trigger-ajax"  data-type="event" data-id="<?php echo $event; ?>"  data-modal="modal-<?php echo $event; ?>" href="#">
                                        Learn More
                                    </a>
                                    <div title="Add to Calendar" class="addeventatc" data-google-api="false" data-styling="none">
                                        <div class="atc-button flex items-center">
                                            Add to Calendar
                                        </div>
                                        <span class="start"><?php echo date_format( date_create(get_field('date', $event)), "d-m-Y"); ?></span>
                                        <span class="all_day_event">true</span>
                                        <span class="timezone">Europe/London</span>
                                        <span class="title"><?php echo get_the_title($event); ?></span>
                                        <span class="description"><?php the_field('subtitle', $event); ?></span>
                                        <span class="location">London, UK</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            $firstEvent++; endwhile;
            wp_reset_query();
        endif; ?>


        <?php $event_posts = $event_query->get_posts();
        $event_months = array();

        foreach ($event_posts as $event_post) {
            $meta_value = get_post_meta($event_post->ID, 'date', true);
            if (!$meta_value) {
                continue;
            }
            $date = date('Ym', strtotime($meta_value));
            $event_months[$date][] = $event_post;
        }
        foreach ($event_months as $post_date => $event_posts): ?>
            <div class="event-divider mb-12">
                <h4><?php echo date_format( date_create($post_date . '01'), "F Y"); ?></h2>
            </div>

            <div class="events-grid flex flex-wrap mb-12 xs:mb-6">
                <?php foreach ($event_posts as $event_post): ?>
                    <div class="event-block flex mb-12 xs:mb-8">
                        <?php if( has_post_thumbnail( $event_post->ID ) ): ?>
                            <a href="#" class="event-img-outer js-single-modal-trigger" data-modal="modal-<?php echo $event_post->ID; ?>">
                                <div class="event-img img-abs">
                                    <?php block_media( get_field('event_media', $event_post->ID), [
                                        'img_sizes' => array('default' => 'img_800', 'page_area' => 40, 'mobile_page_area' => 100),
                                        'slick_dots' => false,
                                        'allow_aspect' => false,
                                        'video_autoplay' => true,
                                        'dynamic_mobile' => false
                                    ]); ?>
                                </div>
                            </a>
                        <?php endif; ?>
                        <div class="event-content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                            <a href="#" class="js-single-modal-trigger-ajax"  data-type="event" data-id="<?php echo $event_post->ID; ?>"  data-modal="modal-<?php echo $event_post->ID; ?>">
                                <h4>
                                    <?php echo get_the_title($event_post->ID); ?>
                                </h4>
                            </a>
                            <?php if( get_field('date', $event_post->ID) ): ?>
                                <p class="flex items-center size-s">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3.893" y="5.001" width="16.213" height="15.167" rx=".5" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.906 8.561L20.107 8.561"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.845 3.831L16.845 6.07"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.431 3.831L7.431 6.07"/><circle cx="12.047" cy="11.404" r="1" fill="currentColor"/><circle cx="16.047" cy="11.404" r="1" fill="currentColor"/><circle cx="12.047" cy="14.404" r="1" fill="currentColor"/><circle cx="16.047" cy="14.404" r="1" fill="currentColor"/><circle cx="12.047" cy="17.404" r="1" fill="currentColor"/><circle cx="16.047" cy="17.404" r="1" fill="currentColor"/><circle cx="8.047" cy="14.404" r="1" fill="currentColor"/><circle cx="8.047" cy="17.404" r="1" fill="currentColor"/></svg>
                                    <?php echo date_format( date_create(get_field('date', $event_post->ID)), "D jS F"); ?>
                                </p>
                            <?php endif; ?>
                            <?php if( get_field('time', $event_post->ID) ): ?>
                                <p class="flex items-center size-s">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L12 6"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L15.119 15.119"/></svg>
                                    <?php the_field('time', $event_post->ID); ?>
                                </p>
                            <?php endif; ?>
                            <?php if( get_field('location', $event_post->ID) ): ?>
                                <p class="flex items-center size-s">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.774 9.429c0 3.223-5.026 9.94-6.42 11.741a.446.446 0 0 1-.708 0c-1.394-1.8-6.42-8.518-6.42-11.741a6.774 6.774 0 0 1 13.548 0z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><circle cx="12" cy="8.655" r="1.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                    <?php the_field('location', $event_post->ID); ?>
                                </p>
                            <?php endif; ?>
                            <?php if( get_field('cost', $event_post->ID) ): ?>
                                <p class="flex items-center size-s">
                                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M8.59 17.359c0-1.212 1.517-1.346 1.517-1.346M15 8.949c.059-2.331-4.159-3.479-5.274-.6-.892 2.3 1.224 5.018.381 7.666a5.863 5.863 0 0 1 1.907.673 3.11 3.11 0 0 0 1.884.429 1.845 1.845 0 0 0 1.593-1.817" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.59 12.08L13.578 12.08"/></svg>
                                    <?php the_field('cost', $event_post->ID); ?>
                                </p>
                            <?php endif; ?>
                            <div class="buttons">
                                <a
                                href="#"
                                data-type="event"
                                data-id="<?php echo $event_post->ID; ?>"
                                class="js-single-modal-trigger-ajax button minor stripped icon-right no-margin"
                                data-modal="modal-<?php echo $event_post->ID; ?>"
                                >
                                    Learn More
                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.158 6.315L14.842 12 9.158 17.685"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <?php wp_reset_query(); ?>
    </section>
    <?php
}

//Modal for ajax request 

function ajax_load_modal_events() {
    if ( isset($_REQUEST) ):
       
    if ( isset($_REQUEST['id'])){
        $post_id = $_REQUEST['id'];
    }else{
        return;
    }

    //Modal content 
    ?>
       <div class="single-modal-inner">
            <div class="modal-images theme--image">
                <?php block_media( get_field('event_media', $post_id), [
                        'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                        'video_autoplay' => true,
                        'allow_aspect' => false, 
                        'ajax' => true,
                ]); ?>
            </div>
            <div class="modal-content">
                <div class="modal-content-inner">
                    <?php if( get_field('overline', $post_id) ): ?>
                        <p class="mb-1 overline color-accent">
                            <?php the_field('overline', $post_id); ?>
                        </p>
                    <?php endif; ?>
                    <h2 class="h1">
                        <?php if( get_field('title', $post_id) ): ?>
                            <?php the_field('title', $post_id); ?>
                        <?php else: ?>
                            <?php echo get_the_title( $post_id ); ?>
                        <?php endif; ?>
                        <?php if( get_field('subtitle', $post_id) ): ?>
                            <span class="subtitle">
                                <?php the_field('subtitle', $post_id); ?>
                            </span>
                        <?php endif; ?>
                    </h2>
                    <div class="flex items-center events-actions mb-8 xs:flex-wrap">
                        <?php block_buttons(get_field('link_field', $post_id), [
                            'class' => 'button primary no-margin '
                        ]); ?>
                        <div title="Add to Calendar" class="addeventatc" data-google-api="false" data-styling="none">
                            <div class="atc-button flex items-center">
                                Add to Calendar
                            </div>
                            <span class="start"><?php echo date_format( date_create(get_field('date', $post_id)), "d-m-Y"); ?></span>
                            <span class="all_day_event">true</span>
                            <span class="timezone">Europe/London</span>
                            <span class="title"><?php echo get_the_title($post_id); ?></span>
                            <span class="description"><?php the_field('subtitle', $post_id); ?></span>
                            <span class="location">London, UK</span>
                        </div>
                    </div>
                    <div class="post-share flex items-center mb-8">
                        <strong>Share</strong>
                        <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo get_the_permalink($post_id); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>facebook</title><path class="facebook" d="M34.107,3.567a45.739,45.739,0,0,0-5.334-.281c-5.288,0-8.914,3.228-8.914,9.148v5.1H13.893v6.925h5.966V42.216h7.159V24.459H32.96l.913-6.925H27.018V13.112c0-1.989.538-3.369,3.416-3.369h3.673Z" fill="currentColor"/></svg>
                        </a>
                        <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('http://twitter.com/share?url=<?php echo get_the_permalink(); ?>&text=<?php echo urlencode(get_the_title($post_id)); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');return false;" title="Share on Twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>twitter</title><path class="twitter" d="M43.457,13.233a15.624,15.624,0,0,1-4.485,1.206A7.763,7.763,0,0,0,42.4,10.147a15.348,15.348,0,0,1-4.943,1.881,7.8,7.8,0,0,0-13.478,5.329,8.765,8.765,0,0,0,.193,1.784,22.14,22.14,0,0,1-16.059-8.15A7.8,7.8,0,0,0,10.52,21.407,7.849,7.849,0,0,1,7,20.419v.1a7.789,7.789,0,0,0,6.245,7.644,8.269,8.269,0,0,1-2.05.265,9.718,9.718,0,0,1-1.47-.121,7.8,7.8,0,0,0,7.281,5.4,15.6,15.6,0,0,1-9.668,3.328,15.963,15.963,0,0,1-1.881-.1,22,22,0,0,0,11.959,3.5c14.323,0,22.159-11.862,22.159-22.158,0-.338,0-.675-.024-1.013A16.728,16.728,0,0,0,43.457,13.233Z" fill="currentColor"/></svg>
                        </a>
                        <a class="button icon secondary no-margin size-s" href="#" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink($post_id); ?>', 'sharer', 'toolbar=0,status=0,width=626,height=436');;return false;" title="Share on LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>linkedin</title><g class="linkedin"><rect x="7.435" y="17.44" width="7.298" height="21.916" fill="currentColor"/><path d="M15.2,10.673a3.763,3.763,0,0,0-4.069-3.782,3.8,3.8,0,0,0-4.114,3.782,3.762,3.762,0,0,0,4.025,3.781h.045A3.777,3.777,0,0,0,15.2,10.673Z" fill="currentColor"/><path d="M40.985,26.8c0-6.723-3.583-9.864-8.382-9.864a7.222,7.222,0,0,0-6.613,3.694h.045V17.44H18.759s.088,2.057,0,21.916h7.276V27.127a5.489,5.489,0,0,1,.243-1.792,3.988,3.988,0,0,1,3.737-2.654c2.632,0,3.694,2.013,3.694,4.954V39.356h7.276Z" fill="currentColor"/></g></svg>
                        </a>
                    </div>
                    <div class="flex flex-wrap single-event-details mb-10">
                        <?php if( get_field('date', $post_id) ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3.893" y="5.001" width="16.213" height="15.167" rx=".5" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.906 8.561L20.107 8.561"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.845 3.831L16.845 6.07"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.431 3.831L7.431 6.07"/><circle cx="12.047" cy="11.404" r="1" fill="currentColor"/><circle cx="16.047" cy="11.404" r="1" fill="currentColor"/><circle cx="12.047" cy="14.404" r="1" fill="currentColor"/><circle cx="16.047" cy="14.404" r="1" fill="currentColor"/><circle cx="12.047" cy="17.404" r="1" fill="currentColor"/><circle cx="16.047" cy="17.404" r="1" fill="currentColor"/><circle cx="8.047" cy="14.404" r="1" fill="currentColor"/><circle cx="8.047" cy="17.404" r="1" fill="currentColor"/></svg>
                                <?php echo date_format( date_create(get_field('date', $post_id)), "D jS F"); ?>
                            </p>
                        <?php endif; ?>
                        <?php if( get_field('time', $post_id) ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L12 6"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12L15.119 15.119"/></svg>
                                <?php the_field('time', $post_id); ?>
                            </p>
                        <?php endif; ?>
                        <?php if( get_field('location', $post_id) ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.774 9.429c0 3.223-5.026 9.94-6.42 11.741a.446.446 0 0 1-.708 0c-1.394-1.8-6.42-8.518-6.42-11.741a6.774 6.774 0 0 1 13.548 0z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><circle cx="12" cy="8.655" r="1.75" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                                <?php the_field('location', $post_id); ?>
                            </p>
                        <?php endif; ?>
                        <?php if( get_field('cost', $post_id) ): ?>
                            <p class="flex items-center">
                                <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M8.59 17.359c0-1.212 1.517-1.346 1.517-1.346M15 8.949c.059-2.331-4.159-3.479-5.274-.6-.892 2.3 1.224 5.018.381 7.666a5.863 5.863 0 0 1 1.907.673 3.11 3.11 0 0 0 1.884.429 1.845 1.845 0 0 0 1.593-1.817" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.59 12.08L13.578 12.08"/></svg>
                                <?php the_field('cost', $post_id); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php the_field('intro_content', $post_id); ?>
                </div>
            </div>
        </div>


    <?php

    endif;
    die();
}
add_action( 'wp_ajax_get_event_modal', 'ajax_load_modal_events' );
add_action( 'wp_ajax_nopriv_get_event_modal', 'ajax_load_modal_events' );

