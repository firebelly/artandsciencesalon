<?php
  /*
    Template name: Front-page
  */


  $mission1 = get_post_meta($post->ID,'_cmb2_mission1',true);
  $mission2 = get_post_meta($post->ID,'_cmb2_mission2',true);

  $careers_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_careers_image_id',true),'gallery-thumb', false);

  $press = get_post_meta($post->ID,'_cmb2_press',true);

  $services_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_services_image_id',true),'gallery-thumb', false);

  $social_impact = get_post_meta($post->ID,'_cmb2_social_impact',true);

  // Get a random featured person
  $people = get_posts([
    'numberposts' => 1,
    'post_type' => 'person',
    'orderby' => 'rand',
    'tax_query' => [
      [
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => 'featured'
      ]
    ]
  ]);
  if($people) {
    $person = $people[0];
    $person_link_url = 'stylists/#'.$person->post_name;
    $person_image_url = \Firebelly\Media\get_post_thumbnail_url($person->ID,'gallery-thumb',true);
  }

  // Get a random featured lookbook
  $lookbooks = get_posts([
    'numberposts' => 1,
    'post_type' => 'lookbook',
    'orderby' => 'rand',
    'tax_query' => [
      [
        'taxonomy' => 'category',
        'field' => 'slug',
        'terms' => 'featured'
      ]
    ]
  ]);
  if($lookbooks) {
    $lookbook = $lookbooks[0];
    $lookbook_link_url = get_permalink($lookbook);
    $lookbook_image_url = \Firebelly\Media\get_post_thumbnail_url($lookbook->ID,'gallery-thumb',true);
  }


?>
<div class="boxes">

  <div class="top-group">

    <article id="mission-statement" class="box-container left one content-sized-box">
      <div class="box">
        <h2 class="font-h1">
          <span class="line-1"><?= $mission1 ?></span>
          <span class="line-2"><?= $mission2 ?></span>
        </h2>
      </div>
    </article>

    <div class="stylist-careers-subgroup">
      <article id="stylist-spotlight" class="box-container right one aspect-ratio-box bigclicky">
        <div class="aspect-ratio">
          <div class="box">
            <div class="thumb" style="background-image: url('<?= $person_image_url ?>');"></div>
            <h2 class="text-wrap">
              <a href="<?= $person_link_url ?>" class="text-bottom font-h2">Stylist <span class="spotlight font-h3">Spotlight</span></a>
            </h2>
          </div>
        </div>
      </article>

      <article id="careers" class="box-container right two aspect-ratio-box bigclicky">
        <div class="aspect-ratio">
          <div class="box">
            <div class="thumb" style="background-image: url('<?= $careers_image_url ?>');"></div>
            <h2 class="text-wrap">
              <a href="/careers" class="text-bottom font-h2">Careers</a>
            </h2>
          </div>
        </div>
      </article>
    </div>

    <div class="lookbook-press-subgroup">
      <article id="press" class="box-container left three content-sized-box bigclicky">
        <div class="box">
          <h2 class="font-h1">
            <?= $press ?>
          </h2>
          <a href="/press" class="details-link">Learn More</a>
        </div>
      </article>

      <article id="lookbook-spotlight" class="box-container left two aspect-ratio-box bigclicky">
        <div class="aspect-ratio">
          <div class="box">
            <div class="thumb" style="background-image: url('<?= $lookbook_image_url ?>');"></div>
            <h2 class="text-wrap">
              <a href="<?= $lookbook_link_url ?>" class="text-bottom font-h2">Lookbook <span class="spotlight font-h3">Spotlight</span></a>
            </h2>
          </div>
        </div>
      </article>
    </div>
  </div>

  <div class="bottom-group">
    <article id="services" class="box-container left four aspect-ratio-box bigclicky">
      <div class="aspect-ratio">
        <div class="box">
          <div class="thumb" style="background-image: url('<?= $services_image_url ?>');"></div>
          <h2 class="text-wrap">
            <a  href="/careers" class="text-bottom font-h2">Services</a>
          </h2>
        </div>
      </div>
    </article>

    <article id="social-impact" class="box-container right three content-sized-box bigclicky">
      <div class="box">
        <h2 class="font-h1">
          <?= $social_impact ?>
        </h2>
        <a href="/social-impact" class="details-link">Learn More</a>
      </div>
    </article>

    <article id="behind-the-scenes" class="box-container right four aspect-ratio-box bigclicky">
      <div class="aspect-ratio">
        <div class="box">
          <div class="thumb" style="background-image: url('<?= '' ?>');"></div>
          <h2 class="text-wrap" href="/careers">
              <a class="font-h3 diamond text-bottom"><div class="diamond-text">Behind<br>The Scenes</div></a>
            </div>
          </h2>
        </div>
      </div>
    </article>
  </div>

</div>