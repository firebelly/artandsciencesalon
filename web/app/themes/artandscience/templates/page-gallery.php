<div class="gallery page-block<?= $content ? ' -top-overlap' : '' ?>">
  <ul class="gallery-list">
  <?php
  foreach ( $posts as $post ) {
    echo '<li class="gallery-list-item">';
    include(locate_template('templates/article-gallery.php'));
    echo '</li>';
  }
  ?>
  </ul>
</div>