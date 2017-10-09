<?php

$full_name = get_post_meta($post->ID, '_cmb2_full_name', true);
$title = get_post_meta($post->ID, '_cmb2_title', true);

$thumb_url = \Firebelly\Media\get_post_thumbnail_url($post->ID,'gallery-thumb',true);
$id = (isset($location_section) ? $location_section->post_name.'-' : '' ).$post->post_name;

?>

<article id="<?= $id ?>" class="stylist person" data-slug="<?= $post->post_name ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">


  <?php include(locate_template('templates/person-popup.php')); ?>

  <div class="thumbnail-wrap open-person-popup">
    <div style="background-image: url('<?= $thumb_url ?>');" class="thumbnail"></div>
  </div>

  <h4 class="stylist-name open-person-popup"><?= $post->post_title ?></h4>
  <h4 class="stylist-title open-person-popup"><?= $title ?></h4>

</article>