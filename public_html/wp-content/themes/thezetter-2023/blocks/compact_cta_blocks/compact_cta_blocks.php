<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'compactctablocks',
    'title'             => __('Compact CTA Blocks'),
    'description'       => __('Compact CTA Blocks'),
    'render_callback'   => 'compact_cta_blocks_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'images-alt2', // dashicons, without the leading dashicons-
    'keywords'          => array( 'cta', 'blocks', 'call to action', 'compact' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_style( 'block-acf-compact-cta', get_template_directory_uri() . '/assets/css/compact_cta_blocks/compact_cta_blocks.css' );
        wp_enqueue_style( 'block-acf-cta', get_template_directory_uri() . '/assets/css/cta_blocks/cta_blocks.css' );
    }
));
function compact_cta_blocks_render_callback( $block, $content = '', $is_preview = false ) {
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

        <div class="cta-blocks compact flex flex-wrap justify-center<?php if( get_field('mobile_layout') == 'scroll' ): ?> mobile-scroll<?php endif; ?>" data-aos="fade-up">
            <?php while ( have_rows('ctas') ) : the_row(); ?>
                <?php
                $link = get_sub_field('link_field_link');
                if( isLink( $link ) ):
                ?>
                <a href="<?php echo linkField( $link, 'url' ); ?>" class="cta compact img-abs theme__card--<?php the_sub_field('theme');?>" <?php echo linkField( $link, 'target' ); ?>>
                <?php else: ?>
                <div class="cta compact img-abs theme__card--<?php the_sub_field('theme');?>">
                <?php endif; ?>
                    <div class="cta-inner flex items-center flex-col justify-center">
                        <header>
                            <h4 class="h5 no-margin">
                                <?php the_sub_field('title'); ?>
                            </h4>
                        </header>

                        <?php if( linkField( $link, 'text' ) ): ?>
                            <p class="size-xs">
                                <?php echo linkField( $link, 'text' ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php if( get_sub_field('theme') == 'image' ): echo img_sizes(get_sub_field('image'), ['default' => 'img_188', 'page_area' => '13', 'tablet_page_area' => '26', 'mobile_page_area' => '38', 'lazy_load' => true]); endif; ?>
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