<?php
// enqueue the override css
function vogue_stylesheet(){
    wp_enqueue_style( 'vogue-style', get_stylesheet_directory_uri() . '/assets/css/vogue.css', false, '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'vogue_stylesheet', 99 );  

// add the override into the Gutenberg editor, after the parent theme's functions
function vogue_gutenberg() {
    add_editor_style( 'assets/css/vogue.css' );
}
add_action( 'init', 'vogue_gutenberg', 25 );

// set header type
function get_header_type() {
    $header_type = 'header_2'; // set the header type here, DO NOT CHANGE
    return $header_type;
}
// set footer type
function get_footer_type() {
    $footer_type = 'footer_1'; // set the footer type here, DO NOT CHANGE
    return $footer_type;
}
// setup blog listing
function get_blog_listing() {
    $blog_listing_type = 'blog_2'; // set the blog listing type here
    return $blog_listing_type;
}
// setup blog single
function get_blog_single() {
    $blog_single_type = 'blog_1'; // set the blog single type here
    return $blog_single_type;
}
// setup offer single template
function get_offer_single_type() {
    $offer_type = 'offer_1'; // set the offer single type here
    return $offer_type;
}
// setup event single template
function get_event_single_type() {
    $offer_type = 'event_1'; // set the event single type here
    return $offer_type;
}
// setup room single template
function get_room_single_type() {
    $offer_type = 'room_1'; // set the room single type here
    return $offer_type;
}