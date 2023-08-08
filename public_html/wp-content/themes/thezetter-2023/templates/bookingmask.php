<form action="#" class="js-booking-mask booking-mask flex sm:flex-col<?php if( get_field('override_page_theme') ): if( $themeField['disable_overlay'] && $themeField['text_colour'] == 'dark' ): ?> theme--default<?php endif; endif; ?>" data-aos="fade-up">
    <div class="dates-fields flex no-margin">
        <div class="date-field check-in-field flex items-center">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3.893" y="5.001" width="16.213" height="15.167" rx=".5" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.906 8.561L20.107 8.561"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.845 3.831L16.845 6.07"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.431 3.831L7.431 6.07"/><circle cx="12.047" cy="11.404" r="1" fill="currentColor"/><circle cx="16.047" cy="11.404" r="1" fill="currentColor"/><circle cx="12.047" cy="14.404" r="1" fill="currentColor"/><circle cx="16.047" cy="14.404" r="1" fill="currentColor"/><circle cx="12.047" cy="17.404" r="1" fill="currentColor"/><circle cx="16.047" cy="17.404" r="1" fill="currentColor"/><circle cx="8.047" cy="14.404" r="1" fill="currentColor"/><circle cx="8.047" cy="17.404" r="1" fill="currentColor"/></svg>
            <p class="no-margin">
                <strong class="size-xs color-body-50 block">Check In</strong>
                <span class="js-check-in-display"><?php echo date('D d M'); ?></span>
            </p>
            <input aria-label="Check In" type="date" class="hidden xs:block js-arrive-input" name="arrival" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" />
        </div>
        <div class="date-field check-out-field flex items-center">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3.893" y="5.001" width="16.213" height="15.167" rx=".5" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.906 8.561L20.107 8.561"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.845 3.831L16.845 6.07"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.431 3.831L7.431 6.07"/><circle cx="12.047" cy="11.404" r="1" fill="currentColor"/><circle cx="16.047" cy="11.404" r="1" fill="currentColor"/><circle cx="12.047" cy="14.404" r="1" fill="currentColor"/><circle cx="16.047" cy="14.404" r="1" fill="currentColor"/><circle cx="12.047" cy="17.404" r="1" fill="currentColor"/><circle cx="16.047" cy="17.404" r="1" fill="currentColor"/><circle cx="8.047" cy="14.404" r="1" fill="currentColor"/><circle cx="8.047" cy="17.404" r="1" fill="currentColor"/></svg>
            <p class="no-margin">
                <strong class="size-xs color-body-50 block">Check Out</strong>
                <span class="js-check-out-display"><?php echo date('D d M', strtotime('tomorrow')); ?></span>
            </p>
            <input aria-label="Check Out" type="date" class="hidden xs:block js-departure-input" name="departure" value="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" />
        </div>
        <div class="js-datepicker-trigger datepicker-trigger xs:hidden"></div>
    </div>
    <div class="rooms-guests-fields flex no-margin">
        <div class="rooms-guests flex items-center js-rooms-guests-trigger">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="8.173" r="4.625" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="M4.345 20.452a7.655 7.655 0 0 1 15.31 0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
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
    <button type="submit" class="button primary">Check Availability</button>
</form>