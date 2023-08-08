// set the global variables here for JSLint
/*global AOS, jQuery, neighbourhood */
"use strict";

// explore carousel
var $exploreCarousel = $('.explore-carousel');
function initializeExploreMap() {

    $('.explore-controls .explore-prev').click(function(e) {
        e.preventDefault();
        $(this).parents('.explore-carousels').find('.explore-carousel').slick('slickPrev');
    });
    $('.explore-controls .explore-next').click(function(e) {
        e.preventDefault();
        $(this).parents('.explore-carousels').find('.explore-carousel').slick('slickNext');
    });

    $('.explore-map').each(function(){
        var $mapContainer = $(this);
        var map;
        function new_map( $el ) {
            var $markers = $el.find('.marker');
            var args = {
                zoom : 14,
                zoomControl : true,
                center : new google.maps.LatLng(0, 0),
                mapTypeId	: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false,
                mapTypeControl : false,
                streetViewControl : false,
                fullscreenControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
                styles: [
                    {
                        "featureType": "all",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#999999"
                            }
                        ]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "gamma": "1"
                            },
                            {
                                "lightness": "-33"
                            }
                        ]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "saturation": "0"
                            },
                            {
                                "lightness": "100"
                            },
                            {
                                "weight": 2
                            },
                            {
                                "gamma": "1"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "all",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "lightness": "85"
                            },
                            {
                                "saturation": "0"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "lightness": "66"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "lightness": "95"
                            },
                            {
                                "saturation": "0"
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "saturation": 25
                            },
                            {
                                "lightness": 25
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "lightness": "-10"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "lightness": "0"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "lightness": "66"
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "lightness": "66"
                            }
                        ]
                    }
                ]
            };
            var map = new google.maps.Map( $el[0], args);
            map.markers = [];
            $markers.each(function(){
                add_marker( $(this), map );
            });
            center_map( map );
            return map;
        }
        function add_marker( $marker, map ) {
            var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
        
            var category = $marker.attr('data-cat');
            var count = $marker.attr('data-count');

            var markerPin = {
                url: '/wp-content/themes/thezetter-2023/assets/img/map-pin-inactive.svg',
                size: new google.maps.Size(82, 104),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(41, 84),
                scaledSize: new google.maps.Size(82, 104)
            }
            
            if( category == 'hotel' ) {
                var markerPin = {
                    url: '/wp-content/themes/thezetter-2023/assets/img/map-pin-logo.svg',
                    size: new google.maps.Size(104, 136),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(52, 116),
                    scaledSize: new google.maps.Size(104, 136)
                }
            }

            var marker = new google.maps.Marker({
                position : latlng,
                map : map,
                icon: markerPin,
                optimized: false,
                category: category,
                count: count
            });
            map.markers.push( marker );
            
            google.maps.event.addListener(marker, 'click', function() {
                // get the count from the marker
                var $slideNo = $marker.attr('data-count');
                // get the slide based on the data tag, not the slide count (as the count changes when filtering)
                var $slide = $(".explore-carousel [data-count='" + $slideNo + "']").last();
                // get the slide index
                var slideIndex = $slide.data("slick-index");
                // then go to the correct slide based on the slide index using the data tag
                $exploreCarousel.slick('slickGoTo', slideIndex);
                map.setZoom(16);
                map.panTo(marker.getPosition());
            });
        }

        function center_map( map ) {
            var bounds = new google.maps.LatLngBounds();
            $.each( map.markers, function( i, marker ){
                var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
                bounds.extend( latlng );
            });
            if( map.markers.length == 1 ) {
                map.setCenter( bounds.getCenter() );
            } else {
                map.fitBounds( bounds );
            }
        }
        var map = null;
        $(document).ready(function(){
            // create map
            map = new_map( $mapContainer );
            
            $exploreCarousel.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide, prevSlide){
                var elSlide = $(slick.$slides[currentSlide]);
                var current = elSlide.attr('data-count');
                
                $.each( map.markers, function( i, marker ){
                    
                    if( marker.category != 'hotel' ) {
                        // let's reset all the markers first, except the hotel pin
                        var markerPin = {
                            url: '/wp-content/themes/thezetter-2023/assets/img/map-pin-inactive.svg',
                            size: new google.maps.Size(82, 104),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(41, 84),
                            scaledSize: new google.maps.Size(82, 104)
                        }
                        marker.setIcon(markerPin);
                    }

                    // then we'll update the active marker, but only on desktop
                    if( i == current ) {
                        if( marker.category != 'hotel' ) {
                            var markerPin = {
                                url: '/wp-content/themes/thezetter-2023/assets/img/map-pin-active.svg',
                                size: new google.maps.Size(82, 104),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(41, 84),
                                scaledSize: new google.maps.Size(82, 104)
                            }
                            marker.setIcon(markerPin);
                        }

                        map.setZoom(16);
                        if(marker.count == current) {
                            map.panTo(marker.getPosition());
                        }
                    }
                });
            });

            $('.js-explore-category-filter').click(function(e) {
                e.preventDefault();
                $('.js-explore-category-filter').removeClass('active');
                var exploreCat = $(this).attr('data-cat');
                $('.js-explore-category-filter[data-cat="' + exploreCat + '"]').addClass('active');
                $(this).parents('.explore-locations').find('.explore-carousel').slick('slickUnfilter');
                if( exploreCat != 'all' ) {
                    // filter slick by this category
                    $(this).parents('.explore-locations').find('.explore-carousel').slick('slickFilter', '.' + exploreCat);
                    // get the active slide

                }else{
                    center_map( map );
                    // var markerCluster = new markerClusterer.MarkerClusterer(map, map.markers);
                    return map;
                }
                var goToSlide = $(this).parents('.explore-locations').find('.explore-carousel .slick-active').attr('data-count');
                $.each( map.markers, function( i, marker ){
                    if(marker.count == goToSlide) {

                        var markerPin = {
                            url: '/wp-content/themes/thezetter-2023/assets/img/map-pin-active.svg',
                            size: new google.maps.Size(82, 104),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(41, 84),
                            scaledSize: new google.maps.Size(82, 104)
                        }
                        marker.setIcon(markerPin);
                        
                        setTimeout(function(){
                            map.setZoom(16);
                            map.panTo(marker.getPosition());
                        }, 500);
                    }
                    if(marker.category == exploreCat || marker.category == 'hotel'){
                        marker.setVisible(true);
                    } else {          
                        marker.setVisible(false);
                    }
                    if( exploreCat == 'all' ) {
                        marker.setVisible(true);
                    }
                });
            });

        });
    });

    // initialise slick at the end for the init functions to work
    $exploreCarousel.not('.slick-initialized').slick({
        arrows: false,
        infinite: true,
        adaptiveHeight: false,
        speed: 500,
        cssEase: 'cubic-bezier(0, 0, 0.04, 0.98)',
        focusOnSelect: false,
        slidesToScroll: 1,
        slidesToShow: 1,
        variableWidth: false,
        autoplay: false,
        rows: 0,
        dots: true,
        appendDots: $('.explore-dots'),
        responsive: [
            {
                breakpoint: 640,
                settings: {
                    variableWidth: true
                }
            }
        ]
    });

    // toggle mobile explore overlay
    $('.js-mob-explore-toggle').click(function(e) {
        e.preventDefault();
        $('.explore-locations').toggleClass('active');
    });
}

