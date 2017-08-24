<?php 
  /*
    Template name: Careers
  */
 
  $children = get_pages(array('child_of'=>$post->ID,'sort_column'=>'menu_order','sort_order'=>'desc'));
?>

<?php print_r($post->post_title); ?>

<?php
foreach ( $children as $post ) {
  include(locate_template('templates/careers-section.php'));
}
?>