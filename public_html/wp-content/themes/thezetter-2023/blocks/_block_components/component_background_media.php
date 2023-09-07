<?php

//Background Media Component 
function block_background_media() {
    if( get_field('override_page_theme')): 
        $themeField = get_field('block_theme_theme');
        $theme = $themeField['theme_select'];
        $themeVid = $themeField['background_video'];
        if($theme == 'image' || $theme == 'seasonal'): 
        ?>
            <div class="block-bg-img
            <?php
                if( $themeField['disable_overlay'] ): ?> no-overlay <?php endif;
                if(is_array($themeField['images'])): if(count($themeField['images']) > 1): ?> bg-image-carousel <?php endif; endif; 
            ?>">
                <?php
                    foreach($themeField['images'] as $images) {
                        echo img_sizes($images['image'], ['default' => 'img_1920', 'page_area' => '100', 'tablet_page_area' => '100', 'mobile_page_area' => '100', 'lazy_load' => false]);
                    }
                ?>
            </div>
        <?php 
        endif;
        if($theme == 'video' ): 
        ?>
            <div class="block-bg-img<?php if( $themeField['disable_overlay'] ): ?> no-overlay<?php endif; ?>">
                <video
                    class="object-fit lazyload"
                    preload="none"
                    muted=""
                    autoplay=""
                    loop
                    playsinline
                    src="<?php echo $themeVid; ?>"></video>
            </div>
        <?php 
        endif; 
    endif; 
}