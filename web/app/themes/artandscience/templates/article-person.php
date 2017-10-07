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

<article id="<?= $post->post_name ?>" class="stylist person" data-slug="<?= $post->post_name ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">
  <div class="person-popup hide-during-page-load">
    <div class="popup-wrap">
      <div class="header-wrap">
        <div class="controls-wrap">
          <div class="thumbnail-wrap">
            <div style="background-image: url('<?= $thumb_url ?>');" class="thumbnail"></div>
          </div>
        </div>
        <div class="header-content">
          <h4 class="stylist-name"><?= $post->post_title ?></h4>
          <p class="stylist-title"><?= $title ?></p>
          <ul class="location-list semantic-only-list">
            <?php
              foreach ($location_terms as $location_term) {
                $location = Location\get_location_from_term($location_term);
                $title = $location->post_title;
                $short_title = get_post_meta($location->ID,'_cmb2_short_title',true);
                $url = Location\get_link_url($location);
                $code = Location\get_code($location->ID);
                echo '<li class="location-list-item"><a href="'.$url.'"><span class="long">'.$title.'</span><span class="short">'.$short_title.'</span> ('.$code.')</a></li>';
              }
            ?>
          </p>
        </div>
      </div>
      <div class="content-wrap">
        <div class="stylist-quote"><?= $quote ?></div>
        <div class="bio">
          <?= $bio ?>
        </div>

        <div class="block-wrap">

          <?php if ($days_group[0]) : ?>
            <div class="availability block">
              <h4>Days</h4>
              <table class="leader-table">
                <tbody>
                  <?php foreach ($days_group as $day) :
                    $location_code = isset($day['location']) ? Location\get_code($day['location']) : '';
                    $day_name = isset($day['day']) ? $day['day'] : '';
                    $details = !empty($day['pattern']) ? ' <br><span class="details">'.$day['pattern'].'</span>' : '';
                    ?>

                    <tr class="leader-row">
                      <td class="leader-left">
                        <span class="leader-text">
                          <?= $day_name.$details ?>
                        </span>
                      </td>
                      <td class="leader-right">
                        <span class="leader-text price">
                          <?= $location_code ?>
                        </span>
                      </td>
                    </tr>

                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>


          <?php if ($pricing_group[0]) : ?>
            <div class="pricing block">
              <h4>Pricing</h4>
              <table class="leader-table">
                <tbody>
                  <?php foreach ($pricing_group as $service) :
                    $name = isset($service['service']) ? $service['service'] : '';
                    $details = !empty($service['details']) ? ' <br><span class="details">('.$service['details'].')</span>' : '';
                    $price = isset($service['price']) ? $service['price'] : '';
                    ?>

                    <tr class="leader-row">
                      <td class="leader-left">
                        <span class="leader-text">
                          <?= $name.$details ?>
                        </span>
                      </td>
                      <td class="leader-right">
                        <span class="leader-text price">
                          <?= $price ?>
                        </span>
                      </td>
                    </tr>

                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>

          <div class="appointments block">
            <h4>Book an appointment</h4>
            <ul class='location-list semantic-only-list'>
            <?php
            foreach ($location_terms as $location_term) :
              $location_post = Location\get_location_from_term($location_term);
              $title = $location_post->post_title;
              $url = Location\get_link_url($location_post);
              $phone = get_post_meta($location_post->ID, '_cmb2_phone_number', true);
              ?>

              <li class="location-list-item">
                <a href="'.$url.'" class="name"><?= $title ?></a>
                <span class="phone"><?= $phone ?></span>
              </li>

            <?php endforeach ?>
            </ul>
          </div>


          <?php if ($lookbook_group[0]) : ?>
            <div class="lookbooks block">
              <h4>Lookbooks</h4>
              <ul class="lookbook-list semantic-only-list">
                <?php
                  foreach ($lookbook_group[0] as $lookbook) :
                    $url = isset($lookbook['url']) ? $lookbook['url'] : '';
                    $source = isset($lookbook['source']) ? $lookbook['source'] : '';
                    ?>
                    <li class="lookbook-list-item">
                      <a target="_blank" href="<?= $url ?>">
                        <svg class="icon icon-<?= $source ?>" aria-hidden="true" role="image"><use xlink:href="#icon-<?= $source ?>"/></svg>
                        <span class="visually-hidden"><?= $source ?></span>
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

  <div class="thumbnail-wrap open-person-popup">
    <div style="background-image: url('<?= $thumb_url ?>');" class="thumbnail"></div>
  </div>

  <h4 class="stylist-name open-person-popup"><?= $post->post_title ?></h4>

</article>