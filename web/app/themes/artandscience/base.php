<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

$header_image = get_the_post_thumbnail_url($post);
// If the post object works, grab the cmb2 header text (or post title, if none)
$header_text = '';
if(isset($post)) {
  $header_text = get_post_meta($post->ID, '_cmb2_header_text', true) ? 
    get_post_meta($post->ID, '_cmb2_header_text', true) : 
    get_the_title($post->ID);
}
// Throw special class if header is very short
$header_class = strlen($header_text) < 30 ? ' -has-short-text' : '';


?>

<!doctype html>
<!--[if IE 8]> <html class="no-js ie8 lt-ie9 lt-ie10" lang="en"> <![endif]-->
<!--[if IE 9 ]> <html class="no-js ie9 lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <div id="breakpoint-indicator"></div>
    <div class="site-background">
      <div class="big-a-s"></div>
    </div>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="site-wrap" role="document">
      <div class="page-header<?= $header_class ?>">
        <div class="header-image-wrap">
          <div class="header-image" style="background-image:url('<?= $header_image ?>');"></div>    
        </div>
        <div class="header-text user-content -indent-right-big">
          <?= $header_text ?>
        </div>    
      </div>
      <main class="site-main" role="main">
        <?php include Wrapper\template_path(); ?>
      </main><!-- /.main -->
    </div><!-- /.site-wrap -->      
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
