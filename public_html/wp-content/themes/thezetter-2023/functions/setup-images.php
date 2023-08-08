<?php
/*
TODO: Ability to pass through custom srcset and sizes in options, as well as select from a group of presets

Example, 1. can manually enter a whole srcset if required. Or 2. can specify image width "quarter" or "half" or "third" for example (which will be passed through from page builder) - this will adjust the srcset and sizes to match.
*/

function _all_img_sizes($img_field){
    // TODO: Replace this with get_intermediate_image_sizes()
  $images = [
    'full' => wp_get_attachment_image_src( $img_field, 'full' )[0],
    'img_188'  => wp_get_attachment_image_src( $img_field, 'img_188' )[0],
    'img_375'  => wp_get_attachment_image_src( $img_field, 'img_375' )[0],
    'img_500'  => wp_get_attachment_image_src( $img_field, 'img_500' )[0],
    'img_640'  => wp_get_attachment_image_src( $img_field, 'img_640' )[0],
    'img_800'  => wp_get_attachment_image_src( $img_field, 'img_800' )[0],
    'img_1024' => wp_get_attachment_image_src( $img_field, 'img_1024' )[0],
    'img_1367' => wp_get_attachment_image_src( $img_field, 'img_1367' )[0],
    'img_1920' => wp_get_attachment_image_src( $img_field, 'img_1920' )[0],
    'img_2200' => wp_get_attachment_image_src( $img_field, 'img_2200' )[0],
  ];

  return $images;
}

function img_src_by_size($img_field, $size){
    $images = _all_img_sizes($img_field);
    return $images[$size];
}

/**
 * Example:
 * echo img_sizes($img_field);
 *
 * echo img_sizes($img_field, [
 *                              'default' => 'img_1024',
 *                              'lazy_load' => false,
 *                              'page_area' => '75',
 *                              'tablet_page_area' => '85',
 *                              'mobile_page_area' => '90',
 *                              'override_srcset' => '{{800}} 50w, {{500}} 25w'
 *                              'object_fit' => 'object-fit'
 *                            ]);
 *
 * default: Which size of image should be used in the src= attribute? 1024 if not specified
 * lazy_load: Disable lazy load. Use this for initial images that show above the fold. Users shouldn't have to wait for those
 * page_area: The percentage of the screen you expect the image to take up. Will be used in sizes= attribute (you'll still need your own CSS). Just a number: e.g. 75, not 75%
 * tablet_page_area: The percentage of the screen you expect the image to take up if the viewport is tablet-sized (usually 1024px). If left blank, defaults to the defined page_area
 * mobile_page_area: The percentage of the screen you expect the image to take up if the viewport is mobile-sized (usually 768px). If left blank, defaults to 100
 * override_srcset: Override a custom srcset with your own. Use the placeholder {{image_size_url}}, e.g. ['override_srcset' => '{{800}} 50w, {{500}} 25w']
 * object_fit: Can be empty, 'cover', or 'contain'. 'cover' is default
 *
 */
function img_sizes($img_field, $opts = []){
  $lazy_load = true;
  if(isset($opts['lazy_load']))
      $lazy_load = $opts['lazy_load'];

  $default = isset($opts['default']) ? $opts['default'] : 'img_1024';
  $page_area = isset($opts['page_area']) ? $opts['page_area'] : '75';
  $tablet_page_area = isset($opts['tablet_page_area']) ? $opts['tablet_page_area'] : $page_area;
  $mobile_page_area = isset($opts['mobile_page_area']) ? $opts['mobile_page_area'] : '100';
  $override_srcset = isset($opts['override_srcset']) ? $opts['override_srcset'] : false;
  $object_fit = isset($opts['object_fit']) ? $opts['object_fit'] : 'object-fit';
  $class = isset($opts['class']) ? $opts['class'] : '';
  $aspect = isset($opts['aspect']) ? $opts['aspect'] : false;

  if($object_fit == 'cover')
      $object_fit = 'object-fit';

  if($object_fit == 'contain')
      $object_fit = 'object-fit contain';

  $images = _all_img_sizes($img_field);
  $alt_text = get_post_meta($img_field, '_wp_attachment_image_alt', true);
  $img_title = get_the_title($img_field);

  $alt = ($alt_text) ? $alt_text : $img_title;

  if( isset($opts['styles']) ):
    $styles = $opts['styles'];
  else:
    $styles = null;
  endif;

  $default_img = $images[$default];
  if(!$default_img) # in case dev specifies bad size
      $default_img = $images['img_1024'];

  // Replace override_srcset tokens e.g. {{500}} with their values in _all_img_sizes()
  if($override_srcset){
      $replacer = function($matches) use ($img_field){
          $size = array_pop($matches);

          if(!is_numeric($size))
              throw new InvalidArgumentException("Image size was not a number: $size");

          $img = img_src_by_size($img_field, $size);
          if(!$img)
              throw new InvalidArgumentException("Image size did not exist: $size");

          return $img;
      };

      $override_srcset = preg_replace_callback('/(\{\{(\w+)\}\})/', $replacer, $override_srcset);
  }

  ob_start();
  require(__DIR__ . '/../templates/img_sizes.tpl.php');
  $out = ob_get_clean();
  return $out;
}
