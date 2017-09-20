<?php

  use Roots\Sage\Titles;
  $body = apply_filters('the_content', $post->post_content);

?>

<article id="<?= $post->post_name ?>" class="careers-child-page">
  <h2 class="block-title"><?= the_title(); ?></h2>
  <?= $body ?>
</article>