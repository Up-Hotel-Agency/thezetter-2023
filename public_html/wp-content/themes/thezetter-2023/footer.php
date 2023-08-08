<?php
    // includes the template of the footer set in setup-footer.php
    include 'templates/' . get_footer_type() . '.php';
    
    // includes the template of the menu of the header set in setup-header.php
    include 'templates/menu_' . get_header_type() . '.php';
?>

<?php
// conversion tools
include 'templates/conversion_tools.php';
//Include broswer warning 
include 'templates/check-browser.php';

// ajax modal container 
include 'templates/ajax_modal.php';
?>
<?php wp_footer(); ?>
<?php acf_load_listener(); ?>

</body>
</html>
