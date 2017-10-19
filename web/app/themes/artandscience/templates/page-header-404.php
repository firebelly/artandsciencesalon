<?php
  use Roots\Sage\Titles;

  $header_text = '';
  $header_image_url = '';
  $header_image_preload_url = '';

  if($page_not_found = get_page_by_path( 'page-not-found' )) {

    // Cmb2 header_text if available
    $header_text = get_post_meta($page_not_found->ID, '_cmb2_header_text', true);

    // Header image
    $header_image_url = \Firebelly\Media\get_post_thumbnail_url($page_not_found->ID, 'gallery', true);
    $header_image_preload_url = \Firebelly\Media\get_post_thumbnail_url($page_not_found->ID, 'preload', true);
  }

  // Otherwise, normal title
  if (!$header_text) {
    $header_text = Titles\title();
  }
?>

 <div class="page-header <?= $header_class ?>">
  <div class="header-image-wrap">
    <div class="header-image lazy" data-src="<?= $header_image_url ?>" data-preload-src="<?= $header_image_preload_url ?>"></div>
  </div>
  <?php if (!is_front_page()) :?>
    <div class="header-text user-content -indent-right-big">
      <?= $header_text ?>
    </div>
  <?php endif; ?>
</div>