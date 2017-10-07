<?php
  use Firebelly\PostTypes\Location;
  $people_types = get_terms(['taxonomy'=>'person_type']);
?>

<article id="<?= $location_section->post_name ?>-people" class="subpage careers-child-page">

  <?php foreach ($people_types as $people_type) :

    $people_args = array(
      'numberposts' => -1,
      'post_type' => 'person',
      'orderby' => 'menu_order',
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'locations',
          'field' => 'slug',
          'terms' => $location_section->post_name
        ),
        array(
          'taxonomy' => 'person_type',
          'field' => 'slug',
          'terms' => $people_type
        )
      )
    );
    $people = get_posts($people_args);

    if (!empty($people)) :
    ?>

      <section class="person-type section" id="<?= $location_section->post_name.'-'.$people_type->slug ?>">

        <h2 class="experience-popup-location"><?= $people_type->name ?>s</h2>

        <ul class="people-grid semantic-only-list">
          <?php foreach ($people as $post):
            echo '<li class="people-grid-item">';
            include(locate_template('templates/article-person.php'));
            echo '</li>';
          endforeach; ?>
        </ul>

      </section>

    <?php endif ?>
  <?php endforeach ?>

</article>