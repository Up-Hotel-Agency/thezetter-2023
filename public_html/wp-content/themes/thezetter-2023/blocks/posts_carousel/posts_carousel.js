// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

jQuery(function($){
    $(".js-posts-carousel").each(function(){
        $(this).slick({
            centerMode: true,
            centerPadding: '200px',
            arrows: false,
            infinite: true,
            adaptiveHeight: false,
            speed: 600,
            cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
            focusOnSelect: false,
            pauseOnHover: false,
            fade: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            responsive: [
                {
                  breakpoint: 750,
                  settings: {
                    centerPadding: '60px',
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
            ],
            autoplay: true,
            autoplaySpeed: 5000,
            rows: 0,
            dots: true,
            appendDots: $(this).parents('.img-content').find(".img-content-dots")
        });
    });
    $('.js-img-next').click(function(e) {
        e.preventDefault();
        $(this).parents('.posts').find('.js-posts-carousel').slick('slickNext');
    });
    $('.js-img-prev').click(function(e) {
        e.preventDefault();
        $(this).parents('.posts').find('.js-posts-carousel').slick('slickPrev');
    });
});