// only run this once per page
var neighbourhoodInit = true;
var neighbourhoodScriptLoaded = false;
function neighbourhood(){
    // function to load in google maps api
    function loadNeighbourhoodScript( url, callback ) {
        var script = document.createElement( "script" )
        script.type = "text/javascript";
        if(script.readyState) {  // only required for IE <9
            script.onreadystatechange = function() {
                if ( script.readyState === "loaded" || script.readyState === "complete" ) {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  //Others
            script.onload = function() {
                callback();
            };
        }
      
        script.src = url;
        document.getElementsByTagName( "head" )[0].appendChild( script );
    }
    // if not already initialised
    if(neighbourhoodInit) {
        // has loadGoogleMapScript been run?
        if(googleMapScriptLoaded) {
            // if yes, don't load the api script, just run the map function
            initializeExploreMap();
        } else {
            // if no, load the api script and run the function
            loadNeighbourhoodScript('https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCb4yfZhPvS3pTzhiVUR3E5jZ7UHNF1HZc&callback=neighbourhood', function() {
                neighbourhoodScriptLoaded = true;
                // run the map function
                initializeExploreMap();
            });
        }
        // it's now initialised
        neighbourhoodInit = false;
    }
}

function IEneighbourhood(){
    neighbourhood();
}

//If the script is loaded within the editor run the function
if( window.acf ) {
    window.acf.addAction( 'render_block_preview', neighbourhood() );
}