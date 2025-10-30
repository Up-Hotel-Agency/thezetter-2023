<?php if ( !class_exists( 'acf' ) ): ?>
<p style="text-align: center;">Please activate Advanced Custom Fields</p>
<?php die; endif; ?>
<!DOCTYPE html>
<html id="html" lang="en" <?php if(get_field('not_zetter', 'options')): ?> class="secondary-typography" <?php endif; ?>>


<?php 
session_start();

$_SESSION['not_zetter'] = false;

if((get_field('not_zetter','options'))):  
	$_SESSION['not_zetter'] = true;
endif; 

?>
<head>

<script>
var googleMapScriptLoaded;
var neighbourhoodScriptLoaded;
</script>

<?php if( get_field('is_book_page') ): ?>
<script>
window.dataLayer = window.dataLayer || [];
dataLayer.push({
  event: 'visitedIbePage',
  <?php if( get_current_blog_id() == 2 ): // Zetter Hotel GTM ?>
  hotel_location: 'clerkenwell'
  <?php elseif( get_current_blog_id() == 3 ): // Clerkenwell GTM ?>
  hotel_location: 'marrables-hotel'
  <?php elseif( get_current_blog_id() == 4 ): // Clerkenwell GTM ?>
  hotel_location: 'marylebone'
  <?php elseif( get_current_blog_id() == 5 ): // Marylebone GTM ?>
  hotel_location: 'bloomsbury'
  <?php else: // Group ?>
  hotel_location: 'group'
  <?php endif; ?>
});
</script>
<?php endif; ?>

<?php $currentID = get_the_ID(); ?>
<?php if(get_current_blog_id() == 3):?>
    <!-- Marrables Hotel -->
    <?php if($currentID == '2864'):?>
        <!-- Pickup page -->
        <script type="application/javascript"> var customice_pickup_config = { configurator_url: 'https://cfg.customice.de/the-zetter-group_marrable-farringdon-hotel?token=<selfpickuptoken>#reservation', iframe_id: 'customicepickup' }; </script> <script type='application/javascript' src='https://www.customice.de/selfpickup-v2.js'></script>
    <?php endif;?>
<?php endif;?>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Author" content="Zetter">
<!--[if lte IE 9]>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/css/ie-9.css" rel="stylesheet">
<![endif]-->


<?php global $post; ?>

<script>
    ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<script type="text/javascript" src="https://app.prommt.com/sdk/prommt.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://app.prommt.com/sdk/prommt.min.css">

<?php if(get_field('not_zetter', 'options') || !get_field('is_group', 'options')): ?>

    <?php include 'secondary_styles.php'; ?>
    <!-- TripTease -->
    <script src="https://onboard.triptease.io/bootstrap.js?integrationId=01E4X68PPMXP1TVN2VV3FHBD2W" defer async crossorigin="anonymous" type="text/javascript"></script>

<?php else: ?>
    <!-- Preload webfont -->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/GillSans/18257675-171f-479d-8d82-cd9c11870d5f.woff2" as="font" type="font/woff2" crossorigin>

    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/Louize/205TF-Louize-Regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/Louize/205TF-Louize-Medium.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/Louize/205TF-Louize-Bold.woff2" as="font" type="font/woff2" crossorigin>
    <!-- End Preload webfont -->

    <style>
        <?php echo file_get_contents(get_template_directory() . '/assets/css/base/typography/load-zetter-fonts.css'); ?>
    </style>

    <!-- TripTease -->
    <script src="https://onboard.triptease.io/bootstrap.js?integrationId=01E4X68PPMXP1TVN2VV3FHBD2W" defer async crossorigin="anonymous" type="text/javascript"></script>


<?php endif; ?>

<style>
<?php echo file_get_contents(get_template_directory() . '/assets/css/abovethefold.css'); ?>
</style>


<?php if( get_current_blog_id() == 1 ): ?>
    <!-- Main site -->
     <?php if(is_page(756)):?>
        <!-- Offers page -->
        <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1122813799671176');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1122813799671176&ev=PageView&noscript=1" /></noscript>
        <!-- End Meta Pixel Code -->
    <?php endif; ?>

<?php  elseif( get_current_blog_id() == 2 ): ?>
    <!-- The Hotels Network - Clerkenwell -->
    <script src='https://www.thehotelsnetwork.com/js/loader.js?property_id=1042280&account_key=C46AE18617ED62CF0B1CA1E7F6CEFB84' async></script>

    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1075706911123677');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1075706911123677&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    
    
    <?php if(is_page(151)):?>
        <!-- Weddings page -->
        <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1137657044856435');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1137657044856435&ev=PageView&noscript=1" /></noscript>
        <!-- End Meta Pixel Code -->
    <?php endif; ?>

<?php elseif( get_current_blog_id() == 3 ): ?>
    <!-- The Hotels Network - Marrable's   -->
    <script src='https://www.thehotelsnetwork.com/js/loader.js?property_id=1042281&account_key=C46AE18617ED62CF0B1CA1E7F6CEFB84' async></script>

    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1934848163586583');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1934848163586583&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
<?php elseif( get_current_blog_id() == 4 ): ?>
    <!-- The Hotels Network - Marylebone -->
    <script src='https://www.thehotelsnetwork.com/js/loader.js?property_id=1039746&account_key=C46AE18617ED62CF0B1CA1E7F6CEFB84' async></script>

    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2421061501598648');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2421061501598648&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
<?php endif; ?>

<?php if($_SESSION['not_zetter']): ?>
    <link rel="apple-touch-icon" sizes="180x180" href="/no-zetter/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/no-zetter/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/no-zetter/favicon-16x16.png">
<?php else: ?>
    <link rel="apple-touch-icon" sizes="180x180" href="/zetter/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/zetter/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/zetter/favicon-16x16.png">
<?php endif; ?>


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