<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'eventsgrid',
    'title'             => __('Events Grid'),
    'description'       => __('Events Grid'),
    'render_callback'   => 'events_grid_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'calendar-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'event, events' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function events_grid_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        $event_posts = $event_query->get_posts();
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
                <section class="cta-blocks flex flex-wrap events-grid">
                    <div class="cta theme__card--standard xs:not-square no-hover events-month">
                        <div class="cta-inner flex items-center flex-col justify-center">
                            <h2 class="no-margin"><?php echo date_format( date_create($post_date . '01'), "F"); ?></h2>
                            <div class="cta-content">
                                <p><?php echo date_format( date_create($post_date . '01'), "Y"); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($event_posts as $event_post): ?>
                        <a href="<?php the_permalink( $event_post->ID ); ?>" class="cta theme__card--image">
                            <div class="cta-inner flex items-center flex-col justify-center">
                                <header>
                                    <p class="mb-1 overline color-accent">
                                        <?php echo date_format( date_create(get_field('date', $event_post->ID)), "l jS F"); ?>
                                    </p>
                                    <h3 class="mb-1">
                                        <?php echo get_the_title($event_post->ID); ?>
                                    </h3>
                                </header>

                                <?php if( get_field('subtitle', $event_post->ID) ): ?>
                                    <div class="cta-content">
                                        <p><?php the_field('subtitle', $event_post->ID); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="buttons justify-center">
                                    <span class="button secondary icon no-margin">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                                    </span>
                                </div>
                            </div>
                            <?php if( has_post_thumbnail( $event_post->ID ) ): echo img_sizes(get_post_thumbnail_id( $event_post->ID ), ['default' => 'img_800', 'lazy_load' => true]); endif; ?>
                        </a>
                    <?php endforeach; ?>
                </section>
            <?php endforeach; ?>
            <?php wp_reset_query(); ?>
    </section>
    <?php
}