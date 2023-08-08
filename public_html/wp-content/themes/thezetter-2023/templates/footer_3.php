<footer class="footer container theme--image">
    <div class="footer-logo flex justify-between items-center mb-14">
        <a href="<?php echo get_bloginfo( 'url' ); ?>" title="<?php echo get_bloginfo( 'name' ); ?>" class="footer-logo flex xs:justify-start">
            <?php echo img_sizes(get_field('footer_logo', 'options'), ['default' => 'img_1367', 'page_area' => '42', 'mobile_page_area' => '85', 'lazy_load' => true]); ?>
        </a>
    </div>
    <div class="footer-content">
        <div class="footer-content-top flex xs:flex-wrap">
            <div class="footer-menus">
                <div class="footer-menu footer-menu-main">
                    <div>
                        <h3 class="h5 mob-footer-menu-toggle js-mob-footer-menu-toggle xs:flex xs:justify-between xs:items-center">   
                            Our Locations
                        </h3>
                        <?php $i=0; while ( have_rows('hotel_navigation', 'options') ) : the_row(); ?>
                            <?php $link = get_sub_field('link', 'options'); ?>
                            <a data-id="<?php echo $i; ?>" href="<?php echo $link; ?>"><?php echo get_sub_field('title_site', 'options');?></a>
                        <?php $i++; endwhile; ?>
                    </div>
                    <div>
                        <h3 class="h5 mob-footer-menu-toggle js-mob-footer-menu-toggle xs:flex xs:justify-between xs:items-center">   
                            Managed by The Zetter
                        </h3>
                        <?php $i=0; while ( have_rows('other_hotels', 'options') ) : the_row(); ?>
                            <?php $link = get_sub_field('link', 'options'); ?>
                            <a data-id="<?php echo $i; ?>" href="<?php echo $link; ?>"><?php echo get_sub_field('title_site', 'options');?></a>
                        <?php $i++; endwhile; ?>
                    </div>
                </div>
                <?php if( have_rows('footer_menus', 'options') ): while ( have_rows('footer_menus', 'options') ) : the_row(); ?>
                    <div class="footer-menu">
                        <?php if( get_sub_field('footer_menu_title', 'options') ): ?>
                            <h3 class="h5 mob-footer-menu-toggle js-mob-footer-menu-toggle ">
                                <?php the_sub_field('footer_menu_title', 'options'); ?>
                            </h3>
                        <?php endif; ?>
                        <div class="footer-menu-wrap js-footer-menu">
                            <?php wp_nav_menu( array( 'menu' => get_sub_field('footer_menu') , 'container' => false, 'menu_class' => 'list-reset' ) ); ?>
                        </div>
                    </div>
                <?php endwhile; endif; ?>
            </div>
            <div class="footer-contact">
                <div class="contact-details">
                    <h3 class="h5">Connect</h3>
                    <?php if( get_field('instagram', 'options') ): ?>
                        <a href="<?php the_field('instagram', 'options'); ?>" class=" " target="_blank" rel="noopener">
                            Instagram
                        </a>
                    <?php endif; ?>
                    <?php if( get_field('facebook', 'options') ): ?>
                        <a href="<?php the_field('facebook', 'options'); ?>" class=" " target="_blank" rel="noopener">
                            Facebook
                        </a>
                    <?php endif; ?>
                    <?php if( get_field('twitter', 'options') ): ?>
                        <a href="<?php the_field('twitter', 'options'); ?>" class=" " target="_blank" rel="noopener">
                            Twitter
                        </a>
                    <?php endif; ?>
                    <?php if( get_field('linkedin', 'options') ): ?>
                        <a href="<?php the_field('linkedin', 'options'); ?>" class=" " target="_blank" rel="noopener">
                            LinkedIn
                        </a>
                    <?php endif; ?>
                </div>
                <div class="credits">
                    Copyright 2023, The Zetter. All Rights Reserved.<br>
                    Design by Ruth Costello. Build by <a href="https://uphotel.agency" target="_blank" rel="nofollow">UP HOTEL AGENCY</a>.
                </div>
            </div>
        </div>
    </div>
</footer>