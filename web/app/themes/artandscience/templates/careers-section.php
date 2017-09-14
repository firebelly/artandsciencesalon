<?php

  use Roots\Sage\Titles;
  $body = apply_filters('the_content', $post->post_content);

?>

<article id="<?= $post->post_name ?>" class="careers-child-page">
  <h3><?= the_title(); ?></h3>
  <?= $body ?>
</article>