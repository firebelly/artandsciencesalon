<?php
  use Firebelly\PostTypes\Location;
?>

<article id="<?= $post->post_name ?>-services" class="subpage careers-child-page">
  <?= Location\get_services_salon_cut() ?>
  <?= Location\get_services_salon_color() ?>
  <?= Location\get_services_barbershop() ?>
  <?= Location\get_services_waxing() ?>
  <?= Location\get_services_tanning() ?>
  <?= Location\get_services_bridal() ?>
</article>