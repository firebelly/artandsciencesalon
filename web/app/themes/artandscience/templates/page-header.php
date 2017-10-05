<?php
use Roots\Sage\Titles;

$header_image = get_the_post_thumbnail_url($post);

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
    <div class="header-image" style="background-image:url('<?= $header_image ?>');"></div>    
  </div>
  <div class="header-text user-content -indent-right-big">
    <?= $header_text ?>
  </div>    
</div>