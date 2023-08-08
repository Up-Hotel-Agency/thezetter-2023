<?php

/**
 * Add UP Core Blocks as a block category
 */

function upcore_block_category( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug' => 'upcore-blocks',
				'title' => __( 'UP Core Blocks', 'upcore-blocks' ),
			),
		),
		array(
			array(
				'slug' => 'upcore-banners',
				'title' => __( 'UP Core Banners', 'upcore-banners' ),
			),
        ),
        $categories
	);
}
add_filter( 'block_categories_all', 'upcore_block_category', 10, 2);


/**
 * Activate wide alignment options on blocks
 */

function mytheme_setup_theme_supported_features() {
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'mytheme_setup_theme_supported_features' );

add_theme_support( 'editor-styles' );
add_editor_style( 'assets/css/blocks-editor.css' );

/**
 * Enqueue block JavaScript and CSS for backend gutenberg editor
 */


 
function block_plugin_editor_scripts() {

    //Fixes issue where $ is not defined 
    wp_add_inline_script('jquery', 'var $ = jQuery.noConflict();');

    function up_unique_array_by_key($array, $key) {
        $result = array();
        $values = array();
        foreach ($array as $subarray) {
            if (!in_array($subarray[$key], $values)) {
                $values[] = $subarray[$key];
                $result[] = $subarray;
            }
        }
        return $result;
    }


    //Gets the current JS enqueued scripts for each block ready to be re-executed when a block changes  
    function inspect_scripts() {
        global $wp_scripts;
        $handle_list = array();
        $enqueued_assets = $wp_scripts->queue;

        foreach ($wp_scripts->queue as $handle) {
            $handle_data = $wp_scripts->registered[$handle];
        
            if (strpos($handle_data->src, '/wp-content/themes/thezetter-2023/assets/js/') !== false) {
                $handle_list[] = array(
                'handle' => $handle,
                'src' => $handle_data->src
                );
            }
            }

            $block_handles = array_filter($handle_list, function($item) {
            return strpos($item['handle'], 'block-acf-') !== false;
        });

        $unique_handles = up_unique_array_by_key($block_handles, 'src');
        $unique_handles = json_encode($unique_handles);

        //Handles the Gutenberg editor JS RE-execute after changes are made
        wp_add_inline_script('jquery',"

            var googleMapScriptLoaded;
            var neighbourhoodScriptLoaded;

            function loadScript(scriptSrc, callback) {
                const existingScript = document.querySelector(`script[src='scriptSrc']`);
                if (existingScript) {
                existingScript.remove();
                }
                const script = document.createElement('script');
                script.src = scriptSrc;
                script.onload = callback;
                document.head.appendChild(script);
            }

            function load_js(blockName){

                var block_scripts = JSON.parse('". addslashes($unique_handles) ."');

                if(blockName !== null){
                    var scriptSrc = null;
                    loadScript('".get_template_directory_uri()."/assets/js/main.min.js');
                    for (var i = 0; i < block_scripts.length; i++) {
                        var handle = block_scripts[i];
                        var handleName = handle['handle'];
                        if (handleName.includes(blockName)) {
                            scriptSrc = handle['src'];
                            loadScript(scriptSrc, function() {
                                console.log('Loaded',  scriptSrc);
                            });
                        }
                    }
                    // this is the first time load_js() is called
                    if (!load_js.called) {
                        load_js.called = true;
                        for (var i = 0; i < block_scripts.length; i++) {
                            var handle = block_scripts[i];
                            var handleName = handle['handle'];
                        
                            scriptSrc = handle['src'];
                            loadScript(scriptSrc, function() {
                                console.log('Loaded',  scriptSrc);
                            });
                            
                        }
                    }
                }

            }
        ");
    }
    add_action( 'wp_print_scripts', 'inspect_scripts' );

    wp_enqueue_script('jquery');
    
    wp_add_inline_script(
        'wp-data',
        " 
            let prevBlocks = null;
            var jsRefreshInProgress = false; 
        
            wp.data.subscribe(() => {
                const editor = wp.data.select('core/editor');
                if (editor) {
                    const currentPost = editor.getCurrentPost ? editor.getCurrentPost() : null;
                    if (currentPost !== null) {
                        const currentBlocks = wp.data.select('core/block-editor').getBlocks();
                        if (prevBlocks !== null && JSON.stringify(prevBlocks) !== JSON.stringify(currentBlocks)) {
                            const changedBlock = currentBlocks.find((block) => {
                                const prevBlock = prevBlocks.find((prevBlock) => prevBlock.clientId === block.clientId);
                                return !prevBlock || JSON.stringify(block.attributes) !== JSON.stringify(prevBlock.attributes);
                            });
                            if (changedBlock) {
                                const blockName = changedBlock.name.replace(/^acf\//, '');
                                if(jsRefreshInProgress == false){
                                    jsRefreshInProgress = true;
                                    setTimeout(function(){
                                        load_js( blockName );
                                        jsRefreshInProgress = false;
                                        console.log('JS refresh called');
                                    }, 5000);
                                }else{
                                    console.log('Skipping JS refresh');
                                }
                            }
                        }
                        prevBlocks = currentBlocks;
                    }
                }
            });
        "
    );

    // Enqueue libs JS
    wp_enqueue_script(
      'libs-js',
       get_template_directory_uri() . '/assets/js/libs.min.js',
       [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
       null
    );

    // Enqueue main JS
   wp_enqueue_script(
       'main-js',
       get_template_directory_uri() . '/assets/js/main.min.js',
       [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
       100
   );

  //Enqueue gutenberg JS
   wp_enqueue_script(
      'block-editor-js',
       get_template_directory_uri() . '/assets/js/gutenberg.js',
       [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
       null
   );

   wp_enqueue_style('frontend-global-css', get_template_directory_uri() . '/assets/css/global.css', array(), '', 'all');
   wp_enqueue_style('lite-youtube', get_template_directory_uri() . '/assets/css/utilities/lite-youtube.css' );

    // hide the grey bg from the editor panel
    wp_register_style( 'gutenberg-inline-css', false );
    wp_enqueue_style( 'gutenberg-inline-css' );
    wp_add_inline_style( 'gutenberg-inline-css', ".interface-interface-skeleton__content {background: none !important;}" );

}

// Hook the enqueue functions into the editor
add_action( 'enqueue_block_editor_assets', 'block_plugin_editor_scripts' );


// remove some default inline css
add_filter('block_editor_settings_all', function ($editor_settings) {
  unset($editor_settings['defaultEditorStyles'][0]['css']);
  return $editor_settings;
});

function my_remove_gutenberg_styles($translation, $text, $context, $domain)
{
    if($context != 'Google Font Name and Variants' || $text != 'Noto Serif:400,400i,700,700i') {
        return $translation;
    }
    return 'off';
}
add_filter( 'gettext_with_context', 'my_remove_gutenberg_styles',10, 4);

// WP Blocks opt-in features
add_theme_support( 'responsive-embeds' ); //Allow option for responsive embeds

// disable custom font sizes
add_theme_support( 'disable-custom-font-sizes' );

// disable custom colours and gradients
add_theme_support( 'disable-custom-colors' );
add_theme_support( 'disable-custom-gradients' );

// remove patterns
remove_theme_support( 'core-block-patterns' );
