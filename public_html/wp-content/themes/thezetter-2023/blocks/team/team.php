<?php 
// register the block.
acf_register_block_type(array(
    'name'              => 'team',
    'title'             => __('Team'),
    'description'       => __('Team'),
    'render_callback'   => 'team_render_callback',
    'category'          => 'upcore-blocks',
    'icon'              => 'editor-aligncenter', // dashicons, without the leading dashicons-
    'keywords'          => array( 'team' ),
    'enqueue_style'     => get_template_directory_uri() . '/assets/css/team/team.css',
    'supports'          => [ 'align' => false, 'align_text' => false ]
));
function team_render_callback( $block, $content = '', $is_preview = false ) {
    extract(set_theme_override_values());
    ?>
    <section
    class="row spacing container team-block-container<?php if(get_field('has_patterned_background')): ?> has-patterned-background<?php endif; ?><?php if( get_field('override_page_theme') ):?> theme--<?php echo $theme; endif; ?><?php if( array_key_exists('className', $block) ): echo ' ' . $block['className']; endif; ?>"
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

        <div class="team-block <?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>">
            <?php if( get_field('title_title') ): ?>
                <h3 data-aos="fade-up"><?php the_field('title_title'); ?></h3>
            <?php endif; ?>
            <div class="the-team">
                <?php
                $team_args = array(
                    'posts_per_page' => -1,
                    'post_type' => 'team',
                );
                $team_query = new WP_Query( $team_args );
                if ( $team_query->have_posts() ) : ?>
                    <div class="team-block">
                        <div class="single-team" data-aos="fade-up">
                            <?php $count = 1; ?>
                            <?php while ( $team_query->have_posts() ) : $team_query->the_post(); $team = get_the_ID(); ?>
                                <?php if(get_field('link', $team)): ?>
                                    <a href="#" target="_blank" class="team-member" data-aos="fade-up" data-aos-delay="200"> 
                                <?php else: ?>
                                    <div class="team-member" data-aos="fade-up" data-aos-delay="200">
                                <?php endif; ?>
                                    <div class="img">
                                        <?php if( get_field('image', $team) ): echo img_sizes(get_field('image', $team), ['default' => 'img_800', 'page_area' => '26', 'mobile_page_area' => '85', 'lazy_load' => true]); endif; ?>
                                    </div>
                                    <div class="size-l mt-0">
                                        <?php the_title(); ?>
                                    </div>
                                    <?php if( get_field('position', $team) ): ?>
                                        <div class="size-s mt-0">
                                            <?php the_field('position', $team); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php if(get_field('link', $team)): ?>
                                    </a>
                                <?php else: ?>
                                    </div>
                                <?php endif; ?>

                            <?php $count++; endwhile; ?>
                        </div>
                    </div>
                <?php endif; wp_reset_query(); ?>
            </div>
        </div>
    </section>
    <?php

}