<?php 
  /*
    Template name: Stylists
  */
 
 $location_args = array(
   'numberposts' => -1,
   'post_type' => 'location',
   'orderby' => 'menu_order',
 );

 $location_posts = get_posts($location_args);

 $people_type_args = array(
   'taxonomy'=>'person_type'
 );
 $people_types = get_terms($people_type_args);
?>

<nav class="stylists-nav">
  <ul class="locations">
    <?php 
      foreach ($location_posts as $location):
        echo '<li class="location"><a href="#people-'.$location->post_name.'">'.$location->post_name.'</a></li>';
      endforeach;
    ?>
  </ul>

  <ul class="person-types">
    <?php foreach ($location_posts as $location):
      echo '<div class="location-group" data-location="'.$location->post_name.'">';

      foreach ($people_types as $people_type):
        $people_args = array(
          'numberposts' => -1,
          'post_type' => 'person',
          'orderby' => 'menu_order',
          'tax_query' => array(
            'relation' => 'AND',
            array(
              'taxonomy' => 'locations',
              'field' => 'name',
              'terms' => $location->post_title
            ),
            array(
              'taxonomy' => 'person_type',
              'field' => 'slug',
              'terms' => $people_type
            )
          )
        );
        $people = get_posts($people_args);

        if (!empty($people)):
          echo '<li>'.$people_type->name.'</li>';
        endif;
      endforeach;

      echo '</div>';
    endforeach;
    ?>
  </ul>
</nav>

<div class="people-container">
  
  <?php foreach ($location_posts as $location) { ?>

    <div id="people-<?= $location->post_name; ?>" class="people">

      <h4><?= $location->post_title ?></h4>
      
      <?php foreach ($people_types as $people_type) {

        $people_args = array(
          'numberposts' => -1,
          'post_type' => 'person',
          'orderby' => 'menu_order',
          'tax_query' => array(
            'relation' => 'AND',
            array(
              'taxonomy' => 'locations',
              'field' => 'name',
              'terms' => $location->post_title
            ),
            array(
              'taxonomy' => 'person_type',
              'field' => 'slug',
              'terms' => $people_type
            )
          )
        );
        $people = get_posts($people_args);

        if (!empty($people)) {
        ?>
        
        <div class="person-type">
          
          <h3><?= $people_type->name ?>s</h3>

          <div class="people-grid">
            <?php foreach ($people as $post):
              include(locate_template('templates/article-person.php'));
            endforeach; ?>
          </div>

        </div>

      <?php } } ?>

    </div>

  <?php } ?>

</div>
