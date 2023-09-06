<?php if ( !class_exists( 'acf' ) ): ?>
<p style="text-align: center;">Please activate Advanced Custom Fields</p>
<?php die; endif; ?>
<!DOCTYPE html>
<html id="html" lang="en" <?php if(get_field('not_zetter', 'options')): ?> class="secondary-typography" <?php endif; ?>>
<head>

<script>
var googleMapScriptLoaded;
var neighbourhoodScriptLoaded;
</script>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Author" content="Zetter">
<!--[if lte IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src=”https://cdn.polyfill.io/v2/polyfill.min.js"></script>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/ie-9.css" rel="stylesheet">
<![endif]-->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com"> 
<link rel="preconnect" href="https://ajax.googleapis.com">

<?php global $post; ?>

<script>
    ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<style>
<?php echo file_get_contents(get_template_directory() . '/assets/css/abovethefold.css'); ?>
</style>
<?php if(get_field('not_zetter', 'options') || !get_field('is_group', 'options')): ?>
    <?php include 'secondary_styles.php'; ?>
<?php endif; ?>

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0e566e">
<meta name="msapplication-TileColor" content="#0e566e">
<meta name="theme-color" content="#0e566e">
<link rel="manifest" href="/manifest.json">

<?php wp_head(); ?>

<script>jQuery.event.special.touchstart = {setup: function( _, ns, handle ) {this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });}};jQuery.event.special.touchmove = {setup: function( _, ns, handle ) {this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });}};jQuery.event.special.wheel = {setup: function( _, ns, handle ){this.addEventListener("wheel", handle, { passive: true });}};jQuery.event.special.mousewheel = {setup: function( _, ns, handle ){this.addEventListener("mousewheel", handle, { passive: true });}};</script>
</head>
<?php if(get_field('footer_color', 'options')): ?>
    <style>
        body{
            --color-footer: <?php the_field('footer_color', 'options'); ?>;
        }
    </style>
<?php else: ?>
    <style>
        body{
            --color-footer: #101921;
        }
    </style>
<?php endif; ?>

<body <?php body_class( get_option('stylesheet') ); ?>>

<a class="button primary screenreader-link" href="#scroll-target">Skip to content</a>

<?php
    // includes the template of the header set in setup-header.php
    include 'templates/' . get_header_type() . '.php';
?>