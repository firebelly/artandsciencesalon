<?php 
  /*
    Template name: Careers
  */
 
  $intro_text = apply_filters('the_content', $post->post_content);
  $details = apply_filters('the_content', get_post_meta( get_the_ID(), '_cmb2_details', true) );
  $contact = Firebelly\PostTypes\Pages\Bridal\get_salons();
  $pricing = Firebelly\PostTypes\Pages\Bridal\get_pricing();
  $fineprint = apply_filters('the_content', get_post_meta( get_the_ID(), '_cmb2_fineprint', true) );

?>

<div class="top-section page-block -bottom-underlap -bg-cream-dark font-h3 -bg-cream-dark">
  <div class="content-wrap">
    <div class="body-content user-content">
      <?= $intro_text ?>
    </div>
  </div>
</div>


<div class="main-content user-content page-block -indent-right -top-overlap">
  <h2>Details</h2>
  <?= $details ?>
  <h2>Contact Information</h2>
  <?= $contact ?>
  <h2>Pricing</h2>
  <?= $pricing ?>
  <h2>The Fine Print</h2>
  <?= $fineprint ?>
</div>