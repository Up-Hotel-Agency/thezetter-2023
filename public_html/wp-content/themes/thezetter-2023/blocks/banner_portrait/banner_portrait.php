<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'upbannerportrait',
    'title'             => __('UP Banner - Portrait'),
    'description'       => __('UP Banner - Portrait'),
    'render_callback'   => 'banner_portrait_render_callback',
    'category'          => 'upcore-banners',
    'icon'              => 'laptop', // dashicons, without the leading dashicons-
    'keywords'          => array( 'banner, portrait' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'       => false,
                                    'anchor'      => true,
                                    'mode'        => false,
                                    'full_height' => true,
                                )
));
function banner_portrait_render_callback( $block, $content = '', $is_preview = false ) {
    if( get_field('booking_mask') ):
        wp_enqueue_script( 'atc-js', get_template_directory_uri() . '/assets/js/atc.min.js' );
        wp_enqueue_script( 'flatpickr-js', get_template_directory_uri() . '/assets/js/flatpickr.min.js' );
        wp_enqueue_script( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/js/booking_mask/booking_mask.min.js' );
        wp_enqueue_style( 'flatpickr', get_template_directory_uri() . '/assets/css/utilities/flatpickr.css' );
        wp_enqueue_style( 'flatpickr-custom', get_template_directory_uri() . '/assets/css/utilities/flatpickr_custom.css' );
        wp_enqueue_style( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/css/booking_mask/booking_mask.css' );
    endif;
    extract(set_theme_override_values());
    ?>
    <section
    class="row container banner-block banner-portrait<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?><?php if(array_key_exists('full_height', $block) && $block['full_height'] != false): echo ' full-height'; endif; ?>"
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
        <div class="banner-portrait-inner flex">
            <div class="banner-portrait-content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                <a href="<?php echo get_bloginfo( 'url' ); ?>" title="<?php echo get_bloginfo( 'name' ); ?>" class="mb-12 sm:mb-8 block">
                    <svg class="up-core-logo" fill="none" height="96" viewBox="0 0 140 40" width="240" xmlns="http://www.w3.org/2000/svg"><title>UP Core logo</title><path clip-rule="evenodd" d="m27.7643.0621215c.1462-.0828264.3252-.0828288.4714-.0000062l13.7062 7.7650747c.0109.00567.0217.01177.0323.0183l13.7834 7.80881c.15.085.2426.2442.2424.4167v.0041.0049 15.5407c0 .1727-.0931.332-.2437.4166l-13.7123 7.7145c-.146.0822-.3243.0819-.4701-.0006l-13.5739-7.6889-13.5739 7.6889c-.1457.0825-.324.0828-.47.0007l-13.712417-7.7136c-.1505287-.0846-.24368299-.2439-.24368299-.4166v-15.5398c0-.0018.00000983-.0036.00002946-.0053-.00001698-.0016-.00002662-.0031-.00002892-.0046-.00026019-.1725.09236835-.3317.24240445-.4167l13.775995-7.80513c.0154-.0099.0313-.01888.0476-.02692zm-13.4857 8.7395885-12.82813 7.26809 12.74003 7.1674 12.7823-7.2423zm13.2433 7.98109-12.8534 7.2825v14.4496l12.8534-7.2807zm.9562 14.4514v-14.4514l12.8534 7.2825v14.4496zm13.8095 7.2835 12.7563-7.1766v-14.4532l-12.7563 7.1783zm-.4773-15.28 12.7393-7.1688-12.8278-7.26744-12.6946 7.19344zm-13.8103-7.7597-12.7516-7.22574 12.7516-7.22473 12.752 7.2245zm-14.2876 23.0397-12.756262-7.1756v-14.4534l12.756262 7.1766z" fill="#fff" fill-rule="evenodd"/><g fill="#fff"><path d="m71.0967 12.8422h-3.0967v9.5669c0 3.2607 2.4097 5.4858 6.2036 5.4858 3.7837 0 6.1934-2.2251 6.1934-5.4858v-9.5669h-3.0967v9.2592c0 1.897-1.1177 3.1377-3.0967 3.1377-1.9892 0-3.1069-1.2407-3.1069-3.1377z"/><path d="m89.0308 16.472c-1.5894 0-2.8096.7999-3.4043 2.0918h-.0616v-1.9174h-2.9531v14.581h2.9942v-5.4346h.0615c.5845 1.2408 1.8149 2.0201 3.4145 2.0201 2.7481 0 4.4502-2.1328 4.4502-5.6704 0-3.5479-1.7124-5.6705-4.5014-5.6705zm-1.0049 8.9312c-1.4663 0-2.4302-1.2715-2.4302-3.2607 0-1.9688.9639-3.271 2.4302-3.271 1.497 0 2.4404 1.2817 2.4404 3.271 0 1.9995-.9434 3.2607-2.4404 3.2607z"/><path d="m101.879 27.8949c3.63 0 6.163-2.0918 6.511-5.3936h-3.015c-.328 1.7535-1.65 2.8301-3.486 2.8301-2.3685 0-3.8553-1.9482-3.8553-5.1064 0-3.1172 1.5073-5.0757 3.8453-5.0757 1.805 0 3.199 1.1894 3.486 3.0044h3.015c-.236-3.312-2.943-5.5679-6.501-5.5679-4.2862 0-7.0035 2.8814-7.0035 7.6494 0 4.7783 2.6968 7.6597 7.0035 7.6597z"/><path d="m115.096 27.8744c3.322 0 5.445-2.1226 5.445-5.7422 0-3.5684-2.153-5.7217-5.445-5.7217-3.291 0-5.445 2.1636-5.445 5.7217 0 3.6094 2.123 5.7422 5.445 5.7422zm0-2.2866c-1.476 0-2.409-1.2408-2.409-3.4453 0-2.1841.953-3.4454 2.409-3.4454s2.4 1.2613 2.4 3.4454c0 2.2045-.934 3.4453-2.4 3.4453z"/><path d="m122.089 27.6385h2.994v-6.142c0-1.5484.862-2.4507 2.338-2.4507.431 0 .841.0718 1.087.1743v-2.6353c-.205-.0615-.502-.1128-.851-.1128-1.292 0-2.225.7588-2.615 2.1534h-.061v-1.979h-2.892z"/><path d="m134.302 18.6254c1.333 0 2.245.9638 2.307 2.3686h-4.666c.103-1.374 1.046-2.3686 2.359-2.3686zm2.348 5.6499c-.277.8408-1.118 1.3842-2.215 1.3842-1.528 0-2.522-1.0766-2.522-2.6455v-.1845h7.577v-.9126c0-3.3428-2.02-5.5064-5.219-5.5064-3.25 0-5.301 2.2764-5.301 5.7832 0 3.5171 2.03 5.6807 5.414 5.6807 2.717 0 4.686-1.4458 5.014-3.5991z"/></g></svg>
                </a>
                <?php if( get_field('overline_overline') ): ?>
                    <p class="mb-2 overline color-accent">
                        <?php the_field('overline_overline'); ?>
                    </p>
                <?php endif; ?>
                <?php if( get_field('title_title') ): ?>
                    <h1 class="mb-12"><?php the_field('title_title'); ?>
                        <?php if( get_field('subtitle_subtitle') ): ?>
                            <span class="subtitle">
                                <?php the_field('subtitle_subtitle'); ?>
                            </span>
                        <?php endif; ?>
                    </h1>
                <?php endif; ?>
                <?php block_buttons(get_field('buttons'), [
                    'class' => 'no-margin items-center centered',
                    'type'  => 'primary'
                ]); ?>
                <?php if( get_field('booking_mask') ): ?>
                    <div class="force-mobile-mask theme--default">
                        <?php include(get_template_directory() . '/templates/bookingmask.php'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if( get_field('portrait_image') ): ?>
            <div class="banner-portrait-image img-abs">
                <?php echo img_sizes(get_field('portrait_image'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true]); ?>
            </div>
            <?php endif; ?>
            <a href="#" class="js-scroll-next-block continue flex items-center">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="6.076" y="2.093" width="11.848" height="19.814" rx="5.924" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.358L12 8.615"/></svg>
                <span>Continue</span>
            </a>
        </div>
    </section>
    <?php
}