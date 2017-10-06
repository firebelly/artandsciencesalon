<?php
  /*
    Template name: Services
  */

$locations = get_posts([
  'post_type'=>'location',
  'sort_column'=>'menu_order',
  'sort_order'=>'asc',
  'numberposts' => -1,
]);

?>

<div class="top-section page-block -bottom-underlap -bg-cream-dark">
  <div class="content-wrap">
    <div class="body-content user-content">

    </div>

    <nav class="subpage-nav -has-subpage-sections">
      <h3 class="nav-title">Location</h3>
      <ul class="subpages-list">
        <?php
        foreach ( $locations as $location ) {

          echo '<li class="subpages-list-item"><a href="'.get_permalink($location).'" data-target="'.$location->post_name.'-services" class="subpage-link">'.$location->post_title.'</a>';

          echo Firebelly\PostTypes\Location\get_service_section_nav($location);

          echo '</li>';
        }
        ?>
      </ul>
    </nav>
  </div>
</div>

<div class="main-content user-content page-block -indent-right -top-overlap -bg-cream">
  <?php
  foreach ( $locations as $post ) {
    include(locate_template('templates/services-section.php'));
  }
  ?>
</div>

<?php include(locate_template('templates/experience-levels.php')); ?>