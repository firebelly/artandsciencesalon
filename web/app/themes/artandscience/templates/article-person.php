<?php

use Firebelly\PostTypes\Location;


$name = Firebelly\PostTypes\People\get_short_name($post);
$thumb_url = \Firebelly\Media\get_post_thumbnail_url($post->ID,'gallery-thumb',true);
$id = (isset($location_section) ? $location_section->post_name.'-' : '' ).$post->post_name;

?>

<article id="<?= $id ?>" class="stylist person" data-slug="<?= $post->post_name ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">


  <?php include(locate_template('templates/person-popup.php')); ?>

  <div class="thumbnail-wrap open-person-popup">
    <div style="background-image: url('<?= $thumb_url ?>');" class="thumbnail"></div>
  </div>

  <h4 class="stylist-name open-person-popup"><?= $name ?></h4>

</article>