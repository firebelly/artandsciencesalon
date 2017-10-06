<?php
  /*
    Template name: Stylists
  */

$location_sections = get_posts([
  'post_type'=>'location',
  'sort_column'=>'menu_order',
  'sort_order'=>'asc',
  'numberposts' => -1,
]);

?>

<div class="top-section page-block -bottom-underlap -bg-cream-dark">
  <div class="content-wrap">
    <nav class="subpage-nav -has-subpage-sections">
      <h3 class="nav-title">Location</h3>
      <ul class="subpages-list">
        <?php
        foreach ( $location_sections as $location_section ) {

          echo '<li class="subpages-list-item"><a href="'.get_permalink($location_section).'" data-target="'.$location_section->post_name.'-people" class="subpage-link">'.$location_section->post_title.'</a>';

          echo Firebelly\PostTypes\People\get_people_section_nav($location_section);

          echo '</li>';
        }
        ?>
      </ul>
    </nav>
  </div>
</div>

<div class="main-content page-block -indent-right -top-overlap -bg-cream user-content">
  <?php
  foreach ( $location_sections as $location_section ) {
    include(locate_template('templates/stylists-section.php'));
  }
  ?>
</div>

<?php include(locate_template('templates/experience-levels.php')); ?>