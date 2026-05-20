<?php
  $room = '';
  $settings = get_option('chameleon_settings')['features']['popularRoomsBlock'];
  $popularRooms = [];

  if ($settings['defaultRooms']['activated']) {
    $popularRooms = array_values($settings['defaultRooms']['items']);
  
    if ($popularRooms) {
      $room = get_post(reset($popularRooms)['value']);
      $postMeta = get_post_meta($room->ID);
    }
  }
?>
<section class="wp-block-chameleon-popular-rooms aos-init aos-animate cham-el alignwide" data-aos="fade-up">
  <div class="udc-carousel" <?php if ($settings['layout']['imageSide'] == 'right'): ?>style="grid-template-columns: minmax(min(30rem, 50%), 4fr) minmax(0, 6fr);"<?php endif; ?>>
    <div class="udc-carousel-container">
      <div class="udc-img-content">
        <div class="udc-img-content__image" <?php if ($settings['layout']['imageSide'] == 'right'): ?>style="grid-column: 2/2;"<?php endif; ?>>
          <a class="udc-img-content__image-link udc-skeleton"></a>
        </div>
        <div class="udc-content" <?php if ($settings['layout']['imageSide'] == 'right'): ?>style="grid-column: 1/2;"<?php endif; ?>>
          <div class="udc-content-inner">
            <div class="udc-content-type-tag udc-skeleton">
              <div class="udc-content-type-icon">
              </div>
              <span class="udc-content-type-text"></span>
            </div>
            <div class="udc-content-article">
              <div class="udc-content-header">
                <h2 class="udc-skeleton"></h2>
                <span class="udc-subtitle udc-skeleton"></span>
              </div>
              <article class="udc-skeleton"></article>
            </div>
          </div>
          <div class="udc-buttons">
            <a class="udc-button secondary udc-skeleton"></a>
            <a class="udc-button primary udc-skeleton"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="udc-carousel-control" <?php if ($settings['layout']['imageSide'] == 'right'): ?>style="grid-column: 1/2;"<?php endif; ?>>
      <div class="udc-carousel-dots udc-img-content-dots">
        <div class="udc-dots">
          <div class="udc-slide-active">
            <button></button>
          </div>
        </div>
      </div>
      <div class="udc-carousel-buttons">
        <div class="udc-carousel-prev" title="Previous slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Previous</title><g class="caret-left"><polyline class="arrowhead" points="29.018 36.036 16.982 24 29.018 11.964" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="3"/></g></svg></div>
        <div class="udc-carousel-next" title="Next slide"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><title>Next</title><g class="caret-right"><polyline class="arrowhead" points="18.982 11.964 31.018 24 18.982 36.036" fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="3"/></g></svg></div>
      </div>
    </div>
  </div>
</section>