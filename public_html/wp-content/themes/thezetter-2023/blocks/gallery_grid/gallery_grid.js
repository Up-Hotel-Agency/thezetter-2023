// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

jQuery(function($){
    // gallery modal trigger
    $('.js-gallery-modal-trigger').click(function(e) {
        e.preventDefault();
        var gallery = $(this).attr('data-modal');
        $('.js-gallery-modal.' + gallery).addClass('active');
        $('body').addClass('modal-open');

        // gallery modal carousel
        var $imgconSlick = $('.js-gallery-modal.' + gallery + ' .js-gallery-modal-slider');
        $imgconSlick.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide, prevSlide){
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $('.js-gallery-modal-counter').html(i + '<span class="slash">/</span>' + slick.slideCount);
        });
        if( !$imgconSlick.hasClass('slick-initialized') ) {
            $imgconSlick.not('.slick-initialized').slick({
                arrows: false,
                infinite: true,
                adaptiveHeight: false,
                speed: 300,
                cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
                focusOnSelect: false,
                fade: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
            });
        }
        $('.js-gallery-modal-next').click(function() {
            $(this).parents('.js-gallery-modal').find('.js-gallery-modal-slider').slick('slickNext');
        });
        $('.js-gallery-modal-prev').click(function() {
            $(this).parents('.js-gallery-modal').find('.js-gallery-modal-slider').slick('slickPrev');
        });
        // if you specifiy the slide, let's go to it!
        if ($(this).attr('data-modal-slide')) {
            var slide = $(this).attr('data-modal-slide');
            $imgconSlick.slick('slickGoTo', slide - 1);
        }
    });
});