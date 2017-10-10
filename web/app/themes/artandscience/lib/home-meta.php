<?php
/**
 * Home Page Meta/Admin Functions, Filters, Hooks
 */

namespace Firebelly\PostTypes\Pages\Home;

/**
 * Custom CMB2 fields for page
 */
function register_metaboxes() {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list


  /**
   * Alternative Featured Image
   */
  $home_alternate_thumb = new_cmb2_box( array(
    'id'            => 'home_alternate_thumb_metabox',
    'title'         => __( 'Alternative Featured Image', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'home'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $home_alternate_thumb -> add_field( array(
    'name'    => "Image",
    'desc'    => 'Select/upload an image -- this image will need to be pre-treated.',
    'id'      => $prefix.'alternate_featured_image',
    'type'    => 'file',
    'options' => array(
      'url'   => false, // Hide the text input for the url
    ),
    'text'    => array(
      'add_upload_file_text' => 'Add Image'
    ),
    // query_args are passed to wp.media's library query.
    'query_args' => array(
      'type'     => 'image',
    ),
    'preview_size' => 'gallery-thumb',
  ) );

  /**
   * Mission Statement
   */
  $home_mission_statement = new_cmb2_box( array(
    'id'            => 'home_mission_statement_metabox',
    'title'         => __( 'Mission Statement', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'home'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $home_mission_statement -> add_field( array(
    'name'     => 'First Line',
    'id'       => $prefix.'mission1',
    'type'     => 'text',
  ) );
  $home_mission_statement -> add_field( array(
    'name'     => 'Second Line',
    'id'       => $prefix.'mission2',
    'type'     => 'text',
  ) );

  /**
   * Careers
   */
  $home_careers = new_cmb2_box( array(
    'id'            => 'home_careers_metabox',
    'title'         => __( 'Careers', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'home'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $home_careers -> add_field( array(
    'name'    => "Image",
    'desc'    => 'Select/upload an image -- this image will need to be pre-treated.',
    'id'      => $prefix.'careers_image',
    'type'    => 'file',
    'options' => array(
      'url'   => false, // Hide the text input for the url
    ),
    'text'    => array(
      'add_upload_file_text' => 'Add Image'
    ),
    // query_args are passed to wp.media's library query.
    'query_args' => array(
      'type'     => 'image',
    ),
    'preview_size' => 'gallery-thumb',
  ) );

  /**
   * Press
   */
  $home_press = new_cmb2_box( array(
    'id'            => 'home_press_metabox',
    'title'         => __( 'Press', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'home'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $home_press -> add_field( array(
    'name'     => 'Teaser',
    'id'       => $prefix.'press',
    'type'     => 'text',
  ) );

  /**
   * Services
   */
  $home_services = new_cmb2_box( array(
    'id'            => 'home_services_metabox',
    'title'         => __( 'Services', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'home'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $home_services -> add_field( array(
    'name'    => "Image",
    'desc'    => 'Select/upload an image -- this image will need to be pre-treated.',
    'id'      => $prefix.'services_image',
    'type'    => 'file',
    'options' => array(
      'url'   => false, // Hide the text input for the url
    ),
    'text'    => array(
      'add_upload_file_text' => 'Add Image'
    ),
    // query_args are passed to wp.media's library query.
    'query_args' => array(
      'type'     => 'image',
    ),
    'preview_size' => 'gallery-thumb',
  ) );

  /**
   * Social Impact
   */
  $home_social_impact = new_cmb2_box( array(
    'id'            => 'home_social_impact_metabox',
    'title'         => __( 'Social Impact', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'home'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $home_social_impact -> add_field( array(
    'name'     => 'Teaser',
    'id'       => $prefix.'social_impact',
    'type'     => 'text',
  ) );

}
add_action( 'cmb2_admin_init', __NAMESPACE__ . '\register_metaboxes', 10 );
