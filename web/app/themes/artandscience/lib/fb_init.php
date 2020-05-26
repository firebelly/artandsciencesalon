<?php

namespace Firebelly\Init;

/**
 * Don't run wpautop before shortcodes are run! wtf Wordpress. from http://stackoverflow.com/a/14685465/1001675
 */
remove_filter('the_content', 'wpautop');
add_filter('the_content', 'wpautop' , 99);
add_filter('the_content', 'shortcode_unautop',100);

/**
 * Various theme defaults
 */
function setup() {
  // Default Image options
  update_option('image_default_align', 'none');
  update_option('image_default_link_type', 'none');
  update_option('image_default_size', 'large');
}
add_action('after_setup_theme', __NAMESPACE__ . '\setup');

/*
 * Tiny MCE options
 */
function mce_buttons_2($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}
add_filter('mce_buttons_2', __NAMESPACE__ . '\mce_buttons_2');

function simplify_tinymce($settings) {
  // What goes into the 'formatselect' list
  $settings['block_formats'] = 'H2=h2;H3=h3;Paragraph=p';

  $settings['inline_styles'] = 'false';
  if (!empty($settings['formats']))
    $settings['formats'] = substr($settings['formats'],0,-1).",underline: { inline: 'u', exact: true} }";
  else
    $settings['formats'] = "{ underline: { inline: 'u', exact: true} }";

  // What goes into the toolbars. Add 'wp_adv' to get the Toolbar toggle button back
  $settings['toolbar1'] = 'styleselect,bold,italic,underline,strikethrough,formatselect,bullist,numlist,blockquote,link,unlink,hr,wp_more,outdent,indent,AccordionShortcode,AccordionItemShortcode,fullscreen';
  $settings['toolbar2'] = '';
  $settings['toolbar3'] = '';
  $settings['toolbar4'] = '';

  // $settings['autoresize_min_height'] = 250;
  $settings['autoresize_max_height'] = 1000;

  // Clear most formatting when pasting text directly in the editor
  $settings['paste_as_text'] = 'true';

  $style_formats = array(
    array(
      'title' => 'Details Link',
      'block' => 'span',
      'classes' => 'details-link',
    ),
    array(
      'title' => 'Two Image Layout',
      'block' => 'div',
      'classes' => 'image-layout -two-image',
    ),
 );
  $settings['style_formats'] = json_encode($style_formats);

  return $settings;
}
add_filter('tiny_mce_before_init', __NAMESPACE__ . '\simplify_tinymce');

/**
 * Clean up content before saving post
 */
function clean_up_content($content) {
  // Convert <span class="details-link"><a></span> to <a class="details-link"> (can't just add class to element w/ tinymce style formats, has to have wrapper)
  $content = preg_replace('/<span class=\\\"details-link\\\"><a(.*)<\/a><\/span>/', '<a class=\"details-link\"$1</a>', $content);
  return $content;
}
add_filter('content_save_pre', __NAMESPACE__ . '\\clean_up_content', 10, 1);
//
// ... and support for cmb2 wysiwyg fields:
//
function cmb2_sanitize_wysiwyg_callback($override_value, $content) {
  $content = preg_replace('/<span class=\\\"button\\\"><a(.*)<\/a><\/span>/', '<a class=\"button\"$1</a>', $content);
  return $content;
}
add_filter('cmb2_sanitize_wysiwyg', __NAMESPACE__ . '\\cmb2_sanitize_wysiwyg_callback', 10, 2);

/**
 * Custom Admin styles + JS
 */
add_action('admin_enqueue_scripts', function($hook){
  wp_enqueue_style('fb_wp_admin_css', Assets\asset_path('styles/admin.css'));
  // wp_enqueue_script('fb_wp_admin_js', Assets\asset_path('scripts/admin.js'), ['jquery'], null, true);
}, 100);
