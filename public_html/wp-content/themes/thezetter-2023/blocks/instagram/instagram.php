<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'instagram',
    'title'             => __('Instagram'),
    'description'       => __('Instagram'),
    'render_callback'   => 'instagram_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'Instagram' ),
    'supports'          => [ 'align' => false, 'align_text' => true, 'anchor' => true ],
    'enqueue_assets' => function(){
        wp_enqueue_script( 'block-acf-instagram', get_template_directory_uri() . '/assets/js/instagram/instagram.min.js' );
        wp_enqueue_style( 'block-acf-instagram', get_template_directory_uri() . '/assets/css/instagram/instagram.css' );
    }
));
function instagram_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());

?>
    <section data-aos-id="instagram"
    class="row spacing instagram-block-class container<?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?> "
    id="<?php if( array_key_exists('anchor', $block) && !empty($block['anchor'])): echo esc_attr($block['anchor']); else: echo $block['id']; endif ?>"
    data-aos="fade-up"
    <?php if( get_field('override_page_theme') && $theme == 'custom' ): ?>
    style="
        <?php if( $custom_text ): ?>--color-body: <?php echo $custom_text; ?>;<?php endif; ?>
        <?php if( $custom_bg ): ?>--color-background: <?php echo $custom_bg; ?>;<?php endif; ?>
        <?php if( $custom_bg_alt ): ?>--color-background-alt: <?php echo $custom_bg_alt; ?>;<?php endif; ?>
        <?php if( $custom_accent ): ?>--color-accent-primary: <?php echo $custom_text; ?>;<?php endif; ?>
        <?php if( $custom_accent_reverse ): ?>--color-accent-reverse: <?php echo $custom_accent_reverse; ?>;<?php endif; ?>
        "
    <?php endif; ?>
    >
    <?php block_background_media(); ?>

        <div class="instagram-block text-align-<?php echo $block['align_text']; ?><?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <div class="insta-top container">
                <?php if( get_field('title_title') ): ?>
                    <h2 data-aos="fade-up"><?php echo get_field('title_title'); ?></h2>
                <?php endif; ?>
            </div>

            <?php if(get_current_blog_id() == 3):?>
                <!-- Marrables -->
                <?php $instaAccount = "marrableshotel" ;?>
            <?php else: ?>
                <?php $instaAccount = "thezetterhotels" ;?>
            <?php endif; ?>
            <div class="insta-images js-insta up-instagram-block" data-account="<?php echo $instaAccount; ?>">
                <?php 
                    $posts = up_instagram($instaAccount);
                    $count = 0;

                    foreach($posts as $post):
                        if($count == 5): break; endif;

                        $src = $post['src'];

                        // Get path info
                        $pathInfo = pathinfo($src);
                        $path = str_replace( home_url(), '', $pathInfo['dirname'] );
                        
                        // Multisite to get the mainsite URL image
                        $main_url = network_home_url( $path );
                        $basePath = $main_url . '/' . $pathInfo['filename'];

                        $webpPath = $basePath . '.webp';
                        $jpgPath  = $basePath . '.jpg';

                        // Convert URL to server file path if needed
                        $webpFile = $_SERVER['DOCUMENT_ROOT'] . parse_url($webpPath, PHP_URL_PATH);
                        $jpgFile  = $_SERVER['DOCUMENT_ROOT'] . parse_url($jpgPath, PHP_URL_PATH);

                        $finalSrc = false;

                        if(file_exists($webpFile)) {
                            $finalSrc = $webpPath;
                        } elseif(file_exists($jpgFile)) {
                            $finalSrc = $jpgPath;
                        }

                        // Only output if a file exists
                        if($finalSrc):
                    ?>
                            <a href="<?php echo $post['permalink'];?>" target="_blank" class="instagram-image load">
                                <img src="<?php echo $finalSrc; ?>">
                            </a>
                    <?php 
                            $count++;
                        endif;

                    endforeach;
                ?>
            </div>
        </div>
    </section>
    <?php
}