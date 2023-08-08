<?php
/**
 * @desc Removes the post_fields from the form editor
 */
    add_filter( 'gform_field_groups_form_editor', 'hide_post_fields', 10, 1 );

    function hide_post_fields( $field_groups ){
        foreach ( $field_groups as &$group ){
            if ( $group['name'] == 'post_fields' ){
                $group['fields'] = array();
            }
        }

        return $field_groups;
    }