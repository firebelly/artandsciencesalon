<?php
  $experience_levels_page = get_page_by_path( 'experience-levels' );
  $content = apply_filters('the_content', $experience_levels_page->post_content);
  $title = $experience_levels_page->post_title;
?>
<div class="experience-levels user-content page-block -bg-gray-medium -text-cream-dark">
  <h2><?= $title ?></h2>
  <?= $content ?>
</div>