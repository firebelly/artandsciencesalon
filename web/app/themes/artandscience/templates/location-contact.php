<?php
  $short_title = get_post_meta($location_post->ID, '_cmb2_short_title', true);
  $phone_number = get_post_meta($location_post->ID, '_cmb2_phone_number', true);
?>

<div class="location data-id="<?= $location_post->ID ?>" data-page-title="<?= $location_post->post_title ?>" data-page-url="<?= get_permalink($location_post) ?>">
  <h4 class="location-name"><?= $short_title ?></h4>
  <a class="location-phone" href="tel:<?= $phone_number ?>"><?= $phone_number ?></a>
</div>