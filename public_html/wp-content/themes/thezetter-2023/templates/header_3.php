<header class="header flex justify-between items-center theme--default">
	<div class="header-left flex items-center">
		<a title="<?php echo get_bloginfo( 'name' ); ?>" class="logo flex justify-center items-center" href="<?php echo get_bloginfo( 'url' ); ?>">
			<?php 
			if(!get_field('not_zetter', 'options')): 
				switch_to_blog(1);
					echo file_get_contents( get_field('header_logo', 'options') ); 
				restore_current_blog();
			else: 
				echo file_get_contents( get_field('header_logo', 'options') ); 
			endif; 
			?>
			<?php if(!get_field('not_zetter', 'options') && !get_field('is_group', 'options')): ?>
				<div class="location-logo">
					<div class="divider-line"></div>
					<p class="location-logo-text"><?php the_field('location_name', 'options'); ?></div>
				</div>
			<?php endif; ?>
		</a>
	</div>
	<div class="header-right flex items-center">
		<?php if(!get_field('not_zetter', 'options')): ?>
			<?php if(get_field('is_group', 'options')): ?>
				<a href="#" class="open-menu js-open-side-menu">Locations</a>
			<?php else: ?>
				<div href="#" class="open-menu js-locations-dropdown">Locations
					<div class="locations-drop-down">
					<?php $current_site = get_current_blog_id(); ?>
					<?php switch_to_blog(1); $i=0; while ( have_rows('hotel_navigation', 'options') ) : the_row(); ?>
						<?php 
						
							$site_id = get_sub_field('site_id'); 
							$site_url = get_site_url($site_id); 
						?>
						<a class="<?php if($site_id == $current_site): ?> active <?php endif; ?>" href="<?php echo $site_url; ?>">The Zetter <?php echo get_sub_field('title_site');?></a>
					<?php $i++; endwhile; restore_current_blog(); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php wp_nav_menu( array( 'theme_location' => 'Main Menu' , 'container' => false, 'menu_class' => 'list-reset hide-mobile' ) ); ?>
		<?php 
			if(!get_field('is_group', 'options') && !get_field('not_zetter', 'options')):
			?><a href="#" class="open-menu js-open-side-menu">More</a><?php 
			endif;
		?>
		<?php block_buttons(get_field('header_button_field', 'options'), [
			'class' => 'button no-margin button-header',
			'type'  => 'primary'
		]); ?>
		<a href="#" title="Toggle menu" class="hidden nav-toggle js-nav-toggle l:flex items-center justify-center"><div class="menu-icon"><span></span><span></span><span></span></div></a>
	</div>
	<div class="overlay overlay-menu">
		<div>
			<div class="mini-menu">
				<?php if(get_field('is_group', 'options')): ?>
					<p class="label xs:mb-0">Locations</p>
					<?php $i=0; while ( have_rows('hotel_navigation', 'options') ) : the_row(); ?>
						<?php 	
							$site_id = get_sub_field('site_id'); 
							$site_url = get_site_url($site_id);  
						?>
						<a data-id="<?php echo $i; ?>" href="<?php echo $site_url; ?>" class="h4 <?php if($link == '#'): ?> no-pointer<?php endif; ?>" ><?php echo get_sub_field('title_site', 'options');?></a>
					<?php $i++; endwhile; ?>
				<?php else: ?>
					<p class="label xs:mb-0"><?php echo get_bloginfo('name'); ?></p>
					<?php wp_nav_menu( array( 'theme_location' => 'Secondary Menu' , 'container' => false, 'menu_class' => 'list-reset side-menu' ) ); ?>
				<?php endif; ?>
			</div>

			<div class="mini-menu">
				<p class="label xs:mb-0">About the Zetter</p>
				<?php if(get_field('is_group', 'options')): ?>
					<?php switch_to_blog(1); ?>
						<?php wp_nav_menu( array( 'theme_location' => 'Side Menu' , 'container' => false, 'menu_class' => 'list-reset side-menu' ) ); ?>
					<?php restore_current_blog(); ?>
				<?php else: ?>
					<?php switch_to_blog(1); ?>
						<?php wp_nav_menu( array( 'theme_location' => 'Side Menu Locations' , 'container' => false, 'menu_class' => 'list-reset side-menu' ) ); ?>
					<?php restore_current_blog(); ?>
				<?php endif; ?>
			</div>
			<?php if(get_field('is_group', 'options')): ?>
				<div class="mini-menu">
					<p class="label xs:mb-0">Our other Hotels</p>
					<?php $i=0; while ( have_rows('other_hotels', 'options') ) : the_row(); ?>
						<?php 
							$site_id = get_sub_field('site_id'); 
							$site_url = get_site_url($site_id);  
						?>
						<a data-id="<?php echo $i; ?>" href="<?php echo $site_url; ?>" class="h4 <?php if($link == '#'): ?> no-pointer<?php endif; ?>" ><?php echo get_sub_field('title_site', 'options');?></a>
					<?php $i++; endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
		<div>
			<div class="overlay-bottom">
				<div class="logo-side-menu">
					<?php if(get_field('side_menu_logo', 'options')): ?>
						<?php echo file_get_contents( get_field('side_menu_logo', 'options') ); ?>
					<?php endif; ?>
				</div>
				<div class="close-overlay-menu">
					<div class="close open-menu">Close</div>
				</div>
			</div>
		</div>
	</div>

	<div class="nav-wrap js-booking-toggle">
		<div class="nav-right">
			<?php echo img_sizes(get_field('booking_mask_image', 'options'), ['default' => 'img_1024', 'page_area' => '50', 'tablet_page_area' => '50', 'mobile_page_area' => '50', 'lazy_load' => false]); ?>
		</div>    
		<div class="nav-left container-left container-right flex items-center">
			
			<div class="close-booking-menu nav-toggle">
				<div class="close">Close</div>
			</div>
			<?php 
				wp_enqueue_script( 'flatpickr-js', get_template_directory_uri() . '/assets/js/flatpickr.min.js' );
				wp_enqueue_script( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/js/booking_mask/booking_mask.min.js' );
				wp_enqueue_style( 'block-acf-booking-mask', get_template_directory_uri() . '/assets/css/booking_mask/booking_mask.css' );
				wp_enqueue_style( 'flatpickr', get_template_directory_uri() . '/assets/css/utilities/flatpickr.css' );
				wp_enqueue_style( 'flatpickr-custom', get_template_directory_uri() . '/assets/css/utilities/flatpickr_custom.css' );    
			?>
			<?php include(get_template_directory() . '/templates/bookingmask-sidebar.php'); ?>        
		</div>

	</div>
</header>

<?php if(get_field('display_header_banner', 'options')): ?>
	<?php if(!get_field('display_in_all_pages', 'options')): ?>
		<?php $page_id = get_queried_object_id(); ?>
		<?php while ( have_rows('pages', 'options') ) : the_row(); ?>
			<?php $pages[] = get_sub_field('page', 'options'); ?>
		<?php endwhile; ?>
	<?php endif; ?>
	<?php if(get_field('display_in_all_pages', 'options') || in_array($page_id, $pages)): ?>
		<?php $link = get_field('banner_link_link', 'options');
		if( linkField( $link, 'text') ): ?>
			<a href="<?php echo linkField( $link, 'url' ); ?>" class="header-banner <?php if(get_field('add_opacity', 'options')):?>opacity<?php endif;?> <?php if( get_field('background_image', 'options') ):?> img-abs theme--image <?php else: ?> theme--accent <?php endif; ?>" <?php echo linkField( $link, 'target' ); ?>>
		<?php else: ?>
			<div class="header-banner <?php if(get_field('add_opacity', 'options')):?>opacity<?php endif;?> <?php if( get_field('background_image', 'options') ):?> img-abs theme--image <?php else: ?> theme--accent <?php endif; ?>">
		<?php endif; ?>
			<div class="header-banner-content">
				<?php if(get_field('top_overline', 'options')): ?>
					<p class="mb-0 overline">
						<?php the_field('top_overline', 'options'); ?>
					</p>
				<?php endif; ?>
				<?php if( get_field('title', 'options') ): ?>
					<h2 class="h1 no-margin">
						<?php the_field('title', 'options'); ?>
					</h2>
				<?php endif; ?>
				<?php if(get_field('description', 'options')): ?>
					<p class="mb-1 text">
						<?php the_field('description', 'options'); ?>
					</p>
				<?php endif; ?>
				<?php if(get_field('bottom_overline', 'options')): ?>
					<p class="mb-0 overline">
						<?php the_field('bottom_overline', 'options'); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php if( get_field('background_image', 'options') ): echo img_sizes(get_field('background_image', 'options'), ['default' => 'img_2200', 'page_area' => '100', 'mobile_page_area' => '100']); endif; ?>
		<?php if( linkField( $link, 'text') ): ?>
			</a>
		<?php else: ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>