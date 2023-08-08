<?php

/**
* @desc customise the logo on the login page
*/
function custom_login() { ?>
    <style>
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/up-login-logo.svg);
            height:65px;
            width:320px;
            background-size: 320px 65px;
            background-repeat: no-repeat;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login' );
