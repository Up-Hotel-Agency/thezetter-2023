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
<form action="#" id="booking-mask" target="_blank"
    <?php $curBlog = get_current_blog_id(); switch_to_blog( $curBlog ); ?>
    data-url="<?php echo get_bloginfo( 'url' ); ?>/book" data-site="<?php the_field('location_name_id', 'options'); ?>" data-property-id="<?php the_field('booking_property_id', 'options'); ?>"
    class="js-booking-mask booking-mask flex flex-col theme--default" data-aos="fade-up"
    >
    <div class="logo">
        <?php if(get_field('side_menu_logo', 'options')): ?>
            <?php echo file_get_contents( get_field('header_logo', 'options') ); ?>
        <?php endif; ?>
    </div>
    <h2><?php _e('Reserve A Room', 'zetter'); ?></h2>
    <?php if($curBlog != 1):?>
        <div class="input-wrap location-select <?php if($curBlog != 1):?> active <?php endif; ?>">
            <label class="body-m mb-0"><?php _e('Destination', 'zetter'); ?></label>
            <div class="sidebar-booking-dots"></div>
            <div class="error-message">*Select a destination</div>
            <div class="location-drop-down">
                <span class="location-display body-l"><?php if($curBlog == 1): _e('Choose Location', 'zetter'); else: echo get_bloginfo('name'); endif; ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>caret-down</title><g class="caret-down"><polyline class="arrowhead" points="36.036 18.982 24 31.018 11.964 18.982" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></g></svg>
                <div class="location-selector-inner js-location-selector-up">
                    <?php
                    switch_to_blog( 1 );
                    while ( have_rows('hotels', 'options') ) : the_row(); ?>
                            <a href="#" class="" data-site="<?php the_sub_field('hotel_unique_id', 'options'); ?>" data-property-id="<?php the_sub_field('booking_id', 'options'); ?>" data-url="<?php echo get_sub_field( 'homepage_url', 'options' ); ?>/book"><?php echo get_sub_field( 'hotel_name', 'options' ); ?></a>
                    <?php endwhile; restore_current_blog();?>                
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="input-wrap location-select hide active mb-0">
            <div class="location-drop-down">
                <div class="location-selector-inner js-location-selector-up">
                    <a href="#" class="" data-site="all" data-property-id="all" data-url="<?php echo get_sub_field( 'homepage_url', 'options' ); ?>/book"><?php echo get_sub_field( 'hotel_name', 'options' ); ?></a>              
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="dates-fields flex">
        <label class="body-m mb-0">Dates</label>
        <div class="sidebar-booking-dots"></div>
        <div class="dates">
            <div class="date-field check-in-field flex items-center">
                <p class="no-margin js-check-in-display body-l">
                    <?php echo date('D d M'); ?>
                </p>
                <input aria-label="Check In" type="date" class="hidden xs:block js-arrive-input" name="arrival" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" />
            </div>
            <svg viewBox="0 0 14 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.5 5C10.7 4.57 10.89 4.2 11.08 3.88H0V3.04H11.08C10.89 2.81 10.7 2.54 10.5 2.22C10.31 1.9 10.12 1.53 9.92 1.12H10.62C11.46 2.09 12.34 2.81 13.26 3.28V3.64C12.34 4.09 11.46 4.81 10.62 5.8H9.92Z" fill="currentColor"/>
            </svg>
            <div class="date-field check-out-field flex items-center">
                <p class="no-margin js-check-out-display body-l">
                    <?php echo date('D d M', strtotime('tomorrow')); ?>
                </p>
                <input aria-label="Check Out" type="date" class="hidden xs:block js-departure-input" name="departure" value="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" />
            </div>
            <div class="js-datepicker-trigger datepicker-trigger xs:hidden"></div>
        </div>
    </div>
    <div class="rooms-guests-fields flex flex-col justify-between">
        <div class="selector-wrap flex justify-between mb-6" data-max="4" data-min="1">
            <input type="hidden" class="js-count-rooms" name="rooms" value="1" />
            <label class="body-m mb-0">Rooms</label>
            <div class="sidebar-booking-dots"></div>
            <div class="selector flex items-center justify-between mb-2">
                <div class="buttons">
                    <button class="selector-control minus button icon secondary size-xs no-margin disabled">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <title>minus</title>
                        <path d="M3.33331 10H16.6666" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <p class="body-l mb-0">0<span class="selector-value text-center">1</span></p>
                <div class="buttons">
                    <button class="selector-control plus button icon secondary size-xs no-margin">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <title>plus</title>
                        <path d="M10 16.6667V3.33334" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.33331 10H16.6666" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>                   
                    </button>
                </div>
            </div>
        </div>
        <div class="selector-wrap flex justify-between mb-6" data-max="4" data-min="1">
            <input type="hidden" class="js-count-adults" name="adults" value="2" />
            <label class="body-m mb-0">Guests</label>
            <div class="sidebar-booking-dots"></div>
            <div class="selector flex items-center justify-between mb-2">
                <div class="buttons">
                    <button class="selector-control minus button icon secondary size-xs no-margin">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <title>minus</title>
                        <path d="M3.33331 10H16.6666" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>            
                    </button>
                </div>
                <p class="body-l mb-0">0<span class="selector-value text-center">2</span></p>
                <div class="buttons">
                    <button class="selector-control plus button icon secondary size-xs no-margin">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <title>plus</title>
                        <path d="M10 16.6667V3.33334" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.33331 10H16.6666" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>                
    </div>
    <button type="submit" class="button primary">
        Check Availability
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.15799 6.315L14.842 12L9.15799 17.685" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
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