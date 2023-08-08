<?php

/**
* @desc Resize and compress images on uploads
*/
function up_uploadresize_resize($image_data){

  $resizing_enabled = true;

  $force_jpeg_recompression = false;

  $compression_level = 85;

  $max_width  = 2200;

  $max_height = 2200;

  $convert_png_to_jpg = false;

  $convert_gif_to_jpg = false;

  $convert_bmp_to_jpg = true;

  if($convert_png_to_jpg && $image_data['type'] == 'image/png' ) {
    $image_data = up_uploadresize_convert_image( $image_data, $compression_level );
  }

  if($image_data['type'] == 'image/gif' && is_animated($image_data['file'])) {
    //animated gif, don't resize
    return $image_data;
  }

  //---------- In with the old v1.6.2, new v1.7 (WP_Image_Editor) ------------

  if($resizing_enabled || $force_jpeg_recompression) {

		$fatal_error_reported = false;
		$valid_types = array('image/gif','image/png','image/jpeg','image/jpg');

    if(empty($image_data['file']) || empty($image_data['type'])) {
		  $fatal_error_reported = true;
    }
    else if(!in_array($image_data['type'], $valid_types)) {
		  $fatal_error_reported = true;
    }

    $image_editor = wp_get_image_editor($image_data['file']);
    $image_type = $image_data['type'];


    if($fatal_error_reported || is_wp_error($image_editor)) {
    }
    else {

      $to_save = false;
      $resized = false;


      // Perform resizing if required
      if($resizing_enabled) {

        $sizes = $image_editor->get_size();

        if((isset($sizes['width']) && $sizes['width'] > $max_width)
          || (isset($sizes['height']) && $sizes['height'] > $max_height)) {

          $image_editor->resize($max_width, $max_height, false);
          $resized = true;
          $to_save = true;

          $sizes = $image_editor->get_size();
        }
        else {
        }
      }
      else {
      }


      // Regardless of resizing, image must be saved if recompressing
      if($force_jpeg_recompression && ($image_type=='image/jpg' || $image_type=='image/jpeg')) {

        $to_save = true;
      }
      elseif(!$resized) {
      }


      // Only save image if it has been resized or need recompressing
      if($to_save) {

        $image_editor->set_quality($compression_level);
        $saved_image = $image_editor->save($image_data['file']);
      }
      else {
      }
    }
  } // if($resizing_enabled || $force_jpeg_recompression)

  else {
  }

  return $image_data;
}

function up_uploadresize_convert_image( $params, $compression_level ){
  $transparent = 0;
  $image = $params['file'];

  $contents = file_get_contents( $image );
  if ( ord ( file_get_contents( $image, false, null, 25, 1 ) ) & 4 ) $transparent = 1;
  if ( stripos( $contents, 'PLTE' ) !== false && stripos( $contents, 'tRNS' ) !== false ) $transparent = 1;

  $transparent_pixel = $img = $bg = false;
  if($transparent) {
    $img = imagecreatefrompng($params['file']);
    $w = imagesx($img); // Get the width of the image
    $h = imagesy($img); // Get the height of the image
    //run through pixels until transparent pixel is found:
    for($i = 0; $i<$w; $i++) {
      for($j = 0; $j < $h; $j++) {
        $rgba = imagecolorat($img, $i, $j);
        if(($rgba & 0x7F000000) >> 24) {
          $transparent_pixel = true;
          break;
        }
      }
    }
  }

  if( !$transparent || !$transparent_pixel) {
    if(!$img) $img = imagecreatefrompng($params['file']);
    $bg = imagecreatetruecolor(imagesx($img), imagesy($img));
    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, 1);
    imagecopy($bg, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
    $newPath = preg_replace("/\.png$/", ".jpg", $params['file']);
    $newUrl = preg_replace("/\.png$/", ".jpg", $params['url']);
    for($i = 1; file_exists($newPath); $i++) {
      $newPath = preg_replace("/\.png$/", "-".$i.".jpg", $params['file']);
    }
    if ( imagejpeg( $bg, $newPath, $compression_level ) ){
      unlink($params['file']);
      $params['file'] = $newPath;
      $params['url'] = $newUrl;
      $params['type'] = 'image/jpeg';
    }
  }

  return $params;
}

function is_animated($filename) {
  if(!($fh = @fopen($filename, 'rb')))
    return false;
  $count = 0;
  $chunk = false;
  while(!feof($fh) && $count < 2) {
    //add the last 20 characters from the previous string, to make sure the searched pattern is not split.
    $chunk = ($chunk ? substr($chunk, -20) : "") . fread($fh, 1024 * 100); //read 100kb at a time
    $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00(\x2C|\x21)#s', $chunk, $matches);
  }

  fclose($fh);
  return $count > 1;
}

add_action('wp_handle_upload', 'up_uploadresize_resize');
