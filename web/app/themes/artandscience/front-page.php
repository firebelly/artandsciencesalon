<?php
  /*
    Template name: Front-page
  */

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
    $person_thumb_url = \Firebelly\Media\get_post_thumbnail_url($person->ID,'gallery-thumb',true);
  }


?>
<div class="boxes">
  <article class="box-container left one content-sized-box" id="mission-statement">
    <div class="box">
      <h2 class="font-h1">
        <span class="line-1">Hair is our Passion</span>
        <span class="line-2">Education is our Mission</span>
      </h2>
    </div>
  </article>
  <article class="box-container right one aspect-ratio-box bigclicky" id="stylist-spotlight">


    <div class="aspect-ratio">
      <div class="box" style="background-image: url('<?= $person_thumb_url ?>');">
        <h2 class="text-wrap">
          <a href="<?= $person_link_url ?>" class="text-bottom font-h2">Stylist <span class="spotlight font-h3">Spotlight</span></a>
        </h2>
      </div>
    </div>
  </article>
  <article class="box-container right two aspect-ratio-box bigclicky" id="careers">
    <div class="aspect-ratio">
      <div class="box">
        <h2 class="text-wrap" href="/careers">
          <a class="text-bottom font-h2">Careers</a>
        </h2>
      </div>
    </div>
  </article>
  <article class="box-container left three content-sized-box bigclicky" id="press">
    <div class="box">
      <h2 class="font-h1">
        Voted Best Hair In Chicago
      </h2>
      <a href="/press" class="details-link">Learn More</a>
    </div>
  </article>
  <article class="box-container left two aspect-ratio-box bigclicky" id="lookbook-spotlight">
    <div class="aspect-ratio">
      <div class="box">
        <h2 class="text-wrap" href="#">
          <a class="text-bottom font-h2">Lookbook <span class="spotlight font-h3">Spotlight</span></a>
        </h2>
      </div>
    </div>
  </article>
  <article class="box-container left four aspect-ratio-box bigclicky" id="services">
    <div class="aspect-ratio">
      <div class="box">
        <h2 class="text-wrap" href="/careers">
          <a class="text-bottom font-h2">Services</a>
        </h2>
      </div>
    </div>
  </article>
  <article class="box-container right three content-sized-box bigclicky" id="social-impact">
    <div class="box">
      <h2 class="font-h1">
        We Take Pride In Giving Back
      </h2>
      <a href="/social-impact" class="details-link">Learn More</a>
    </div>
  </article>
  <article class="box-container right four aspect-ratio-box bigclicky" id="behind-the-scenes">
    <div class="aspect-ratio">
      <div class="box">
        <h2 class="text-wrap" href="/careers">
            <a class="font-h3 diamond text-bottom"><div class="diamond-text">Behind<br>The Scenes</div></a>
          </div>
        </h2>
      </div>
    </div>
  </article>
</div>