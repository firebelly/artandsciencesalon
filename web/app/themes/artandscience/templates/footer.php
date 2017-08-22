<footer class="site-footer" role="contentinfo">
  <div class="locations">
    <?= \Firebelly\PostTypes\Location\get_locations(); ?>
  </div>

  <ul class="social">
    <li><a href="https://www.facebook.com/<?= \Firebelly\SiteOptions\get_option('facebook_id'); ?>"><svg class="icon icon-facebook" aria-hidden="hidden" role="image"><use xlink:href="#icon-facebook"/></svg><span class="">Facebook</span></a></li>
    <li><a href="https://www.twitter.com/<?= \Firebelly\SiteOptions\get_option('twitter_id'); ?>"><svg class="icon icon-twitter" aria-hidden="hidden" role="image"><use xlink:href="#icon-twitter"/></svg><span class="">Twitter</span></a></li>
    <li><a href="https://www.instagram.com/<?= \Firebelly\SiteOptions\get_option('instagram_id'); ?>"><svg class="icon icon-instagram" aria-hidden="hidden" role="image"><use xlink:href="#icon-instagram"/></svg><span class="">Instagram</span></a></li>
    <li><a href="https://www.pinterest.com/<?= \Firebelly\SiteOptions\get_option('pinterest_id'); ?>"><svg class="icon icon-pinterest" aria-hidden="hidden" role="image"><use xlink:href="#icon-pinterest"/></svg><span class="">Pinterest</span></a></li>
  </ul>

  <nav class="site-nav --secondary" role="navigation">
    <?php
    if (has_nav_menu('secondary_navigation')) :
      wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'nav']);
    endif;
    ?>
  </nav>
</footer>
