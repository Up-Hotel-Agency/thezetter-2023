<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'imagecontentfullblock',
    'title'             => __('Image / Content Full Block'),
    'description'       => __('Image / Content Full Block'),
    'render_callback'   => 'img_content_full_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'forms', // dashicons, without the leading dashicons-
    'keywords'          => array( 'image, content' ),
    'enqueue_script'    => get_template_directory_uri() . '/assets/js/img_content_full/img_content_full.min.js',
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/img_content_full/img_content_full.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function img_content_full_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    // the img-content-row class below is for vogue
    ?>
    <section
    class="row spacing container img-content-row-full <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <?php $top_block = get_field('top_block'); ?>
        <?php if( $top_block ): ?>
            <div class="row layout-text-image img-content-row-full--first">
                <div class="first-block">
                    <div class="img-content text-image">
                        <div class="img" data-aos="fade-up">
                            <?php block_media( $top_block['images'], [
                                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                                'default_aspect' => '1/1',
                                'slick_dots' => true,
                            ]); ?>
                        </div>

                        <div class="content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                            <div class="content-inner">
                                <header>
                                    <?php if( $top_block['title_title'] ): ?>
                                        <h2 data-aos="fade-up"  data-aos-delay="100">
                                            <?php echo $top_block['title_title']; ?>
                                        </h2>
                                    <?php endif; ?>
                                </header>

                                <?php if( $top_block['content_content'] ): ?>
                                    <article class="content-wrap mb-4 " data-aos="fade-up" data-aos-delay="150">
                                            <?php echo $top_block['content_content']; ?>
                                    </article>
                                <?php endif; ?>
                                <?php block_buttons($top_block['buttons'], [
                                    'class' => 'no-margin',
                                    'aos' => true, 
                                    'aos_delay' => '150'
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php $middle_block = get_field('middle_block'); ?>
        <?php if( $middle_block ): ?>
            <div class="row middle-block">
                <?php if( $middle_block['left_image'] ): ?>
                    <div class="img-content image-left <?php if($middle_block['add_blend_mode_li']):?> blend-mode <?php endif; ?>">
                        <img src="<?php echo $middle_block['left_image']; ?>" class="lazyload object-fit contain" alt="popup image" width="100%" height="64">
                    </div>
                <?php endif; ?>
                <?php if( $middle_block['right_image'] ): ?>
                    <div class="img-content image-right <?php if($middle_block['add_blend_mode_ri']):?> blend-mode <?php endif; ?>">
                        <img src="<?php echo $middle_block['right_image']; ?>" class="lazyload object-fit contain" alt="popup image" width="100%" height="64">
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php $bottom_block = get_field('bottom_block'); ?>
        <?php if( $bottom_block ): ?>
            <div class="row layout-image-text img-content-row-full wide-image spacing--top">
                <div class="first-block">
                    <div class="img-content image-text">
                        <div class="img" data-aos="fade-up">
                            <?php block_media( $bottom_block['images'], [
                                'img_sizes' => array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100),
                                'default_aspect' => '1/1',
                                'slick_dots' => true,
                            ]); ?>
                        </div>

                        <div class="content<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
                            <div class="content-inner">
                                <header>
                                    <?php if( $bottom_block['title_title'] ): ?>
                                        <h2 data-aos="fade-up"  data-aos-delay="100">
                                            <?php echo $bottom_block['title_title']; ?>
                                        </h2>
                                    <?php endif; ?>
                                </header>

                                <?php if( $bottom_block['content_content'] ): ?>
                                    <article class="content-wrap mb-4 " data-aos="fade-up" data-aos-delay="150">
                                            <?php echo $bottom_block['content_content']; ?>
                                    </article>
                                <?php endif; ?>
                                <?php block_buttons($bottom_block['buttons'], [
                                    'class' => 'no-margin',
                                    'aos' => true, 
                                    'aos_delay' => '150'
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <?php
}