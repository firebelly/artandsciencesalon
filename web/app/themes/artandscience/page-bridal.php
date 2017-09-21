<?php 
  /*
    Template name: Careers
  */
 
  $intro_text = apply_filters('the_content', $post->post_content);
  $details = apply_filters('the_content', get_post_meta( get_the_ID(), '_cmb2_details', true) );
  $fineprint = apply_filters('the_content', get_post_meta( get_the_ID(), '_cmb2_fineprint', true) );

?>

<div class="top-section page-block -bottom-underlap -bg-cream-dark font-h3">
  <div class="content-wrap">
    <div class="body-content user-content">
      <?= $intro_text ?>
    </div>
  </div>
</div>


<div class="main-content user-content page-block -indent-right -top-overlap -bg-cream">
  <h2>Details</h2>
  <?= $details ?>
  <h2>Contact Information</h2>
  <h2>Pricing</h2>
  <h2>The Fine Print</h2>
  <?= $fineprint ?>
</div>