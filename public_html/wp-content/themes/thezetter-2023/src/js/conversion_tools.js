// set the global variables here for JSLint
/*global AOS, jQuery, objectFitImages, window, console, document, ajaxurl, setTimeout, navigator */
"use strict";

jQuery(function($){
    $(document).ready(function(){
        // exit capture
        if( $('.js-exitcapture-modal').length ) {
            if (!Cookies.get('hide-exitcapture')) {
                setTimeout(function() {
                    $('.js-exitcapture-modal').fadeIn();
                }, 500);

                // GTM event on display of exit capture
                if( $('.js-exitcapture-modal').length ) {
                    window.dataLayer.push({
                        'event': 'Exit Capture Display',
                        'category': 'sweetnr',
                        'label': 'Exit Capture',
                        'action': 'display'
                    });
                }
            }
          
            $(".js-exitcapture-close").click(function (e) {
                e.preventDefault();
                $(".js-exitcapture-modal").fadeOut();

                if( $('.js-exitcapture-modal').hasClass('js-session-cookie') ) {
                    Cookies.set('hide-exitcapture', true);
                }
            });
        }

        // slide callout
        if( $('.js-slide-callout').length ) {
            if (!Cookies.get('hide-slidecallout')) {
                setTimeout(function() {
                    $('.js-slide-callout').fadeIn();
                }, 500);

                // GTM event on display of slide callout
                if( $('.js-slide-callout').length ) {
                    window.dataLayer.push({
                        'event': 'Slide Callout Display',
                        'category': 'sweetnr',
                        'label': 'Slide Callout',
                        'action': 'display'
                    });
                }
            }
          
            $(".js-slide-callout-close").click(function (e) {
                e.preventDefault();
                $(".js-slide-callout").fadeOut();

                if( $('.js-slide-callout').hasClass('js-session-cookie') ) {
                    Cookies.set('hide-slidecallout', true);
                }
            });
        }

        // highlight bar
        if( $('.js-highlight-bar').length ) {
            if (!Cookies.get('hide-highlightbar')) {
                setTimeout(function() {
                    $('.js-highlight-bar').fadeIn();
                }, 500);

                // GTM event on display of highlight bar
                if( $('.js-highlight-bar').length ) {
                    window.dataLayer.push({
                        'event': 'Highlight Bar Display',
                        'category': 'sweetnr',
                        'label': 'Highlight Bar',
                        'action': 'display'
                    });
                }
            }
          
            $(".js-highlight-bar-close").click(function (e) {
                e.preventDefault();
                $(".js-highlight-bar").fadeOut();

                if( $('.js-highlight-bar').hasClass('js-session-cookie') ) {
                    Cookies.set('hide-highlightbar', true);
                }
            });
        }
    });

    function modalTimer() {
        $('.js-conversion-tools-countdown').each(function(){
            var endTime = new Date( $(this).attr('data-countdown-date') );
            endTime = (Date.parse(endTime) / 1000);

            var now = new Date();
            now = (Date.parse(now) / 1000);

            if(endTime < now){
                $(this).find(".countdown-inner").css('display','none');
            }

            var timeLeft = endTime - now;

            var days = Math.floor(timeLeft / 86400); 
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);

            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }

            $(this).find(".js-conversion-tools-countdown-days").html(days + "<span>d</span>");
            $(this).find(".js-conversion-tools-countdown-hours").html(hours + "<span>h</span>");
            $(this).find(".js-conversion-tools-countdown-minutes").html(minutes + "<span>m</span>");
        });
    }
    
    if( $('.js-conversion-tools-countdown').length ) {
        setInterval(function() { 
            modalTimer(); 
        }, 1000);
    }
});