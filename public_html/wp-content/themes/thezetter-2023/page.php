<?php
get_header();

while ( have_posts() ) : the_post();

$themeField = get_field('page_theme');
$theme = $themeField['theme']['theme_select'];

if( $theme == 'image' ):
    $themeImg = $themeField['theme']['background_image'];
endif;
if( $theme == 'video' ):
    $themeVid = $themeField['theme']['background_video'];
endif;
if( $theme == 'custom' ):
    $custom_text = $themeField['theme']['custom_text_colour'];
    $custom_bg = $themeField['theme']['custom_background_colour'];
    $custom_bg_alt = $themeField['theme']['custom_background_colour_alt'];
    $custom_accent = $themeField['theme']['custom_accent_colour'];
    $custom_accent_reverse = $themeField['theme']['custom_accent_reverse_colour'];
endif;
?>

<main class="page-container  page--<?php echo str_replace(' ', '-', strtolower(get_the_title())); ?>  theme--<?php echo $theme; ?>"
<?php if( $theme == 'custom' ): ?>
style="
        <?php if( $custom_text ): ?>--color-body: <?php echo $custom_text; ?>;<?php endif; ?>
        <?php if( $custom_bg ): ?>--color-background: <?php echo $custom_bg; ?>;<?php endif; ?>
        <?php if( $custom_bg_alt ): ?>--color-background-alt: <?php echo $custom_bg_alt; ?>;<?php endif; ?>
        <?php if( $custom_accent ): ?>--color-accent-primary: <?php echo $custom_accent; ?>;<?php endif; ?>
        <?php if( $custom_accent_reverse ): ?>--color-accent-reverse: <?php echo $custom_accent_reverse; ?>;<?php endif; ?>
    "
<?php endif; ?>
>
    <?php if( $theme == 'image' ): ?>
        <div class="page-bg-img<?php if( $themeField['theme']['disable_overlay'] ): ?> no-overlay<?php endif; ?>">
            <?php echo img_sizes($themeImg, ['default' => 'img_1920', 'lazy_load' => true]); ?>
        </div>
    <?php endif; ?>
    <?php if( $theme == 'video' ): ?>
        <div class="page-bg-img<?php if( $themeField['theme']['disable_overlay'] ): ?> no-overlay<?php endif; ?>">
            <video
                class="object-fit lazyload"
                preload="none"
                muted=""
                autoplay=""
                loop
                playsinline
                src="<?php echo $themeVid; ?>"></video>
        </div>
    <?php endif; ?>

    <?php the_content(); ?>
</main>



<?php endwhile;

get_footer();