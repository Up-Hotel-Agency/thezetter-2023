<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'designmynightbooking',
    'title'             => __('Design My Night - Booking'),
    'description'       => __('Design My Night - Booking'),
    'render_callback'   => 'design_my_night_booking_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'forms', // dashicons, without the leading dashicons-
    'keywords'          => array( 'image, content' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/img_content/img_content.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/img_content/img_content.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function design_my_night_booking_render_callback( $block, $content = '', $is_preview = false ) {


    //This block accepts posts requests from Design My Night (Booking confirmed redirect)
    $booking_data = false;
    if(isset($_POST['booking'])):

        $booking_data   = json_decode(stripslashes($_POST['booking']), true) ?? false;

        $venue_id       = isset($booking_data['venue_id']) ? $booking_data['venue_id'] : false;
        $first_name     = isset($booking_data['first_name']) ? $booking_data['first_name'] : false;
        $last_name      = isset($booking_data['last_name']) ? $booking_data['last_name'] : false;
        $num_people     = isset($booking_data['num_people']) ? $booking_data['num_people'] : false;
        $date           = isset($booking_data['date']) ? $booking_data['date'] : false;
        $time           = isset($booking_data['time']) ? $booking_data['time'] : false;
        $reference      = isset($booking_data['reference']) ? $booking_data['reference'] : false;
        $booking_type   = isset($booking_data['type']) ? $booking_data['type'] : false;
        $notes          = isset($booking_data['notes']) ? $booking_data['notes'] : false;


        ?>
        <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(<?php echo wp_json_encode(array("design_my_night_data" => $booking_data)); ?>);
        </script>
        <?php 

        $venue_name     = false;
        $venue_img_id   = false;

        switch_to_blog(1);
        $venues_data = get_field('design_my_night_venues', 'options') ?? array();
        foreach($venues_data as $venue):
            if(isset($venue['venue_id'])):
                if($venue['venue_id'] == $venue_id):
                    $venue_name     = isset($venue['venue_name']) ? $venue['venue_name'] : false;
                    $venue_img_id   = isset($venue['venue_img_id']) ? $venue['venue_img_id'] : false;
                    break; 
                endif;
            endif;
        endforeach;
        restore_current_blog();


    endif;


    extract(set_theme_override_values());
    // the img-content-row class below is for vogue
    ?>
    <?php if($booking_data): ?>
        <section
        class="row spacing layout-image-text container img-content-row <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
        id="<?php if( array_key_exists('anchor', $block) && !empty($block['anchor'])): echo esc_attr($block['anchor']); else: echo $block['id']; endif ?>"
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
            
            <div class="img-content <?php the_field('layout'); ?><?php if( get_field('images_bottom_mob') ): ?> mob-img-bottom<?php endif; ?>">
                
                <?php if($venue_img_id): ?>
                    <?php switch_to_blog(1); ?>
                    <style>
                        .fixed-aspect img{
                            height:unset;
                            aspect-ratio: 1/1;
                        }
                    </style>
                    <div class="img fixed-aspect" data-aos="fade-up">
                        <?php 
                            echo img_sizes($venue_img_id, ['default' => 'img_1920', 'lazy_load' => true]);
                        ?>
                    </div>
                    <?php restore_current_blog(); ?>
                <?php endif; ?>

                <div class="content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                    <div class="content-inner mobile-left">
                        <header>
                            <h2 class="font-bold" data-aos="fade-up"  data-aos-delay="100">Thank you for your booking <?php echo $first_name; ?>
                                <div class="subtitle-2" data-aos="fade-up" data-aos-delay="150">
                                    <?php if($venue_name): ?>
                                        Your booking at <?php echo $venue_name; ?> is confirmed. You will receive confirmation by email shortly.
                                    <?php else: ?>
                                        Your booking is confirmed. You will receive confirmation by email shortly.
                                    <?php endif; ?>
                                </div>
                            </h2>
                        </header>

                        <article class="content-wrap mb-4 <?php if(get_field('overide_font')): the_field('content_text_font'); endif ?> <?php if(get_field('content_text_size_small')): ?> content-text-small <?php endif; ?>" data-aos="fade-up" data-aos-delay="150"<?php if( get_field('hide_content_on_mobile') ): ?> class="hide-mobile"<?php endif; ?>>
                            <p style="display:flex; flex-direction:column;">

                                <?php if($first_name && $date && $time && $num_people): ?>
                                    <span>
                                        <?php echo $first_name; ?> <?php echo $last_name; ?><br>
                                        <?php echo $num_people; ?> <?php if($num_people === 1): ?> person <?php else: ?> people <?php endif; ?>
                                        on <?php echo $date; ?> at <?php echo $time; ?>
                                    </span>
                                    <br>
                                <?php endif; ?>

                                <?php if($reference): ?>
                                    <span>
                                        <b>Reference code:</b> <?php echo $reference; ?>
                                    </span>
                                <?php endif; ?>
                                <?php if($booking_type && is_array($booking_type)): ?>
                                    <?php if(isset($booking_type[0]['name'])): ?>
                                        <span>
                                            <b>Booking type:</b> <?php echo $booking_type[0]['name']; ?></b> 
                                        </span>
                                    <?php endif ?>
                                <?php endif; ?>
                                <?php if($time): ?>
                                    <span>
                                        <b>Time:</b> <?php echo $time; ?>
                                    </span>
                                <?php endif; ?>
                                <?php if($notes): ?>
                                    <span>
                                        <b>Special Requests:</b> <?php echo $notes; ?>
                                    </span>
                                <?php endif; ?>
                            </p>
                        </article>
                     
                        <div class="buttons no-margin aos-init aos-animate" data-aos="fade-up" data-aos-delay="150">
                            <a class="button secondary " href="<?php echo get_home_url(); ?>">Learn More Here</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <?php 
            if(is_user_logged_in()):
                echo "<section class='container row'>";
                echo "<h2>Admin only message: This block requires a booking confirmation post request</h2>";
                echo "</section>"; 
            else:
                //In case of direct access without post request 
                //wp_safe_redirect(home_url('/'));
                //exit;
            endif; 
        ?>
    <?php endif; ?> 
    <?php
}