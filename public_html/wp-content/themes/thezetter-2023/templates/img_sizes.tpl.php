<?php $img_size = wp_get_attachment_image_src($img_field, $default); ?>
<img
    <?php if($default_img): // if image exists ?>
        src="<?php echo $default_img; ?>"
    <?php else: // if no image added, just show grey placeholder ?>
        src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
    <?php endif; ?>

    <?php if($lazy_load): ?>
        loading="lazy"          
    <?php endif; ?>

    <?php 
    //Aspect Ratio 
    $aspectVar = "";
    $aspectClass = "";
    if($aspect):
        $aspectVar = " --aspect-ratio: $aspect; ";
        $aspectClass = " set-aspect ";
    endif; 
    ?>

    onerror="this.onerror=null; this.src='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='; this.srcset='data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='"
    alt="<?php echo $alt ?>"
    width="<?php echo $img_size[1]; ?>"
    height="<?php echo $img_size[2]; ?>"
    class="
        <?php echo "$object_fit $aspectClass" ?>
        <?php if($class) {echo $class;}?>
    "

    <?php if($styles || $aspect): ?>
        style="<?php echo "$styles $aspectVar" ?> "
    <?php endif; ?>
    
    <?php if($override_srcset): ?>
        srcset="<?php echo $override_srcset; ?>"
    <?php elseif($default_img): ?>
        srcset="<?php echo $images['img_188']; ?> 188w, <?php echo $images['img_375']; ?> 375w, <?php echo $images['img_500']; ?> 500w, <?php echo $images['img_640']; ?> 640w, <?php echo $images['img_800']; ?> 800w, <?php echo $images['img_1024']; ?> 1024w, <?php echo $images['img_1367']; ?> 1367w, <?php echo $images['img_1920']; ?> 1920w, <?php echo $images['img_2200']; ?> 2200w"
    <?php endif; ?>

    sizes="(max-width: 48em) <?php echo $mobile_page_area ?>vw, (max-width: 64em) <?php echo $tablet_page_area ?>vw, (min-width: 64em) <?php echo $page_area ?>vw">
