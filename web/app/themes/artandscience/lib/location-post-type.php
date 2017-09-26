<?php
/**
 * Location post type
 */

namespace Firebelly\PostTypes\Location;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Locations',
    'singular_name'       => 'Location',
    'menu_name'           => 'Locations',
    'parent_item_colon'   => '',
    'all_items'           => 'All Locations',
    'view_item'           => 'View Location',
    'add_new_item'        => 'Add New Location',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Location',
    'update_item'         => 'Update Location',
    'search_items'        => 'Search Locations',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => '',
    'with_front'          => false,
    'pages'               => false,
    'feeds'               => false,
  );
  $args = array(
    'label'               => 'location',
    'description'         => 'Locations',
    'labels'              => $labels,
    'taxonomies'          => array('location_type'),
    'supports'            => array( 'title', 'editor', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-admin-multisite',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'location', $args );

}
add_action( 'init', __NAMESPACE__ . '\post_type', 0 );

/**
 * Custom admin columns for post type
 */
function edit_columns($columns){
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => 'Name',
    'content' => 'Description',
    'featured_image' => 'Image',
  );
  return $columns;
}
add_filter('manage_location_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'location' ) {
    if ( $column == 'featured_image' )
      echo the_post_thumbnail('thumbnail');
    elseif ( $column == 'content' )
      echo Utils\get_excerpt($post);
    else {
      $custom = get_post_custom();
      if (array_key_exists($column, $custom))
        echo $custom[$column][0];
    }
  };
}
add_action('manage_posts_custom_column',  __NAMESPACE__ . '\custom_columns');


/**
 * Style services meta-boxes so there can be multiple per line (1 per line is VERY annoying/disorienting when entering data)
 */
function admin_styling() {
  echo <<<HTML
  <style>
    *, *::before, *::after {
      box-sizing: inherit;
    }

    html {
      box-sizing: border-box;
    }

    .cmb-type-text .cmb-th {
      min-width: 60px;
    }

    .cmb-type-text .cmb-td {
      max-width: calc(100% - 60px);
    }

    #_cmb2_salon_cut_box .cmb-type-text {
      width: 33%;
      min-width: 120px;
      border-bottom: none;
      display: inline-block;
      padding: 10px 10px 10px 0 !important;
    }

    #_cmb2_salon_color_box .cmb-type-text:not(:first-of-type) {
      width: 25%;
      min-width: 120px;
      border-bottom: none;
      display: inline-block;
      padding: 10px 10px 10px 0 !important;
    }

    #_cmb2_tanning_box .cmb-type-text:first-of-type,
    #_cmb2_waxing_lounge_box .cmb-type-text:first-of-type,
    #_cmb2_barbershop_services_box .cmb-type-text:first-of-type {
      width: 60%;
      min-width: 120px;
      border-bottom: none;
      display: inline-block;
      padding: 10px 10px 10px 0 !important;
    }

    #_cmb2_tanning_box .cmb-type-text:nth-of-type(2),
    #_cmb2_waxing_lounge_box .cmb-type-text:nth-of-type(2),
    #_cmb2_barbershop_services_box .cmb-type-text:nth-of-type(2) {
      width: 40%;
      min-width: 120px;
      border-bottom: none;
      display: inline-block;
      padding: 10px 10px 10px 0 !important;
    }


  </style>
HTML;
}
add_action('admin_head', __NAMESPACE__ . '\admin_styling');

