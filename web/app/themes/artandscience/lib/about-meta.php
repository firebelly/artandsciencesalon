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
  $about_owners = new_cmb2_box( array(
    'id'            => 'about_owners_metabox',
    'title'         => __( 'Owners', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'about'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $about_owners -> add_field( array(
    'name'     => 'David Raccuglia...',
    'id'       => $prefix.'david_bio',
    'description' => 'Bio for David.<br><br>Continue the sentence starting with his name. E.g.: "is the original founder of..."',
    'type'    => 'wysiwyg',
    'options' => array(
      'media_buttons' => false,
    ),
  ) );
  $about_owners -> add_field( array(
    'name'    => "David Raccuglia's Image",
    'desc'    => 'Select/upload an image.  This image should be TREATED.',
    'id'      => $prefix.'david_image',
    'type'    => 'file',
    'desc'    => '(PRE-TREATMENT REQUIRED. 800px width advised. Will be cropped to 1:1 aspect ratio [top weighted].)<br><br>David\'s picture.',
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
  $about_owners -> add_field( array(
    'name'        => 'Paul Wilson...',
    'id'          => $prefix.'paul_bio',
    'description' => 'Bio for Paul.<br><br>Continue the sentence starting with his name. E.g.: "is the original founder of..."',
    'type'        => 'wysiwyg',
    'options'     => array(
      'media_buttons' => false,
    ),
  ) );
  $about_owners -> add_field( array(
    'name'    => "Paul Wilson's Image",
    'desc'    => 'Select/upload an image.  This image should be TREATED.',
    'id'      => $prefix.'paul_image',
    'type'    => 'file',
    'desc'    => '(PRE-TREATMENT REQUIRED. 800px width advised. Will be cropped to 1:1 aspect ratio [top weighted].)<br><br>Paul\'s picture.<br><br>This can and should be a different image than his popup bio picture--especially since it needs to be treated here whereas the image uploaded to the popup should NOT be treated.',
    'options' => array(
      'url'   => false, // Hide the text input for the url
    ),
    'text'    => array(
      'add_upload_file_text' => 'Add Image'
    ),
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
