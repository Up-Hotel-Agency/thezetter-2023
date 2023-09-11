
 <?php echo get_field('activate_exit_capture', ''); ?>

<?php $options = "options"; ?>
<?php if( get_field('activate_exit_capture')): $options = ""; endif; ?>
<?php if( get_field('activate_exit_capture', $options) ): ?>
    <div class="
            exitcapture-modal js-exitcapture-modal
            <?php if( !get_field('aggressive_exit_capture',$options) ): ?>js-session-cookie<?php endif; ?>
        "
    >
        <div class="exitcapture-container flex items-center justify-center">
            <div class="exitcapture-overlay js-exitcapture-close"></div>
            <div class="modal flex text-center<?php if( get_field('exit_capture_img',$options) ): ?> has-image<?php endif; ?>">
                <a class="exitcapture-close js-exitcapture-close button size-s no-margin" data-dismiss="modal" title="Close modal" id="event-exitcapture-close">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245L19.245 4.755"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.245 19.245L4.755 4.755"/></svg>
                </a>
                <?php if( get_field('exit_capture_img',$options) ): ?>
                    <div class="modal-img img-abs">
                        <?php echo img_sizes(get_field('exit_capture_img',$options), ['default' => 'img_800', 'page_area' => '26', 'mobile_page_area' => '85', 'lazy_load' => true]); ?>
                    </div>
                <?php endif; ?>
                <div class="modal-content">
                    <h3 class="color-accent"><?php the_field('exit_capture_title', $options); ?></h3>
                    <div class="mb-8">
                        <?php the_field('exit_capture_content', $options); ?>
                    </div>
                    <?php if( get_field('display_exit_capture_countdown',$options) && get_field('exit_capture_countdown',$options) ): ?>
                        <div class="countdown flex justify-center items-center mb-8 js-conversion-tools-countdown" data-countdown-date="<?php the_field('exit_capture_countdown', $options); ?>">
                            <div class="countdown-inner flex justify-center items-center">
                                <div class="countdown-item js-conversion-tools-countdown-days">d</div>
                                <div class="countdown-item js-conversion-tools-countdown-hours">h</div>
                                <div class="countdown-item js-conversion-tools-countdown-minutes">m</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php block_buttons(get_field('exit_capture_button_link', $options), [
                        'class' => 'button no-margin',
                        'type'  => 'primary'
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $options = "options"; ?>
<?php if( get_field('activate_slide_callout')): $options = ""; endif; ?>
<?php if( get_field('activate_slide_callout',$options) ): ?>
    <div class="
        slide-callout js-slide-callout
        <?php if( !get_field('aggressive_slide_callout',$options) ): ?>js-session-cookie<?php endif; ?>
        "
    >
        <div class="slide-callout-title flex justify-between">
            <h3 class="h5 flex-grow no-margin"><?php the_field('slide_callout_title', $options); ?></h3>
            <a href="#" class="js-slide-callout-close slide-callout-close flex justify-center items-center" id="event-slidecallout-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20L12 4"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 12L20 12"/></svg>
            </a>
        </div>
        <div class="slide-callout-inner">
            <?php if( get_field('slide_callout_content_type',$options) == 'content' ): ?>
                <p class="size-s no-margin"><?php the_field('slide_callout_long_content',$options); ?></p>
            <?php endif; ?>
            <?php if( get_field('slide_callout_content_type',$options) == 'list' ): ?>
                <p class="size-s no-margin"><?php the_field('slide_callout_short_content',$options); ?></p>
                <?php if( have_rows('slide_callout_list', $options) ): ?>
                    <ul class="unstyled no-margin">
                        <?php while ( have_rows('slide_callout_list', $options) ) : the_row(); ?>
                            <li class="flex items-center"><svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.282 13.298L8.229 18.245 20.718 5.755"/></svg><?php the_sub_field('title'); ?></li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>
            <?php block_buttons(get_field('slide_callout_button_link', $options), [
                'class' => 'button no-margin',
                'type'  => 'primary'
            ]); ?>
        </div>
    </div>
<?php endif; ?>

<?php $options = "options"; ?>
<?php if( get_field('activate_highlight_bar')): $options = ""; endif; ?>
<?php if( get_field('activate_highlight_bar',$options) ): ?>
    <div class="
        highlight-bar js-highlight-bar theme--dark
        <?php if( !get_field('aggressive_highlight_bar',$options) ): ?>js-session-cookie<?php endif; ?>
        "
    >
        <div class="flex xs:items-center xs:justify-between">
            <div class="highlight-bar-inner flex items-center justify-center xs:flex-wrap text-center flex-grow xs:text-left xs:justify-start">
                <h3 class="h4 no-margin xs:size-s"><?php the_field('highlight_bar_title',$options); ?></h3>
                <?php if( get_field('display_highlight_bar_countdown',$options) && get_field('highlight_bar_countdown',$options) ): ?>
                    <div class="countdown flex justify-center items-center flex-shrink-0 js-conversion-tools-countdown" data-countdown-date="<?php the_field('highlight_bar_countdown', $options); ?>">
                        <div class="countdown-inner flex justify-center items-center">
                            <div class="countdown-item js-conversion-tools-countdown-days">d</div>
                            <div class="countdown-item js-conversion-tools-countdown-hours">h</div>
                            <div class="countdown-item js-conversion-tools-countdown-minutes">m</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php block_buttons(get_field('highlight_bar_button_link', $options), [
                'class' => 'button no-margin',
                'type'  => 'primary'
            ]); ?>
            <a href="#" class="highlight-bar-close js-highlight-bar-close flex items-center justify-center" id="event-highlightbar-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245L19.245 4.755"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.245 19.245L4.755 4.755"/></svg>
            </a>
        </div>
    </div>
<?php endif; ?>
<?php $options = "options"; ?>

<?php if( get_field('activate_exit_capture',$options) || get_field('activate_slide_callout',$options) || get_field('activate_highlight_bar',$options) || get_field('activate_exit_capture') || get_field('activate_slide_callout') || get_field('activate_highlight_bar') ):
    // only load the cookie library if conversion tools are activated
    wp_enqueue_script( 'cookie-js', get_template_directory_uri() . '/assets/js/js.cookie.min.js' );
    wp_enqueue_script( 'conversion-tools-js', get_template_directory_uri() . '/src/js/conversion_tools.js' );
    wp_enqueue_style( 'conversion-tools', get_template_directory_uri() . '/assets/css/conversion_tools.css' );
endif; ?>