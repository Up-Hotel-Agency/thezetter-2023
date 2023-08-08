<?php
// register the block.
acf_register_block_type(array(
    'name'              => 'newslettersignupblock',
    'title'             => __('Newsletter Signup Block'),
    'description'       => __('Newsletter Signup Block'),
    'render_callback'   => 'newsletter_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'email-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'newsletter', 'signup' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/newsletter/newsletter.css',
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                )
));
function newsletter_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="container">
            <div class="newsletter-block flex flex-col items-center">
                <header>
                    <?php if( get_field('overline_overline') ): ?>
                        <p class="mb-1 overline color-accent" data-aos="fade-up">
                            <?php the_field('overline_overline'); ?>
                        </p>
                    <?php endif; ?>
                    <?php if( get_field('title_title') ): ?>
                        <h2 class="mb-12" data-aos="fade-up"><?php the_field('title_title'); ?>
                            <?php if( get_field('subtitle_subtitle') ): ?>
                                <span class="subtitle" data-aos="fade-up" data-aos-delay="50">
                                    <?php the_field('subtitle_subtitle'); ?>
                                </span>
                            <?php endif; ?>
                        </h2>
                    <?php endif; ?>
                </header>
                <form class="newsletter-container mb-4" data-aos="fade-up" action="#" target="_blank">
                    <div class="newsletter theme--default flex">
                        <div class="newsletter-icon flex items-center">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>email</title><g class="email"><rect class="main-body" x="5" y="11.333" width="38" height="25.333" rx="3.001" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="flap" points="42.51 12.808 24 24.103 5.49 12.808" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                        </div>
                        <input class="no-margin" name="EMAIL" type="email" required placeholder="Email Address" aria-label="Email Address">
                        <button type="submit" class="no-margin">
                            <span class="sm:hidden">Submit</span>
                            <svg class="hidden sm:flex" width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>arrow-right</title><g class="arrow-right"><line class="arrow-stem" x1="39.964" y1="23.964" x2="7.964" y2="23.964" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><polyline class="arrowhead" points="28 11.929 40.036 23.964 28 36" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                        </button>
                    </div>
                    <p class="flex items-center text-left size-xs">
                        <input type="checkbox" id="terms" required />
                        <label for="terms">I have read the Terms &amp; Conditions and would like to be added to the mailing list</label>
                    </p>
                </form>
            </div>
        </div>
    </section>
    <?php
}