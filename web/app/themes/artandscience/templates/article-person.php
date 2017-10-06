<?php

use Firebelly\PostTypes\Location;

$bio = apply_filters('the_content', $post->post_content);
$quote = get_post_meta($post->ID, '_cmb2_quote', true);
$title = get_post_meta($post->ID, '_cmb2_title', true);
$location_terms = get_the_terms($post, 'locations');
$days_group = get_post_meta($post->ID, '_cmb2_days_group', true);
$pricing_group = get_post_meta($post->ID, '_cmb2_pricing_group', true);
$lookbook_group = get_post_meta($post->ID, '_cmb2_lookbook_group', false);
$thumb_url = \Firebelly\Media\get_post_thumbnail_url($post->ID,'gallery-thumb',true);
?>

<article id="<?= $post->post_name ?>" class="stylist data-id="<?= $post->ID ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <div class="person-popup <?= $first_person ? 'first-one' : '' ?>">
    <div class="header-wrap">
      <div class="controls-wrap">
        <div class="thumbnail-wrap">
          <div style="background-image: url('<?= $thumb_url ?>');" class="thumbnail"></div>
        </div>
      </div>
      <div class="header-content">
        <h4 class="stylist-name"><?= $post->post_title ?></h4>
        <p class="stylist-title"><?= $title ?></p>
        <p class="stylist-quote"><?= $quote ?></p>
        <p class="stylist-locations">
          <?php
            foreach ($location_terms as $location_term) {
              $location = Location\get_location_from_term($location_term);
              // echo '<pre>'.var_dump($location).'</pre>';
              $title = $location->post_title;
              $short_title = get_post_meta($location->ID,'_cmb2_short_title',true);
              $url = Location\get_link_url($location);
              $code = Location\get_code($location->ID);
              echo '<a href="'.$url.'"><span class="long">'.$title.'</span><span class="short">'.$short_title.'</span> ('.$code.')</a>';
            }
          ?>
        </p>
      </div>
    </div>
    <div class="content-wrap">
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
    </div><!-- /.content-wrap -->
  </div><!-- /.popup -->

  <div class="thumbnail-wrapper">
    <div style="background-image: url('<?= $thumb_url ?>');" class="thumbnail"></div>
  </div>

  <h4 class="stylist-name"><?= $post->post_title ?></h4>

</article>