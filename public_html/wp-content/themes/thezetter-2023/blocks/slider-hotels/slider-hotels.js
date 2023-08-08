// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

$(".hotel-list-item").hover(function() {
    var hotelID = $(this).attr('data-hotel');
    $(".img-hotel").removeClass('active');
    $(".img-hotel").fadeOut();
    // $(".img-hotel-single-" + hotelID).slick("refresh");
    $(".img-hotel-single-" + hotelID).addClass('active');
});