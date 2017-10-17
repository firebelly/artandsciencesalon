<?php
/**
 * Bridal Page Meta/Admin Functions, Filters, Hooks
 */

namespace Firebelly\PostTypes\Pages\SocialImpact;

/**
 * Custom CMB2 fields for page
 */
function register_metaboxes() {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  /**
   * Contact
   */
  $social_impact_details = new_cmb2_box( array(
    'id'            => 'social_impact_contact_metabox',
    'title'         => __( 'Contact', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'social-impact'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $social_impact_details -> add_field( array(
    'name'     => 'For more information',
    'id'       => $prefix.'contact',
    'type'     => 'wysiwyg',
    'options'  => array(
      'media_buttons' => false,
    ),
    'desc'     => 'Contact information copy after dash in main section.',
  ) );

}
add_action( 'cmb2_admin_init', __NAMESPACE__ . '\register_metaboxes', 10 );