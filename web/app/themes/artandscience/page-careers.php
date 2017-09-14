<?php 
  /*
    Template name: Careers
  */
 
  $children = get_pages(array('child_of'=>$post->ID,'sort_column'=>'menu_order','sort_order'=>'asc'));
  $body = apply_filters('the_content', $post->post_content);

?>

<div class="top-section">
  <div class="body-content user-content">
    <?= $body ?>
  </div>
  
  <nav class="careers-nav">
    <ul class="child-pages">
      <?php
      foreach ( $children as $child_page ) {
        echo '<li class="child-page"><a href="'.get_permalink($child_page).'" data-target="'.$child_page->post_name.'">'.$child_page->post_title.'</a></li>';
      }
      ?>
    </ul>
  </nav>

</div>


<div class="main-content user-content">
  <?php
  foreach ( $children as $post ) {
    include(locate_template('templates/careers-section.php'));
  }
  ?>
</div>