<?php
  /*
    Template name: Social Impact
  */

$si_galleries = get_posts([
  'post_type'=>'si-gallery',
  'sort_column'=>'menu_order',
  'sort_order'=>'asc',
  'numberposts'=>-1,
]);
$content = apply_filters('the_content',$post->post_content);
$contact = apply_filters('the_content',get_post_meta( $post->ID, '_cmb2_contact', true ));
?>
<div class="page-block description -bg-cream-dark -bottom-underlap">
  <h2 class="content-h1">Hair Cares</h2>
  <div class="user-content">
    <?= $content ?>
  </div>
  <div class="contact user-content">
    <?= $contact ?>
  </div>
</div>

<?php
$posts = $si_galleries;
include(locate_template('templates/page-gallery.php'));
?>