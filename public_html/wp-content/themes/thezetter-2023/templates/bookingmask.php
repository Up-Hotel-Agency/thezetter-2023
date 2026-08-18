<form action="#" class="js-booking-mask booking-mask flex sm:flex-col<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>" data-aos="fade-up">
    <div class="bm-field locations-field">
        <div class="">
            <p class="no-margin">
                <strong class="size-xs color-body-50 block">Location</strong>
                <div class="hotel-select" name="hotel-id" >
                <?php if(get_current_blog_id() == 1):?>
                    <span class="js-location-display">Find Location</span>
                    <input type="hidden" class="js-hotel-id" name="hotel" value="0" data-property-id="0" />
                <?php else: ?>
                    <span class="js-location-display"><?php echo get_bloginfo( 'name' ); ?></span>
                    <input type="hidden" class="js-hotel-id"  data-property-id="<?php the_field('booking_property_id', 'options'); ?>" name="hotel" value="<?php echo get_current_blog_id(); ?>" />
                <?php endif; ?>
            </div>

            </p>
            <input aria-label="location" type="text" class="hidden xs:block js-location-input" name="location" value=""/>
        </div>
    </div>
    <div class="bm-field dates-fields flex no-margin">
        <div class="date-field check-in-field flex items-center">
            <p class="no-margin">
                <strong class="size-xs color-body-50 block">Check In / Check Out</strong>
                <span class="js-check-in-display">Add Dates</span>
                <span> - </span>
                <span class="js-check-out-display"></span>
            </p>
            <input aria-label="Check In" type="date" class="hidden xs:block js-arrive-input" name="arrival" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" />
            <input aria-label="Check Out" type="date" class="hidden xs:block js-departure-input" name="departure" value="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" />
            <div class="js-datepicker-trigger datepicker-trigger xs:hidden"></div>
        </div>
    </div>
    <div class="bm-field rooms-guests-fields flex no-margin">
        <div class="rooms-guests flex items-center js-rooms-guests-trigger">
            <p class="no-margin size-xs">
                <strong class="color-body-50 block mb-1">Rooms / Guests</strong>
                <span class="js-rooms-display">1 Room</span>, <span class="js-adults-display">2 Adults</span>, <span class="js-children-display">1 Child</span>
            </p>
        </div>
        <div class="rooms-guests-select theme--default">
            <div class="select-inner">
                <div class="selector-wrap flex items-center justify-between mb-6" data-max="4" data-min="1">
                    <input type="hidden" class="js-count-rooms" name="rooms" value="1" />
                    <p class="no-margin"><strong>Rooms</strong></p>
                    <div class="selector flex items-center">
                        <button class="selector-control minus button icon secondary size-s no-margin disabled"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>minus</title><g class="minus"><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                        <span class="selector-value text-center">1</span>
                        <button class="selector-control plus button icon secondary size-s no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>plus</title><g class="plus"><line class="line-vertical" x1="24" y1="40" x2="24" y2="8" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                    </div>
                </div>
                <div class="selector-wrap flex items-center justify-between mb-6" data-max="4" data-min="1">
                    <input type="hidden" class="js-count-adults" name="adults" value="2" />
                    <p class="no-margin"><strong>Adults</strong></p>
                    <div class="selector flex items-center">
                        <button class="selector-control minus button icon secondary size-s no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>minus</title><g class="minus"><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                        <span class="selector-value text-center">2</span>
                        <button class="selector-control plus button icon secondary size-s no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>plus</title><g class="plus"><line class="line-vertical" x1="24" y1="40" x2="24" y2="8" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                    </div>
                </div>
                <div class="selector-wrap flex items-center justify-between mb-6" data-max="4" data-min="0">
                    <input type="hidden" class="js-count-children" name="children" value="1" />
                    <p class="no-margin"><strong>Children</strong><br>
                        <span class="size-xs">Ages 0–12</span>
                    </p>
                    <div class="selector flex items-center">
                        <button class="selector-control minus button icon secondary size-s no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>minus</title><g class="minus"><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                        <span class="selector-value text-center">1</span>
                        <button class="selector-control plus button icon secondary size-s no-margin"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48"><title>plus</title><g class="plus"><line class="line-vertical" x1="24" y1="40" x2="24" y2="8" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><line class="line-horizontal" x1="8" y1="24" x2="40" y2="24" stroke-width="3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/></g></svg></button>
                    </div>
                </div>
                <footer class="flex justify-end">
                    <a href="#" class="rooms-guests-close">Confirm</a>
                </footer>
            </div>
        </div>
    </div>
    <button type="submit" class="bm-field bm-field-button primary theme--image">Check Availability</button>
    <div class="hotel-selector theme--default">
        <?php 
            $sites = get_sites();
            $hotel_logo = '';
            foreach ($sites as $site) {
                if ($site->blog_id != 1){
                    switch_to_blog($site->blog_id);
                        echo '<div class="hotel" data-hotel-id=" ' . get_field('booking_property_id', 'options') .' " data-hotel-name=" ' . get_bloginfo('name') .' ">';
                        echo '<div class="hotel-title">' . get_bloginfo('name') . '</div></div>';
                    restore_current_blog();
                }
            }  
        ?>
    </div>
</form>