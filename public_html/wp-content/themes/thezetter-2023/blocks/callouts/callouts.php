<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'calloutsections',
    'title'             => __('Callout Sections'),
    'description'       => __('Callout Sections'),
    'render_callback'   => 'callouts_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-justify', // dashicons, without the leading dashicons-
    'keywords'          => array( 'callout', 'sections' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/callouts/callouts.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function callouts_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row container spacing<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="callouts flex flex-wrap justify-center" data-aos="fade-up">
            <?php while ( have_rows('ctas') ) : the_row(); ?>
                <?php
                $link = get_sub_field('link_field_link');
                if( isLink( $link ) ):
                ?>
                <a href="<?php echo linkField( $link, 'url' ); ?>" class="callout flex items-center justify-between img-abs theme__card--<?php the_sub_field('theme'); ?>" <?php echo linkField( $link, 'target' ); ?>>
                <?php else: ?>
                <div class="callout flex items-center justify-between img-abs theme__card--<?php the_sub_field('theme'); ?>">
                <?php endif; ?>
                    <header>
                        <h3 class="h4 no-margin">
                            <?php the_sub_field('title'); ?>
                        </h3>
                        <?php if( linkField( $link, 'text' ) ): ?>
                            <p class="size-xs xs:size-s no-margin">
                                <?php echo linkField( $link, 'text' ); ?>
                            </p>
                        <?php endif; ?>
                    </header>
                    <?php if( isLink( $link ) ): ?>
                        <span class="button icon secondary no-margin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                        </span>
                    <?php endif; ?>        
                    <?php if( get_sub_field('theme') == 'image' ): echo img_sizes(get_sub_field('image'), ['default' => 'img_800', 'page_area' => '56', 'tablet_page_area' => '78', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
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