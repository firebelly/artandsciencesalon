<?php
use Roots\Sage\Titles;

$header_image_url = \Firebelly\Media\get_post_thumbnail_url($post->ID, 'gallery', true);
$header_image_preload_url = \Firebelly\Media\get_post_thumbnail_url($post->ID, 'preload', true);


// Cmb2 header_text if available
$header_text = get_post_meta($post->ID, '_cmb2_header_text', true);


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

 <div class="page-header <?= $header_class ?>">
  <div class="header-image-wrap">
    <div class="header-image lazy" data-src="<?= $header_image_url ?>" data-preload-src="<?= $header_image_preload_url ?>"></div>
  </div>
  <div class="header-text user-content -indent-right-big">
    <?= $header_text ?>
  </div>
</div>