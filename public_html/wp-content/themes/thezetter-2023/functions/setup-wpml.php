<?php

/**
* @desc If using WPML, use languages_list(); for the language dropdown selector
*/
function languages_list(){
    if ( function_exists('icl_object_id') ) {
        $languages = icl_get_languages('skip_missing=0&orderby=custom');
        if(!empty($languages)){ ?>
        <div class="lang-select">
            <?php
            foreach($languages as $l){
                if($l['active']) { ?>
                <a href="<?php echo $l['url']; ?>" class="active-lang"><?php echo icl_disp_language($l['language_code']); ?></a>
                <p class="other-langs"><span>
            <?php }
            } ?>
            <?php
            foreach($languages as $l){
                if(!$l['active']) { ?>
                    <a class="lang-<?php echo icl_disp_language($l['language_code']); ?>" href="<?php echo $l['url']; ?>"><?php echo icl_disp_language($l['language_code']); ?></a>
                <?php }
                } ?>
                </span></p>
        </div>
    <?php }
    }
};
