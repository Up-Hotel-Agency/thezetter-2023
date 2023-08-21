<?php

//Function to overide default SASS colours using PHP selector. Included using @include file functions

$change_colours = false;


if(!get_field('is_group', 'options')): 
	$change_colours = true;
	$background_alt = get_field('background_alt', 'options');
	$accent_primary = get_field('site_accent_color', 'options');
endif; 


if($change_colours):
?>
<style>
*{
	
	--color-accent-primary: <?php echo $accent_primary; ?>;
	--color-buttons:  <?php echo $accent_primary; ?>;
	
}
.block-editor .editor-styles-wrapper .theme--default, .block-editor .editor-styles-wrapper .theme--default *, .theme--default, .theme--default *{
	
	--color-accent-primary: <?php echo $accent_primary; ?>;
}
.block-editor .editor-styles-wrapper .theme--accent, .block-editor .editor-styles-wrapper .theme--accent *, .theme--accent, .theme--accent *{
	--color-background: <?php echo $accent_primary; ?> ;	
	--color-accent-primary: <?php echo $accent_reverse; ?>;
	
}
.block-editor .editor-styles-wrapper .theme--image, .block-editor .editor-styles-wrapper .theme--image *, .theme--image, .theme--image *{
	--color-accent-primary: var(--color-body);
}
.theme__card--image, .theme__card--image *{
	--color-accent-primary: var(--color-body);
}
</style>

<?php endif; ?>

