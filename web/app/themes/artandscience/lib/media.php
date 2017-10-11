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
  $url = wp_get_attachment_image_src( $thumb_id , $size)[0];

  // CURRENTLY MISSING TREATMENT CODE -- WILL GET TO THIS

  return $url;
}