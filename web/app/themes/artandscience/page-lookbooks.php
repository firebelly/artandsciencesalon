<?php
  /*
    Template name: Lookbooks
  */

$lookbooks = get_posts([
  'post_type'=>'lookbook',
  'sort_column'=>'menu_order',
  'sort_order'=>'asc',
  'numberposts'=>-1,
]);

?>

<div class="main-content gallery page-block">
  <ul class="gallery-list">
  <?php
  foreach ( $lookbooks as $post ) {
    echo '<li class="gallery-list-item">';
    include(locate_template('templates/article-gallery.php'));
    echo '</li>';
  }
  ?>
  </ul>
</div>