<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'faqs',
    'title'             => __('FAQs'),
    'description'       => __('FAQs'),
    'render_callback'   => 'faqs_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'format-status', // dashicons, without the leading dashicons-
    'keywords'          => array( 'faqs', 'frequently asked questions' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_script( 'gumshoe-js', get_template_directory_uri() . '/assets/js/gumshoe.js' );
        wp_enqueue_script( 'block-acf-faqs', get_template_directory_uri() . '/assets/js/faqs/faqs.min.js' );
        wp_enqueue_script( 'block-acf-accordion', get_template_directory_uri() . '/assets/js/accordion/accordion.min.js' );
        wp_enqueue_style( 'block-acf-faqs', get_template_directory_uri() . '/assets/css/faqs/faqs.css' );
        wp_enqueue_style( 'block-acf-accordion', get_template_directory_uri() . '/assets/css/accordion/accordion.css' );
    }
));
function faqs_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row faqs cf<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="faqs-mob-header hidden sm:block container text-center<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <?php if( get_field('overline') ): ?>
                <p class="mb-2 overline color-accent" data-aos="fade-up">
                    <?php the_field('overline'); ?>
                </p>
            <?php endif; ?>
            <h1 class="mb-2" data-aos="fade-up"><?php the_field('title'); ?></h1>
            <p class="size-l mb-12" data-aos="fade-up"><?php the_field('top_content'); ?></p>
            <form action="" class="js-live-search faqs-search" method="post">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><line x1="20.39" y1="20.39" x2="12.91" y2="12.91" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><circle cx="9.059" cy="9.059" r="5.449" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></g></svg>
                <input type="text" placeholder="Search FAQs e.g. ‘check-in’" class="text-input js-filter-mob" value="" />
            </form>
            <div class="faqs-notification">
                <span class="results-for">
                    <strong>Search results for:</strong>
                    <span class="js-search-term"></span>
                </span>

                <span class="filter-count flex items-center">
                </span>
            </div>
            <a href="<?php echo get_the_permalink( get_field('get_in_touch_button_link') ); ?>" class="faqs-cta flex theme--accent items-center justify-between">
                <div class="flex-grow faqs-cta-content flex flex-col items-start justify-center">
                    <h5 class="mb-0"><?php the_field('get_in_touch_button_title'); ?></h5>
                    <p class="size-xs mb-0"><?php the_field('get_in_touch_button_subtitle'); ?></p>
                </div>

                <div class="button icon secondary no-margin">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><line x1="19.982" y1="12" x2="3.982" y2="12" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><polyline points="14.333 6.315 20.018 12 14.333 17.685" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></g></svg>
                </div>
            </a>
            <div class="in-page-nav-wrap">
                <div class="in-page-nav flex flex-wrap justify-center text-center">
                    <?php $count = 1; while ( have_rows('faq_groups') ) : the_row(); ?>
                        <a href="#group-<?php echo $count; ?>" class="scroll-to js-faq-nav"><?php the_sub_field('group_title'); ?></a>
                    <?php $count ++; endwhile; ?>
                </div>
            </div>
        </div>
        <div class="faqs-sidebar stick-in">
            <form action="" class="js-live-search faqs-search" method="post">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><line x1="20.39" y1="20.39" x2="12.91" y2="12.91" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><circle cx="9.059" cy="9.059" r="5.449" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></g></svg>
                <input type="text" placeholder="Search FAQs e.g. ‘check-in’" class="text-input js-filter-desktop" value="" />
            </form>
            <div class="faqs-nav-wrapper">
                <ul class="faq-nav" data-gumshoe>
                    <?php $count = 1; while ( have_rows('faq_groups') ) : the_row(); ?>
                        <li><h5 class="mb-0"><a href="#group-<?php echo $count; ?>" class="scroll-to js-faq-nav"><?php the_sub_field('group_title'); ?></a></h5></li>
                    <?php $count ++; endwhile; ?>
                </ul>
                <a href="<?php echo get_the_permalink( get_field('get_in_touch_button_link') ); ?>" class="faqs-cta flex theme--accent items-center justify-between">
                    <div class="flex-grow faqs-cta-content flex flex-col items-start justify-center">
                        <h5 class="mb-0"><?php the_field('get_in_touch_button_title'); ?></h5>
                        <p class="size-xs mb-0"><?php the_field('get_in_touch_button_subtitle'); ?></p>
                    </div>

                    <div class="button icon secondary no-margin">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g><line x1="19.982" y1="12" x2="3.982" y2="12" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><polyline points="14.333 6.315 20.018 12 14.333 17.685" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></g></svg>
                    </div>
                </a>
            </div>
        </div>
        <div class="faqs-content">
            <div class="faqs-content-inner">
                <div class="faq-top-content sm:hidden">
                    <?php if( get_field('overline') ): ?>
                        <p class="mb-2 overline color-accent" data-aos="fade-up">
                            <?php the_field('overline'); ?>
                        </p>
                    <?php endif; ?>
                    <h1 class="mb-2" data-aos="fade-up"><?php the_field('title'); ?></h1>
                    <p class="size-l" data-aos="fade-up"><?php the_field('top_content'); ?></p>

                    <div class="faqs-notification">
                        <span class="results-for">
                            <strong>Search results for:</strong> 
                            <span class="js-search-term"></span>
                        </span>

                        <span class="filter-count flex items-center">
                        </span>
                    </div>
                </div>
                <?php $count = 1; while ( have_rows('faq_groups') ) : the_row(); ?>
                    <div class="faq-group" id="group-<?php echo $count; ?>">
                        <p class="overline color-accent"><?php the_sub_field('group_title'); ?></p>
                        <div class="accordion">
                            <?php while ( have_rows('faqs') ) : the_row(); ?>
                                <div class="accordion-group">
                                    <div class="accordion-title has-icon">
                                        <h4>
                                            <?php the_sub_field('question'); ?>
                                            <span class="button secondary icon"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-down</title><g class="caret-down"><polyline class="arrowhead" points="36.036 18.982 24 31.018 11.964 18.982" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></span>
                                        </h4>
                                    </div>
                                    <div class="accordion-content">
                                        <?php the_sub_field('answer'); ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php $count ++; endwhile; ?>
            </div>
        </div>
    </section>
    <?php
}