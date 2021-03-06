<?php
  /*
    Template name: About
  */

  // Philosophy
  $philosophy =apply_filters('the_content',  get_post_meta($post->ID,'_cmb2_philosophy',true) );
  $philosophy_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_philosophy_image_id',true),'gallery-thumb', false);
  $philosophy_image_preload_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_philosophy_image_id',true),'preload', false);

  // Owners
  $owners = get_post_meta($post->ID,'_cmb2_owners_group',true);

  // Management
  $managing_partners = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_managing_partners',true) );

  // Educators
  $educators = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_educators',true) );

  // Social Impact
  $social_impact = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_social_impact',true) );

  // Barbershops
  $barbershops = apply_filters('the_content', get_post_meta($post->ID,'_cmb2_barbershops',true) );
  $barbershops_image_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_barbershops_image_id',true),'gallery-thumb', false);
  $barbershops_image_preload_url = Firebelly\Media\get_thumbnail_url(get_post_meta($post->ID,'_cmb2_barbershops_image_id',true),'preload', false);

?>

<div class="page-block -bg-cream-dark -bottom-underlap philosophy">
  <div class="content">
    <div class="image">
      <div class="thumbnail-wrap">
        <div class="thumbnail lazy" data-src="<?= $philosophy_image_url ?>" data-preload-src="<?= $philosophy_image_preload_url ?>"></div>
      </div>
    </div>
    <h2 class="content-h1">Philosophy</h2>
    <div class="user-content">
      <?= $philosophy ?>
    </div>
  </div>
</div>
<div class="page-block -bg-gray-dark -text-cream -indent-right-big -top-overlap owners">
  <h2 class="content-h1">Owners</h2>

  <?php foreach ($owners as $owner):

    $owner_bio = apply_filters('the_content', '<h3 class="owner-name">'.$owner['name'].'</h3>'.$owner['bio']);
    $owner_image_url = Firebelly\Media\get_thumbnail_url($owner['image_id'],'gallery-thumb', false);
    $owner_image_preload_url = Firebelly\Media\get_thumbnail_url($owner['image_id'],'preload', false);

    // Link to profile?
    if (empty($owner['profile'])):
 ?>
  <div class="owner">
    <div class="user-content owner-bio"><?= $owner_bio ?></div>
    <div class="image">
      <div class="thumbnail-wrap">
        <div class="thumbnail lazy" data-src="<?= $owner_image_url ?>" data-preload-src="<?= $owner_image_preload_url ?>"></div>
      </div>
    </div>
  </div>

  <?php
  else:
    $person = get_post($owner['profile']);
    $id = $person->post_name;
    ?>

    <div class="section">
      <article id="<?= $id ?>" class="stylist person owner" data-slug="<?= $person->post_name ?>" data-page-title="<?= $person->post_title ?>" data-page-url="<?= get_permalink($person) ?>">


          <?php $post = $person;
          include(locate_template('templates/person-popup.php')); ?>

          <div class="user-content owner-bio"><?= $owner_bio ?></div>
          <div class="image">
            <div class="open-person-popup">
              <div class="thumbnail-wrap">
                <div class="thumbnail lazy" data-src="<?= $owner_image_url ?>" data-preload-src="<?= $owner_image_preload_url ?>"></div>
              </div>
              <p><a href="#" class="details-link non-user-content-link open-person-popup"><?= $owner['name'] ?>'s Profile</a></p>
            </div>
          </div>

      </article>
    </div>

  <?php endif; ?>
  <?php endforeach; ?>

</div>
<div class="page-block -bg-cream-dark -indent-right management">
  <h2 class="content-h1">Managing Partners</h2>
  <div class="user-content">
    <?=  $managing_partners ?>
  </div>

  <?php
  $people = get_posts([
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby'=> 'title',
    'order' => 'ASC',
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
        <?php foreach ($people as $person):
          echo '<li class="people-grid-item">';
            echo \Firebelly\PostTypes\People\get_person_markup($person,true,true);
          echo '</li>';
        endforeach; ?>
      </ul>
    </div>

  <?php endif ?>

  <h2 class="content-h1">Managerial Staff</h2>

  <?php
  $people = get_posts([
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby'=> 'title',
    'order' => 'ASC',
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
        <?php foreach ($people as $person):
          echo '<li class="people-grid-item">';
          echo \Firebelly\PostTypes\People\get_person_markup($person,true,true);
          echo '</li>';
        endforeach; ?>
      </ul>
    </div>

  <?php endif ?>


</div>
<div class="page-block -indent-right -bg-cream">
  <h2 class="content-h1">Educators</h2>
  <div class="user-content">
    <?=  $educators ?>
  </div>



  <?php

  // Get all person_type terms that are children of 'stylyist-type'
  $educator_type_term = get_term_by('slug', 'educator-type', 'person_type');
  $people_types = get_terms([
    'taxonomy'=>'person_type',
    'parent' => $educator_type_term->term_id,
  ]);

  foreach ($people_types as $people_type) :

    $people_args = array(
      'numberposts' => -1,
      'post_type' => 'person',
      'orderby'=> 'title',
      'order' => 'ASC',
      'tax_query' => array(
        array(
          'taxonomy' => 'person_type',
          'field' => 'slug',
          'terms' => $people_type
        )
      )
    );
    $educators = get_posts($people_args);

    if (!empty($educators)) :
    ?>
      <h3 class="content-h2"><?= $people_type->name ?></h3>
      <div class="person-type section">
        <ul class="people-grid semantic-only-list">
          <?php foreach ($educators as $person):
            echo '<li class="people-grid-item">';
            echo \Firebelly\PostTypes\People\get_person_markup($person);
            echo '</li>';
          endforeach; ?>
        </ul>
      </div>

  <?php endif;
  endforeach;
  ?>


</div>
<div class="page-block -bg-gray-dark -text-cream -border-bottom -indent-left-huge">
  <h2 class="content-h1">Social Impact</h2>
  <div class="user-content">
    <?=  $social_impact ?>
    <p><a href="/social-impact" class="details-link non-user-content-link">Learn More</a></p>
  </div>
</div>
<div class="page-block -bg-gold -text-cream -indent-right-big -indent-left-big barbershops">

  <div class="content">
    <h2 class="content-h1">Barbershops</h2>
    <div class="user-content">
      <?=  $barbershops ?>
      <p><a href="/services/#logan-square-barbershop-barbershop-services" class="details-link -text-gray-dark non-user-content-link">Learn More</a></p>
    </div>
  </div>
  <div class="image">
    <div class="thumbnail-wrap">
      <div class="thumbnail lazy" data-src="<?= $barbershops_image_url ?>" data-preload-src="<?= $barbershops_image_preload_url ?>"></div>
    </div>
  </div>
</div>