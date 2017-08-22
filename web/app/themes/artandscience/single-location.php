<?php
  $body = apply_filters('the_content', $post->post_content);
  $address = get_post_meta($post->ID, '_cmb2_address', true);
  $phone_number = get_post_meta($post->ID, '_cmb2_phone_number', true);
  $email = get_post_meta($post->ID, '_cmb2_email', true);
  $virtual_tour_url = get_post_meta($post->ID, '_cmb2_virtual_tour_url', true);
  $hours_group = get_post_meta($post->ID, '_cmb2_hours_group', true);
  $services_group = get_post_meta($post->ID, '_cmb2_services_group', true);
  $people_types = get_post_meta($post->ID, '_cmb2_people_types', true);
  $location_image = get_the_post_thumbnail_url($post);

  $stylists_args = array(
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'location',
        'field' => 'name',
        'terms' => $post->post_title
      ),
      array(
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => array('stylist', 'master-stylist', 'senior-stylist', 'director-stylist')
      )
    )
  );

  $barbers_args = array(
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'location',
        'field' => 'name',
        'terms' => $post->post_title
      ),
      array(
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => 'barber'
      )
    )
  );

  $aestheticians_args = array(
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'location',
        'field' => 'name',
        'terms' => $post->post_title
      ),
      array(
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => 'aesthetician'
      )
    )
  );

  $colorists_args = array(
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'location',
        'field' => 'name',
        'terms' => $post->post_title
      ),
      array(
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => array('colorist', 'master-colorist', 'senior-colorist', 'director-colorist')
      )
    )
  );

?>

<div id="<?= $post->post_name ?>" class="location data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <div class="banner" style="background-image:url('<?= $location_image ?>');">
    <?= (!empty($virtual_tour_url))?'<a href="'.$virtual_tour_url.'">Take a virtual tour</a>':''; ?>
  </div>
    
  <h4 class="location-name"><?= $post->post_title ?></h4>
  <p class="location-address"><?= $address ?></p>
  <p class="location-phone"><?= $phone_number ?></p>
  <p class="location-email"><?= $email ?></p>

  <div class="hours">
    <h4>Hours</h4>
    <table class="data-table hours-table">
      <?php 
      if ($hours_group) {
        foreach ($hours_group as $day) {
          echo '<tr><td>'.$day['day'].((!empty($day['details']))?'<span>'.$day['details'].'</span>':'').'</td><td>'.$day['hours'].'</td></tr>';
        }
      }
      ?>
    </table>
  </div>

  <?php if (!empty($services_group)) { ?>
  <div class="services">
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
  <?php } ?>

  <?php 
    if (!empty($people_types)) {

      foreach ($people_types as $people_type) {
        $people_type_args = $people_type.'_args';
        $people = get_posts($$people_type_args);

        $people_type_title = ucfirst($people_type);

        if (!empty($people)) {
          echo '<h4>'.$people_type_title.'</h4>';
          foreach ($people as $person):
            echo $person->post_title;
          endforeach;
        }
      }
    }
  ?>
</div>