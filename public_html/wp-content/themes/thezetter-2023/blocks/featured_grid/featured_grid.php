<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'featuredgrid',
    'title'             => __('Featured Grid'),
    'description'       => __('Featured Grid'),
    'render_callback'   => 'featured_grid_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'featured_grid' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/featured_grid/featured_grid.css',
    'supports'          => [ 'align' => false, 'align_text' => false ]
));
function featured_grid_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container featured_grid-block-container<?php if(get_field('has_patterned_background')): ?> has-patterned-background<?php endif; ?><?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="featured-grid-block <?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <?php if( get_field('title') ): ?>
                <h3 data-aos="fade-up"><?php the_field('title'); ?></h3>
            <?php endif; ?>
            <div class="the-featured-grid mt-12">
                <?php if(have_rows('grid_items')): ?>
                    <div class="featured-grid-block">
                        <div class="single-featured-grid" data-aos="fade-up">
                            <?php $count = 1; ?>
                            <?php while(have_rows('grid_items')): the_row(); ?>
                                    <div class="grid-item" data-aos="fade-up" data-aos-delay="200">
                                    <div class="img <?php if(get_sub_field('add_blend_mode')):?> blend-mode <?php endif; ?>">
                                        <?php if( get_sub_field('image')): echo img_sizes(get_sub_field('image', $featured_grid), ['default' => 'img_800', 'page_area' => '26', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
                                    </div>
                                    <div class="size-l h3 mt-6">
                                        <?php the_sub_field('title'); ?>
                                    </div>
                                    <?php if( get_sub_field('content') ): ?>
                                        <div class="size-m h3 mt-0">
                                            <?php the_sub_field('content'); ?>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                            <?php $count++; endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php

}