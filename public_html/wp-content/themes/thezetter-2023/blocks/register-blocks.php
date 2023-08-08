<?php

require_once(dirname(__FILE__) . '/_block_components/register_components.php');

if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'my_acf_init_block_types');
    function my_acf_init_block_types() {
        $thisFile = realpath(__FILE__);
        $di = new RecursiveDirectoryIterator( dirname(__FILE__) );
        foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
            $info = pathinfo($file);
            // let's just get the PHP files
            if ($info["extension"] == "php") {
                if (str_contains($filename, '_block_components') ){
                    continue;
                }

                // exclude this register-blocks.php file
                if( $filename != $thisFile ) {
                    // include all the blocks php files
                    include($filename);
                }
            }
        }
    }
} else {
    function my_error_notice() {
        ?>
        <div class="error notice">
            <p>ERROR: You must install and activate the Advanced Custom Fields Pro plugin!</p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'my_error_notice' );
}