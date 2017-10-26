<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

$classes = '';
if(is_front_page()) {
  $homepage_theme = rand(0,1);
  $schemes = ['a','b'];
  $classes .= 'color-scheme-'.$schemes[$homepage_theme];
}

?>

<!doctype html>
<!--[if IE 8]> <html class="no-js ie8 lt-ie9 lt-ie10" lang="en"> <![endif]-->
<!--[if IE 9 ]> <html class="no-js ie9 lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class($classes); ?>>
    <div id="breakpoint-indicator"></div>
    <div class="site-background">
    </div>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->

    <div class="site-top">
      <?php
        do_action('get_header');
        get_template_part('templates/header');
      ?>
      <div class="site-wrap" role="document">
        <?php 
        if (is_front_page()) { 
          include(locate_template('templates/page-header-frontpage.php'));
        } elseif (is_404()) {
          include(locate_template('templates/page-header-404.php'));
        } else {
          include(locate_template('templates/page-header.php'));
        }
        ?>
        <main class="site-main" role="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
      </div><!-- /.site-wrap -->
    </div><!-- /.site-top -->
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
