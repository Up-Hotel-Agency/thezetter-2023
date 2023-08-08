<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'ctablocks',
    'title'             => __('CTA Blocks'),
    'description'       => __('CTA Blocks'),
    'render_callback'   => 'cta_blocks_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'images-alt2', // dashicons, without the leading dashicons-
    'keywords'          => array( 'cta', 'blocks', 'call to action' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => true
                                )
));
function cta_blocks_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row container spacing<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?><?php if( get_field('mobile_layout') == 'scroll' ): ?> nopadd-mob<?php endif; ?>"
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

        <div class="cta-blocks flex flex-wrap justify-center<?php if( get_field('mobile_layout') == 'scroll' ): ?> mobile-scroll<?php endif; ?>" data-aos="fade-up">
            <?php while ( have_rows('ctas') ) : the_row(); ?>
                <?php
                $link = get_sub_field('link_field_link');
                if( isLink( $link ) ):
                ?>
                <a href="<?php echo linkField( $link, 'url' ); ?>" class="cta img-abs theme__card--<?php the_sub_field('theme');?>" <?php echo linkField( $link, 'target' ); ?>>
                <?php else: ?>
                <div class="cta img-abs theme__card--<?php the_sub_field('theme');?>">
                <?php endif; ?>
                    <div class="cta-inner flex items-center flex-col justify-center">
                        <header>
                            <?php if( get_sub_field('overline') ): ?>
                                <p class="mb-1 overline color-accent">
                                    <?php the_sub_field('overline'); ?>
                                </p>
                            <?php endif; ?>
                            <h3 class="mb-1">
                                <?php the_sub_field('title'); ?>
                            </h3>
                        </header>

                        <div class="cta-content">
                            <?php the_sub_field('content'); ?>
                        </div>
                        <?php if( isLink( $link ) && linkField( $link, 'text' ) ): ?>
                            <div class="buttons justify-center">
                                <span class="button secondary no-margin">
                                    <?php echo linkField( $link, 'text' ); ?>
                                </span>
                            </div>
                        <?php elseif( isLink( $link ) && !linkField( $link, 'text' ) ): ?>
                            <div class="buttons justify-center">
                                <span class="button secondary icon no-margin">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if( get_sub_field('theme') == 'image' ): echo img_sizes(get_sub_field('image'), ['default' => 'img_800', 'page_area' => '26', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
                <?php if( isLink( $link ) ): ?>
                </a>
                <?php else: ?>
                </div>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </section>
    <?php
}