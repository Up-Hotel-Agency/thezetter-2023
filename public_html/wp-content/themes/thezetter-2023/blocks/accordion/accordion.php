<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'accordion',
    'title'             => __('Accordion'),
    'description'       => __('Accordion'),
    'render_callback'   => 'accordion_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'menu-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'accordion' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/accordion/accordion.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/accordion/accordion.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function accordion_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="
        row spacing container
        <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?>
        <?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>
        <?php if( get_field('display_content') ): ?> 
            accordion-lockup
            flex
            justify-between
            sm:flex-col
            <?php the_field('layout'); ?>
        <?php endif; ?>
    "
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
        <?php if( get_field('override_page_theme') && ($theme == 'image' || $theme == 'seasonal') ): ?>
            <div class="block-bg-img<?php if( $themeField['disable_overlay'] ): ?> no-overlay<?php endif; if($themeField['multiple_images']): echo ' bg-image-carousel'; endif; ?>">
                <?php if($themeField['multiple_images'] && $themeField['slide_images']) {
                    foreach($themeField['slide_images'] as $slideImage) {
                        echo img_sizes($slideImage['slide_image'], ['default' => 'img_1920', 'lazy_load' => true]);
                    }
                } else {
                    echo img_sizes($themeImg, ['default' => 'img_1920', 'lazy_load' => true]);
                } ?>
            </div>
        <?php endif; ?>
        <?php if( get_field('override_page_theme') && $theme == 'video' ): ?>
            <div class="block-bg-img<?php if( $themeField['disable_overlay'] ): ?> no-overlay<?php endif; ?>">
                <video
                    class="object-fit lazyload"
                    preload="none"
                    muted=""
                    autoplay=""
                    loop
                    playsinline
                    src="<?php echo $themeVid; ?>"></video>
            </div>
        <?php endif; ?>
        <?php if( get_field('display_content') ): ?>
            <div class="content-lockup-wrapper<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                <div class="content-lockup">
                    <?php if( get_field('overline_overline') ): ?>
                        <p class="mb-1 overline color-accent" data-aos="fade-up">
                            <?php the_field('overline_overline'); ?>
                        </p>
                    <?php endif; ?>

                    <?php if( get_field('title_title') ): ?>
                        <h2 class="mb-6" data-aos="fade-up"><?php the_field('title_title'); ?>
                            <?php if( get_field('subtitle_subtitle') ): ?>
                                <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                                    <?php the_field('subtitle_subtitle'); ?>
                                </span>
                            <?php endif; ?>
                        </h2>
                    <?php endif; ?>

                    <div data-aos="fade-up">    
                        <?php the_field('content_content'); ?>
                    </div>
                    
                    <?php block_buttons(get_field('buttons'), [
                        'class' => 'no-margin',
                        'aos' => true, 
                        'aos_delay' => '150'
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="accordion<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>" data-aos="fade-up">
            <?php while ( have_rows('questions') ) : the_row(); ?>
                <div class="accordion-group">
                    <div class="accordion-title has-icon">
                        <h4>
                            <?php the_sub_field('question'); ?>
                            <span class="button icon"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-down</title><g class="caret-down"><polyline class="arrowhead" points="36.036 18.982 24 31.018 11.964 18.982" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></span>
                        </h4>
                    </div>
                    <div class="accordion-content"><?php the_sub_field('answer'); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
    <?php
}