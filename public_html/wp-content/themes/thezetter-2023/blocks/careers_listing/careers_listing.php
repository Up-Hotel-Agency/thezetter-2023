<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'careerslisting',
    'title'             => __('Careers Listing'),
    'description'       => __('Careers Listing'),
    'render_callback'   => 'careers_listing_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'tickets-alt', // dashicons, without the leading dashicons-
    'keywords'          => array( 'careers' ),
    'mode'              => 'preview',
    'supports'          => array(
                                    'align'     => false,
                                    'anchor'    => true,
                                    'mode'      => false
                                ),
    'enqueue_assets' => function(){
        wp_enqueue_style( 'block-acf-careers-grid', get_template_directory_uri() . '/assets/css/offers_grid/offers_grid.css' );
        wp_enqueue_style( 'block-acf-content', get_template_directory_uri() . '/assets/css/content/content.css' );
        wp_enqueue_style( 'block-acf-image-content-block', get_template_directory_uri() . '/assets/css/img_content/img_content.css' );
    }
));
function careers_listing_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row <?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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
        
        <div class="row spacing container content-block-container" data-aos="fade-up">
            <div class="content-block text-align-centre">
                <?php if( get_field('title_title') ): ?>
                    <h2 data-aos="fade-up"><?php the_field('title_title'); ?></h2>
                <?php endif; ?>
                <?php if( get_field('content_content') ): ?>
                    <div data-aos="fade-up">
                        <?php the_field('content_content'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="careers">
            <?php
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'careers',
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) :
                $careersCount = 1;
                while ( $the_query->have_posts() ) : $the_query->the_post(); $career = get_the_ID(); ?>
                    <div class="img-content <?php if( $careersCount % 2 ): ?>text-image<?php else: ?>image-text<?php endif; ?>">

                        <div class="content">
                            <div class="content-inner">
                                <header>
                                    <?php if( get_field('job_type', $career) ): ?>
                                        <h1 class="mb-3 h4 regular-weight" data-aos="fade-up">
                                            <?php the_field('job_type', $career); ?>
                                        </h1>
                                    <?php endif; ?>
                                    <h2 data-aos="fade-up">
                                        <?php the_title(); ?>
                                    </h2>
                                </header>

                                <?php if(get_field('job_description', $career)): ?>
                                    <article class="content-wrap content-wrap-careers" data-aos="fade-up" data-aos-delay="150">
                                        <?php the_field('job_description', $career); ?>
                                    </article>
                                <?php endif; ?>

                                <?php if( have_rows('buttons_buttons', $career) ): ?>
                                    <div class="buttons"  data-aos="fade-up" data-aos-delay="200">
                                        <?php while ( have_rows('buttons_buttons', $career) ) : the_row(); ?>
                                            <?php
                                            $class = get_sub_field('button_type', $career);
                                            $link = get_sub_field('link_field_link', $career);
                                            if( isLink( $link ) ):
                                            ?>
                                                <a class="button <?php echo $class; ?>" href="<?php echo linkField( $link, 'url' ); ?>" <?php echo linkField( $link, 'target' ); ?>>
                                                    <?php echo linkField( $link, 'text' ); ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php $careersCount++; endwhile;
            endif; wp_reset_query(); ?>
        </div>
    </section>
    <?php
}