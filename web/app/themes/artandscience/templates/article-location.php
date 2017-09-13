<?php
$body = apply_filters('the_content', $post->post_content);
$address = get_post_meta($post->ID, '_cmb2_address', true);
$phone_number = get_post_meta($post->ID, '_cmb2_phone_number', true);
$email = get_post_meta($post->ID, '_cmb2_email', true);
?>

<div id="<?= $post->post_name ?>" class="location" data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <h4 class="location-name"><?= $post->post_title ?></h4>
  <p class="location-address"><?= $address ?></p>
  <p class="location-phone"><?= $phone_number ?></p>
  <p class="location-email"><a href="mailto:<?= $email ?>"><?= $email ?></a></p>
  <ul class="location-hours">
    <?php # How should this be handled? Does having the hours be expressed differenty down here necessitate an entirely seperate cmb2 field? For now, hardcoded bogus data below so I can style this: ?>
    <li>Tues-Thurs 10-9</li>
    <li>Fri 10-8</li>
    <li>Sat-Sun 9-6</li>
  </ul>
</div>