<?php
 $images = get_post_meta( $post->ID, '_cmb2_images', true );
 $content = apply_filters('the_content',$post->post_content);
?>

<?php if($content) :?>
<div class="page-block -bg-gray-dark -text-cream user-content -bottom-underlap -indent-left">
  <?= $content ?>
</div>
<?php endif ?>

<div class="gallery page-block<?= $content ? ' -top-overlap' : '' ?>">
  <ul class="image-list">
  <?php 
  $i = 0;
  foreach ( (array) $images as $attachment_id => $attachment_url ) : 

    $image_url = \Firebelly\Media\get_thumbnail_url($attachment_id,'gallery-thumb',false); // false = these are UNtreated
    $image_preload_url = \Firebelly\Media\get_thumbnail_url($attachment_id,'preload',false);

    ?>

    <li class="image-list-item">
      <div id="image-<?= $i ?>" class="gallery-image image-viewer-popup-open" data-slide="<?= $i ?>">
        <div class="content-wrap">
          <div class="thumbnail lazy" data-src="<?= $image_url ?>" data-preload-src="<?= $image_preload_url ?>">
          </div>
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
    foreach ( (array) $images as $attachment_id => $attachment_url ) : 

    $image_url = \Firebelly\Media\get_thumbnail_url($attachment_id,'gallery',false); // false = these are UNtreated    
    $image_preload_url = \Firebelly\Media\get_thumbnail_url($attachment_id,'preload',false); // false = these are UNtreated
    ?>

      <div class="slide">
        <div class="full-image lazy" data-src="<?= $image_url ?>">
          <div class="load-mask" style="background-image: url('<?= $image_preload_url ?>');"></div>
        </div>
      </div>

      <?php $i++;
    endforeach ?>
  </div>
</div>