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
    data-url="<?php echo get_bloginfo( 'url' ); ?>/book" data-site="<?php the_field('location_name_id', 'options'); ?>" data-property-id="<?php the_field('booking_property_id', 'options'); ?>"
    class="js-booking-mask booking-mask flex flex-col theme--default" data-aos="fade-up"
    >
    <div class="logo">
        <?php echo file_get_contents( get_field('header_logo', 'options') ); ?>
    </div>
    <h2><?php _e('Reserve A Room', 'zetter'); ?></h2>
    <div class="input-wrap location-select input-styled <?php if($curBlog != 1):?> active <?php endif; ?>">
        <label class="size-l"><?php _e('Destination', 'zetter'); ?></label>
        <div class="error-message">*Select a destination</div>
        <div class="location-drop-down">
            <span class="location-display size-xs"><?php if($curBlog == 1): _e('Choose Location', 'zetter'); else: echo get_bloginfo('name'); endif; ?></span>
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-down</title><g class="caret-down"><polyline class="arrowhead" points="36.036 18.982 24 31.018 11.964 18.982" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
            
            <div class="location-selector-inner js-location-selector-up">
                <?php
                switch_to_blog( 1 );
                while ( have_rows('hotels', 'options') ) : the_row(); ?>
                        <a href="#" class="" data-site="<?php the_sub_field('hotel_unique_id', 'options'); ?>" data-property-id="<?php the_sub_field('booking_id', 'options'); ?>" data-url="<?php echo get_sub_field( 'homepage_url', 'options' ); ?>/book"><?php echo get_sub_field( 'hotel_name', 'options' ); ?></a>
                <?php endwhile; restore_current_blog();?>                
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
            <label class="size-l mb-5">Number of Guests</label>
            <div class="selector flex items-center justify-between mb-2">
                <div class="buttons">
                    <button class="selector-control minus button icon secondary size-xs no-margin"><svg fill="none" height="11" viewBox="0 0 11 11" width="11" xmlns="http://www.w3.org/2000/svg"><title>minus</title><g fill="#525535"><path d="m3.75 6v-1h3.5v1z"/><path clip-rule="evenodd" d="m5.5 10c2.48528 0 4.5-2.01472 4.5-4.5s-2.01472-4.5-4.5-4.5-4.5 2.01472-4.5 4.5 2.01472 4.5 4.5 4.5zm0 1c3.03757 0 5.5-2.46243 5.5-5.5s-2.46243-5.5-5.5-5.5-5.5 2.46243-5.5 5.5 2.46243 5.5 5.5 5.5z" fill-rule="evenodd"/></g></svg></button>
                </div>
                <span class="size-xs">0<span class="selector-value text-center">2</span></span>
                <div class="buttons">
                    <button class="selector-control plus button icon secondary size-xs no-margin"><svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"><title>plus</title><path d="M5.0061 7.75V5.98606H3.25V5.0061H5.0061V3.25H5.9939V5.0061H7.75V5.98606H5.9939V7.75H5.0061Z" fill="#525535"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10C7.98528 10 10 7.98528 10 5.5C10 3.01472 7.98528 1 5.5 1C3.01472 1 1 3.01472 1 5.5C1 7.98528 3.01472 10 5.5 10ZM5.5 11C8.53757 11 11 8.53757 11 5.5C11 2.46243 8.53757 0 5.5 0C2.46243 0 0 2.46243 0 5.5C0 8.53757 2.46243 11 5.5 11Z" fill="#525535"/> </svg></button>
                </div>
            </div>
        </div>        
        <div class="selector-wrap flex flex-col items-start justify-between mb-6 input-styled" data-max="4" data-min="1">
            <input type="hidden" class="js-count-rooms" name="rooms" value="1" />
            <label class="size-l mb-5">Number of Rooms</label>
            <div class="selector flex items-center justify-between mb-2">
                <div class="buttons">
                    <button class="selector-control minus button icon secondary size-xs no-margin disabled"><svg fill="none" height="11" viewBox="0 0 11 11" width="11" xmlns="http://www.w3.org/2000/svg"><title>minus</title><g fill="#525535"><path d="m3.75 6v-1h3.5v1z"/><path clip-rule="evenodd" d="m5.5 10c2.48528 0 4.5-2.01472 4.5-4.5s-2.01472-4.5-4.5-4.5-4.5 2.01472-4.5 4.5 2.01472 4.5 4.5 4.5zm0 1c3.03757 0 5.5-2.46243 5.5-5.5s-2.46243-5.5-5.5-5.5-5.5 2.46243-5.5 5.5 2.46243 5.5 5.5 5.5z" fill-rule="evenodd"/></g></svg></button>
                </div>
                <span class="size-xs">0<span class="selector-value text-center">1</span></span>
                <div class="buttons">
                    <button class="selector-control plus button icon secondary size-xs no-margin"><svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"><title>plus</title><path d="M5.0061 7.75V5.98606H3.25V5.0061H5.0061V3.25H5.9939V5.0061H7.75V5.98606H5.9939V7.75H5.0061Z" fill="#525535"/> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10C7.98528 10 10 7.98528 10 5.5C10 3.01472 7.98528 1 5.5 1C3.01472 1 1 3.01472 1 5.5C1 7.98528 3.01472 10 5.5 10ZM5.5 11C8.53757 11 11 8.53757 11 5.5C11 2.46243 8.53757 0 5.5 0C2.46243 0 0 2.46243 0 5.5C0 8.53757 2.46243 11 5.5 11Z" fill="#525535"/> </svg></button>
                </div>
            </div>
        </div>

        
    </div>
    <button type="submit" class="button primary">
        Check Availability
    </button>
</form>
<div class="bookingmask-footer flex flex-row">
    <?php if(get_field('booking_mask_content', 'options')): ?>
        <div class="bookingmask-footer-content">
            <?php the_field('booking_mask_content', 'options'); ?>
        </div>
    <?php endif; ?>
    <?php if(get_field('side_menu_logo', 'options')): ?>
        <div class="bookingmask-footer-image">
            <?php echo file_get_contents( get_field('side_menu_logo', 'options') ); ?>
        </div>
    <?php endif; ?>
</div>