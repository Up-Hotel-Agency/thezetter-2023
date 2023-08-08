// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

jQuery(function($){
    $(".js-gallery-carousel").each(function(){
        $(this).not('.slick-initialized').slick({
            arrows: false,
            infinite: true,
            adaptiveHeight: false,
            speed: 500,
            cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
            focusOnSelect: false,
            slidesToScroll: 1,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true,
            autoplay: false,
            rows: 0,
            dots: true,
            customPaging : function(slider, i) {
            var thumb = $(slider.$slides[i]).data();
            return '<a class="dot">'+i+'</a>';}
        });
    });

    $('.js-gallery-prev').click(function(e) {
        e.preventDefault();
        $(this).parents('.row').find('.js-gallery-carousel').slick('slickPrev');
    });
    $('.js-gallery-next').click(function(e) {
        e.preventDefault();
        $(this).parents('.row').find('.js-gallery-carousel').slick('slickNext');
    });
});