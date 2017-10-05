<?php

$header_image = get_the_post_thumbnail_url($post);
$permalink = get_permalink($post);

?>


<article id="<?= $post->post_name ?>" class="gallery-article bigclicky -bottom-border">
  <div class="content-wrap page-block">
    <div class="thumbnail" style="background-image: url('<?= $header_image ?>');"></div>
    <h2 class="title">
      <a href="<?= $permalink ?>" class="text-wrap"><?= $post->post_title ?></a>
    </h2>
  </div>
</article>