<?php
  /*
    Template name: About
  */

  $philosophy =apply_filters('the_content',  get_post_meta($post->ID,'_cmb2_philosophy',true) );
  $philosophy_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_philosophy_image_id',true),'gallery-thumb');

  $david_bio = apply_filters('the_content', '<h3 class="owner-name">David Raccuglia</h3>'.get_post_meta($post->ID,'_cmb2_david_bio',true) );
  $david_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_david_image_id',true),'gallery-thumb');

  $paul_bio = apply_filters('the_content', '<h3 class="owner-name">Paul Wilson</h3>'.get_post_meta($post->ID,'_cmb2_paul_bio',true) );
  $paul_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_paul_image_id',true),'gallery-thumb');

  $managing_partners = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_managing_partners',true) );

  $educators = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_educators',true) );

  $social_impact = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_social_impact',true) );

  $barbershops = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_barbershops',true) );
  $barbershops_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_barbershops_image_id',true),'gallery-thumb');

?>

<div class="page-block -bg-cream-dark -bottom-underlap philosophy">
  <div class="content">
    <div class="image">
      <div class="thumbnail-wrap">
        <div class="thumbnail" style="background-image: url(<?= $philosophy_image_url ?>);"></div>
      </div>
    </div>
    <h2 class="user-content-h1">Philosophy</h2>
    <div class="user-content">
      <?= $philosophy ?>
    </div>
  </div>
</div>
<div class="page-block -bg-gray-dark -text-cream -indent-right-big -top-overlap owners">
  <h2 class="user-content-h1">Owners</h2>
  <div class="owner">
    <div class="user-content owner-bio"><?= $david_bio ?></div>
    <div class="image">
      <div class="thumbnail-wrap">
        <div class="thumbnail" style="background-image: url(<?= $david_image_url ?>);"></div>
      </div>
    </div>
  </div>

  <?php
  $pauls = get_posts([
    'numberposts' => 1,
    'post_type' => 'person',
    'name' => 'paul-wilson',
  ]);

  foreach($pauls as $post) :
    $id = $post->post_name;
    ?>

    <div class="section">
      <article id="<?= $id ?>" class="stylist person owner" data-slug="<?= $post->post_name ?>" data-page-title="<?= $post->post_title ?>" data-page-url="<?= get_permalink($post) ?>">

          <?php include(locate_template('templates/person-popup.php')); ?>

          <div class="user-content owner-bio"><?= $paul_bio ?></div>
          <div class="image">
            <div class="open-person-popup">
              <div class="thumbnail-wrap">
                <div class="thumbnail" style="background-image: url(<?= $paul_image_url ?>);"></div>
              </div>
              <p><a href="#" class="details-link non-user-content-link open-person-popup">Paul's Profile</a></p>
            </div>
          </div>

      </article>
    </div>

  <?php endforeach; ?>

</div>
<div class="page-block -bg-cream-dark -indent-right management">
  <h2 class="user-content-h1">Managing Partners</h2>
  <div class="user-content">
    <?=  $managing_partners ?>
  </div>

  <?php
  $people = get_posts([
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => [
      [
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => 'managing-partner'
      ]
    ]
  ]);

  if (!empty($people)) :
  ?>
    <div class="person-type section">
      <ul class="people-grid semantic-only-list">
        <?php foreach ($people as $post):
          echo '<li class="people-grid-item">';
          include(locate_template('templates/article-person-formal.php'));
          echo '</li>';
        endforeach; ?>
      </ul>
    </div>

  <?php endif ?>

  <h2 class="user-content-h1">Managerial Staff</h2>

  <?php
  $people = get_posts([
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => [
      [
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => 'managerial-staff'
      ]
    ]
  ]);

  if (!empty($people)) :
  ?>
    <div class="person-type section">
      <ul class="people-grid semantic-only-list">
        <?php foreach ($people as $post):
          echo '<li class="people-grid-item">';

          $full_name = true;
          $title = true;
          include(locate_template('templates/article-person-formal-nopopup.php'));
          echo '</li>';
        endforeach; ?>
      </ul>
    </div>

  <?php endif ?>


</div>
<div class="page-block -indent-right -bg-cream">
  <h2 class="user-content-h1">Educators</h2>
  <div class="user-content">
    <?=  $educators ?>
  </div>

  <?php
  $stylist_educators = get_posts([
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => [
      'relation' => 'AND',
      [
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => 'educator'
      ],
      [
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => ['stylist', 'master-stylist', 'senior-stylist', 'director-stylist']
      ]
    ]
  ]);

  if (!empty($stylist_educators)) :
  ?>
    <h3 class="user-content-h2">Stylists</h3>
    <div class="person-type section">
      <ul class="people-grid semantic-only-list">
        <?php foreach ($stylist_educators as $post):
          echo '<li class="people-grid-item">';
          include(locate_template('templates/article-person.php'));
          echo '</li>';
        endforeach; ?>
      </ul>
    </div>

  <?php endif ?>

  <?php
  $colorist_educators = get_posts([
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
    'tax_query' => [
      'relation' => 'AND',
      [
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => 'educator'
      ],
      [
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => ['colorist', 'master-colorist', 'senior-colorist', 'director-colorist']
      ]
    ]
  ]);

  if (!empty($colorist_educators)) :
  ?>
    <h3 class="user-content-h2">Colorists</h3>
    <div class="person-type section">
      <ul class="people-grid semantic-only-list">
        <?php foreach ($colorist_educators as $post):
          echo '<li class="people-grid-item">';
          include(locate_template('templates/article-person.php'));
          echo '</li>';
        endforeach; ?>
      </ul>
    </div>

  <?php endif ?>


</div>
<div class="page-block -bg-gray-dark -text-cream -border-bottom -indent-left-huge">
  <h2 class="user-content-h1">Social Impact</h2>
  <div class="user-content">
    <?=  $social_impact ?>
    <p><a href="/social-impact" class="details-link non-user-content-link">Learn More</a></p>
  </div>
</div>
<div class="page-block -bg-gold -text-cream -indent-right-big -indent-left-big barbershops">

  <div class="content">
    <h2 class="user-content-h1">Barbershops</h2>
    <div class="user-content">
      <?=  $barbershops ?>
      <p><a href="/services/#logan-square-barbershop-barbershop-services" class="details-link -text-gray-dark non-user-content-link">Learn More</a></p>
    </div>
  </div>
  <div class="image">
    <div class="thumbnail-wrap">
      <div class="thumbnail" style="background-image: url(<?= $barbershops_image_url ?>);"></div>
    </div>
  </div>
</div>