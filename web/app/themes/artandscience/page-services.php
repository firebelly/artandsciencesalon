<?php 
  /*
    Template name: Services
  */
 
$locations = get_posts(['post_type'=>'location','sort_column'=>'menu_order','sort_order'=>'asc']);

?>

<div class="top-section page-block -bottom-underlap -bg-cream-dark">
  <div class="content-wrap">
    <div class="body-content user-content">
      
    </div>
    
    <nav class="subpage-nav">
      <ul class="child-pages">
        <?php
        $i = 0;
        foreach ( $locations as $location ) {
          echo '<li class="child-page"><a href="'.get_permalink($location).'" data-target="'.$location->post_name.'-services">'.$location->post_title.'</a></li>';
          $i++;
        }
        ?>
      </ul>
    </nav>
  </div>
</div>

<?php

?>

<?php include(locate_template('templates/experience-levels.php')); ?>

<div class="main-content user-content page-block -indent-right -top-overlap -bg-cream">
  <?php
  foreach ( $locations as $post ) {
    include(locate_template('templates/services-section.php'));
  }
  ?>
</div>