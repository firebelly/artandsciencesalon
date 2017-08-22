<header class="site-header" role="banner">
  <div class="container">
    <h1><a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
    <nav class="site-nav" role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>

  <div id="book-appointment" class="book-appointment">
    <button>Book an appointment</button>
    <ul class="location-list">
      
      <?php
        $args = array(
          'numberposts' => -1,
          'post_type' => 'location',
          'orderby' => 'menu_order',
        );

        $location_posts = get_posts($args);

        foreach ( $location_posts as $post ):
          echo '<li>';
          include(locate_template('templates/location-contact.php'));
          echo '</li>';
        endforeach;
      ?>

    </ul>
  </div>
</header>
