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
$thumb_preload_url = \Firebelly\Media\get_post_thumbnail_url($post->ID,'preload',true);
$id = (isset($location_section) ? $location_section->post_name.'-' : '' ).$post->post_name;
$name = get_the_title($post);

?>

<div class="person-popup hide-during-page-load user-content">
  <div class="popup-wrap">
    <div class="header-wrap">
      <div class="controls-wrap">
        <div class="thumbnail-wrap">
            <div data-src="<?= $thumb_url ?>" data-preload-src="<?= $thumb_preload_url ?>"" class="thumbnail lazy"></div>
        </div>
      </div>
      <div class="header-content">
        <h4 class="stylist-name"><?= $name ?></h4>
        <p class="stylist-title"><?= $title ?></p>
        <?php if($location_terms) : ?>
          <ul class="location-list semantic-only-list">
            <?php
              foreach ($location_terms as $location_term) {
                $location = Location\get_location_from_term($location_term);
                $location_title = $location->post_title;
                $location_short_title = get_post_meta($location->ID,'_cmb2_short_title',true);
                $location_url = Location\get_link_url($location);
                $location_code = Location\get_code($location->ID);
                echo '<li class="location-list-item"><a href="'.$location_url.'"><span class="long">'.$location_title.'</span><span class="short">'.$location_short_title.'</span> ('.$location_code.')</a></li>';
              }
            ?>
          </ul>
        <?php endif ?>
      </div>
    </div>
    <div class="content-wrap">
      <div class="stylist-quote"><?= $quote ?></div>
      <div class="bio">
        <?= $bio ?>
      </div>

      <div class="block-wrap">

        <?php if ($days_group) : ?>
          <div class="availability block">
            <h4>Days</h4>
            <table class="leader-table">
              <tbody>
                <?php foreach ($days_group as $day) :
                  $location_code = isset($day['location']) ? Location\get_code($day['location']) : '';
                  $day_name = isset($day['day']) ? $day['day'] : '';
                  $day_details = !empty($day['pattern']) ? $day['pattern'] : '';
                  ?>

                  <tr class="leader-row">
                    <td class="leader-left">
                      <span class="leader-text">
                        <?= $day_name ?>
                      </span>
                    </td>
                    <td class="leader-right">
                      <span class="leader-text price">
                        <?= $location_code ?>
                      </span>
                    </td>
                  </tr>

                  <?php if ($day_details) : ?>
                    <tr class="details">
                      <td colspan="2">(<?= $day_details ?>)</td>
                    </tr>
                  <?php endif ?>

                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>


        <?php if ($pricing_group) : ?>
          <div class="pricing block">
            <h4>Pricing</h4>
            <table class="leader-table">
              <tbody>
                <?php foreach ($pricing_group as $service) :
                  $service_name = isset($service['service']) ? $service['service'] : '';
                  $service_details = !empty($service['details']) ? $service['details'] : '';
                  $service_price = isset($service['price']) ? $service['price'] : '';
                  ?>

                  <tr class="leader-row">
                    <td class="leader-left">
                      <span class="leader-text">
                        <?= $service_name ?>
                      </span>
                    </td>
                    <td class="leader-right">
                      <span class="leader-text price">
                        <?= $service_price ?>
                      </span>
                    </td>
                  </tr>
                  <?php if ($service_details) : ?>
                    <tr class="details">
                      <td colspan="2">(<?= $service_details ?>)</td>
                    </tr>
                  <?php endif ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

        <?php if ($lookbook_group) : ?>
          <div class="appointments block">
            <h4>Book an appointment</h4>
            <ul class='location-list semantic-only-list'>
            <?php
            foreach ($location_terms as $location_term) :
              $location_post = Location\get_location_from_term($location_term);
              $location_title = $location_post->post_title;
              $location_url = Location\get_link_url($location_post);
              $location_phone = get_post_meta($location_post->ID, '_cmb2_phone_number', true);
              ?>

              <li class="location-list-item">
                <a href="<?= $location_url ?>" class="name"><?= $location_title ?></a>
                <a href="tel:<?= $location_phone ?>" class="phone"><?= $location_phone ?></a>
              </li>

            <?php endforeach ?>
            </ul>
          </div>
        <?php endif ?>


        <?php if ($lookbook_group) : ?>
          <div class="lookbooks block">
            <h4>Lookbooks</h4>
            <ul class="lookbook-list semantic-only-list">
              <?php
                foreach ($lookbook_group[0] as $lookbook) :
                  $lookbook_url = isset($lookbook['url']) ? $lookbook['url'] : '';
                  $lookbook_source = isset($lookbook['source']) ? $lookbook['source'] : '';
                  ?>
                  <li class="lookbook-list-item">
                    <a target="_blank" href="<?= $lookbook_url ?>">
                      <svg class="icon icon-<?= $lookbook_source ?>" aria-hidden="true" role="image"><use xlink:href="#icon-<?= $lookbook_source ?>"/></svg>
                      <span class="visually-hidden"><?= $lookbook_source ?></span>
                    </a>
                  </li>

                <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

      </div><!-- /.block-wrap -->
    </div><!-- /.content-wrap -->
  </div><!-- /.popup-inner -->
</div><!-- /.popup -->