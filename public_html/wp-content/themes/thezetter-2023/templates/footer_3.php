<?php if(get_field('display_newsletter', 'options')): ?>
    <div class="footer-newsletter container spacing flex flex-row">
        <div class="footer-newsletter-left flex flex-row">
            <?php if(get_field('illustration_newsletter', 'options')): ?>
                <div class="illustration-newsletter <?php if(get_field('add_blend_mode', 'options')):?> blend-mode <?php endif; ?>"  data-aos="fade-up">
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
            <?php $currentID = get_the_ID(); ?>
            <?php if(get_current_blog_id() == 3):?>
                <!-- Marrables Hotel -->
                <script data-xp-widget-newsletter-427 src="https://widgets.experience-hotel.com/front/widget/widget-newsletter/bootstrap.js?widget_id=427"></script>
            <?php elseif(get_current_blog_id() == 5):?>
                <!-- Bloomsbury Hotel -->
                 <script data-xp-widget-newsletter-457 src="https://widgets.experience-hotel.com/front/widget/widget-newsletter/bootstrap.js?widget_id=457"></script>
            <?php else: ?>
                <script data-xp-widget-newsletter-409 src="https://widgets.experience-hotel.com/front/widget/widget-newsletter/bootstrap.js?widget_id=409"></script>
            <?php endif; ?>
            <template>
                <div class="xp-widget-newsletter-panel">

                    <div v-if="loading" class="loader">
                        <div class="xp-loader-light">
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                            <div/>
                        </div>
                    </div>

                    <h3 v-if="title" class="title">{{ title }}</h3>

                    <p v-if="introduction" class="intro">{{ introduction }}</p>

                    <div v-if="display_message" class="end-action-message" v-html="end_action_message"></div>

                    <form v-if="!display_message" @submit.prevent="submitForm()">

                        <div
                            v-for="field in fields"
                            :class="[`form-line-${field.name}`, {'filled': fields_value[field.name]}]"
                            class="form-line"
                        >
                            <label v-if="labelIsShown(field)" :for="inputId(field)">{{ field.text }}{{
                                    field.mandatory ? " *" : ""
                                }}</label>
                            <component
                                :is="getFieldComponent(field)"
                                :ref="field.name"
                                v-model="fields_value[field.name]"
                                v-bind="getFieldProps(field)"
                            />
                        </div>

                        <div v-if="multi_list === 1">
                            <div v-if="multi_list_intro" class="multi_list_intro">{{ multi_list_intro }}</div>
                            <div v-for="list in lists" class="form-checkbox">
                                <label><input v-model="selected_lists" :value="list.id" type="checkbox"> {{ list.name }}</label>
                            </div>
                        </div>

                        <p class="text-mandatory">{{ mandatory_fields }}</p>

                        <button class="form-submit">{{ call_to_action }}</button>

                    </form>
                </div>
            </template>
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
                            <?php $link = get_sub_field('site_id', 'options'); ?>
                            <a data-id="<?php echo $i; ?>" href="<?php echo get_blogaddress_by_id($link); ?>"><?php echo get_sub_field('title_site', 'options');?></a>
                        <?php $i++; endwhile; ?>
                        <?php if(!get_field('not_zetter', 'options')): ?>
                            <?php restore_current_blog(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="footer-submenu">
                        <h3 class="h5 mob-footer-menu-toggle  xs:flex xs:justify-between xs:items-center">   
                            Managed by <?php if(get_field('not_zetter', 'options')): ?> Marrable's <?php else: ?> The Zetter <?php endif; ?>
                        </h3>
                        <?php if(!get_field('not_zetter', 'options')): ?>
                            <?php switch_to_blog(1); ?>
                        <?php endif; ?>
                        <?php $i=0; while ( have_rows('other_hotels', 'options') ) : the_row(); ?>
                            <?php $link = get_sub_field('site_id', 'options'); ?>
                            <a data-id="<?php echo $i; ?>" href="<?php echo get_blogaddress_by_id($link); ?>"><?php echo get_sub_field('title_site', 'options');?></a>
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
                    Design by <a class="credits" href="https://ruthcostello.com" target="_blank" rel="nofollow">Ruth Costello</a>. Build by <a class="credits" href="https://uphotel.agency" target="_blank" rel="nofollow">UP Hotel Agency</a>.
                </div>
            </div>
        </div>
    </div>
</footer>