<?php 
if(!function_exists('get_footer_type')){
    // wrap in an if statement in case set in a child theme
    function get_footer_type() {
        $footer_type = 'footer_3'; // set the footer type here
        return $footer_type;
    }
}

register_nav_menu( 'Footer Copyright', 'Footer Copyright' );

if( get_footer_type() == 'footer_1' ) {
    // register menus for footer type 1
    register_nav_menu( 'Footer Menu', 'Footer Menu' );
}

if( get_footer_type() == 'footer_2' ) {
    
    // add fields for footer type 2
    function footer_2_group() {
	
        acf_add_local_field_group(array(
            'key' => 'footer_2_group',
            'title' => 'Footer',
            'menu_order' => '20',
            'fields' => array (
                array (
                    'key' => 'field_footer_address',
                    'label' => 'Address',
                    'name' => 'address',
                    'type' => 'text',
                    'default_value' => '123 Address Street, City, County, AB1 2CD',
                ),
                array (
                    'key' => 'field_footer_telephone',
                    'label' => 'Telephone',
                    'name' => 'telephone',
                    'type' => 'text',
                    'default_value' => '01234 567890',
                ),
                array (
                    'key' => 'field_footer_email',
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'text',
                    'default_value' => 'companyemail@email.com',
                )
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'acf-options-site-options',
                    ),
                ),
            ),
        ));
    }
    add_action('acf/init', 'footer_2_group');
}

// if( get_footer_type() == 'footer_3' ) {

//     // add fields for footer type 3
//     function footer_3_group() {
	
//         acf_add_local_field_group(array(
//             'key' => 'footer_2_group',
//             'title' => 'Footer',
//             'menu_order' => '20',
//             'fields' => array (
//                 array (
//                     'key' => 'field_footer_contact_title',
//                     'label' => 'Contact Title',
//                     'name' => 'contact_title',
//                     'type' => 'text',
//                     'default_value' => 'Get In Touch',
//                 ),
//                 array (
//                     'key' => 'field_footer_address',
//                     'label' => 'Address',
//                     'name' => 'address',
//                     'type' => 'text',
//                     'default_value' => '123 Address Street, City, County, AB1 2CD',
//                 ),
//                 array (
//                     'key' => 'field_footer_telephone',
//                     'label' => 'Telephone',
//                     'name' => 'telephone',
//                     'type' => 'text',
//                     'default_value' => '01234 567890',
//                 ),
//                 array (
//                     'key' => 'field_footer_email',
//                     'label' => 'Email',
//                     'name' => 'email',
//                     'type' => 'text',
//                     'default_value' => 'companyemail@email.com',
//                 )
//             ),
//             'location' => array (
//                 array (
//                     array (
//                         'param' => 'options_page',
//                         'operator' => '==',
//                         'value' => 'acf-options-site-options',
//                     ),
//                 ),
//             ),
//         ));
//     }
//     add_action('acf/init', 'footer_3_group');
// }

if( get_footer_type() == 'footer_2' || get_footer_type() == 'footer_3' ) {
    // menus for footer type 2 and 3
    function footer_menus() {
	
        acf_add_local_field_group(array(
            'key' => 'group_footer_menus',
            'title' => 'Footer Menus',
            'menu_order' => '30',
            'fields' => array (
                array(
                    'key' => 'field_footer_menus',
                    'label' => 'Footer Menus',
                    'name' => 'footer_menus',
                    'type' => 'repeater',
                    'min' => 0,
                    'max' => 4,
                    'button_label' => 'Add Footer Menu',
                    'sub_fields' => array(
                        array (
                            'key' => 'field_footer_menu_title',
                            'label' => 'Footer Menu Title',
                            'name' => 'footer_menu_title',
                            'type' => 'text',
                            'default_value' => 'Footer Menu',
                        ),
                        array(
                            'key' => 'field_footer_menu',
                            'label' => 'Footer Menu',
                            'name' => 'footer_menu',
                            'type' => 'select',
                            'choices' => array(
                            ),
                            'ui' => 1,
                            'return_format' => 'value',
                        ),
                    ),
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'acf-options-site-options',
                    ),
                ),
            ),
        ));
    }
    add_action('acf/init', 'footer_menus');

    function select_menu_choices($field) {
        $field['choices'] = array();

        $menus = wp_get_nav_menus(); 
    
        foreach($menus as $menu){
            // var_export($menus);
            $field['choices'][ $menu->term_id ] = $menu->name;
        }
    
        return $field;
    }
    add_filter('acf/load_field/name=footer_menu', 'select_menu_choices');
}