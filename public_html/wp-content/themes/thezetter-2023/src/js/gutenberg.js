// set the global variables here for JSLint
/*global AOS, jQuery, document, wp, console, setTimeout, window */
"use strict";

// set fullscreen mode by default
jQuery(document).ready(function($){
    var isFullScreenMode = wp.data.select('core/edit-post').isFeatureActive('fullscreenMode');
    if ( !isFullScreenMode ) {
        wp.data.dispatch('core/edit-post').toggleFeature('fullscreenMode');
    }

    // add page theme in gutenberg
    if( jQuery('#acf-field_5f199b3c9decb-field_5f199b3c9decb_field_5f22df005795e-field_5f22cd70c0d44').length ) {
        var pageTheme = jQuery('#acf-field_5f199b3c9decb-field_5f199b3c9decb_field_5f22df005795e-field_5f22cd70c0d44 option:checked').val();
        setTimeout(function() {
            jQuery('.block-editor-block-list__layout').addClass('theme--' + pageTheme);
        }, 500);
    }

    // back end colours on work single banner
    jQuery(window).load(function () {
        if( $('body').hasClass('post-type-work') ) {
            // if Custom colours? checkbox is checked
            if ($('#acf-field_5f452edaaa901').is(':checked')) {
                setTimeout(function() {
                    var bodyCol = $('input[name="acf[field_5f452eecaa902]"]').val();
                    var bgCol = $('input[name="acf[field_5f452f84aa905]"]').val();
                    var accentCol = $('input[name="acf[field_5f452f65aa903]"]').val();
                    var accentReverseCol = $('input[name="acf[field_5f452f76aa904]"]').val();

                    if(bodyCol) {
                        jQuery('.banner-work').get(0).style.setProperty('--color-body', bodyCol);
                    }
                    if(bgCol) {
                        jQuery('.banner-work').get(0).style.setProperty('--color-background', bgCol);
                    }
                    if(accentCol) {
                        jQuery('.banner-work').get(0).style.setProperty('--color-accent-primary', accentCol);
                    }
                    if(accentReverseCol) {
                        jQuery('.banner-work').get(0).style.setProperty('--color-accent-reverse', accentReverseCol);
                    }
                }, 500);
            }
        }
    });

    // if page theme is image, add image in gutenberg
    if( jQuery('#acf-field_5f199b3c9decb-field_5f199b3c9decb_field_5f22df005795e-field_5f22cd70c0d44').val() === 'image' ) {
        var bgImg = jQuery('.acf-field-5f22df125795f .acf-image-uploader img').attr('src');
        setTimeout(function() {
            jQuery('.block-editor-block-list__layout').prepend('<div class="page-bg-img"><img class="object-fit" src="' + bgImg + '"></div>');
        }, 500);
    }

    // if page theme is custom, apply in gutenberg editor
    if( jQuery('#acf-field_5f199b3c9decb-field_5f199b3c9decb_field_5f22df005795e-field_5f22cd70c0d44').val() === 'custom' ) {
        setTimeout(function() {
            var bodyCol = $('input[name="acf[field_5f199b3c9decb][field_5f199b3c9decb_field_5f22df005795e][field_5f280287338c3]"]').val();
            var bgCol = $('input[name="acf[field_5f199b3c9decb][field_5f199b3c9decb_field_5f22df005795e][field_5f280294338c4]"]').val();
            var accentCol = $('input[name="acf[field_5f199b3c9decb][field_5f199b3c9decb_field_5f22df005795e][field_5f28029e338c5]"]').val();
            var accentReverseCol = $('input[name="acf[field_5f199b3c9decb][field_5f199b3c9decb_field_5f22df005795e][field_5f2802a6338c6]"]').val();

            if(bodyCol) {
                jQuery('.block-editor-block-list__layout').get(0).style.setProperty('--color-body', bodyCol);
            }
            if(bgCol) {
                jQuery('.block-editor-block-list__layout').get(0).style.setProperty('--color-background', bgCol);
            }
            if(accentCol) {
                jQuery('.block-editor-block-list__layout').get(0).style.setProperty('--color-accent-primary', accentCol);
            }
            if(accentReverseCol) {
                jQuery('.block-editor-block-list__layout').get(0).style.setProperty('--color-accent-reverse', accentReverseCol);
            }
        }, 500);

    }
});