<?php
$phone_number = get_post_meta($post->ID, '_cmb2_phone_number', true);
?>

<div id="<?= $post->post_name ?>" class="location data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <h4 class="location-name"><?= $post->post_title ?></h4>
  <p class="location-phone"><?= $phone_number ?></p>
</div>