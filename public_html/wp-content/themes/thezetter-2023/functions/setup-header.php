<?php 
if(!function_exists('get_header_type')){
    // wrap in an if statement in case set in a child theme
    function get_header_type() {
        $header_type = 'header_3'; // set the header type here
        return $header_type;
    }
}

register_nav_menu( 'Main Menu', 'Main Menu' );
register_nav_menu( 'Side Menu', 'Side Menu' );

if( get_header_type() == 'header_1' ) {
    // register menus for header type 1
    register_nav_menu( 'Sticky Header Left', 'Sticky Header Left' );
}