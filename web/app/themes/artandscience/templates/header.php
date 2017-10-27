<header class="site-header -unloaded -fixed" role="banner">
    <div class="site-banner">
      <h1 class="brand">
        <a  href="<?= esc_url(home_url('/')); ?>">
          <svg class="icon icon-logo" aria-hidden="true" role="image"><use xlink:href="#icon-logo"/></svg>
          <svg class="icon icon-wordmark" aria-hidden="true" role="image"><use xlink:href="#icon-wordmark"/></svg>
          <span class="visually-hidden"><?php bloginfo('name'); ?></span>
        </a>
      </h1>
    </div>
    <nav class="site-nav" role="navigation">



      <div class="book-appointment hide-during-page-load">
        <button>Book an appointment</button>
        <ul class="location-list">
          
          <?php
            $location_args = array(
              'numberposts' => -1,
              'post_type' => 'location',
              'orderby' => 'menu_order',
            );

            $location_posts = get_posts($location_args);

            foreach ($location_posts as $location_post) {
              echo '<li>';
              include(locate_template('templates/location-contact.php'));
              echo '</li>';
            }
          ?>

        </ul>
      </div>

      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
      <?php
      if (has_nav_menu('secondary_navigation')) :
        wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>

  
</header>
