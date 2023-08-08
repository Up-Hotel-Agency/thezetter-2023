<?php 
// remove all woocommerce css
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_action( 'wp_enqueue_scripts', 'enqueue_woo_styles' );

function enqueue_woo_styles() {
    if( is_woocommerce() || is_cart() || is_checkout() ):
        wp_enqueue_style( 'custom-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css' );
    endif;
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'ts_replace_add_to_cart_button', 10, 2 );
function ts_replace_add_to_cart_button( $button, $product ) {
    if (is_product_category() || is_shop()) {
        $button_text = __("View Product", "woocommerce");
        $button_link = $product->get_permalink();
        $button = '<a class="button primary" href="' . $button_link . '">' . $button_text . '</a>';
        return $button;
    }
}