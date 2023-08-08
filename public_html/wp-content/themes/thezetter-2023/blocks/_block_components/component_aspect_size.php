<?php

//Size / Aspect Ratio Capture  
function media_size($size, $defaultAspect, $allowAspect = false){

    $aspectSelect = $size['aspect_ratio'];

    //If we have allowed aspec ratio changes for this request
    if(!$allowAspect){
        $values['aspectRatio'] = false;
        $values['fit'] = "cover";
        return $values;
    }

    //If a default aspect has been defined the use that else use natural (as fallback)
    if($aspectSelect == "default"):
        if($defaultAspect):
        $aspectSelect = $defaultAspect;
        else:
            $aspectSelect = "natural";
        endif; 
    endif;

    if($aspectSelect == "natural"):
        $aspectRatio = false;
        $fit = "cover"; //default to cover 
    else:
        //Capture custom aspect or use selected value
        if($aspectSelect == "custom"):
            $aspectRatio = $size['custom_ratio_x']." / ".$size['custom_ratio_y'];
        else:
            $aspectRatio = $aspectSelect;
        endif;
            $orientation = $size['orientation'];
            $fit = $size['fit'];

            //Change aspect orientation 
            if($orientation == "portrait"){
                $parts = explode('/', $aspectRatio);
                $aspectRatio = $parts[1] . '/' . $parts[0];
            }
    endif; 
    
    $values['aspectRatio'] = $aspectRatio;
    $values['fit'] = $fit;

    return $values;
}