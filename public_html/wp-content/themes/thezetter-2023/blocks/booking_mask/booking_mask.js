// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

jQuery(function($){
    $('.js-booking-mask').submit(function(e) {
        // generic code to be modified
        e.preventDefault();
        if($('.location-select').hasClass('active')){
            var location = $(this).data('url');
            var site = $(this).data('site');
            var arrivalDate = $(this).find('input[name="arrival"]').val();
            var departureDate = $(this).find('input[name="departure"]').val();
            var arrival = dayjs(arrivalDate).format('YYYY-MM-DD');
            var departure = dayjs(departureDate).format('YYYY-MM-DD');
            var rooms = $(this).find('input[name="rooms"]').val();
            var adults = $(this).find('input[name="adults"]').val();
            // var children = $(this).find('input[name="children"]').val();
            var propertyId = $(this).data('property-id');
            $('.js-booking-toggle').toggleClass('menu-open');


            // --- DISTRIBUTE ADULTS ---
            var adultsPerRoom = [];
            var baseAdults = Math.floor(adults / rooms);
            var remainder = adults % rooms;

            for (var i = 0; i < rooms; i++) {
                adultsPerRoom.push(baseAdults + (i < remainder ? 1 : 0));
            }

            var params = new URLSearchParams({
                rooms: rooms
            });
            params.set('adult', adultsPerRoom.join(','));   // e.g. "2,2"
            var totalRoomsandGuests = params.toString();

            console.log(site);
            if(site == 'clerkenwell'){
                window.location.href = "https://reservations.thezetter.com/?arrive=" + arrival + "&brand=ZETTER&chain=34634&currency=GBP&depart=" + departure + "&hotel=35181&level=chain&locale=en-US&productcurrency=GBP&" + totalRoomsandGuests + "&theme=Zetter";
            }else if(site == 'marylebone'){
                window.location.href = "https://reservations.thezetter.com/?arrive=" + arrival + "&brand=ZETTER&chain=34634&currency=GBP&depart=" + departure + "&hotel=35183&level=chain&locale=en-US&productcurrency=GBP&" + totalRoomsandGuests + "&theme=Zetter"
            }else if(site == 'marrables'){
                window.location.href = "https://reservations.marrableshotel.com/?arrive=" + arrival + "&chain=34634&level=hotel&hotel=35182&currency=GBP&depart=" + departure + "&" + totalRoomsandGuests;
            }else if(site == 'bloomsbury'){
                // NEW
                window.location.href = "https://reservations.thezetter.com/?arrive=" + arrival + "&brand=ZETTER&chain=34634&child=0&currency=GBP&depart=" + departure + "&hotel=95317&level=chain&locale=en-US&productcurrency=GBP&" + totalRoomsandGuests + "&theme=Zetter";
                // TEMPORARY
                // window.location.href = "https://reservations.thezetter.com/?arrive=" + arrival + "&brand=ZETTER&chain=34634&currency=GBP&depart=" + departure + "&level=chain&theme=Zetter";
            }else{
                // Group
                window.location.href = "https://reservations.thezetter.com/?arrive=" + arrival + "&brand=ZETTER&chain=34634&currency=GBP&depart=" + departure + "&level=chain&theme=Zetter";
            }

        }else{
            $('.location-select').addClass('error');
        }
    });


    // location selector on booking form - UP IBE
    $('.js-location-selector-up a').click(function(e) {
        e.preventDefault();
        var locationUrl = $(this).attr('data-url');
        var locationSite = $(this).attr('data-site');
        var locationID = $(this).attr('data-property-id');
        var locationName = $(this).text();
        $('.location-display').text(locationName);

        if(locationID != null || locationID != '') {
            $(this).parents('form').find('button[type=submit').removeClass('disabled');
        }
        
        $(this).parents('form').attr('data-url', locationUrl);
        $(this).parents('form').attr('data-property-id', locationID);
        $(this).parents('form').attr('data-site', locationSite);
    }); 

    $(".js-datepicker-trigger").flatpickr({
        mode: "range",
        minDate: "today",
        showMonths: "2",
        locale: {
            firstDayOfWeek: 1
        },
        onClose: function(selectedDates) {
            var startDate = selectedDates[0];
            var endDate = selectedDates[1];
            $('.js-check-in-display').html( dayjs(startDate).format('ddd D MMM') );
            $('.js-check-out-display').html( dayjs(endDate).format('ddd D MMM') );

            $('.js-arrive-input').val( dayjs(startDate).format('YYYY-MM-DD') );
            $('.js-departure-input').val( dayjs(endDate).format('YYYY-MM-DD') );
        }
    });

    $('.js-arrive-input').change(function(){
        // get new selected date
        var checkInDate = new Date($(this).val());
        // figure out check out date (the next day)
        var checkOutDate = dayjs(checkInDate).add(1, 'day').format('YYYY-MM-DD');
        // update departure date input
        $(this).parents('form').find('input[name="departure"]').val(checkOutDate);
        // set the depart date input min date
        $(this).parents('form').find('input[name="departure"]').attr({
            'min' : dayjs(checkOutDate).format('YYYY-MM-DD')
        });
        // update text on the labels
        $(this).parents('form').find('.js-check-in-display').html(dayjs(checkInDate).format('ddd D MMM'));
        $(this).parents('form').find('.js-check-out-display').html(dayjs(checkOutDate).format('ddd D MMM'));
    });
    $('.js-departure-input').change(function(){
        // get new departure date
        var checkOutDate = new Date(this.value);
        // update the hidden depart input
        $(this).parents('form').find('input[name="departure"]').val(dayjs(checkOutDate).format('YYYY-MM-DD'));
        $(this).parents('form').find('input[name="departure"]').focus();
        // update text on the label
        $(this).parents('form').find('.js-check-out-display').html(dayjs(checkOutDate).format('ddd D MMM'));
    });
    $('.native-depart').change(function(){
        // get new departure date
        var checkOutDate = new Date(this.value);
        // update the hidden depart input
        $(this).parents('form').find('input[name="departure"]').val(dayjs(checkOutDate).format('YYYY-MM-DD'));
        $(this).parents('form').find('input[name="departure"]').focus();
        // update text on the label
        $(this).parents('form').find('.js-check-out-display').html(dayjs(checkOutDate).format('ddd D MMM'));
    });
    
    // booking widget inc / dec buttons
    $('.selector-control').on('click', function(e) {
        e.preventDefault();
        var $button = $(this);
        var max = $button.parents('.selector-wrap').attr('data-max');
        var min = $button.parents('.selector-wrap').attr('data-min');
        var oldValue = $button.parents('.selector-wrap').find('.selector-value').text();
        oldValue = parseInt(oldValue);
        var noless = Number(min) + Number(1);
        var nomore = Number(max) - Number(1);

        // update the input and update mini display
        if ($button.hasClass('plus')) {
            // + clicked
            // make sure min button is not disabled
            if (!oldValue >= max) {
                newVal = oldValue;
            } else if(oldValue < max) {
                // make sure - is reactivated
                $button.parents('.selector-wrap').find('.minus').removeClass('disabled');
                var newVal = parseFloat(oldValue) + 1;
            } else {
                newVal = max;
            }
            // the next click will reach the min so disable the max button
            if ( oldValue == nomore ) {
                $button.parents('.selector-wrap').find('.plus').addClass('disabled');
            }
        } else {
            // - clicked
            // Don't allow decrementing below zero
            if (oldValue > min) {
                // minus has been clicked and it can be decreased, make sure min button is not disabled
                var newVal = parseFloat(oldValue) - 1;
                $button.parents('.selector-wrap').find('.plus').removeClass('disabled');
            } else {
                // already reached the min, don't do anything
                newVal = min;
            }
            // the next click will reach the min so disable the min button
            if ( oldValue == noless ) {
                $button.parents('.selector-wrap').find('.minus').addClass('disabled');
            }
        }
        $button.parents('.selector-wrap').find('.selector-value').text(newVal);
        $button.parents('.selector-wrap').find('input').val(newVal);

        var rooms = $button.parents('.select-inner').find('input[name="rooms"]').val();
        var adults = $button.parents('.select-inner').find('input[name="adults"]').val();
        var children = $button.parents('.select-inner').find('input[name="children"]').val();

        // update the main display on the booking mask (this one only)
        // rooms
        var roomsSum = 0;
        var roomsCount = $button.parents('form').find('.js-count-rooms');
        roomsCount.each(function(){
            rooms = $(this).val();
            roomsSum = +roomsSum + +rooms;
        });
        if(roomsSum > 1) {
            $(".js-rooms-display").text(roomsSum + ' Rooms');
        } else {
            $(".js-rooms-display").text(roomsSum + ' Room');
        }
        // adults
        var adultsSum = 0;
        var adultsCount = $button.parents('form').find('.js-count-adults');
        adultsCount.each(function(){
            adults = $(this).val();
            adultsSum = +adultsSum + +adults;
        });
        if(adultsSum > 1) {
            $(".js-adults-display").text(adultsSum + ' Adults');
        } else {
            $(".js-adults-display").text(adultsSum + ' Adult');
        }
        // children
        var childSum = 0;
        var roomCount = $button.parents('form').find('.js-count-children');
        roomCount.each(function(){
            children = $(this).val();
            childSum = +childSum + +children;
        });
        if(childSum > 1 || childSum === 0) {
            $(".js-children-display").text(childSum + ' Children');
        } else {
            $(".js-children-display").text(childSum + ' Child');
        }
    });

    // rooms / guests selector on booking form
    $('.js-rooms-guests-trigger, .rooms-guests-close').click(function(e) {
        e.preventDefault();
        $(this).parents('form').find('.rooms-guests-select').toggleClass('active');
    });
});