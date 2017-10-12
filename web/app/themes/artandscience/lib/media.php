<?php
/**
 * Various media functions
 */

namespace Firebelly\Media;

// Compress jpegs
add_filter( 'jpeg_quality', create_function( '', 'return 80;' ) );

// Add image sizes
add_image_size( 'preload', 50 );
add_image_size( 'gallery', 1600 );
add_image_size( 'gallery-thumb', 800 );
add_image_size( 'popout-thumb', 250, 300, ['center', 'top'] );

/**
 * Get thumbnail image for post
 * @param  integer $post_id
 * @return string image URL
 */
function get_post_thumbnail_url($post_id, $size = 'gallery', $treated=true) {
  $return = false;
  if (has_post_thumbnail($post_id)) {
    $return = get_thumbnail_url(get_post_thumbnail_id($post_id), $size, $treated);
  }
  return $return;
}

// Get URL of thumbnail image at proper size
function get_thumbnail_url($thumb_id, $size = 'gallery', $treated=true) {

  if($treated) {
    $url = get_treated_url($thumb_id, $size);
  } else {
    $url = wp_get_attachment_image_src($thumb_id , $size)[0];
  }

  return $url;
}

/**
 * Get the file path (not URL) to a thumbnail of a particular size.  
 * (get_attached_file() only returns paths to full-sized thumbnails.)  
 * @param  int            $thumb_id - attachment id of thumbnail
 * @param  string|array   $size - thumbnail size string (e.g. 'full') or array [w,h]
 * @return path           file path to properly sized thumbnail
 */
function get_thumbnail_size_path($thumb_id,$size) {
  // Find the path to the root image. We can get this from get_attached_file.
  $old_path = get_attached_file($thumb_id, true);

  // Find the url of the image with the proper size
  $attr = wp_get_attachment_image_src( $thumb_id , $size);
  $url = $attr[0];

  // Grab the filename of the sized image from the url
  $exploded_url =  explode ( '/' , $url );
  $filename = $exploded_url[ count($exploded_url)-1 ];

  // Replace the filename in our path with the filename of the properly sized image
  $exploded_path = explode ( '/' , $old_path );
  $exploded_path[count($exploded_path)-1] = $filename; 
  $new_path = implode ( '/' , $exploded_path );

  return $new_path;
}

/**
 * Get url for duo image, make duo image if non-existent
 * @param  int|object   $post_or_id (WP post object or image attachment id)
 * @return URL            background image code
 * e.g. get_treated_url($id, ['type'=>'color'])
 */
function get_treated_url($post_or_id, $size, $type='default') {

  // If WP post object, get the featured image
  if (is_object($post_or_id)) {
    if (has_post_thumbnail($post_or_id->ID)) {
      $thumb_id = get_post_thumbnail_id($post_or_id->ID);
    } else { 
      return false;  //thumbnail not found
    }
  } else {
    // Otherwise, id was sent directly
    $thumb_id = $post_or_id;
  }
  $full_image = get_attached_file($thumb_id, true); //this only returns images of size 'full'

  // Do not proceed if full image not found
  if (!file_exists($full_image)) { 
    return false; 
  } 

  // Get the image of proper size
  $image_to_convert = get_thumbnail_size_path($thumb_id,$size);

  // Do not proceed if sized image not found
  if (!file_exists($image_to_convert)) { 
    return false; 
  }

  $upload_dir = wp_upload_dir();
  $treated_dir = '/treated_'.$type.'/';
  $base_dir = $upload_dir['basedir'] . $treated_dir;

  // Build treated filename with thumb_id in case there are filename conflicts
  $treated_filename = preg_replace("/.+\/(.+)\.(\w{2,5})$/", $thumb_id."-$1-".$type.".$2", $image_to_convert);
  $treated_image = $base_dir . $treated_filename;

  // If treated file doesn't exist, create it
  // if (!file_exists($treated_image)) {
    // If the duo directory doesn't exist, create it first
    if(!file_exists($base_dir)) {
      mkdir($base_dir);
    }

    // Build the ImageMagick convert command and execute
    $convert_command = (WP_ENV==='development') ? '/usr/local/bin/convert' : '/usr/bin/convert';
    $full_command = '';
 
    // GRAY TO TEST
    if ($type==='gray') {
      //convert keys.jpg -modulate 100,0 -size 256x1! gradient:#555555-#dddddd -clut keys-treated.jpg
      $full_command = $convert_command.' '.$image_to_convert.' -modulate 100,0 -size 256x1! gradient:#555555-#BDBDBD -clut -quality 75 '.$treated_image;

    // DEFAULT BEHAVIOR
    } else {
      // convert test1.jpg -brightness-contrast -5%x-20% +level 13%,87%,1.3 -channel B +level 1% testfoo10.jpg
      $full_command = $convert_command.' '.$image_to_convert.' -brightness-contrast -5%x-20% +level 13%,87%,1.3 -channel B +level 1% '.$treated_image;
    }

    if($full_command) { exec($full_command); }

  // echo '<script>console.log(\'MESSAGE FROM PHP:'.$full_command.'\');</script>';
  // }

  // Finally, get the URL
  $duo_url = $upload_dir['baseurl'] . $treated_dir . $treated_filename;
  return $duo_url;
}
