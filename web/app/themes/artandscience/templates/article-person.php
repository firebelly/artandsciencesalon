<?php
$bio = apply_filters('the_content', $post->post_content);
$quote = get_post_meta($post->ID, '_cmb2_quote', true);
$title = get_post_meta($post->ID, '_cmb2_title', true);
$locations = get_the_terms($post, 'locations');
$days_group = get_post_meta($post->ID, '_cmb2_days_group', true);
$pricing_group = get_post_meta($post->ID, '_cmb2_pricing_group', true);
$lookbook_group = get_post_meta($post->ID, '_cmb2_lookbook_group', false);
?>

<div id="<?= $post->post_name ?>" class="stylist data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  
  <?php if ($thumb = \Firebelly\Media\get_post_thumbnail($post->ID)): ?>
  <img src="<?= $thumb ?>">
  <?php endif; ?>

  <div class="bio">
    <h4 class="stylist-name"><?= $post->post_title ?></h4>
    <p class="stylist-title"><?= $title ?></p>
    <p class="stylist-quote"><?= $quote ?></p>
    <p class="stylist-locations">
      <?php
        $i = 0;
        foreach ($locations as $location) {
          $i++;
          $title = get_the_title($location);
          $permalink = get_permalink($location);
          echo '<a href="'.$permalink.'">'.$title.'</a>';
          if (count($locations) > 1 && $i < count($locations)) {
            echo '<br>';
          }
        }
      ?>
    </p>

    <div class="availability">
      <h4>Days</h4>
      <table class="data-table availability-table">    
        <?php 
        if ($days_group) {
          foreach ($days_group as $day) {
            $location = get_post_meta($day['location'], '_cmb2_code', true);

            echo '<tr><td>'.$day['day'].((!empty($day['pattern']))?'<span>'.$day['pattern'].'</span>':'').'</td><td>'.$location.'</td></tr>';
          }
        }
        ?>
      </table>
    </div>

    <div class="availability">
      <h4>Pricing</h4>
      <table class="data-table pricing-table">    
        <?php 
        if ($pricing_group) {
          foreach ($pricing_group as $service) {
            echo '<tr><td>'.$service['service'].((!empty($service['details']))?'<span>'.$service['details'].'</span>':'').'</td><td>'.$service['price'].'</td></tr>';
          }
        }
        ?>
      </table>
    </div>

    <div class="appointments">
      <h4>Book an appointment</h4>
      <?php
        $i = 0;
        foreach ($locations as $location) {
          $i++;
          $title = get_the_title($location);
          $permalink = get_permalink($location);
          echo '<a href="'.$permalink.'">'.$title.'</a>';
          if (count($locations) > 1 && $i < count($locations)) {
            echo '<br>';
          }
        }
      ?>
    </div>

    <div class="lookbooks">
      <h4>Lookbooks</h4>
      <ul class="lookbook-links">
        <?php 
        if ($lookbook_group[0]) {
          foreach ($lookbook_group[0] as $lookbook) {
            echo '<li><a href="'.$lookbook['_cmb2_url'].'" target="_blank">'.$lookbook['_cmb2_source'].'</a></li>';
          }
        }
        ?>
      </ul>
    </div>

  </div><!-- /.bio -->

</div>