<section class="wp-block-chameleon-suggested-pages-block udc-suggested-pages-cta aos-init aos-animate cham-el alignwide" data-aos="fade-up">
  <section class="udc-row">
    <?php $settings = get_option('chameleon_settings')['features']['suggestedPagesBlock']; ?>
    <?php $numToRender = $settings['maximumItemsPerBlock']['numberSelected'] ? $settings['maximumItemsPerBlock']['numberSelected'] : 0; ?>
    <div class="udc-cta-blocks" style="--udc-col-span: var(--udc-col-span-<?php echo $numToRender; ?>)">
      <?php $itemNum = 0; ?>
      <?php while ($itemNum < $numToRender): ?>
        <a class="udc-callout-card udc-recently-visited-anchor">
          <div class="udc-callout-card__img udc-recently-visited-image skeleton">

          </div>
          <div class="udc-callout-card__content udc-recently-visited-cta-content">
            <header class="udc-recently-visited-header">
              <h2 class="udc-recently-visited-title skeleton">
                <div class="udc-recently-visited-icon-small">
                </div>
                <span class="udc-recently-visited-title-span"></span>
              </h2>
              <div class="udc-callout-card__title udc-recently-visited-title-container skeleton">
                <h3>
                </h3>
                <div class="chevron udc-recently-visited-chevron">
                </div>
              </div>
            </header>
          </div>
        </a>
        <?php $itemNum++; ?>
      <?php endwhile; ?>
    </div>
  </section>
</section>
