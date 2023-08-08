<?php

/**
* @desc shortcode for modal
*/
function modalSC($params, $content = null) {
	// default parameters
	extract(shortcode_atts(array(
		'linktext' => '',
		'modaltitle' => '',
		'modalsubtitle' => '',
	), $params));
    $html = "<div class='modal-trigger-wrap'><p><a class='modal-trigger button' href='#'>$linktext</a></p><div style='display:none;'><div class='modal-target'><div class='inpage-modal' style='text-align: center;'><h3>$modaltitle</h3><h4>$modalsubtitle</h4>$content</div></div></div></div>";
    return $html;
}
add_shortcode('modal','modalSC');

/**
* @desc shortcode for button
*/
function buttonSC($params, $content = null) {
	// default parameters
	extract(shortcode_atts(array(
		'link' => '',
		'type' => '',
		'target' => '_self'
	), $params));
    $html = "<a class='button $type' href='$link' target='$target'>$content</a>";
    return $html;
}
add_shortcode('button','buttonSC');

/**
* @desc shortcode for accordion
*/
function accordionSC($params, $content = null) {
    $html = "<div class='accordion'>" . do_shortcode( $content ) . "</div>";
    return $html;
}
add_shortcode('accordion','accordionSC');

// shortcode for accordion-item
function accordion_itemSC($params, $content = null) {
	// default parameters
	extract(shortcode_atts(array(
		'title' => '',
	), $params));
    $html = "<div class='accordion-group'><div class='accordion-title'><h4>$title</h4></div><div class='accordion-content'>$content</div></div>";
    return $html;
}
add_shortcode('accordion-item','accordion_itemSC');
