<?php 
/**
* ------------------------------------------------------------------------------- 
* @desc UP ACF Icon Picker / Settings (V1.0.1)
* ------------------------------------------------------------------------------- 
*/

//Database name (This is the name where icons will be stored).
$up_icons_db_name = "up_icons";

//This is the admin functionality that hooks into upload.php for custom icons.
$up_enable_custom_icons_upload = true;

//This changes how the select field works and opens the icon modal.
$up_enable_acf_selector_mask = true;

//This option changes what the icon field outputs (required for this functionality to work)
$up_enable_acf_field_overwrite = true;

//This options runs a database search / replace for old values to new 
$up_enable_acf_sync = true;

/**
* ------------------------------------------------------------------------------- 
*/

//Get icons stored in /autoload-svgs/* directory
function up_get_theme_icons(){
    $svg_categories = array();
    $path = __DIR__ . '/' . '../../autoload-svgs/';
    $data = array();
    if(!is_dir($path)){
        return $field;
    }
    $dir = scandir($path);

    $svg_categories['uncategorised'] = array_filter($dir, function($svg){
        return (substr($svg, -4) == '.svg');
    });
    foreach ($dir as $result) {
        if ($result === '.' or $result === '..') continue;
        if (is_dir($path . '/' . $result)) {
            //code to use if directory
            $subdata = scandir($path.'/'.$result);
            $svg_categories[$result] = array_filter($subdata, function($svg){
                return (substr($svg, -4) == '.svg');
            });
        }
    }
    foreach($svg_categories as $cat => $svgs){
        foreach($svgs as $svg_item):
            $friendlyName = basename($svg_item, '.svg');
            if($cat == "uncategorised"):
                $svgContents = file_get_contents($path . $svg_item);
            else:
                $svgContents = file_get_contents($path ."/".$cat."/".$svg_item);
            endif;
            $data[$cat][$friendlyName] = $svgContents;
        endforeach;
    }
    return $data;
}

//Get custom icons stored within media 
function up_get_custom_icons(){
    $data = array();

    //We only use the main blogs "custom" icons
    if(is_multisite()):
        switch_to_blog(get_main_site_id());
    endif;
        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'meta_query' =>  array(
                array(
                    'key'     => 'is_icon',
                    'value'   => '1',
                    'compare' => '='
                )
            )
        ));
    if(is_multisite()):
        restore_current_blog();
    endif;
    
    foreach($attachments as $attachment):
        $data['custom'][pathinfo(basename ($attachment->guid),PATHINFO_FILENAME)] = str_replace('<?xml version="1.0" encoding="UTF-8"?>', "", file_get_contents($attachment->guid)); 
    endforeach;
    return $data;
}

//Get icons from the database (use main site if multisite)
function up_icons_get_db(){
    global $up_icons_db_name;
    if(is_multisite()): switch_to_blog(get_main_site_id()); endif;
        $db_data = (array)json_decode(get_option($up_icons_db_name)) ?? array();
    if(is_multisite()): restore_current_blog(); endif;
    return $db_data;
}

//Display admin notice if icons are missing. This requires under interaction to delete from the list.
function up_icons_deleted_notify(){
    $db_data = up_icons_get_db();
    global $pagenow;
    $admin_pages = [ 'index.php' ];
    $user = wp_get_current_user();
    if ( in_array( $pagenow, $admin_pages ) && current_user_can( 'administrator' ) && isset($_GET['up-icon-remove']) ) :
        echo
        '<div class="notice notice-success is-dismissible">
            <p>Completed: The icon with id <b>'.$_GET['up-icon-remove'].'</b> has been removed permanently.</p>
        </div>';
    endif;
    foreach($db_data as $id => $fields):
        if(isset($db_data[$id]->deleted)):
           if($db_data[$id]->deleted):
                if ( in_array( $pagenow, $admin_pages ) && current_user_can( 'administrator' ) ) :
                    // Display a warning notice for editors
                    echo
                    '<div class="notice notice-warning is-dismissible">
                        <p>Warning: The file for the icon <b>'.$db_data[$id]->label.'</b> has been removed.</p>
                        <p>This may still be in use across the website. Are you sure you would you like to permanently delete this? <a href="?up-icon-remove='.$id.'">Delete</a></p>
                    </div>';
                endif;
           endif;
        endif;
    endforeach;
}
add_action( 'admin_notices', 'up_icons_deleted_notify' );


//Function to permanently delete an icon after user acceptance 
function up_icons_delete_icon($id = false){
    global $up_icons_db_name;
    if($id):
        $db_data = up_icons_get_db();
        unset($db_data[$id]); 
        if(is_multisite()): switch_to_blog(get_main_site_id()); endif;
            update_option($up_icons_db_name, json_encode($db_data));
        if(is_multisite()): restore_current_blog(); endif;
    endif;
}
if(current_user_can( 'administrator' ) && isset($_GET['up-icon-remove'])):
    up_icons_delete_icon($_GET['up-icon-remove']);
endif;

//Store collected icons within the database
function up_icons_db(){
    global $up_icons_db_name;
    $db_data = up_icons_get_db();
    $db_changes = false; //Store if db changes are made

    //Merge custom & native icons
    $loaded_icons = array_merge(up_get_custom_icons(), up_get_theme_icons());

    //Create a lookup array to match existing icons and remove missing ones
    $lookup = array();
    foreach ($db_data as $id => $fields) {
        $found = false;
        foreach($loaded_icons as $icon_cat => $icons):
            if(isset($icons[$fields->file_name])):
                $found = true;
            endif;
        endforeach;
        if(!$found): 
            //To prevent issues with accidentally deleting files require user input
            //Apart from custom icons which already requires user input
            if($db_data[$id]->cat == "custom"): 
                unset($db_data[$id]); 
            else:
                $db_data[$id]->deleted = true;
            endif;
            $db_changes = true;
        else:
            if(isset($db_data[$id]->deleted)):
                if($db_data[$id]->deleted):
                    $db_data[$id]->deleted = false;
                    $db_changes = true;
                endif;
            endif;
        endif;
        array_push($lookup, $fields->file_name);
    }

    //Loop through the found icons and add to database var
    foreach ($loaded_icons as $icon_cat => $icons):
        foreach ($icons as $icon_name => $svg):
            if (!in_array($icon_name, $lookup)): 
                $db_changes = true;
                $db_data[uniqid()] = array(
                    "file_name" => $icon_name,
                    "label" => ucfirst(strtolower(str_replace(['_', '-'], ' ', $icon_name))),
                    "svg" => htmlentities($svg),
                    "cat" => $icon_cat,
                    "deleted" => false
                );
            endif;
        endforeach;
    endforeach;

    //Update database if required
    if($db_changes):
        if(is_multisite()): switch_to_blog(get_main_site_id()); endif;
            update_option($up_icons_db_name, json_encode($db_data));
        if(is_multisite()): restore_current_blog(); endif;
    endif;
}

add_action('wp_loaded', 'up_icons_db');

//Update ACF icons options field
function up_icons_acf_options($field){
    $db_data = up_icons_get_db();
    $field['choices'] = array();
    foreach($db_data as $id => $fields){
        $field['choices'][ $id ] = $fields->label;
    }
    return $field;
}
add_filter('acf/load_field/name=autoloaded_icon', 'up_icons_acf_options');

//Changes the output of icons field from ID to SVG code
function up_icons_acf_output($value){
    $db_data = up_icons_get_db();
    if(isset($db_data[$value])):
        return html_entity_decode($db_data[$value]->svg);
    endif;
}
if($up_enable_acf_field_overwrite):
    add_filter( 'acf/format_value/name=autoloaded_icon', 'up_icons_acf_output',  10, 3);
endif;

function add_icon_picker_scripts() {
    // Enqueue custom CSS and JS files if needed
    wp_enqueue_style('custom-acf-icon-picker-admin-css', get_template_directory_uri() . '/functions/setup-icons/setup-icons.css');
    wp_enqueue_script('custom-acf-icon-picker-admin-js', get_template_directory_uri() . '/functions/setup-icons/setup-icons.js', array('jquery'), null, true);
}
if($up_enable_acf_selector_mask):
   add_action('admin_enqueue_scripts', 'add_icon_picker_scripts');
endif;


function up_icons_field_render() {
    $db_data = up_icons_get_db();
    ?>
        <div class="up-icon-picker-modal">
            <div class="up-icon-picker">
                <div class="up-icon-picker-header">
                    <div class="up-icon-picker-title">
                        <h2>Pick an icon from the library</h2>
                        <div class="up-icon-picker-actions">
                            <a href="<?php echo network_home_url(); ?>/wp-admin/upload.php?custom-icons" rel="noopener" target="_blank" class="up-icon-picker-upload">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2.853v11.509M7.671 7.156L12 2.827l4.329 4.329m3.175 7.427v6.59H4.496v-6.59"/></svg>
                                Add New
                            </a>
                            <button class="up-icon-picker-close">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.755 19.245l14.49-14.49m0 14.49L4.755 4.755"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="up-icon-picker-search">
                        <input type="text" name="up-icon-seach-input" placeholder="Find icons by name or category">
                    </div>
                    <div class="up-icon-picker-filter">
                        <div class="up-icon-picker-categories">
                            <button class="up-icon-picker-category active" data-cat="all">All</button>
                            <?php 
                                $svg_categories = array();
                                foreach($db_data as $icon): 
                                    array_push($svg_categories, $icon->cat);
                                endforeach; 
                                $svg_categories = array_unique($svg_categories);
                                foreach($svg_categories as $category):
                                    ?>  
                                        <button class="up-icon-picker-category" data-cat="<?php echo $category; ?>"><?php echo ucfirst(strtolower(str_replace(['_', '-'], ' ', $category))); ?></button>
                                    <?php
                                endforeach;
                            ?>
                        </div>
                        <div class="up-icon-picker-results">
                            <?php if(is_array($db_data)): ?>
                                <p>Showing: <span class="up-icon-picker-results-number"><?php echo count($db_data); ?></span> results</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="up-icon-picker-grid">
                    <?php 
                    foreach($db_data as $id => $fields):
                        echo "<div class='up-icon-select' data-id='$id' data-cat='$fields->cat' data-value='$fields->label'>";
                            echo "<div class='up-icon-preview'>".html_entity_decode($fields->svg)."</div>";
                            echo "<p>$fields->label</p>";
                        echo "</div>";
                    endforeach;
                    ?>
                </div>
            </div>
        </div>  
    <?php
}
if($up_enable_acf_selector_mask):
    add_action('admin_head', 'up_icons_field_render');
