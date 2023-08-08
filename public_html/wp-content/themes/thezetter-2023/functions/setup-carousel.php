<?php

/**
* @desc Override the WP inpage gallery markup to make it a carousel
* @link https://codex.wordpress.org/The_WordPress_Gallery
*/

 add_filter('post_gallery','customFormatGallery',10,2);
 function customFormatGallery($string,$attr){
     $output = "<div class=\"inpage-gallery\">";
     $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));
     foreach($posts as $imagePost){
         $output .= "<img src='".wp_get_attachment_image_src($imagePost->ID, 'small')[0]."' class='object-fit' srcset='".wp_get_attachment_image_src($imagePost->ID, 'medium')[0]." 768w, ".wp_get_attachment_image_src($imagePost->ID, 'large')[0]." 1024w, ".wp_get_attachment_image_src($imagePost->ID, 'large')[0]." 1367w, ".wp_get_attachment_image_src($imagePost->ID, 'full')[0]." 1920w, ".wp_get_attachment_image_src($imagePost->ID, 'full')[0]." 2200w'
         sizes='(max-width: 48em) 98vw, (max-width: 85em) 90vw, (max-width: 120em) 75vw, 90em'>";
     }
     $output .= "</div>";
     return $output;
 }
