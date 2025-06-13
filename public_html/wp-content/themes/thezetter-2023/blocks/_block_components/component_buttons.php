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
                    $meeting = $button['book_a_meeting'];
                    if($sevenrooms):
                        $sevenroomsID = $button['restaurant_name'];
                        $sevenroomsTrigger = uniqid();
                        ?>
                         <div class="button button-opentable <?php echo $class; ?> <?php echo $sevenroomsTrigger; ?>" id="sr-res-root<?php echo $sevenroomsTrigger; ?>" data-button="<?php echo $buttonCount; ?>">
                                <?php echo linkField( $link, 'text' ); ?>
                        </div>
                        <!-- <script src="https://www.sevenrooms.com/widget/embed.js"></script>
                        <script>
                        SevenroomsWidget.init({
                            venueId: "<?php echo $sevenroomsID; ?>",
                            triggerId: "sr-res-root<?php echo $sevenroomsTrigger; ?>", // id of the dom element that will trigger this widget
                            type: "reservations", // either 'reservations' or 'waitlist' or 'events'
                            clientToken: "" //(Optional) Pass the api generated clientTokenId here
                        })
                        </script> -->

                        <!-- Open Table -->
                        <?php
                            if($sevenroomsID == 'theparlouratthezetterclerkenwell'):
                                $loader_rid = '330768';
                                $logo_pid = '63819867';
                            elseif($sevenroomsID == 'theparlouratthezettermarylebone'):
                                $loader_rid = '330780';
                                $logo_pid = '63820019';
                            else:
                                $loader_rid = '';
                                $logo_pid = '';
                            endif; 
                        ?>
                        <div class="open-table-class" data-ot="<?php echo $buttonCount; ?>">
                            <div class="close-open-table"></div>
                            <script type='text/javascript' src='//www.opentable.co.uk/widget/reservation/loader?rid=<?php echo $loader_rid; ?>&type=standard&theme=standard&color=8&dark=false&iframe=true&domain=couk&lang=en-GB&newtab=true&ot_source=Restaurant%20website&font=georgia&ot_logo=standard&primary_color=f2eae6&primary_font_color=333333&button_color=525525&button_font_color=ffffff&logo_pid=<?php echo $logo_pid; ?>&cfe=true'></script>
                        </div>
                        <!-- Open Table -->
                        <?php
                    elseif($meeting):
                        $hotelID = $button['meeting_hotel'];
                        $sevenroomsTrigger = uniqid();
                        ?>
                         <div class="button button-opentable <?php echo $class; ?> <?php echo $sevenroomsTrigger; ?>" id="sr-res-root<?php echo $sevenroomsTrigger; ?>" data-button="<?php echo $buttonCount; ?>">
                                <?php echo linkField( $link, 'text' ); ?>
                        </div>

                        <!-- Events -->
                        <?php
                            if($hotelID == 'clerkenwell'):
                                $meeting_id = '682721';
                            else:
                                $sevenroomsID = '';
                            endif; 
                        ?>
                        <div class="open-table-class" data-ot="<?php echo $buttonCount; ?>">
                            <div class="close-open-table"></div>
                            <div id="mp-widget" class="horizontal"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    var s = document.createElement("script");
                                    s.src = "https://meetingpackage.com/whitelabel/simplewidget/<?php echo $meeting_id; ?>/en";
                                    document.body.appendChild(s);
                                });
                            </script>
                        </div>
                        <!-- Events -->
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