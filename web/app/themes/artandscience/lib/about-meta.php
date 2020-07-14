<?php
/**
 * About Page Meta/Admin Functions, Filters, Hooks
 */

namespace Firebelly\PostTypes\Pages\About;

/**
 * Custom CMB2 fields for page
 */
function register_metaboxes() {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  /**
   * Philosophy
   */
  $about_philosophy = new_cmb2_box( array(
    'id'            => 'about_philosophy_metabox',
    'title'         => __( 'Philosophy', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'about'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $about_philosophy -> add_field( array(
    'name'     => 'Content',
    'id'       => $prefix.'philosophy',
    'type'     => 'wysiwyg',
    'options' => array(
      'media_buttons' => false,
      'textarea_rows' => 8,
    ),
    'desc'    => 'Copy for Philosophy section.',
  ) );
  $about_philosophy -> add_field( array(
    'name'    => "Philosophy Image",
    'desc'    => 'Select/upload an image',
    'id'      => $prefix.'philosophy_image',
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
    'desc'    => '(PRE-TREATMENT REQUIRED. 800px width advised. Will be cropped to 1:1 aspect ratio [top weighted].)<br><br>The image for the Philosophy section.',
  ) );

  /**
   * Owners
   */
  $owners_group = new_cmb2_box( array(
    'id'           => $prefix . 'owners_box',
    'title'        => __( 'Owners', 'cmb2' ),
    'priority'     => 'default',
    'context'      => 'normal',
    'object_types' => array( 'page', ), // Post type
    'show_on'      => array( 'key' => 'slug', 'value' => 'about'),
  ) );

  $owners_group_id = $owners_group->add_field( array(
    'id'      => $prefix . 'owners_group',
    'type'    => 'group',
    'options' => array(
        'group_title'   => __( 'Owner {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Owner', 'cmb2' ),
        'remove_button' => __( 'Remove Owner', 'cmb2' ),
        'sortable'      => true,
    ),
  ) );

  $owners_group->add_group_field( $owners_group_id, array(
    'name'        => 'Name',
    'id'          => 'name',
    'type'        => 'text',
  ) );

  $owners_group->add_group_field( $owners_group_id, array(
    'name'        => 'Bio',
    'id'          => 'bio',
    'description' => 'Continue the sentence starting with owner name. E.g.: "is the original founder of..."',
    'type'        => 'wysiwyg',
    'options'     => array(
      'media_buttons' => false,
      'textarea_rows' => 8,
    ),
  ) );

  $owners_group->add_group_field( $owners_group_id, array(
    'name'        => 'Profile',
    'id'          => 'profile',
    'type'     => 'select',
    'show_option_none' => true,
    'options'  => \Firebelly\CMB2\get_post_options(['post_type' => 'person', 'numberposts' => -1]),
    'description' => 'Select profile to link to (optional)',
  ) );

  $owners_group->add_group_field( $owners_group_id, array(
    'name'    => 'Image',
    'desc'    => 'Select/upload an image.  This image should be TREATED.',
    'id'      => 'image',
    'type'    => 'file',
    'desc'    => '(PRE-TREATMENT REQUIRED. 800px width advised. Will be cropped to 1:1 aspect ratio [top weighted].)<br><br>If a profile is selected, this can and should be a different image than the popup bio picture--especially since it needs to be treated here whereas the image uploaded to the popup should NOT be treated.',
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
   * Managing Partners
   */
  $about_managing_partners = new_cmb2_box( array(
    'id'            => 'about_managing_partners_metabox',
    'title'         => __( 'Managing Partners', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'about'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $about_managing_partners -> add_field( array(
    'name'     => 'Content',
    'id'       => $prefix.'managing_partners',
    'type'     => 'wysiwyg',
    'description' => 'Copy for Managing Partners section.<br><br>The partners and staff themselves will be added automatically.',
    'options'  => array(
      'media_buttons' => false,
      'textarea_rows' => 8,
    ),
  ) );

  /**
   * Educators
   */
  $about_educators = new_cmb2_box( array(
    'id'            => 'about_educators_metabox',
    'title'         => __( 'Educators', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'about'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $about_educators -> add_field( array(
    'name'     => 'Content',
    'id'       => $prefix.'educators',
    'type'     => 'wysiwyg',
    'description' => 'Copy for Educators section.<br><br>The educators themselves will be added automatically.',
    'options'  => array(
      'media_buttons' => false,
      'textarea_rows' => 8,
    ),
  ) );

  /**
   * Social Impact
   */
  $about_social_impact = new_cmb2_box( array(
    'id'            => 'about_social_impact_metabox',
    'title'         => __( 'Social Impact', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'about'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $about_social_impact -> add_field( array(
    'name'     => 'Content',
    'id'       => $prefix.'social_impact',
    'type'     => 'wysiwyg',
    'description' => 'Copy for Social Impact section',
    'options'  => array(
      'media_buttons' => false,
      'textarea_rows' => 8,
    ),
  ) );

  /**
   * Barbershops
   */
  $about_barbershops = new_cmb2_box( array(
    'id'            => 'about_barbershops_metabox',
    'title'         => __( 'Barbershops', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'about'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $about_barbershops -> add_field( array(
    'name'     => 'Barbershops Content',
    'id'       => $prefix.'barbershops',
    'type'     => 'wysiwyg',
    'description' => 'Copy for Barbershops section.',
    'options'  => array(
      'media_buttons' => false,
      'textarea_rows' => 8,
    ),
  ) );
  $about_barbershops -> add_field( array(
    'name'    => "Barbershops Image",
    'desc'    => 'Select/upload an image.  This image should be TREATED.',
    'id'      => $prefix.'barbershops_image',
    'type'    => 'file',
    'options' => array(
      'url'   => false, // Hide the text input for the url
    ),
    'desc'    => '(PRE-TREATMENT REQUIRED. 800px width advised. Will be cropped to 3:4 aspect ratio [top weighted].)<br><br>The image for the Barbershops section.',
    'text'    => array(
      'add_upload_file_text' => 'Add Image'
    ),
    // query_args are passed to wp.media's library query.
    'query_args' => array(
      'type'     => 'image',
    ),
    'preview_size' => 'gallery-thumb',
  ) );

}
add_action( 'cmb2_admin_init', __NAMESPACE__ . '\register_metaboxes', 10 );