endif;


//This section handles the custom icon admin functions (using upload.php template)
function up_media_custom_icon(){

    if(is_multisite()):
        if(get_current_blog_id() != get_main_site_id()):
            return; //Don't show on subsites
        endif;
    endif;

    function is_async_upload() {
        return isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === 'async-upload.php';
    }

    //This function is used to pass data to the filters 'ajax_query_attachments_args' & 'add_attachment'
    if (is_admin()) {
        if (!session_id()) {
            session_start();
        }
        if (isset($_GET['custom-icons'])) {
            $_SESSION['custom-icons'] = 'true';
            global $submenu_file;
            $submenu_file = "upload.php?custom-icons";

            //Update Media Library Title
            function customize_media_texts( $translated_text, $text, $domain ) {
                switch ( $text ) {
                    case 'Media Library':
                        $translated_text = 'Custom Icons (SVG Files Only)';
                        break;
                }
                return $translated_text;
            }
            add_filter( 'gettext', 'customize_media_texts', 10, 3 );

            //Allow SVGs to be uploaded
            function allow_svg_only( $mimes ) {
                $mimes = array(
                    'svg' => 'image/svg+xml'
                );
                return $mimes;
            }
            add_filter( 'upload_mimes', 'allow_svg_only' );

            //Only allow SVGs to be uploaded for custom icons
            function restrict_uploads_to_svg( $file ) {
                $filetype = wp_check_filetype( $file['name'] );
            
                if ( $filetype['ext'] !== 'svg' ) {
                    $file['error'] = 'Sorry, you can only upload SVG files.';
                }
            
                return $file;
            }
            add_filter( 'wp_handle_upload_prefilter', 'restrict_uploads_to_svg' );

            function custom_css_for_media_library() {
                global $pagenow;
            
                // Check if we are on the 'upload.php' page
                if ( $pagenow === 'upload.php' ) {
                    echo '<style>.media-toolbar-secondary{display:none!important;}</style>';
                }
            }
            add_action( 'admin_head', 'custom_css_for_media_library' );

        }elseif(!defined('DOING_AJAX') && !is_async_upload()){
            unset($_SESSION['custom-icons']);
        }
    }
   

    //Filter media by icons only
    function show_current_user_attachments( $query = array() ) {
        if (isset($_SESSION['custom-icons']) && $_SESSION['custom-icons'] === 'true') {
            $meta_query = array(
                array(
                    'key'     => 'is_icon',
                    'value'   => '1',
                    'compare' => '='
                )
            );
        }else{
            $meta_query = array(
                array(
                    'key'     => 'is_icon',
                    'compare' => 'NOT EXISTS'
                )
            );
        }
        if (isset($query['meta_query']) && is_array($query['meta_query'])) {
            $query['meta_query'][] = $meta_query;
        } else {
            $query['meta_query'] = $meta_query;
        }
        return $query;
    }
    add_filter( 'ajax_query_attachments_args', 'show_current_user_attachments', 10, 1 );
    function add_is_icon_meta_to_media($post_id) {
        if (isset($_SESSION['custom-icons']) && $_SESSION['custom-icons'] === 'true') {
            update_post_meta($post_id, 'is_icon', '1'); 
        }
    }
    add_action('add_attachment', 'add_is_icon_meta_to_media');
    add_submenu_page(
        'upload.php',
        __( 'Custom Icons', 'textdomain' ),
        __( 'Custom Icons', 'textdomain' ),
        'upload_files', // Capability to view the menu
        'upload.php?custom-icons',
        '',
        null
    );
   
}
if($up_enable_custom_icons_upload):
    add_action('admin_init', 'up_media_custom_icon');
endif;

if($up_enable_acf_sync && isset($_GET['sync-acf-icons']) && current_user_can( 'administrator' )):
    if(file_exists(__DIR__ .'/setup-icons-sync.php')):
        include 'setup-icons-sync.php';
    endif;
endif; 
