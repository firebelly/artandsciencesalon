<?php 
  /*
    Template name: Locations
  */
?>

<?php
  $args = array(
    'numberposts' => -1,
    'post_type' => 'location',
    'orderby' => 'menu_order',
  );

  $location_posts = get_posts($args);

  foreach ( $location_posts as $post ):
    include(locate_template('templates/single-location.php'));
  endforeach;
?>
