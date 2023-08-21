<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'columncontent',
    'title'             => __('Column Content'),
    'description'       => __('Column Content'),
    'render_callback'   => 'col_content_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'images-alt2', // dashicons, without the leading dashicons-
    'keywords'          => array( 'column', 'content', 'lockup' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/column_content/column_content.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function col_content_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row container-small spacing<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?><?php if( get_field('mobile_layout') == 'scroll' ): ?> nopadd-mob<?php endif; ?>"
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

        <?php if(get_field('add_intro_content')): ?>

            <div class="content col-content-intro">
                <?php if(get_field('illustration')): echo img_sizes(get_field('illustration'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
                <?php if(get_field('title')): ?>
                    <h3 class="h2 mb-4"><?php the_field('title'); ?></h3>
                <?php endif; ?>
                <?php if(get_field('content')): ?>
                    <?php the_field('content'); ?>
                <?php endif; ?>
            </div>  

        <?php endif; ?>

        <div class="column-content images-<?php the_field('image_size'); ?> flex justify-center flex-wrap<?php if( get_field('mobile_layout') == 'scroll' ): ?> mobile-scroll<?php endif; ?><?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>" data-aos="fade-up">
            <?php while ( have_rows('column') ) : the_row(); ?>
                <div class="content-lockup">
    
                    
                    <?php block_media( get_sub_field('image'), [
                        'img_sizes' => array('default' => 'img_800', 'page_area' => 26, 'mobile_page_area' => 85),
                        'default_aspect' => '4/3',
                        'slick_dots' => false,
                    ]); ?>
                

                    <div class="column-content-content">
                        <?php if( get_sub_field('overline_overline') ): ?>
                            <p class="mb-1 overline color-accent" data-aos="fade-up">
                                <?php the_sub_field('overline_overline'); ?>
                            </p>
                        <?php endif; ?>

                        <?php if( get_sub_field('title_title') ): ?>
                            <h3 class="mb-6" data-aos="fade-up"><?php the_sub_field('title_title'); ?>
                                <?php if( get_sub_field('subtitle_subtitle') ): ?>
                                    <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                                        <?php the_sub_field('subtitle_subtitle'); ?>
                                    </span>
                                <?php endif; ?>
                            </h3>
                        <?php endif; ?>

                        <div data-aos="fade-up">    
                            <?php the_sub_field('content_content'); ?>
                        </div>
                        
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
                </div>
            <?php endwhile; ?>
        </div>
    </section>
    <?php
}