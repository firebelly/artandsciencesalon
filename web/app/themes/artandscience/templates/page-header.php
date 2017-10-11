<?php
use Roots\Sage\Titles;

// The homepage handles images differently
if (is_front_page()) {

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

// Every other page, just take the treated featured image
} else {
  $header_image_url = \Firebelly\Media\get_post_thumbnail_url($post->ID, 'gallery', true);
  $header_image_preload_url = \Firebelly\Media\get_post_thumbnail_url($post->ID, 'preload', true);
}

$header_text = '';

// Cmb2 header_text if available
if(isset($post)) {
  $header_text = get_post_meta($post->ID, '_cmb2_header_text', true);
}

// Otherwise, normal title
if (!$header_text) {
  $header_text = Titles\title();
}

// Prepend post type
if ( 'lookbook' == get_post_type() ) {
  $header_text = '<h2>Lookbook</h2>'.$header_text;
}
if ( 'si-gallery' == get_post_type() ) {
  $header_text = '<h2>Gallery</h2>'.$header_text;
}

// Throw special class if header is very short
$header_class = strlen($header_text) < 30 ? ' -has-short-text' : '';
?>

 <div class="page-header<?= $header_class ?>">
  <div class="header-image-wrap">
    <div class="header-image lazy" data-src="<?= $header_image_url ?>" data-preload-src="<?= $header_image_preload_url ?>"></div>
  </div>
  <?php if (!is_front_page()) :?>
    <div class="header-text user-content -indent-right-big">
      <?= $header_text ?>
    </div>
  <?php endif; ?>
</div>