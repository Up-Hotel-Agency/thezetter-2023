<?php

/**
* @desc get the the role object
* @desc add $cap capability to this role object
*/
$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );
