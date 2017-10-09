<footer class="site-footer" role="contentinfo">
  <div class="locations">
    <?= \Firebelly\PostTypes\Location\get_footer_locations(); ?>
  </div>
  <ul class="social">
    <li><a target="_blank" href="https://www.facebook.com/<?= \Firebelly\SiteOptions\get_option('facebook_id'); ?>"><svg class="icon icon-facebook" aria-hidden="true" role="image"><use xlink:href="#icon-facebook"/></svg><span class="visually-hidden">Facebook</span></a></li>
    <li><a target="_blank" href="https://www.twitter.com/<?= \Firebelly\SiteOptions\get_option('twitter_id'); ?>"><svg class="icon icon-twitter" aria-hidden="true" role="image"><use xlink:href="#icon-twitter"/></svg><span class="visually-hidden">Twitter</span></a></li>
    <li><a target="_blank" href="https://www.instagram.com/<?= \Firebelly\SiteOptions\get_option('instagram_id'); ?>"><svg class="icon icon-instagram" aria-hidden="true" role="image"><use xlink:href="#icon-instagram"/></svg><span class="visually-hidden">Instagram</span></a></li>
    <li><a target="_blank" href="https://www.pinterest.com/<?= \Firebelly\SiteOptions\get_option('pinterest_id'); ?>"><svg class="icon icon-pinterest" aria-hidden="true" role="image"><use xlink:href="#icon-pinterest"/></svg><span class="visually-hidden">Pinterest</span></a></li>
  </ul>
</footer>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<script type="text/javascript">
window.__lc = window.__lc || {};
window.__lc.license = 9157085;
(function() {
  var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
  lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();
</script>
<!-- End of LiveChat code -->