<?php

/**
 * @desc Image Size wordpress documentation on function use:
 * @link https://developer.wordpress.org/reference/functions/add_image_size/
 */
add_theme_support( 'title-tag' );

add_theme_support( 'post-thumbnails' );

function wpse_setup_theme() {
    add_theme_support( 'post-thumbnails' );

    // new image sizes
    add_image_size( 'square', 500, 500, true );
    add_image_size( 'img_188', 188 );
    add_image_size( 'img_375', 375 );
    add_image_size( 'img_500', 500 );
    add_image_size( 'img_640', 640 );
    add_image_size( 'img_800', 800 );
    add_image_size( 'img_1024', 1024 );
    add_image_size( 'img_1367', 1367 );
    add_image_size( 'img_1920', 1920 );
    add_image_size( 'img_2200', 2200 );
}

add_action( 'after_setup_theme', 'wpse_setup_theme' );

/**
 * @desc allow SVG upload
 * @desc todo: delete and try to upload an svg
 */
function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );
