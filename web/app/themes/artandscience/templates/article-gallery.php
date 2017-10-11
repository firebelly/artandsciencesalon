<?php

$image = Firebelly\Media\get_post_thumbnail_url($post->ID,'gallery-thumb');

$image_preload = Firebelly\Media\get_post_thumbnail_url($post->ID,'preload');
$permalink = get_permalink($post);

?>


<article id="<?= $post->post_name ?>" class="gallery-article bigclicky -border-bottom">
  <div class="content-wrap page-block">
    <div class="thumbnail lazy" data-src="<?= $image ?>">
      <div class="load-mask" style="background-image: url('<?= $image_preload ?>');"></div>
    </div>
    <h2 class="title">
      <a href="<?= $permalink ?>" class="text-wrap"><?= $post->post_title ?></a>
    </h2>
  </div>
</article>