<?php

  use Firebelly\PostTypes\People;
  use Firebelly\PostTypes\Location;
  use Firebelly\Media;

  $body = apply_filters('the_content', $post->post_content);
  $address = get_post_meta($post->ID, '_cmb2_address', true);
  $phone_number = get_post_meta($post->ID, '_cmb2_phone_number', true);
  $email = get_post_meta($post->ID, '_cmb2_email', true);
  $virtual_tour_url = get_post_meta($post->ID, '_cmb2_virtual_tour_url', true);
  $hours_group = get_post_meta($post->ID, '_cmb2_hours_group', true);
  $people_types = get_post_meta($post->ID, '_cmb2_people_types', true);
  $location_image_url = Media\get_post_thumbnail_url($post->ID,'gallery',true);
  $location_image_preload_url = Media\get_post_thumbnail_url($post->ID,'preload',true);

  $colorists = People\get_people_list($post, ['colorist', 'master-colorist', 'senior-colorist', 'director-colorist']);
  $stylists = People\get_people_list($post, ['stylist', 'master-stylist', 'senior-stylist', 'director-stylist']);
  $barbers = People\get_people_list($post, ['barber']);
  $aestheticians = People\get_people_list($post, ['aesthetician']);
  $services = Location\get_service_table($post);

?>

<div id="<?= $post->post_name ?>" class="location" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <div class="banner lazy" data-src="<?= $location_image_url ?>" data-preload-src="<?= $location_image_preload_url ?>">
    <?= (!empty($virtual_tour_url))?'<a href="'.$virtual_tour_url.'" target="_blank">Take a virtual tour</a>':''; ?>
  </div>

  <header class="page-block -bg-cream-dark location-header">
    <h4 class="location-name"><?= $post->post_title ?></h4>
    <div class="location-meta">
      <p class="location-address"><?= $address ?></p>
      <p class="location-phone"><a href="tel:<?= $phone_number ?>"><?= $phone_number ?></a></p>
      <p class="location-email"><a href="mailto:<?= $email ?>" target="_blank" class="breakup-email"><?= $email ?></a></p>
    </div>
    <p class="location-description"><?= $body ?></p>
  </header>

  <div class="page-block location-details -bg-cream user-content">
    <div class="details-block-wrap">

      <div class="hours details-block">
        <h4>Hours</h4>
        <table class="leader-table hours-table">
          <?php
          if ($hours_group) {
            foreach ($hours_group as $day) {
              echo '<tr class="leader-row"><td class="day leader-left"><span class="leader-text">'.$day['day'].'</span></td><td class="time leader-right"><span class="leader-text">'.$day['hours'].'</span></td></tr>'.((!empty($day['details']))?'<tr class="hour-details"><td>('.$day['details'].')</td></tr>':'').'';
            }
          }
          ?>
        </table>
      </div>

      <?= $services ?>

      <?php if ($colorists) : ?>
        <div class="services details-block">
          <h4>Colorists</h4>
          <?= $colorists ?>
        </div>
      <?php endif; ?>

      <?php if ($stylists) : ?>
        <div class="services details-block">
          <h4>Stylists</h4>
          <?= $stylists ?>
        </div>
      <?php endif; ?>

      <?php if ($barbers) : ?>
        <div class="services details-block">
          <h4>Barbers</h4>
          <?= $barbers ?>
        </div>
      <?php endif; ?>

      <?php if ($aestheticians) : ?>
        <div class="services details-block">
          <h4>Aestheticians</h4>
          <?= $aestheticians ?>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>




<!-- 
 <?php if (!empty($services_group)) : ?>
      <div class="services details-block">
        <h4>Available Services</h4>
        <table class="data-table services-table">
          <?php
          if ($services_group) {
            foreach ($services_group as $service) {
              echo '<tr><td>'.((!empty($service['link']))?'<a href="'.$service['link'].'">'.$service['service'].'</a>': $service['service']).'</td></tr>';
            }
          }
          ?>
        </table>
      </div>
      <?php endif; ?> -->