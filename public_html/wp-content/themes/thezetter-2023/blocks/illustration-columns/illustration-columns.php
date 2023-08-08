<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'illustrationcolumns',
    'title'             => __('Illustration Columns'),
    'description'       => __('Illustration Columns'),
    'render_callback'   => 'illustration_columns_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'illustration', 'columns' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/illustration-columns/illustration-columns.css',
    'supports'          => [ 'align' => false, 'align_text' => true ]
));
function illustration_columns_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container content-block-container<?php if(get_field('has_patterned_background')): ?> has-patterned-background<?php endif; ?><?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="illustration-columns <?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            
            <div class="featured-content-image">
                <?php if(get_field('illustration')): echo img_sizes(get_field('illustration'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
            </div>
            <?php if( get_field('title_title') ): ?>
                <h3 data-aos="fade-up"><?php the_field('title_title'); ?></h3>
            <?php endif; ?>
            <div class="column-list flex flex-row items-center" data-aos="fade-up">
                <?php while ( have_rows('content') ) : the_row(); ?>
                    <div class="column-list-item flex flex-col items-center" data-aos="fade-up">
                        
                        <?php if( get_sub_field('subtitle_subtitle') ): ?>
                            <p class="underlined" data-aos="fade-up">
                                <?php the_sub_field('subtitle_subtitle'); ?>
                            </p>
                        <?php endif; ?>
                        <?php if( get_sub_field('content_content') ): ?>
                            <div data-aos="fade-up">
                                <?php the_sub_field('content_content'); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        if( have_rows('buttons_buttons') ): ?>
                            <div class="buttons" data-aos="fade-up" data-aos-delay="150">
                                <?php $buttonCount = 1;
                                while ( have_rows('buttons_buttons') ) : the_row(); ?>
                                    <?php
                                    $class = get_sub_field('button_type');
                                    $link = get_sub_field('link_field_link');
                                    if( isLink( $link ) ):
                                    ?>
                                        <a class="button <?php echo $class; ?>" href="<?php echo linkField( $link, 'url' ); ?>" <?php echo linkField( $link, 'target' ); ?>>
                                            <?php echo linkField( $link, 'text' ); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php $buttonCount++; endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>

        </div>
    </section>
    <?php

}