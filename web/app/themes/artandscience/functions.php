<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

$firebelly_includes = [
  'lib/disable-comments.php',                 // Disables WP comments in admin and frontend
  'lib/fb_init.php',                          // FB theme setups
  'lib/media.php',                            // FB media
  'lib/fb_metatags.php',                        // FB metatags
  'lib/fb_assets.php',                        // FB assets
  'lib/ajax.php',                             // AJAX functions
  'lib/custom-functions.php',                 // Rando utility functions and miscellany
  'lib/site-options.php',                     // Custon site options
  'lib/cmb2-custom-fields.php',               // Custom CMB2
  'lib/page-meta-boxes.php',                  // Various tweaks for multiple post types
  'lib/post-meta-boxes.php',                  // Various tweaks for multiple post types
  'lib/location-post-type.php',               // Locations
  'lib/lookbook-post-type.php',               // Lookbooks
  'lib/social-impact-gallery-post-type.php',  // Social Impact Gallery
  'lib/person-post-type.php',                 // People
  // 'lib/service-post-type.php',                // Services
  'lib/bridal-meta.php',                      // Bridal page admin/meta
  'lib/social-impact-meta.php',                      // Social Impact page admin/meta
  'lib/press-meta.php',                       // Press page admin/meta
  'lib/about-meta.php',                       // About page admin/meta
  'lib/home-meta.php',                        // Home page admin/meta
];

$sage_includes = array_merge($sage_includes, $firebelly_includes);

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
