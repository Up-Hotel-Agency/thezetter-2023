<?php
  $curBlog = get_current_blog_id();
  $sites = get_sites(array(
    'site__not_in' => array(
      1,
    ),
  ));
  $mainSite = get_sites(array(
    'site__in' => array(
      1,
    ),
  ));
?>
<form action="#" id="booking-mask" 
    <?php $curBlog = get_current_blog_id(); switch_to_blog( $curBlog ); ?>
    data-url="<?php echo get_bloginfo( 'url' ); ?>/book" data-property-id="<?php the_field('booking_property_id', 'options'); ?>" 
    class="js-booking-mask booking-mask flex flex-col theme--default" data-aos="fade-up"
    >
    <div class="logo">
        <!--Change on server!!  -->
        <!-- <?php //echo file_get_contents( get_field('header_logo', 'options') ); ?> -->
        <svg class="up-core-logo" width="159" height="45" viewBox="0 0 159 45" fill="none" xmlns="http://www.w3.org/2000/svg"><title>Zetter Group logo</title><g clip-path="url(#clip0_521_2438)"> <path d="M0.98234 20.7943V23.8753H15.3977L0 45H21.7227V41.919H6.34814L21.7227 20.7896H0.98234V20.7943ZM36.2215 34.3795H46.0773V31.2799H36.2215V23.9079H46.4202V20.8269H32.774V44.9674H46.7445V41.8864H36.2168V34.3748L36.2215 34.3795ZM86.0566 6.12938C86.0242 6.58083 85.964 6.91126 85.686 7.25101H85.7694C86.1679 7.25101 86.3764 7.21843 86.622 7.21843C87.9333 7.21843 89.189 7.22774 89.935 7.26962C90.0601 6.76699 90.1714 6.21781 90.1714 5.5709C90.1714 5.46851 90.1714 5.35681 90.1621 5.24977C89.8655 5.73379 89.6802 6.03165 89.518 6.25039C89.3558 6.46913 89.1473 6.65064 88.7674 6.70183C88.4893 6.74372 88.2252 6.75303 87.836 6.75303C87.3726 6.75303 87.2429 6.65994 87.1919 6.15731C87.1734 5.95253 87.1502 5.39404 87.1502 5.03568V3.76978C87.4885 3.76978 88.0816 3.77909 88.4106 3.82097C88.8739 3.88148 89.1195 4.06764 89.4578 4.3655V4.26311C89.4578 3.93267 89.4253 3.76047 89.4253 3.52312C89.4253 3.28576 89.4578 3.12287 89.4578 2.80174V2.69004C89.1195 2.9879 88.8739 3.19268 88.4106 3.24853C88.0816 3.2811 87.4977 3.29041 87.1502 3.29041V2.05244C87.1502 1.68011 87.1502 1.31244 87.1826 0.991313C87.2151 0.577102 87.2753 0.497983 87.7572 0.497983C88.0538 0.497983 88.2576 0.507291 88.5171 0.567794C88.721 0.618989 88.9295 0.71207 89.0917 0.874961C89.3373 1.11232 89.5319 1.39156 89.8285 1.81043C89.8377 1.72665 89.8377 1.63357 89.8377 1.55445C89.8377 1.03785 89.7868 0.484021 89.6941 0C89.2956 0.0325783 88.9573 0.0325783 88.5357 0.0325783H86.6266C86.381 0.0325783 86.1771 0 85.774 0H85.6906C85.9686 0.339746 86.0288 0.670183 86.0613 1.12163C86.0937 1.47068 86.0937 1.8942 86.0937 2.25721V4.99845C86.0937 5.35681 86.0937 5.78033 86.0613 6.13404L86.0566 6.12938ZM69.5376 0.898232C69.7137 0.721378 69.9361 0.600372 70.1631 0.558486C70.3902 0.516599 70.5616 0.497983 70.8119 0.497983C71.2938 0.497983 71.354 0.591064 71.3864 1.00062C71.4189 1.32175 71.4189 1.6708 71.4189 2.05244V4.99845C71.4189 5.35681 71.4189 5.78033 71.3864 6.13404C71.354 6.58548 71.2428 6.91592 70.9138 7.25566H70.9972C71.3957 7.25566 71.7062 7.22308 71.9517 7.22308C72.1973 7.22308 72.5078 7.25566 72.897 7.25566H72.9897C72.6514 6.90661 72.5171 6.59479 72.4985 6.13404C72.4892 5.78498 72.48 5.36146 72.48 4.99845V2.05244C72.48 1.6708 72.48 1.32175 72.5124 1.00062C72.5449 0.58641 72.6051 0.497983 73.087 0.497983C73.3326 0.497983 73.5087 0.516599 73.7311 0.558486C73.9581 0.600372 74.1805 0.721378 74.3566 0.898232C74.542 1.07509 74.7551 1.39156 75.0424 1.85697C75.0609 1.6615 75.0609 1.42414 75.0609 1.23798C75.0609 0.763264 75.0285 0.353708 74.9868 0C74.5883 0.0325783 74.2361 0.0325783 73.8191 0.0325783H70.0751C69.6534 0.0325783 69.3059 0.0325783 68.9074 0C68.8657 0.349054 68.8333 0.763264 68.8333 1.23798C68.8333 1.42414 68.8333 1.6615 68.8518 1.85697C69.1391 1.39156 69.3522 1.07509 69.5376 0.898232ZM83.0077 1.12628C83.0262 0.660875 83.1096 0.353708 83.3969 0.00465405H83.3042C82.915 0.00465405 82.6972 0.0372324 82.4609 0.0372324C82.2246 0.0372324 81.9976 0.00465405 81.5991 0.00465405H81.5156C81.7937 0.3444 81.8539 0.674837 81.8863 1.12628C81.9188 1.47533 81.9188 1.89885 81.9188 2.26187V3.18802H78.4528V2.26187C78.4528 1.90351 78.4621 1.47999 78.4713 1.12628C78.4899 0.660875 78.5733 0.353708 78.8605 0.00465405H78.7679C78.3786 0.00465405 78.1609 0.0372324 77.9245 0.0372324C77.6882 0.0372324 77.4751 0.00465405 77.072 0.00465405H76.9885C77.2666 0.3444 77.3268 0.674837 77.3592 1.12628C77.3917 1.47533 77.3917 1.89885 77.3917 2.26187V5.0031C77.3917 5.36146 77.3917 5.78498 77.3592 6.13869C77.3268 6.59013 77.2666 6.92057 76.9885 7.26032H77.072C77.4704 7.26032 77.679 7.22774 77.9245 7.22774C78.1701 7.22774 78.374 7.26032 78.7679 7.26032H78.8605C78.5733 6.91126 78.4899 6.59944 78.4713 6.13869C78.4621 5.78964 78.4528 5.36612 78.4528 5.0031V3.7372H81.9188V5.0031C81.9188 5.36146 81.9188 5.78498 81.8863 6.13869C81.8539 6.59013 81.7937 6.92057 81.5156 7.26032H81.5991C81.9976 7.26032 82.2153 7.22774 82.4609 7.22774C82.7065 7.22774 82.9104 7.26032 83.3042 7.26032H83.3969C83.1096 6.91126 83.0262 6.59944 83.0077 6.13869C82.9984 5.78964 82.9892 5.36612 82.9892 5.0031V2.26187C82.9892 1.90351 82.9984 1.47999 83.0077 1.12628ZM157.726 43.2734C157.221 42.5799 156.549 41.5467 155.71 40.1738C154.376 37.9957 153.342 36.4645 152.61 35.5895C151.873 34.7146 151.123 34.0211 150.354 33.5138C151.665 33.0065 152.666 32.2386 153.37 31.2101C154.07 30.1815 154.422 28.9668 154.422 27.5613C154.422 25.4949 153.708 23.8567 152.277 22.6466C150.845 21.4366 148.912 20.8315 146.48 20.8315H140.451V45.0047H143.899V34.4818H144.798C145.924 34.4818 146.725 34.6122 147.203 34.8728C147.68 35.1334 148.213 35.5569 148.806 36.1433C149.399 36.7298 150.048 37.5209 150.761 38.5123L151.915 40.3971L152.981 42.161L153.653 43.1151C153.755 43.2547 153.824 43.3525 153.861 43.4083L154.908 45H159.009L157.735 43.2687L157.726 43.2734ZM148.792 30.9541C148.143 31.2519 146.948 31.4055 145.201 31.4055H143.89V23.7729H144.923C146.61 23.7729 147.819 23.8985 148.551 24.1545C149.279 24.4105 149.844 24.8433 150.247 25.4623C150.65 26.0813 150.849 26.7701 150.849 27.5287C150.849 28.2873 150.669 28.9901 150.307 29.5951C149.946 30.2001 149.441 30.6516 148.792 30.9541ZM118.381 34.3795H128.237V31.2799H118.381V23.9079H128.58V20.8269H114.934V44.9674H128.904V41.8864H118.377V34.3748L118.381 34.3795ZM84.2773 23.8753H92.5299V45.0047H95.9913V23.8753H104.383V20.7943H84.2773V23.8753ZM56.1324 23.8753H64.3849V45.0047H67.8463V23.8753H76.2379V20.7943H56.1324V23.8753Z" fill="#1A2115"/> </g> <defs> <clipPath id="clip0_521_2438"> <rect width="159" height="45" fill="white"/> </clipPath> </defs> </svg>
    </div>
    <h2><?php _e('Reserve A Room', 'zetter'); ?></h2>
    <div class="input-wrap location-select input-styled">
        <label class="size-l"><?php _e('Destination', 'zetter'); ?></label>
        <div>
            <span class="location-display size-xs"><?php if($curBlog == 1): _e('Choose Location', 'zetter'); else: echo get_bloginfo('name'); endif; ?></span>
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-down</title><g class="caret-down"><polyline class="arrowhead" points="36.036 18.982 24 31.018 11.964 18.982" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
            <div class="location-selector js-location-selector-up">
                <div class="location-selector-inner">
                <?php
                    foreach ( $sites as $site ):
                        switch_to_blog( $site->blog_id ); ?>
                        <a href="#" data-property-id="<?php the_field('booking_property_id', 'options'); ?>" data-url="<?php echo get_bloginfo( 'url' ); ?>/book"><?php echo $site->blogname; ?></a>
                        <?php restore_current_blog();
                    endforeach; ?>                
                </div>
            </div>
        </div>
    </div>
    <div class="dates-fields flex">
        <div class="date-field check-in-field flex items-center input-styled">
            <p class="no-margin">
                <label class="size-l color-body block mb-0">Arrival</label>
                <span class="js-check-in-display size-xs"><?php echo date('D d M'); ?></span>
            </p>
            <input aria-label="Check In" type="date" class="hidden xs:block js-arrive-input" name="arrival" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" />
        </div>
        <div class="date-field check-out-field flex items-center input-styled">
            <p class="no-margin">
                <label class="size-l color-body block mb-0">Departure</label>
                <span class="js-check-out-display size-xs"><?php echo date('D d M', strtotime('tomorrow')); ?></span>
            </p>
            <input aria-label="Check Out" type="date" class="hidden xs:block js-departure-input" name="departure" value="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" />
        </div>
        <div class="js-datepicker-trigger datepicker-trigger xs:hidden"></div>
    </div>
    <div class="rooms-guests-fields flex justify-between mb-10">
        <div class="selector-wrap flex flex-col items-start justify-between mb-6 input-styled" data-max="4" data-min="1">
            <input type="hidden" class="js-count-adults" name="adults" value="2" />
            <label class="size-l mb-0">Number of Guests</label>
            <div class="selector flex items-center justify-between">
                <div class="buttons">
                    <button class="selector-control minus button icon secondary size-xs no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>minus</title><g class="minus"><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                </div>
                <span class="size-xs">0<span class="selector-value text-center">2</span></span>
                <div class="buttons">
                    <button class="selector-control plus button icon secondary size-xs no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>plus</title><g class="plus"><line class="line-vertical" x1="24" y1="40" x2="24" y2="8" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                </div>
            </div>
        </div>        
        <div class="selector-wrap flex flex-col items-start justify-between mb-6 input-styled" data-max="4" data-min="1">
            <input type="hidden" class="js-count-rooms" name="rooms" value="1" />
            <label class="size-l mb-0">Number of Rooms</label>
            <div class="selector flex items-center justify-between">
                <div class="buttons">
                    <button class="selector-control minus button icon secondary size-xs no-margin disabled"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>minus</title><g class="minus"><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                </div>
                <span class="size-xs">0<span class="selector-value text-center">1</span></span>
                <div class="buttons">
                    <button class="selector-control plus button icon secondary size-xs no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>plus</title><g class="plus"><line class="line-vertical" x1="24" y1="40" x2="24" y2="8" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                </div>
            </div>
        </div>

        
    </div>
    <button type="submit" class="button primary">
        Check Availability
    </button>
</form>