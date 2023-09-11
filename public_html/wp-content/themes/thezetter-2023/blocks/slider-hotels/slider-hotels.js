// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";
jQuery(function($){

    $(".js-slider-hotels").each(function(){
        $(this).not('.slick-initialized').slick({
            arrows: false,
            infinite: true,
            adaptiveHeight: false,
            speed: 700,
            cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
            focusOnSelect: false,
            pauseOnHover: false,
            fade: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 5000,
            rows: 0,
            dots: true,
            appendDots: $(this).parent().find('.slick-controls .hotel-slider-dots')
        });
    });

    $('.js-img-next-hotel-slider').click(function(e) {
        e.preventDefault();
        $(this).parent().parents().find('.slide-hotels-img .js-slider-hotels').slick('slickNext');
    });
    $('.js-img-prev-hotel-slider').click(function(e) {
        e.preventDefault();
        $(this).parent().parents().find('.slide-hotels-img .js-slider-hotels').slick('slickPrev');
    });
    
    $(".hotel-list-item").hoverIntent(function() {
        $(this).addClass('item-active');
        var hotelID = $(this).attr('data-hotel');
        $('.hotels-list').addClass('items-hovered');
        $(this).parents().find('.slide-hotels-block .js-slider-hotels').slick('slickGoTo', hotelID);
    }, function(){
        $('.hotels-list').removeClass('items-hovered');
        $('.hotel-list-item').removeClass('item-active');
    });
    $('.hotel-list-item').mouseleave(function () {
        $(this).parents().find('.slide-hotels-block .js-slider-hotels').slick('slickGoTo', 0);
    });

});