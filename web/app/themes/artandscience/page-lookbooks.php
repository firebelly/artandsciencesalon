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


$content = false;
$posts = $lookbooks;
include(locate_template('templates/page-gallery.php'));