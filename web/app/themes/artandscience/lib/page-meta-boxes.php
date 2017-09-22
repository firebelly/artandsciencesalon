<?php
/**
 * Extra fields for Pages
 */

namespace Firebelly\PostTypes\Pages;

// // Custom CMB2 fields for post type
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

//   $meta_boxes['page_metabox'] = array(
//     'id'            => 'page_metabox',
//     'title'         => __( 'Extra Fields', 'cmb2' ),
//     'object_types'  => array( 'page', ), // Post type
//     'context'       => 'normal',
//     'priority'      => 'high',
//     'show_names'    => true, // Show field names on the left
//     'fields'        => array(
      
//       // General page fields
//       array(
//         'name' => 'Secondary Content',
//         'desc' => 'Used on several pages for secondary content areas',
//         'id'   => $prefix . 'secondary_content',
//         'type' => 'wysiwyg',
//       ),
//     ),
//   );

  $meta_boxes['header_text'] = array(
    'id'            => 'header_text',
    'title'         => __( 'Header Text', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
    'fields'        => array(
      
      array(
        'name' => 'Header Text',
        'id'   => $prefix . 'header_text',
        'type' => 'textarea_small',
      ),
    ),
  );

  $meta_boxes['frontpage_accolades'] = array(
    'id'            => 'frontpage_accolades',
    'title'         => __( 'Accolades', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'normal',
    'show_on'       => array( 'key' => 'page-template', 'value' => 'front-page.php'),
    'priority'      => 'high',
    'show_names'    => true,
    'fields'        => array(
      
      array(
        'name' => 'Accolades',
        'id'   => $prefix . 'accolade',
        'type' => 'text',
      ),
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

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