// Custom CMB2 fields for post type
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['location_details'] = array(
    'id'            => 'location_details',
    'title'         => __( 'Location Details', 'cmb2' ),
    'object_types'  => array( 'location', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Abbreviate Title',
        'id'   => $prefix . 'short_title',
        'desc' => 'Ex: "Logan Square" instead of "Logan Square Barbershop"',
        'type' => 'text',
      ),
      array(
        'name' => 'Location Code',
        'id'   => $prefix . 'code',
        'desc' => 'Ex: Logan Square = LSQ',
        'type' => 'text',
      ),
      array(
        'name' => 'Address',
        'id'   => $prefix . 'address',
        'type' => 'text',
      ),
      array(
        'name' => 'Phone Number',
        'desc' => 'format: 847.123.1234',
        'id'   => $prefix . 'phone_number',
        'type' => 'text',
      ),
      array(
        'name' => 'Email',
        'id'   => $prefix . 'email',
        'type' => 'text_email',
      ),
      array(
        'name' => 'Virtual Tour URL',
        'id'   => $prefix . 'virtual_tour_url',
        'type' => 'text_url',
      ),
      array(
        'name'           => 'Types of People to Display',
        'desc'           => 'Check all that apply',
        'id'             => $prefix.'people_types',
        'type'           => 'multicheck',
        'options'        => array(
            'barbers'    => 'Barbers',
            'stylists'   => 'Stylists',
            'colorists'  => 'Colorists',
            'aestheticians' => 'Aestheticians',
        ),
      ),
    ),
  );

  /**
   * Hours
   */
  $hours_group = new_cmb2_box( array(
    'id'           => $prefix . 'hours_box',
    'title'        => __( 'Hours', 'cmb2' ),
    'priority'      => 'low',
    'object_types' => array( 'location', ),
  ) );

  $hours_group_id = $hours_group->add_field( array(
    'id'          => $prefix . 'hours_group',
    'type'        => 'group',
    'options'     => array(
        'group_title'   => __( 'Day {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Day', 'cmb2' ),
        'remove_button' => __( 'Remove Day', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $hours_group->add_group_field( $hours_group_id, array(
      'name' => 'Day',
      'id'   => 'day',
      'type'             => 'select',
      'show_option_none' => false,
      'default'          => 'monday',
      'options'          => array(
        'monday'    => __( 'Monday', 'cmb2' ),
        'tuesday'   => __( 'Tuesday', 'cmb2' ),
        'wednesday' => __( 'Wednesday', 'cmb2' ),
        'thursday'  => __( 'Thursday', 'cmb2' ),
        'friday'    => __( 'Friday', 'cmb2' ),
        'saturday'  => __( 'Saturday', 'cmb2' ),
        'sunday'    => __( 'Sunday', 'cmb2' ),
      ),
  ) );

  $hours_group->add_group_field( $hours_group_id, array(
    'name'     => 'Hours',
    'id'       => 'hours',
    'type'     => 'text',
    'desc'     => 'Ex: 10-9',
  ) );

  $hours_group->add_group_field( $hours_group_id, array(
    'name'     => 'Details',
    'id'       => 'details',
    'type'     => 'text',
    'desc'     => 'Ex: appointment lines open',
  ) );

  $hours_group->add_field( array(
    'name'        => 'Abbreviated Hours',
    'id'          => $prefix . 'hours_abbr',
    'type'        => 'textarea_small',
    'description' => __( 'An abbreviated version of the location hours for the footer (ideally 3 lines)', 'cmb2' ),
  ) );

  /**
   * Salon Cut Pricing
   */
  $salon_cut_group = new_cmb2_box( array(
    'id'            => $prefix . 'salon_cut_box',
    'title'         => __( 'Salon Cut Services/Pricing', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $salon_cut_group->add_field( array(
    'id'          => $prefix . 'salon_cut_description',
    'type'        => 'wysiwyg',
    'name'        => 'Description',
    'description' => __( 'Text underneath Salon Cut header', 'cmb2' ),
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Stylist Price',
      'id'   => 'stylist_price',
      'type' => 'text',
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Senior Price',
      'id'   => 'senior_price',
      'type' => 'text',
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Master Price',
      'id'   => 'master_price',
      'type' => 'text',
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Director Price',
      'id'   => 'director_price',
      'type' => 'text',
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Blowdry Price',
      'id'   => 'blowdry_price',
      'type' => 'text',
  ) );

  /**
   * Salon Color Pricing
   */
  $salon_color_group = new_cmb2_box( array(
    'id'           => $prefix . 'salon_color_box',
    'title'        => __( 'Salon Color Services/Pricing', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $salon_color_group_id = $salon_color_group->add_field( array(
    'id'          => $prefix . 'salon_color_group',
    'type'        => 'group',
    'options'     => array(
        'group_title'   => __( 'Service {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Service', 'cmb2' ),
        'remove_button' => __( 'Remove Service', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Name',
      'id'   => 'name',
      'type' => 'text',
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Colorist Price',
      'id'   => 'colorist_price',
      'type' => 'text',
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Senior Price',
      'id'   => 'senior_price',
      'type' => 'text',
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Master Price',
      'id'   => 'master_price',
      'type' => 'text',
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Director Price',
      'id'   => 'director_price',
      'type' => 'text',
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
  ) );

  /**
   * Barbershop Services Pricing
   */
  $barbershop_services_group = new_cmb2_box( array(
    'id'           => $prefix . 'barbershop_services_box',
    'title'        => __( 'Barbershop Services/Pricing', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $barbershop_services_group->add_field( array(
    'id'          => $prefix . 'barbershop_services_description',
    'type'        => 'wysiwyg',
    'name'        => 'Description',
    'description' => __( 'Text underneath Barbershop Services header', 'cmb2' ),
  ) );

  $barbershop_services_group_id = $barbershop_services_group->add_field( array(
    'id'          => $prefix . 'barbershop_services_group',
    'type'        => 'group',
    'options'     => array(
        'group_title'   => __( 'Service {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Service', 'cmb2' ),
        'remove_button' => __( 'Remove Service', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $barbershop_services_group->add_group_field( $barbershop_services_group_id, array(
      'name' => 'Name',
      'id'   => 'name',
      'type' => 'text',
  ) );

  $barbershop_services_group->add_group_field( $barbershop_services_group_id, array(
      'name' => 'Price',
      'id'   => 'price',
      'type' => 'text',
  ) );

  $barbershop_services_group->add_group_field( $barbershop_services_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
  ) );

  /**
   * Waxing Lounge Pricing
   */
  $waxing_lounge_group = new_cmb2_box( array(
    'id'           => $prefix . 'waxing_lounge_box',
    'title'        => __( 'Waxing Lounge Services/Pricing', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $waxing_lounge_group_id = $waxing_lounge_group->add_field( array(
    'id'          => $prefix . 'waxing_lounge_group',
    'type'        => 'group',
    'options'     => array(
        'group_title'   => __( 'Service {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Service', 'cmb2' ),
        'remove_button' => __( 'Remove Service', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $waxing_lounge_group->add_group_field( $waxing_lounge_group_id, array(
      'name' => 'Name',
      'id'   => 'name',
      'type' => 'text',
  ) );

  $waxing_lounge_group->add_group_field( $waxing_lounge_group_id, array(
      'name' => 'Price',
      'id'   => 'price',
      'type' => 'text',
  ) );

  $waxing_lounge_group->add_group_field( $waxing_lounge_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
  ) );

  /**
   * Tanning Pricing
   */
  $tanning_group = new_cmb2_box( array(
    'id'           => $prefix . 'tanning_box',
    'title'        => __( 'Tanning Services/Pricing', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $tanning_group_id = $tanning_group->add_field( array(
    'id'          => $prefix . 'tanning_group',
    'type'        => 'group',
    'options'     => array(
        'group_title'   => __( 'Service {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Service', 'cmb2' ),
        'remove_button' => __( 'Remove Service', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $tanning_group->add_group_field( $tanning_group_id, array(
      'name' => 'Name',
      'id'   => 'name',
      'type' => 'text',
  ) );

  $tanning_group->add_group_field( $tanning_group_id, array(
      'name' => 'Price',
      'id'   => 'price',
      'type' => 'text',
  ) );

  $tanning_group->add_group_field( $tanning_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
  ) );

  /**
   * Bridal Suite Pricing
   */
  $bridal_suite_group = new_cmb2_box( array(
    'id'           => $prefix . 'bridal_suite_box',
    'title'        => __( 'Bridal Suite Services/Pricing', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $bridal_suite_group->add_field( array(
    'id'          => $prefix . 'bridal_suite_description',
    'type'        => 'wysiwyg',
    'name'        => 'Description',
    'description' => __( 'Text underneat Bridal Suite header', 'cmb2' ),
  ) );

  return $meta_boxes;
}

add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Get Locations
 */
function get_locations($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'location',
    'orderby' => 'menu_order',
  );

  $location_posts = get_posts($args);
  if (!$location_posts) return false;

  $output = '<ul class="grid-items locations-grid">';

  foreach ( $location_posts as $post ):
    $output .= '<li class="grid-item">';
    ob_start();
    include(locate_template('templates/article-location.php'));
    $output .= ob_get_clean();
    $output .= '</li>';
  endforeach;

  $output .= '</ul>';

  return $output;
}