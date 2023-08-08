<?php

/**
 * @desc deregister old jQuery with vulnerabilities and replace with new
 */
function replace_core_jquery_version() {
    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'jquery-migrate' );
    wp_register_script( 'jquery', "/wp-content/themes/thezetter-2023/assets/js/jquery-3.5.1.min.js", array(), '3.5.1' );
}
add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );

/**
* @desc add jQuery to head
*/
function insert_jquery(){
    wp_enqueue_script('jquery', false, array(), false, false);
}
add_filter('wp_enqueue_scripts','insert_jquery',1);

/**
 * @desc rename blog title
 */
function rename_stupid_title(){
    $currentTitle = get_option( 'blogdescription' );
    if($currentTitle == 'Just another WordPress site'){
        update_option( 'blogdescription', 'Site in development');
    }
}
add_action( 'after_switch_theme', 'rename_stupid_title' );
add_action( 'wpmu_new_blog', 'rename_stupid_title' );

//Check if the user is in the office -- Used for remote editing
function is_up() {
    if ( $_SERVER['REMOTE_ADDR'] == "188.39.184.42" || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ) {
        return 1;
    } else {
        return 0;
    }
}


//START - Disable comments on Wordpress (Remove this entire function to enable comments)
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});
//END - Disable comments on Wordpress (Remove this entire function to enable comments)

//Enqueue JS scripts 
function up_core_footer_scripts(){
    wp_enqueue_script('frontend-libs-js', get_template_directory_uri() . '/assets/js/libs.min.js', array(), '', true);
    wp_enqueue_script('frontend-main-js', get_template_directory_uri() . '/assets/js/main.min.js', array(), '', true);
}
add_action('wp_footer', 'up_core_footer_scripts');

//Enqueue CSS scripts 
function up_core_footer_css(){
    wp_enqueue_style('frontend-global-css', get_template_directory_uri() . '/assets/css/global.css', array(), '', 'all');
    wp_enqueue_style('frontend-checkbrowser-css', get_template_directory_uri() . '/assets/css/checkbrowser.css', array(), '', 'all');
    wp_enqueue_style('frontend-lite-youtube', get_template_directory_uri() . '/assets/css/utilities/lite-youtube.css' );
}
add_action('wp_footer', 'up_core_footer_css');

add_filter("script_loader_tag", "add_module_to_my_script", 10, 3);
function add_module_to_my_script($tag, $handle, $src)
{
    if ("lite-viemo" === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }

    return $tag;
}