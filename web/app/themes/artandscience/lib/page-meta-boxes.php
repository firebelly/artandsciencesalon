<?php
/**
 * Extra fields for Pages
 */

namespace Firebelly\PostTypes\Pages;

// Custom CMB2 fields for post type
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['header_text'] = array(
    'id'            => 'header_text',
    'title'         => __( 'Header Text', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
    'show_on'       => array( 'key' => 'exclude_slug', 'value' => ['home','experience-levels','our-approach','benefits-compensation','models','education','career-path','administrative-jobs']), // wrote a custom exclude by slug
    'fields'        => array(
      array(
        'name' => 'Header Text',
        'id'   => $prefix . 'header_text',
        'type' => 'textarea_small',
        'description'   => 'Banner text at top of page.<br><br>  IMPORTANT: Use normal capitalization--text will be transformed to all-caps when displayed.',
      ),
    ),
  );


  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Add descriptions to featured images on pages
 */
add_filter( 'admin_post_thumbnail_html', __NAMESPACE__ . '\add_featured_image_instruction');
function add_featured_image_instruction( $content ) {

  // Possible image instructions
  $desc_page = '<p>(Untreated. 1600px width advised. Will be cropped to 5:3 aspect ratio desktop, 1:1 square ratio on mobile--so put important content in center.)</p><p>Banner Image at top of page.</p>';
  $desc_home = '<p>(PRE-TREATMENT REQUIRED. 1600px width advised. Will be cropped to 5:3 aspect ratio desktop, 1:1 square ratio on mobile--so put important content in center.)</p><p>Banner Image at top of page. Home page has two schemes.</p><p>This image will be used for the primary scheme.</p>';

  if( get_current_screen()->id != 'page') return $content; // This function is only concerned with pages.

  // Get the Post ID (if we need to figure out what type of post we are on).  Lack of id will indicate new page.
  if ( isset( $_GET['post'] ) ) {
      $post_id = $_GET['post'];
  } elseif ( isset( $_POST['post_ID'] ) ) {
      $post_id = $_POST['post_ID'];
  }
  if( !isset( $post_id ) ) return $content . $desc_page; // New page

  if (get_post($post_id)->post_name === 'home') {
    return $content . $desc_home;
  } else {
    return $content . $desc_page;
  }
}

/**
 * Hide editor and featured image on specific pages by slug.  Adapted from: https://gist.github.com/ramseyp/4060095
 */
// add_action( 'do_meta_boxes', __NAMESPACE__ . '\hide_editor' );
// function hide_editor() {

//   if( get_current_screen()->id != 'page') return;

//   // Get the Post ID.
//   if ( isset( $_GET['post'] ) ) {
//       $post_id = $_GET['post'];
//   } elseif ( isset( $_POST['post_ID'] ) ) {
//       $post_id = $_POST['post_ID'];
//   }
//   if( !isset( $post_id ) ) return;

//   // Get the slug
//   $slug = get_post($post_id)->post_name;

//   // Hide editor on certain pages
//   if(in_array( $slug, ['home','about','locations','services','stylists','lookbooks','press'])){ 
//     remove_post_type_support('page', 'editor');
//   }

//   // Hide featured image on certian pages
//   if(in_array( $slug, ['experience-levels','our-approach','benefits-compensation','models','education','career-path','administrative-jobs'])){ 
//     remove_meta_box( 'postimagediv','page','side' );
//   }
// }

/**
 * Remove page attributes site-wide
 */
function remove_page_attributes() {
    remove_meta_box('pageparentdiv', 'page', 'normal');
}
add_action( 'admin_menu', __NAMESPACE__ . '\remove_page_attributes' );

/**
 * ADAPTED FROM:
 * Metabox for Page Slug
 * @author Tom Morton
 * @link https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
 *
 * @param bool $display
 * @param array $meta_box
 * @return bool display metabox
 */
// Allows for a cmb2 boxes to be put on a page with
// 'show_on'       => array( 'key' => 'slug', 'value' => 'bridal'),
function metabox_show_on_slug( $display, $meta_box ) {
    if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
        return $display;
    }

    if ( 'slug' !== $meta_box['show_on']['key'] ) {
        return $display;
    }

    $post_id = 0;

    // If we're showing it based on ID, get the current ID
    if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = $_POST['post_ID'];
    }

    if ( ! $post_id ) {
      return false; // In Morton's code, this WAS 'return $dispay;'-- but this caused all the metaboxes to appear for pages as they were being created, i.e. before they had proper slugs.
    }

    $slug = get_post( $post_id )->post_name;

    // See if there's a match
    return in_array( $slug, (array) $meta_box['show_on']['value']);
}
add_filter( 'cmb2_show_on', __NAMESPACE__ . '\metabox_show_on_slug', 10, 2 );

// AND THE OPPOSITE

// Allows for a cmb2 boxes to be EXCLUDED on a page by slug with
// 'show_on'       => array( 'key' => 'slug', 'value' => 'bridal'),
function metabox_exclude_on_slug( $display, $meta_box ) {
    if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
        return $display;
    }

    if ( 'exclude_slug' !== $meta_box['show_on']['key'] ) {
        return $display;
    }

    $post_id = 0;

    // If we're showing it based on ID, get the current ID
    if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = $_POST['post_ID'];
    }

    if ( ! $post_id ) {
      return $display; // WILL SHOW AUTOMATICALLY ON A NEW PAGE
    }

    $slug = get_post( $post_id )->post_name;

    // See if there's a match
    return !in_array( $slug, (array) $meta_box['show_on']['value']);
}
add_filter( 'cmb2_show_on', __NAMESPACE__ . '\metabox_exclude_on_slug', 10, 2 );

