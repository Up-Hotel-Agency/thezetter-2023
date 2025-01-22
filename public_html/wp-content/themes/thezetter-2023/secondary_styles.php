<?php

//Function to overide default SASS colours using PHP selector. Included using @include file functions

$change_colours = false;

if(!get_field('is_group', 'options')): 
	$change_colours = true;
	$background_alt = get_field('site_background_alt', 'options');
	$accent_primary = get_field('site_accent_color', 'options');
endif; 

if($change_colours):
?>
<style>
*{
	
	--color-accent-primary: <?php echo $accent_primary; ?>;
	--color-background-alt: <?php echo 	$background_alt; ?>;
	--color-buttons:  <?php echo $accent_primary; ?>;
	<?php if(get_field('no_zetter')): ?>
	--color-footer: <?php echo $accent_primary; ?>;
	<?php endif; ?>
	
}
.block-editor .editor-styles-wrapper .theme--default, .block-editor .editor-styles-wrapper .theme--default *, .theme--default, .theme--default *{
	
	--color-accent-primary: <?php echo $accent_primary; ?>;
}
.block-editor .editor-styles-wrapper .theme--accent, .block-editor .editor-styles-wrapper .theme--accent *, .theme--accent, .theme--accent *{
	--color-background: <?php echo $accent_primary; ?> ;	
	
}
.block-editor .editor-styles-wrapper .theme--image, .block-editor .editor-styles-wrapper .theme--image *, .theme--image, .theme--image *{
	--color-accent-primary: var(--color-body);
}
.theme__card--image, .theme__card--image *{
	--color-accent-primary: var(--color-body);
}
.theme--background-alt, .theme--background-alt *{
	--color-background: <?php echo $background_alt; ?>
}
</style>

<?php endif; ?>

<!-- Preload webfont -->
<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/Abhaya_Libre/abhaya-libre-v17-latin-600.woff2" as="font" type="font/woff2" crossorigin />
<link rel="preload" href="https://use.typekit.net/ttk1dgt.css" as="style" crossorigin />
<!-- End Preload webfont -->`

<?php if(get_field('not_zetter', 'options')): ?>
	<link rel="stylesheet" href=https://use.typekit.net/ttk1dgt.css>
<?php endif; ?>

<style>
<?php echo file_get_contents(get_template_directory() . '/assets/css/secondary_styles.css'); ?>
</style>

