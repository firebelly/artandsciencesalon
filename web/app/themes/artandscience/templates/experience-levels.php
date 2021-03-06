<?php
  $experience_levels = get_page_by_path( 'experience-levels' );
  if($experience_levels) {
    $content = apply_filters('the_content', $experience_levels->post_content);
    $title = $experience_levels->post_title;
  }
?>
<div class="experience-popup hide-during-page-load user-content page-block -bg-gray-medium -text-cream-dark" tabindex="-1">
  <?php if ($experience_levels) : ?>
  <h2><?= $title ?></h2>
  <?= $content ?>

  <?php else : ?>
  <h2>Experience Levels Content Not Found</h2>
  <?php endif ?>

</div>