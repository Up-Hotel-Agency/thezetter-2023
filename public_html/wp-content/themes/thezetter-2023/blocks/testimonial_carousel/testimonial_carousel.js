// set the global variables here for JSLint
/*global AOS, jQuery, setTimeout, window, $slides */
"use strict";

jQuery(function($){

    $(".js-testimonial-carousel").each(function(){
        $(this).not('.slick-initialized').slick({
            arrows: false,
            infinite: true,
            adaptiveHeight: true,
            speed: 500,
            cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
            focusOnSelect: false,
            slidesToScroll: 1,
            slidesToShow: 1,
            fade: true,
            dots: true,
            autoplay: true,
            autoplaySpeed: 20000,
            rows: 0,
            appendDots: $(this).parents('.row').find(".testimonial-dots")
        });
    });

    $('.js-testimonial-prev').click(function(e) {
        e.preventDefault();
        $(this).parents('.row').find('.js-testimonial-carousel').slick('slickPrev');
    });
    $('.js-testimonial-next').click(function(e) {
        e.preventDefault();
        $(this).parents('.row').find('.js-testimonial-carousel').slick('slickNext');
    });

});