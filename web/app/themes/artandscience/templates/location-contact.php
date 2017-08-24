<?php
  $phone_number = get_post_meta($location_post->ID, '_cmb2_phone_number', true);
?>

<div id="<?= $location_post->post_name ?>" class="location data-id="<?= $location_post->ID ?>" data-page-title="<?= $location_post->post_title ?>" data-page-url="<?= get_permalink($location_post) ?>">
  <h4 class="location-name"><?= $location_post->post_title ?></h4>
  <p class="location-phone"><?= $phone_number ?></p>
</div>