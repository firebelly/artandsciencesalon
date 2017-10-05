<?php
 $images = get_post_meta( $post->ID, '_cmb2_images', true );
 $content = apply_filters('the_content',$post->post_content);
?>

<?php if($content) :?>
<div class="page-block -bg-gray-dark -text-cream user-content -bottom-underlap -indent-left">
  <?= $content ?>
</div>
<?php endif ?>

<div class="main-content gallery page-block<?= $content ? ' -top-overlap' : '' ?>">
  <ul class="image-list">
  <?php 
  $i = 0;
  foreach ( (array) $images as $attachment_id => $attachment_url ) : ?>

    <li class="image-list-item">
      <div id="image-<?= $i ?>" class="gallery-image image-viewer-popup-open" data-slide="<?= $i ?>">
        <div class="thumbnail -bottom-border page-block" style="background-image: url('<?= $attachment_url ?>');">
        </div>
      </div>
    </li>

    <?php $i++;
  endforeach ?>
  </ul>
</div>

<div class="image-viewer-popup hide-during-page-load">
  <div class="image-slider">
    <?php 
    $i = 0;
    foreach ( (array) $images as $attachment_id => $attachment_url ) : ?>

      <div class="slide">
        <div class="full-image" style="background-image: url('<?= $attachment_url ?>');"></div>
      </div>

      <?php $i++;
    endforeach ?>
  </div>
</div>