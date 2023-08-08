<?php 

//Enable the Wordpress admin area to be restyled
add_action( 'admin_enqueue_scripts', 'upcore_admin_styles');

function upcore_admin_styles() {
  wp_enqueue_style( 'admin-style', get_template_directory_uri(). '/assets/css/admin.css' );
}