<?php
  $page_not_found = get_page_by_path( 'page-not-found' );
  $content = $page_not_found ? $page_not_found->post_content : '';
?>

<div class="page-block user-content -indent-right">
  <?= $content ?>
</div>