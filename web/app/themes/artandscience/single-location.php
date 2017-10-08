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

<div id="<?= $post->post_name ?>" class="location" data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <div class="banner" style="background-image:url('<?= $location_image ?>');">
    <?= (!empty($virtual_tour_url))?'<a href="'.$virtual_tour_url.'">Take a virtual tour</a>':''; ?>
  </div>

  <header class="page-block -bg-cream-dark location-header">
    <h4 class="location-name"><?= $post->post_title ?></h4>
    <div class="location-meta">
      <p class="location-address"><?= $address ?></p>
      <p class="location-phone"><?= $phone_number ?></p>
      <p class="location-email"><a href="<?= $email ?>" target="_blank" class="breakup-email"><?= $email ?></a></p>
    </div>
    <p class="location-description"><?= $body ?></p>
  </header>

  <div class="page-block location-details -bg-cream">
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

      <?php if (!empty($services_group)) { ?>
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
  </div>
</div>