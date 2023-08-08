<?php

//Media Component 
function block_media($field, $opts = [] ){

    //Exit early if field set is not defined 
    if(!isset($field)){
        echo "Please define a field for block_media function.";
        return;
    }

    //Exit early if media array is not found within defiend field 
    if(!isset($field['media'])){
        echo "Couldn't find media array within defiend field.";
        return;
    }

    //Set our root field 
    $root_field = $field['media'];

    //Get params for function or assign defaults 
    $imgSize = isset($opts['img_sizes']) ? $opts['img_sizes'] : array('default' => 'img_1367', 'page_area' => 100, 'mobile_page_area' => 100); //Default image sizes or defined
    $slickDots = isset($opts['slick_dots']) ? $opts['slick_dots'] : false; //Enable or disable slick dots
    $allowAspect = isset($opts['allow_aspect']) ? $opts['allow_aspect'] : true; //Enable or disable aspect (hardcoded)
    $defaultAspect = isset($opts['default_aspect']) ? $opts['default_aspect'] : false; //Default block aspect ratio for all media
    $videoAspect = isset($opts['video_aspect']) ? $opts['video_aspect'] : false; //Overide video aspect no matter selection
    $videoAutoplay = isset($opts['video_autoplay']) ? $opts['video_autoplay'] : "default"; //Overide video autoplay no matter selection 
    $dynamic_mobile = isset($opts['dynamic_mobile']) ? $opts['dynamic_mobile'] : true; //Disable mobile media (Used when container isn't appropriate for dynamic media)
    $dynamic = isset($opts['dynamic']) ? $opts['dynamic'] : true; //Define is dynamic media should be used on both desktop or mobile.
    $ajax = isset($opts['ajax']) ? $opts['ajax'] : false; //Define true to reload required libs on insert (Used when function is apart of an ajax request)

    //Check if the user is using a mobile device (Used due to the inability to auto play videos on all mobile devices)
    if(wp_is_mobile()){
        $mobileSettings = true;
    }else{
        $mobileSettings = false;
    }

    
    //Mobile media is disabled and current device is mobile
    if(!$dynamic_mobile && $mobileSettings){
        $allow_dynamic = false;

    //Dynamic media is completely disabled
    }elseif(!$dynamic){
        $allow_dynamic = false;

    //We can use dynamic media
    }else{
        $allow_dynamic = true;
    }

    //Get media type 
    $mediaType = $root_field['media_type'];
    if($mediaType == "image"):

        //Check if array of images
        $imgArray = false;
        if(is_array($root_field['image_options']['images'])):
            $count = count($root_field['image_options']['images']);
            if( $count > 1 ): 
                $imgArray = true;
            endif;
        else:
            return; 
        endif;


        //Check if we're appying image sizing based on our group value or individual images
        $custom_repeater_sizing = isset($root_field['custom_repeater_sizing']) ? $root_field['custom_repeater_sizing'] : false;
        if(!$custom_repeater_sizing):
            $size = $root_field['repeater_sizing']['size'];
            $individualSizing = false;
        else:
            $individualSizing = true;
        endif;

        //Image container with call to carousel JS 
        ?><div class="media-container <?php if(!$allowAspect): ?> no-aspec <?php endif; ?> image-carousel <?php if($imgArray && $allow_dynamic ): ?> js-image-carousel <?php endif; ?>"><?php
        foreach ( $root_field['image_options']['images'] as $data) :

            $imageID = $data['image'];

            //Get image options (if we're selecting from each image)
            if($individualSizing == true):
                $size = $data['image_size']['size'];
            endif; 

            //Handle object sizing
            $values = media_size($size, $defaultAspect, $allowAspect);

            //Output image & options  
            echo img_sizes($imageID, ['default' => $imgSize['default'], 'page_area' => $imgSize['page_area'], 'mobile_page_area' => $imgSize['mobile_page_area'], 'lazy_load' => true, 'object_fit' => $values['fit'], 'aspect' =>  $values['aspectRatio']]);

            //Only show one image if lite mobile is enabled
            if( !$allow_dynamic ):
                break; 
            endif;

        endforeach;
        ?></div><?php

        //Handle reload of slick if used within ajax request
        if($imgArray && $allow_dynamic && $ajax){
            ?><script>slick_load();</script><?php
        }

        //Image slick controls 
       
        if( $imgArray && $slickDots && $allow_dynamic): 
            ?><div class="slick-controls slick-media flex justify-center items-center">
                <a href="#" class="js-img-prev slick-control" title="Previous slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Previous</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
                <div class="slick-dots img-content-dots"></div>
                <a href="#" class="js-img-next slick-control" title="Next slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Next</title><g class="caret-right"><polyline class="arrowhead" points="18.982 11.964 31.018 24 18.982 36.036" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg></a>
            </div><?php        
        endif; 

    elseif($mediaType == "video"):
        $videoOptions = $root_field['video_options']['video'];

        //Youtube Lite Player 
        if($videoOptions['video_source'] == "youtube"):
            if($videoOptions['youtube_embed_url']):
            
            //Get all options 
            $videoURL = $videoOptions['youtube_embed_url'];
            $posterImage = $videoOptions['poster_image'];
            $autoPlay = $videoOptions['auto_play'];

            //Overide auto play settings if hardcoded defined
            if($videoAutoplay != "default"){
                if($videoAutoplay){
                    $autoPlay = 1;
                }else{
                    $autoPlay = 0;
                }
            }

            if(!$autoPlay): 
                $autoPlay = "0"; 
                $muted = $videoOptions['muted'];
                if(!$muted): $muted = "0"; endif;
                $controls = $videoOptions['show_controls'];
                if(!$controls): $controls = "0"; endif;
            else:
                $muted = 1;
                $controls = 0;
            endif;

            //Mobile video override 
            if($mobileSettings):
                $autoPlay = 0;
                $controls = 1;
                $muted = 1;
            endif;

            //Disable video on mobile lite and show image instead
            if(!$allow_dynamic):
                if($posterImage){
                    $image = wp_get_attachment_image_url($posterImage, 'full'); //Use poster image
                }else{
                    $image = "https://i.ytimg.com/vi/$videoURL/maxresdefault.jpg"; //Use thumbnail from Youtube
                }
                videoLiteImage($image);
            return;
            endif;
            
            if($posterImage):
                $posterImage = "background-image: url('".wp_get_attachment_image_url($posterImage, 'full')."');";
            endif;

            ?>
            <div class="media-container video-media-container <?php if(!$allowAspect): ?> no-aspec <?php endif; ?> ">
                <lite-youtube
                    data-aos="fade-up"
                    <?php if($autoPlay): ?>data-aos-id="liteYoutube" <?php endif;?> 
                    style="<?php echo $posterImage; ?> <?php if($videoAspect): echo 'aspect-ratio:'.$videoAspect.';'; endif; ?>"
                    autoplay="<?php echo $autoPlay; ?>" 
                    videoid="<?php echo $videoURL; ?>" 
                    params="modestbranding=1&autoplay=1&listType=playlist&loop=1&rel=0&controls=<?php echo $controls; ?>&enablejsapi=1&mute=<?php echo $muted; ?>">
                </lite-youtube>
            </div>
            <?php
            else:
                echo "Please enter a Youtube video ID";
            endif;
        endif;

        //Direct or file select video player
        if($videoOptions['video_source'] == "direct" || $videoOptions['video_source'] == "file"):

            //Get file URL
            if($videoOptions['video_source'] == "direct"):
                $videoURL = $videoOptions['direct_video_link'];
            elseif($videoOptions['video_source'] == "file"):
                $videoURL = wp_get_attachment_url($videoOptions['uploaded_video_file']);
            endif;

            //Get all options 
            $autoPlay = $videoOptions['auto_play'];
            $posterImage = $videoOptions['poster_image'];

            //Overide auto play settings if hardcoded defined
            if($videoAutoplay != "default"){
                if($videoAutoplay){
                    $autoPlay = 1;
                }else{
                    $autoPlay = 0;
                }
            }

            if(!$autoPlay): 
                $autoPlay = "0"; 
                $muted = $videoOptions['muted'];
                if(!$muted): $muted = "0"; endif;
                $controls = $videoOptions['show_controls'];
                if(!$controls): $controls = "0"; endif;
            else:
                $muted = 1;
                $controls = 0;
            endif;

            //Mobile video override 
            if($mobileSettings):
                $autoPlay = 0;
                $controls = 1;
            endif;

            //Disable video on mobile lite and show image instead
            if(!$allow_dynamic):
                if($posterImage){
                    $image = wp_get_attachment_image_url($posterImage, 'full'); //Use poster image
                    videoLiteImage($image);
                    return;
                }else{
                    //No poster image supplied, therefore we must load the video but act as a still frame.
                    $controls = 0;
                    $autoPlay = 0;
                }
            endif;

            $posterImage = $videoOptions['poster_image'];
            if($posterImage):
                $posterImage = "poster='".wp_get_attachment_image_url($posterImage, 'full')."'";
            endif;

            //Get video options
            $size = $videoOptions['video_size']['size'];

            //Handle object sizing
            $values = media_size($size, $defaultAspect, $allowAspect);

            //If a hardcoded video aspect has been set change var
            if($videoAspect): 
                $values['aspectRatio'] = $videoAspect;
            endif; 

            $fit = "";
            if($values['fit'] == "cover"){
                $fit = "object-fit";
            }else{
                $fit = "object-fit contain";
            }

            //Add in video player 
            ?>

                <video 
                class="media-container <?php if(!$allowAspect): ?> no-aspec <?php endif; ?> <?php echo $fit; ?> <?php if($values['aspectRatio']): ?> set-aspect <?php endif; ?>  "
                <?php echo $posterImage; ?>
                style="<?php if($values['aspectRatio']): ?> --aspect-ratio: <?php echo $values['aspectRatio']; ?> <?php endif; ?>"
                width="auto" height="auto" 
                <?php if($controls): ?>controls <?php endif; ?>
                <?php if($autoPlay): ?>autoplay <?php endif; ?>
                <?php if($muted): ?>muted <?php endif; ?>
                loop
                playsinline
                preload="metadata"
                >
                <source src="<?php echo $videoURL; ?><?php if(!$posterImage): ?>#t=0.5<?php endif; ?>" type="video/mp4">
                Your browser does not support the video tag.
                </video>

            <?php

        elseif($videoOptions['video_source'] == "vimeo"): 


            //Get Vimeo ID
            $videoURL = $videoOptions['vimeo_embed_url'];
       
            //Get all options 
            $autoPlay = $videoOptions['auto_play'];
            $posterImage = $videoOptions['poster_image'];

            //Overide auto play settings if hardcoded defined
            if($videoAutoplay !== "default"){
                if($videoAutoplay){
                    $autoPlay = 1;
                }else{
                    $autoPlay = 0;
                }
            }


            if(!$autoPlay): 
                $autoPlay = "0"; 
                $muted = $videoOptions['muted'];
                if(!$muted): $muted = "0"; endif;
                $controls = $videoOptions['show_controls'];
                if(!$controls): $controls = "0"; endif;
            else:
                $muted = 1;
                $controls = 0;
            endif;

            //Mobile video override 
            if($mobileSettings):
                $autoPlay = 0;
                $controls = 1;
            endif;

            //Disable video on mobile lite and show image instead
            if(!$allow_dynamic):
                if($posterImage){
                    $image = wp_get_attachment_image_url($posterImage, 'full'); //Use poster image
                    videoLiteImage($image);
                    return;
                }else{
                    //No poster image supplied, therefore we must use vimeo API to call for one
                    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoURL.php"));
                    videoLiteImage($hash[0]['thumbnail_medium']);
                    return;
                }
            endif;

            if($posterImage):
                $posterImage = "poster='".wp_get_attachment_image_url($posterImage, 'full')."'";
            endif;
            ?>
            <div class="media-container video-media-container<?php if(!$allowAspect): ?> no-aspec <?php endif; ?> ">
                <div 
                style="<?php if($videoAspect): echo 'aspect-ratio:'.$videoAspect.';'; endif; ?>" 
                class="vimeo-player" 
                data-vimeo-id="<?php echo $videoURL; ?>" 
                data-vimeo-loop="true"
                data-vimeo-autoplay="<?php echo $autoPlay; ?>"
                data-vimeo-muted="<?php echo $muted; ?>"
                data-vimeo-controls="<?php echo $controls; ?>"
                ></div>
            </div>
            <?php
            
            //Handle ajax request reload
            if($ajax){
                ?><script>initializeVimeoPlayers();</script><?php
            }

        endif; 
    endif; 
}

//Function used to return image if mobileLite enabled 
function videoLiteImage($image){
?>
<img src="<?php echo $image; ?>" class="object-fit no-aspec media-container" alt="">
<?php
}