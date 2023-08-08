// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

jQuery(function($){

    gumshoe.init({
        offset: 72,
        activeClass: 'active'
    });

    if( $('.js-live-search').length ) {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        function faqForm(){
            // get the correct form based on screensize
            if($(window).width() <= 640){
                var filterInput = $('.js-filter-mob');
            } else if($(window).width() > 640){
                var filterInput = $('.js-filter-desktop');
            }
            $(filterInput).keyup(function(){
                // Reset filters
                $('.accordion-group').removeClass('filter-active');
                $(".filtered-accordion").removeClass('filtered-accordion');
    
                // Make sure to show if filter count has been hidden previously
                $(".faqs-notification").addClass('active');
    
                // Retrieve the input field text and reset the count to zero
                var filter = $(this).val(), count = 0;
                if(!$(filterInput).val()){
                    // there's nothing in the filter so reset everything
                    $('.accordion-title').removeClass('active');
                    $('.accordion-title').show();
                    $(".accordion-content").slideUp();
                    $(".faqs-notification").removeClass('active');
                    $(".accordion-title").removeClass('open');
                    $('.faq-group').removeClass('no-results');
                    return;
                }
    
                $('.faq-group').addClass('no-results');
                $('.accordion-group').addClass('filter-active');
                // Loop through the comment list
                $(".accordion-title, .accordion-content").each(function(){
                    $(filterInput).val();
                    $(this).hide();
    
                    // If the list item does not contain the text phrase fade it out
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        // Show the list item if the phrase matches and increase the count by 1
                    } else {
                        $(this).parents('.faq-group').removeClass('no-results');
                        if($(this).hasClass('accordion-title')){
                            $(this).show();
                            $(this).addClass('filtered-accordion');
                        }
                        if($(this).hasClass('accordion-content')){
                            $(this).parent().find('.accordion-title').show();
                            $(this).parent().find('.accordion-title').addClass('filtered-accordion');
                        }
                    }
                });
    
                // Make sure unwanted headings are hidden
                $('.accordion-content').hide();
    
                // Show Headings with relevant questions
                $('.filtered-accordion').parent().show();
                $('.filtered-accordion').show();
    
                // Count questions that have matches
                var count = $('.filtered-accordion').length;
    
                var mapObj = {
                    '&':"&amp;",
                    '<':"&lt;",
                    '>':"&gt;",
                    '"':"&quot;",
                    '\'':"&#039;"
                };
                var re = new RegExp(Object.keys(mapObj).join("|"),"gi");
                
                function escapeHtml(str) 
                {   
                    return str.replace(re, function(matched)
                    {
                        return mapObj[matched.toLowerCase()];
                    });
                }

                // add the search to the notification
                $(".js-search-term").text(escapeHtml(filter));
    
                // Update the count
                $(".filter-count").text(count + " results found");
            });
        };
        $(document).ready(function(){
            faqForm();
        });
        $(window).on('resize', function(){
            faqForm();
        });
    }

    $(".js-faq-nav").click(function(e) {
        e.preventDefault();
        var group = $(this).attr('href');
        $(group + ' .accordion-group:first-child .accordion-title').click();
    });

    // Scroll to the opened tab if it's out of the viewport
    $.fn.isInViewport = function(){
        var bounds = this.offset();
        if (!bounds) {
            return
        }
        
        var viewport = {
            top : $(window).scrollTop(),
            left : $(window).scrollLeft()
        };
        viewport.right = viewport.left + $(window).width();
        viewport.bottom = viewport.top + $(window).height();

        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();
    
        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    
    };

    $(".accordion-title").click(function(e) {
        e.preventDefault();
        if(!$(this).hasClass("open")){
            if (!$('.accordion-title.open').isInViewport()) {
                const height = $('.accordion.opened').height();
                const height_title = $('.accordion-title.open').height();
                $('html, body').animate({
                    scrollTop: $(this).offset().top + (height_title * 2) - height
                }, 1000);
            } 
        }

    });

    // End - Scroll to the opened tab if it's out of the viewport
    
});