<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'featuredlist',
    'title'             => __('Featured List'),
    'description'       => __('Featured List'),
    'render_callback'   => 'feat_list_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'grid-view', // dashicons, without the leading dashicons-
    'keywords'          => array( 'list', 'featured', 'featured list' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/featured_list/featured_list.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function feat_list_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());

    $counterType = get_field('counter_type');
    ?>
    <section
    class="row spacing container<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
      
        <div class="featured-list flex flex-wrap<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <?php $listCount = 1; while ( have_rows('list_items') ) : the_row(); ?>
                <div class="featured-list-item flex items-center" data-aos="fade-up">
                    <div class="list-counter flex items-center <?php echo $counterType; ?>">
                        <?php if( $counterType == 'numbers' ): ?>
                            <span class="number"><?php if( $listCount < '10' ): echo '0'; endif; echo $listCount; ?></span>
                        <?php else: ?>
                            <?php the_sub_field('autoloaded_icon'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="list-content">
                        <h3 class="h4 no-margin"><?php the_sub_field('title'); ?></h3>
                        <p class="size-s mb-0"><?php the_sub_field('content'); ?></p>
                    </div>
                </div>
            <?php $listCount++; endwhile; ?>
        </div>
    </section>
    <?php
}