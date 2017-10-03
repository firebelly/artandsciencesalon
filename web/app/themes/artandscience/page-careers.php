<?php 
  /*
    Template name: Careers
  */
 
  $children = get_pages(array('child_of'=>$post->ID,'sort_column'=>'menu_order','sort_order'=>'asc'));
  $body = apply_filters('the_content', $post->post_content);

?>

<div class="top-section page-block -bottom-underlap -text-cream -bg-gold">
  <div class="content-wrap">
    <div class="body-content user-content">
      <?= $body ?>
    </div>
    
    <nav class="subpage-nav">
      <ul class="subpages-list">
        <?php
        $i = 0;
        foreach ( $children as $child_page ) {
          // Open the row at beginning of each 3-element group
          if ($i % 3 === 0) { 
            echo '<div class="row">';
          }
          // Write nav item
          echo '<li class="subpages-list-item"><a href="'.get_permalink($child_page).'" data-target="'.$child_page->post_name.'" class="subpage-link">'.$child_page->post_title.'</a></li>';
          // Close the row at end of each group
          if ($i % 3 === 2) {
            echo '</div><!-- /.row -->';
          }
          $i++;
        }
        // Close out the row if we haven't already
        if ($i % 3 !== 0) { 
          echo '</div><!-- /.row -->';
        }
        ?>
      </ul>
    </nav>
  </div>
</div>


<div class="main-content user-content page-block -indent-right -top-overlap -bg-cream-dark">
  <?php
  foreach ( $children as $post ) {
    include(locate_template('templates/careers-section.php'));
  }
  ?>
</div>