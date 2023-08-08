<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'title',
    'title'             => __('Title'),
    'description'       => __('Title'),
    'render_callback'   => 'title_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'title' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/content/content.css',
    'supports'          => [ 'align' => false, 'align_text' => true ]
));
function title_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing--top container title-block<?php if(get_field('has_patterned_background')): ?> has-patterned-background<?php endif; ?><?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="content-block text-align-<?php echo $block['align_text']; ?><?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <?php if( get_field('title') ): ?>
                <h2 data-aos="fade-up"><?php the_field('title'); ?></h2>
                <hr class="centered mb-0" data-aos="fade-up">
            <?php endif; ?>
        </div>
    </section>
    <?php
}