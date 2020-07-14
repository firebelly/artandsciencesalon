<?php
use Roots\Sage\Titles;

// Theme 0 ('a') is the featured image, no treatment
if ( $homepage_theme === 0 ) {
  $header_image_url =  \Firebelly\Media\get_post_thumbnail_url($post->ID, 'gallery', false);
  $header_image_preload_url =  \Firebelly\Media\get_post_thumbnail_url($post->ID, 'preload', false);
}

// Theme 1 ('b') is an alternative, no treatment
if ( $homepage_theme === 1 ) {
  $header_image_url =  \Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID, '_cmb2_alternate_featured_image_id', true),'gallery',false);
  $header_image_preload_url =  \Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID, '_cmb2_alternate_featured_image_id', true),'preload',false);
}

?>

 <div class="page-header<?= !empty($header_class) ? ' '.$header_class : '' ?>">
  <div class="header-image-wrap">
    <div class="header-image lazy" data-src="<?= $header_image_url ?>" data-preload-src="<?= $header_image_preload_url ?>"></div>
  </div>
</div>