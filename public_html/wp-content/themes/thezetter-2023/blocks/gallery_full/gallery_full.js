// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

jQuery(function($){

    // gallery modal carousel
    var $galleryFullSlick = $('.js-gallery-full');
    $galleryFullSlick.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide, prevSlide){
        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $('.js-gallery-full-counter').html(i + '/' + slick.slideCount);
    });

    $galleryFullSlick.not('.slick-initialized').slick({
        arrows: false,
        infinite: true,
        adaptiveHeight: false,
        speed: 300,
        cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
        focusOnSelect: false,
        slidesToScroll: 1,
        slidesToShow: 1,
        centerMode: false,
        variableWidth: true,
        dots: false,
        autoplay: false,
        rows: 0,
        fade: true,
        asNavFor: '.js-gallery-image-details'
    });
    $('.js-gallery-image-details').not('.slick-initialized').slick({
        arrows: false,
        infinite: true,
        adaptiveHeight: false,
        speed: 300,
        cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
        focusOnSelect: false,
        slidesToScroll: 1,
        slidesToShow: 1,
        centerMode: false,
        variableWidth: true,
        dots: false,
        autoplay: false,
        rows: 0,
        fade: true,
        asNavFor: '.js-gallery-full'
    });

    $('.js-gallery-full-prev').click(function(e) {
        e.preventDefault();
        $(this).parents('.row').find('.js-gallery-full').slick('slickPrev');
    });
    $('.js-gallery-full-next').click(function(e) {
        e.preventDefault();
        $(this).parents('.row').find('.js-gallery-full').slick('slickNext');
    });

    $('.js-hide-gallery').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).parents('.gallery-full-controls').toggleClass('gallery-menu-hide');
        $('.header').toggleClass('gallery-menu-hide');
    });

    $('.js-gallery-cat').change(function () {
        var cat = $(this).find(':selected').attr('value');
        if( cat === 'all' ) {
            $('.js-gallery-full, .js-gallery-image-details').slick('slickUnfilter');
        } else {
            $('.js-gallery-full, .js-gallery-image-details').slick('slickUnfilter');
            $('.js-gallery-full, .js-gallery-image-details').slick('slickFilter', '.' + cat);
        }
    });
});