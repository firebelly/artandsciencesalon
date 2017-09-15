<footer class="site-footer container" role="contentinfo">
  <div class="footer-nav">
    <?php
    if (has_nav_menu('secondary_navigation')) :
      wp_nav_menu(['theme_location' => 'secondary_navigation', 'menu_class' => 'nav']);
    endif;
    ?>
  </div>
  <div class="locations">
    <?= \Firebelly\PostTypes\Location\get_locations(); ?>
  </div>
  <ul class="social">
    <li><a href="https://www.facebook.com/<?= \Firebelly\SiteOptions\get_option('facebook_id'); ?>"><svg class="icon icon-facebook" aria-hidden="true" role="image"><use xlink:href="#icon-facebook"/></svg><span class="visually-hidden">Facebook</span></a></li>
    <li><a href="https://www.twitter.com/<?= \Firebelly\SiteOptions\get_option('twitter_id'); ?>"><svg class="icon icon-twitter" aria-hidden="true" role="image"><use xlink:href="#icon-twitter"/></svg><span class="visually-hidden">Twitter</span></a></li>
    <li><a href="https://www.instagram.com/<?= \Firebelly\SiteOptions\get_option('instagram_id'); ?>"><svg class="icon icon-instagram" aria-hidden="true" role="image"><use xlink:href="#icon-instagram"/></svg><span class="visually-hidden">Instagram</span></a></li>
    <li><a href="https://www.pinterest.com/<?= \Firebelly\SiteOptions\get_option('pinterest_id'); ?>"><svg class="icon icon-pinterest" aria-hidden="true" role="image"><use xlink:href="#icon-pinterest"/></svg><span class="visually-hidden">Pinterest</span></a></li>
  </ul>
</footer>