<?php

//Media Component 
function block_buttons($field, $opts = [] ){


    //Exit early if field set is not defined 
    if(!isset($field)){
        return;
    }
    $single = false;
    //Check if we are using the Buttons array
    if(isset($field['buttons'])){
        //Check if buttons have been added
        if(is_array($field)){
            //Set our root field 
            $root_field = $field['buttons'];
        }else{
            return;
        }
    }else{
        $single = true;
        //Set our root field 
        $root_field = $field['link'];
    }

    $aos = isset($opts['aos']) ? $opts['aos'] : false; //AOS Options
    $aos_delay = isset($opts['aos_delay']) ? $opts['aos_delay'] : false; //AOS Options Delay
    $class = isset($opts['class']) ? $opts['class'] : false; //AOS Options
    $data = isset($opts['data']) ? $opts['data'] : false; //AOS Options
    $type = isset($opts['type']) ? $opts['type'] : false; //AOS Options
    $linkButtons = isset($opts['link-buttons']) ? $opts['link-buttons'] : true; //Output button links

    

    if(!$single): 
        if( is_array($root_field) ): ?>
            <div class="buttons <?php if($class): echo $class; endif;?>" <?php if($aos): echo 'data-aos="true"'; if($aos_delay): echo 'data-aos-delay="'.$aos_delay.'"'; endif; endif; ?>>
                <?php $buttonCount = 1;
                foreach ( $root_field as $button ) : ?>
                    <?php
                    $class = $button['button_type'];
                    $link = $button['link_field_link'];
                    $sevenrooms = $button['open_sevenrooms'];
                    if($sevenrooms):
                        $sevenroomsID = $button['restaurant_name'];
                        $sevenroomsTrigger = uniqid();
                        ?>
                         <div class="button <?php echo $class; ?>" id="<?php echo $sevenroomsTrigger; ?>">
                                <?php echo linkField( $link, 'text' ); ?>
                        </div>
                        <script src=https://www.sevenrooms.com/widget/embed.js></script>
                        <script>
                        SevenroomsWidget.init({
                            venueId: "<?php echo $sevenroomsID; ?>",
                            triggerId: "<?php echo $sevenroomsTrigger; ?>", // id of the dom element that will trigger this widget
                            type: "reservations", // either 'reservations' or 'waitlist' or 'events'
                            clientToken: "" //(Optional) Pass the api generated clientTokenId here
                        })
                        </script>

                        <?php
                    else: 
                        if( isLink( $link ) ):
                            if($linkButtons):
                                button_template($link, $class);
                            else: ?>
                                <div 
                                    class="button <?php echo $class; ?>">
                                    <?php echo linkField( $link, 'text' ); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php $buttonCount++; endforeach; ?>
            </div>
        <?php endif; 
    else:
        ?>
        <?php
        $link = $root_field;

        if( isLink( $link ) ):
            button_template($link, $class, $type, $data);
        endif;
    endif; 

}
function button_template($link = [], $class = false, $type = false, $data = false, $aos = false, $aos_delay = false){
    ?>
    <?php if(linkField( $link, 'url' )): ?>
        <a class="button <?php echo $class; ?> <?php echo $type; ?>" href="<?php echo linkField( $link, 'url' ); ?>" <?php echo linkField( $link, 'target' ); ?> <?php echo $data; ?> <?php if($aos): echo 'data-aos="true"'; if($aos_delay): echo 'data-aos-delay="'.$aos_delay.'"'; endif; endif; ?>>
            <?php echo linkField( $link, 'text' ); ?>
        </a>
    <?php endif; 

}