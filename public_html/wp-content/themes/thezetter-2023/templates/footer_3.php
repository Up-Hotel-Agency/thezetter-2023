<?php if(get_field('display_newsletter', 'options')): ?>
    <div class="footer-newsletter container spacing flex flex-row">
        <div class="footer-newsletter-left flex flex-row">
            <?php if(get_field('illustration_newsletter', 'options')): ?>
                <div class="illustration-newsletter"  data-aos="fade-up">
                    <?php echo img_sizes(get_field('illustration_newsletter', 'options'), ['default' => 'img_1367', 'page_area' => '30', 'mobile_page_area' => '85', 'lazy_load' => true]); ?>
                </div>
            <?php endif; ?>
            <div class="content-newsletter flex flex-col">
                <?php if(get_field('title_newsletter', 'options')): ?>
                    <h4 class="bold h2 mb-5"  data-aos="fade-up"><?php echo get_field('title_newsletter', 'options');?></h4>
                <?php endif; ?>
                <?php if(get_field('content_newsletter', 'options')): ?>
                    <article  data-aos="fade-up">
                        <?php echo get_field('content_newsletter', 'options');?>
                    </article>
                <?php endif; ?>
            </div>
        </div>
        <div class="newsletter-form"  data-aos="fade-up">
            <form method="post" target="_blank" action="https://r1.for-email.com/signup.ashx" autocomplete="off">
                <input type="hidden" name="userid" value="323089">
                <input type="hidden" name="SIG83f80dfbb07870791e2f733bd2416efcc80f7df2d993c0aa1a3e99ef86669417" value="">
                <input type="hidden" name="addressbookid" value="690525" />
                <input type="hidden" name="ReturnURL" value="https://thezetter.com/newsletter-sign-up/">
                <input type="hidden" id="ci_consenturl" name="ci_consenturl" value="">    
                <div class="newsletter-signup_input">
                    <input type="text" name="NAME" required placeholder="NAME*" aria-label="Enter name">
                    <input type="text" name="SURNAME" required placeholder="SURNAME*" aria-label="Enter surname">
                    <input type="email" name="EMAIL" required placeholder="EMAIL ADDRESS*" aria-label="Enter email address">
                    <button class="primary flex items-center no-margin" type="submit" id="btnsubmit" name="btnsubmit">Sign up</button>
                </div>
                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_9ea26ca78a5fa6ab143c116df_f01fa4434c" aria-label="Hidden Input" tabindex="-1" value=""></div>
            </form>
        </div>
    </div>
<?php endif; ?>
<footer class="footer container theme--image">
    <div class="footer-logo flex justify-between items-center mb-14">
        <a href="<?php echo get_bloginfo( 'url' ); ?>" title="<?php echo get_bloginfo( 'name' ); ?>" class="footer-logo flex xs:justify-start">
            <?php if(!get_field('not_zetter', 'options')):  
                switch_to_blog(1);
                    echo file_get_contents( get_field('footer_logo', 'options') ); 
                restore_current_blog();
            else: 
                echo file_get_contents( get_field('footer_logo', 'options') ); 
            endif; ?>
        </a>
    </div>
    <div class="footer-content">
        <div class="footer-content-top flex xs:flex-wrap">
            <div class="footer-menus">
                <div class="footer-menu footer-menu-main">
                <?php if(get_field('not_zetter')): ?>

                <?php else: ?>
           
                    <div class="footer-submenu">
                        <h3 class="h5 mob-footer-menu-toggle  xs:flex xs:justify-between xs:items-center">   
                            <?php if(get_field('not_zetter', 'options')): ?> Our Hotels <?php else: ?> Our Locations <?php endif; ?>
                        </h3>
                        <?php if(!get_field('not_zetter', 'options')): ?>
                            <?php switch_to_blog(1); ?>
                        <?php endif; ?>
                        <?php $i=0; while ( have_rows('hotel_navigation', 'options') ) : the_row(); ?>
                            <?php $link = get_sub_field('link', 'options'); ?>
                            <a data-id="<?php echo $i; ?>" href="<?php echo $link; ?>"><?php echo get_sub_field('title_site', 'options');?></a>
                        <?php $i++; endwhile; ?>
                        <?php if(!get_field('not_zetter', 'options')): ?>
                            <?php restore_current_blog(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="footer-submenu">
                        <h3 class="h5 mob-footer-menu-toggle  xs:flex xs:justify-between xs:items-center">   
                            Managed by <?php if(get_field('not_zetter', 'options')): ?> The Ailesbury <?php else: ?> The Zetter <?php endif; ?>
                        </h3>
                        <?php if(!get_field('not_zetter', 'options')): ?>
                            <?php switch_to_blog(1); ?>
                        <?php endif; ?>
                        <?php $i=0; while ( have_rows('other_hotels', 'options') ) : the_row(); ?>
                            <?php $link = get_sub_field('link', 'options'); ?>
                            <a data-id="<?php echo $i; ?>" href="<?php echo $link; ?>"><?php echo get_sub_field('title_site', 'options');?></a>
                        <?php $i++; endwhile; ?>
                        <?php if(!get_field('not_zetter', 'options')): ?>
                            <?php restore_current_blog(); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                </div>
                <?php if( have_rows('footer_menus', 'options') ): while ( have_rows('footer_menus', 'options') ) : the_row(); ?>
                    <div class="footer-menu">
                        <?php if( get_sub_field('footer_menu_title', 'options') ): ?>
                            <h3 class="h5 mob-footer-menu-toggle  ">
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