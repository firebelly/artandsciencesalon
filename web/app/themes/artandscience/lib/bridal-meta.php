<?php
/**
 * Bridal Page Meta/Admin Functions, Filters, Hooks
 */

namespace Firebelly\PostTypes\Pages\Bridal;

/**
 * Custom CMB2 fields for page
 */
function register_metaboxes() {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  /**
   * Details
   */
  $bridal_details = new_cmb2_box( array(
    'id'            => 'bridal_details_metabox',
    'title'         => __( 'Details', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'bridal'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $bridal_details -> add_field( array(
    'name'     => 'Details',
    'id'       => $prefix.'details',
    'type'     => 'wysiwyg',
    'desc'     => 'Content for "Details" section',
    'options' => array(
      'media_buttons' => false, 
    ),
  ) );

  /**
   * Contact
   */
  $salon_group = new_cmb2_box( array(
    'id'           => $prefix . 'contact_box',
    'title'        => __( 'Contact Information', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'bridal'),
  ) );

  $salon_group_id = $salon_group->add_field( array(
    'id'          => $prefix . 'salon_group',
    'type'        => 'group',
    'description' => __( 'Note that you must switch Text mode and refresh to reorder these salons', 'cmb2' ),
    'options'     => array(
        'group_title'   => __( 'Salon {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Salon', 'cmb2' ),
        'remove_button' => __( 'Remove Salon', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $salon_group->add_group_field( $salon_group_id, array(
      'name' => 'Salon Name',
      'id'   => 'name',
      'type' => 'text',
  ) );

  $salon_group->add_group_field( $salon_group_id, array(
      'name' => 'Coordinator',
      'id'   => 'coordinator',
      'type' => 'text',
  ) );

  $salon_group->add_group_field( $salon_group_id, array(
      'name' => 'Coordinator Email',
      'id'   => 'email',
      'type' => 'text',
  ) );

  $salon_group->add_group_field( $salon_group_id, array(
      'name' => 'Bridal Stylists',
      'id'   => 'bridal_stylists',
      'type' => 'text',
  ) );


  /**
   * Pricing
   */
  $service_group = new_cmb2_box( array(
    'id'           => $prefix . 'service_box',
    'title'        => __( 'Pricing', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'bridal'),
  ) );

  $service_group_id = $service_group->add_field( array(
    'id'          => $prefix . 'service_group',
    'type'        => 'group',
    'description' => __( 'Note that you must switch Text mode and refresh to reorder these services', 'cmb2' ),
    'options'     => array(
        'group_title'   => __( 'Service {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Service', 'cmb2' ),
        'remove_button' => __( 'Remove Service', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $service_group->add_group_field( $service_group_id, array(
      'name' => 'Service name',
      'id'   => 'name',
      'type' => 'text',
  ) );

  $service_group->add_group_field( $service_group_id, array(
      'name' => 'Price',
      'id'   => 'price',
      'type' => 'text',
  ) );

  $service_group->add_group_field( $service_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
  ) );

  /**
   * The Fine Print
   */
  $bridal_fineprint = new_cmb2_box( array(
    'id'            => 'bridal_fineprint_metabox',
    'title'         => __( 'The Fine Print', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'bridal'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    )
  );
  $bridal_fineprint -> add_field( array(
    'name'     => 'The Fine Print',
    'id'       => $prefix.'fineprint',
    'type'     => 'wysiwyg',
    'desc'     => 'Content for "Fine Print" section',
    'options' => array(
      'media_buttons' => false, 
    ),
  ) );

}
add_action( 'cmb2_admin_init', __NAMESPACE__ . '\register_metaboxes', 10 );

// function get_salons() {
//   salons = get_post_meta(get_the_ID(),'_cmb2_salon_group',true);
//   $output = '';

//   $output.= '<ul class="salons-list">';
//   foreach (salons as salon) {

//     $thumbnail_url = \wp_get_attachment_image_src(salon['thumbnail_id'],'medium')[0];
//     $description = apply_filters('the_content',salon['description']);
//     $url = esc_url(salon['url']);

//     $output .= <<<HTML
//       <li class="bridal columns-item">
//         <h3 class='sr-only'>{salon['title']}</h3>
//         <img src="{$thumbnail_url}" class="thumb">
//         <p class="description">{$description}</p>
//         <div class="login-wrap">
//           <hr>
//           <a href="{$url}" class="login no-underline" target="_blank"><button class="arrow -right -black -small">Login</button></a>
//         </div>
//       </li>
// HTML;
//   }
//   $output .= '</ul>';

//   return $output;

// }
