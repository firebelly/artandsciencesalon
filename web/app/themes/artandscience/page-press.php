<?php
  /*
    Template name: Press
  */

  $awards = Firebelly\PostTypes\Pages\Press\get_awards();
  $media_inquiries = Firebelly\PostTypes\Pages\Press\get_media_inquiries();
  $notable_press = Firebelly\PostTypes\Pages\Press\get_notable_press();
  $additional_sections = Firebelly\PostTypes\Pages\Press\get_additional_sections();

?>


<div class="awards user-content page-block -bg-cream-dark -bottom-underlap">
 <h2>Awards</h2>
 <?= $awards ?>
</div>



<div class="notable-press user-content page-block -bg-cream -indent-right">
  <div class="media-inquiries user-content page-block -bg-gray-dark -text-cream -bottom-border">
    <h2>Media Inquiries</h2>
    <?= $media_inquiries ?>
  </div>

 <h2>Notable Press</h2>
 <?= $notable_press ?>
 <div class="additional-sections-wrap">
   <?= $additional_sections ?>
 </div>
</div>