// set the global variables here for JSLint
/*global AOS, jQuery, document, window, setTimeout */
"use strict";

jQuery(function($){
    var $mobLogoGrid;
    var $desktopLogoGrid;
    $mobLogoGrid = false;
    $desktopLogoGrid = false;
    function mobLogoGridSlider(){
        if($(window).width() <= 640){
            setTimeout(function(){
                if(!$mobLogoGrid){
                    $('.js-logo-grid-mob-slider').not('.slick-initialized').slick({
                        speed: 5000,
                        autoplay: true,
                        autoplaySpeed: 0,
                        centerMode: true,
                        cssEase: 'linear',
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        variableWidth: true,
                        infinite: true,
                        initialSlide: 1,
                        arrows: false,
                        buttons: false,
                        pauseOnHover: false
                    });
                    $mobLogoGrid = true;
                }
            }, 500);
        } else if($(window).width() > 640){
            if($mobLogoGrid){
                $('.js-logo-grid-mob-slider').slick('unslick');
                $mobLogoGrid = false;
            }
        }
    }
    function desktopLogoGridSlider(){
        if($(window).width() > 640){
            setTimeout(function(){
                if(!$desktopLogoGrid){
                    $('.js-logo-grid-desktop-slider').not('.slick-initialized').slick({
                        speed: 5000,
                        autoplay: true,
                        autoplaySpeed: 0,
                        centerMode: true,
                        cssEase: 'linear',
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        variableWidth: true,
                        infinite: true,
                        initialSlide: 1,
                        arrows: false,
                        buttons: false,
                        pauseOnHover: false
                    });
                    $desktopLogoGrid = true;
                }
            }, 500);
        } else if($(window).width() > 640){
            if($desktopLogoGrid){
                $('.js-logo-grid-desktop-slider').slick('unslick');
                $desktopLogoGrid = false;
            }
        }
    }
    $(document).ready(function(){
        mobLogoGridSlider();
        desktopLogoGridSlider();
    });
    $(window).on('resize', function(){
        mobLogoGridSlider();
        desktopLogoGridSlider();
    });
});