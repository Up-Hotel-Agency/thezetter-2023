<?php if ( is_page_template( 'page-rooms.php' ) ) {
  include('rooms-impression.php');
}
if ( is_page_template( 'page-offers.php' ) ) {
    include('offers-impression.php');
}
if ( is_singular( 'offer' ) ) {
    include('offer-impression.php');
}
if ( is_singular( 'room' ) ) {
    include('room-impression.php');
} ?>