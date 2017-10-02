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

function get_salons() {
  $salons = get_post_meta(get_the_ID(),'_cmb2_salon_group',true);
  $output = '';

  $output.= '<ul class="salons-list semantic-only-list">';
  foreach ($salons as $salon) {

    // Safely grab repeating group array values
    $name = isset($salon['name']) ? $salon['name'] : '';
    $coordinator = isset($salon['coordinator']) ? $salon['coordinator'] : '';
    $email = isset($salon['email']) ? $salon['email'] : '';
    $bridal_stylists = isset($salon['bridal_stylists']) ? $salon['bridal_stylists'] : '';

    // Append Email link if applicable
    if ( $email ) {
      $coordinator = '<a href="mailto:'.$email.'">'.$coordinator.'</a>';
    }

    // Output markup
    $output .= <<<HTML
      <li class="salons-item">
        <h3>{$name}</h3>
        <table class="contact-table">
          <tbody>
            <tr class="leader-row">
              <th class="leader-left" scope="row"><span class="leader-text">Coordinator</span></th>
              <td class="leader-right"><span class="leader-text">{$coordinator}</span></td>
            </tr>
            <tr class="leader-row">
              <th class="leader-left" scope="row"><span class="leader-text">Bridal Stylists</span></th>
              <td class="leader-right"><span class="leader-text">{$bridal_stylists}</span></td>
            </tr>
          </tbody>
        </table>
      </li>
HTML;
  }
  $output .= '</ul>';

  return $output;

}


function get_pricing() {

  $services = get_post_meta(get_the_ID(),'_cmb2_service_group',true);
  $output = '';

  ob_start();
  include(locate_template('templates/pricing-table.php'));
  $output .= ob_get_clean();

  return $output;

}
