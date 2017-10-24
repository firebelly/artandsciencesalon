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
        'name' => 'Abbreviated Title',
        'id'   => $prefix . 'short_title',
        'desc' => 'Ex: "Logan Square" instead of "Logan Square Barbershop".',
        'type' => 'text',
      ),
      array(
        'name' => 'Location Code',
        'id'   => $prefix . 'code',
        'desc' => 'Ex: Logan Square = "LSQ".',
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
    'desc'     => 'Ex: "appointment lines open". Parentheses will be added.',
  ) );

  $hours_group->add_field( array(
    'name'        => 'Abbreviated Hours',
    'id'          => $prefix . 'hours_abbr',
    'type'        => 'textarea_small',
    'description' => __( 'An abbreviated version of the location hours for the footer (ideally 3 lines).', 'cmb2' ),
  ) );

  /**
   * Salon Cut Pricing
   */
  $salon_cut_group = new_cmb2_box( array(
    'id'            => $prefix . 'salon_cut_box',
    'title'         => __( 'Salon Cut Services/Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $salon_cut_group->add_field( array(
    'id'          => $prefix . 'salon_cut_description',
    'type'        => 'wysiwyg',
    'name'        => 'Description',
    'description' => __( 'Copy for Salon Cut section.', 'cmb2' ),
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Stylist Price',
      'id'   => $prefix . 'salon_cut_stylist_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Senior Price',
      'id'   => $prefix . 'salon_cut_senior_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Master Price',
      'id'   => $prefix . 'salon_cut_master_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Director Price',
      'id'   => $prefix . 'salon_cut_director_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $salon_cut_group->add_field( array(
      'name' => 'Blowdry Price',
      'id'   => $prefix . 'salon_cut_blowdry_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  /**
   * Salon Color Pricing
   */
  $salon_color_group = new_cmb2_box( array(
    'id'           => $prefix . 'salon_color_box',
    'title'        => __( 'Salon Color Services/Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $salon_color_group_id = $salon_color_group->add_field( array(
    'id'          => $prefix . 'salon_color_group',
    'type'        => 'group',
    'description' => 'List of services to be included under Salon Color for this location.  If no services are added, the Salon Color section will be ommitted for this location.<br><br>If all prices are left blank for a service, pricing table will display "Quoted by Consultation".',
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
      'desc' => 'Include "$"'
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Senior Price',
      'id'   => 'senior_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Master Price',
      'id'   => 'master_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Director Price',
      'id'   => 'director_price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $salon_color_group->add_group_field( $salon_color_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
      'desc' => 'The text hidden within the accordion (triangle icon).<br>If blank, this service will have no accordion.',
  ) );

  /**
   * Barbershop Services Pricing
   */
  $barbershop_services_group = new_cmb2_box( array(
    'id'           => $prefix . 'barbershop_services_box',
    'title'        => __( 'Barbershop Services/Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $barbershop_services_group->add_field( array(
    'id'          => $prefix . 'barbershop_services_description',
    'type'        => 'wysiwyg',
    'name'        => 'Description',
    'description' => __( 'Copy for Barbershop Services section.', 'cmb2' ),
  ) );

  $barbershop_services_group_id = $barbershop_services_group->add_field( array(
    'id'          => $prefix . 'barbershop_services_group',
    'type'        => 'group',
    'description' => 'List of services to be included under Barbershop Services for this location.  If no services are added, the Barbershop Services section will be ommitted for this location.',
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
      'desc' => 'Include "$"'
  ) );

  $barbershop_services_group->add_group_field( $barbershop_services_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
      'desc' => 'The text hidden within the accordion (triangle icon).<br>If blank, this service will have no accordion.',
  ) );

  /**
   * Formal Styling Services/Pricing
   */
  $formal_styling_group = new_cmb2_box( array(
    'id'           => $prefix . 'formal_styling_box',
    'title'        => __( 'Formal Styling Services/Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $formal_styling_group->add_field( array(
    'id'          => $prefix . 'formal_styling_description',
    'type'        => 'wysiwyg',
    'name'        => 'Description',
    'description' => __( '(Optional) Copy for Formal Styling section.', 'cmb2' ),
  ) );

  $formal_styling_group_id = $formal_styling_group->add_field( array(
    'id'          => $prefix . 'formal_styling_group',
    'type'        => 'group',
    'description' => 'List of services to be included under Formal Styling for this location.  If no services are added, the Formal Styling section will be ommitted for this location.',
    'options'     => array(
        'group_title'   => __( 'Service {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Service', 'cmb2' ),
        'remove_button' => __( 'Remove Service', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $formal_styling_group->add_group_field( $formal_styling_group_id, array(
      'name' => 'Name',
      'id'   => 'name',
      'type' => 'text',
  ) );

  $formal_styling_group->add_group_field( $formal_styling_group_id, array(
      'name' => 'Price',
      'id'   => 'price',
      'type' => 'text',
      'desc' => 'Include "$"'
  ) );

  $formal_styling_group->add_group_field( $formal_styling_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
      'desc' => 'The text hidden within the accordion (triangle icon).<br>If blank, this service will have no accordion.',
  ) );

  /**
   * Waxing Lounge Pricing
   */
  $waxing_lounge_group = new_cmb2_box( array(
    'id'           => $prefix . 'waxing_lounge_box',
    'title'        => __( 'Waxing Lounge Services/Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $waxing_lounge_group_id = $waxing_lounge_group->add_field( array(
    'id'          => $prefix . 'waxing_lounge_group',
    'type'        => 'group',
    'description' => 'List of services to be included under Waxing Lounge for this location.  If no services are added, the Waxing Lounge section will be ommitted for this location.',
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
      'desc' => 'Include "$"'
  ) );

  $waxing_lounge_group->add_group_field( $waxing_lounge_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
      'desc' => 'The text hidden within the accordion (triangle icon).<br>If blank, this service will have no accordion.',
  ) );

  /**
   * Tanning Pricing
   */
  $tanning_group = new_cmb2_box( array(
    'id'           => $prefix . 'tanning_box',
    'title'        => __( 'Tanning Services/Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $tanning_group_id = $tanning_group->add_field( array(
    'id'          => $prefix . 'tanning_group',
    'type'        => 'group',
    'description' => 'List of services to be included under Tanning for this location.  If no services are added, the Tanning section will be ommitted for this location.',
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
      'desc' => 'Include "$"'
  ) );

  $tanning_group->add_group_field( $tanning_group_id, array(
      'name' => 'Description (optional)',
      'id'   => 'description',
      'type' => 'textarea_small',
      'desc' => 'The text hidden within the accordion (triangle icon).<br>If blank, this service will have no accordion.',
  ) );

  /**
   * Bridal Suite Pricing
   */
  $bridal_suite_group = new_cmb2_box( array(
    'id'           => $prefix . 'bridal_suite_box',
    'title'        => __( 'Bridal Suite Services/Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types'  => array( 'location', ), // Post type
  ) );

  $bridal_suite_group->add_field( array(
    'id'          => $prefix . 'bridal_suite_description',
    'type'        => 'wysiwyg',
    'name'        => 'Description',
    'description' => __( 'Copy for Bridal Suite section.', 'cmb2' ),
  ) );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Add descriptions to featured images in locations
 */
add_filter( 'admin_post_thumbnail_html', __NAMESPACE__ . '\add_featured_image_description');

function add_featured_image_description( $content ) {

  if( get_current_screen()->id === 'location') {

    return $content.'<p>(Untreated. 1600px width advised. Will be cropped to 8:3 aspect ratio desktop, 3:2 on mobile--so put important content in center)</p><p>Banner Image at top of this location on Locations page.</p>';

  } else {
    return $content;
  }
}


/**
 * Get Locations
 */
function get_footer_locations($options=[]) {
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

/**
 * Get Service Section Nav
 */
function get_service_section_nav($location) {

  $output = '';
  $output .= '<nav class="subpage-section-nav hide-during-page-load">';
  $output .= '<ul class="subpage-section-list">';

  $slug = $location->post_name;
  $location_id = $location->ID;


  $output .= get_post_meta($location_id,'_cmb2_salon_cut_description',true) ?
  '<li class="subpage-section-list-item"><a href="#'.$slug.'-salon-cut" class="smoothscroll">Salon Cut</a></li>' : '';

  $output .= get_post_meta($location_id,'_cmb2_salon_color_group',true) ?
  '<li class="subpage-section-list-item"><a href="#'.$slug.'-salon-color" class="smoothscroll">Salon Color</a></li>' : '';

  $output .= get_post_meta($location_id,'_cmb2_barbershop_services_group',true) ?
  '<li class="subpage-section-list-item"><a href="#'.$slug.'-barbershop-services" class="smoothscroll">Barbershop Services</a></li>' : '';

  $output .= get_post_meta($location_id,'_cmb2_formal_styling_group',true) ?
  '<li class="subpage-section-list-item"><a href="#'.$slug.'-formal-styling" class="smoothscroll">Formal Styling</a></li>' : '';

  $output .= get_post_meta($location_id,'_cmb2_waxing_lounge_group',true) ?
  '<li class="subpage-section-list-item"><a href="#'.$slug.'-waxing-lounge" class="smoothscroll">Waxing Lounge</a></li>' : '';

  $output .= get_post_meta($location_id,'_cmb2_tanning_group',true) ?
  '<li class="subpage-section-list-item"><a href="#'.$slug.'-tanning" class="smoothscroll">Tanning</a></li>' : '';

  $output .= get_post_meta($location_id,'_cmb2_bridal_suite_description',true) ?
  '<li class="subpage-section-list-item"><a href="#'.$slug.'-bridal" class="smoothscroll">Bridal</a></li>' : '';


  $output.= '</ul></nav>';

  return $output;
}


/**
 * Get Service Section Nav
 */
function get_service_table($location) {

  $output = '';
  $output .= '<div class="services details-block">';
  $output .= '<h4>Available Services</h4>';
  $output .= '<table class="data-table services-table"><tbody>';

  $slug = $location->post_name;
  $location_id = $location->ID;


  $output .= get_post_meta($location_id,'_cmb2_salon_cut_description',true) ?
  '<tr><td><a href="/services/#'.$slug.'-salon-cut">Salon Cut</td></tr>' : '';

  $output .= get_post_meta($location_id,'_cmb2_salon_color_group',true) ?
  '<tr><td><a href="/services/#'.$slug.'-salon-color">Salon Color</td></tr>' : '';

  $output .= get_post_meta($location_id,'_cmb2_barbershop_services_group',true) ?
  '<tr><td><a href="/services/#'.$slug.'-barbershop-services">Barbershop Services</td></tr>' : '';

  $output .= get_post_meta($location_id,'_cmb2_formal_styling_group',true) ?
  '<tr><td><a href="/services/#'.$slug.'-formal-styling">Formal Styling</td></tr>' : '';

  $output .= get_post_meta($location_id,'_cmb2_waxing_lounge_group',true) ?
  '<tr><td><a href="/services/#'.$slug.'-waxing-lounge">Waxing Lounge</td></tr>' : '';

  $output .= get_post_meta($location_id,'_cmb2_tanning_group',true) ?
  '<tr><td><a href="/services/#'.$slug.'-tanning">Tanning</td></tr>' : '';

  $output .= get_post_meta($location_id,'_cmb2_bridal_suite_description',true) ?
  '<tr><td><a href="/services/#'.$slug.'-bridal">Bridal</td></tr>' : '';


  $output.= '</tbody></table></div>';

  return $output;
}

/**
 * Get Salon Cut Pricing Table
 */
function get_services_salon_cut() {

  global $post;
  $location_id = $post->ID;

  $salon_cut_text = get_post_meta($location_id,'_cmb2_salon_cut_description',true);

  if(!$salon_cut_text) { return false; }

  $output = '';


  $slug = $post->post_name;

  $output .= '<section class="section to-top-location" id="'.$slug.'-salon-cut">';

  $output .= '<h2 class="experience-popup-location">Salon Cut</h2>';
  $output .= '<div class="salon-cut-wrap">';

  $stylist_price = get_post_meta($location_id,'_cmb2_salon_cut_stylist_price',true);
  $senior_price = get_post_meta($location_id,'_cmb2_salon_cut_senior_price',true);
  $master_price = get_post_meta($location_id,'_cmb2_salon_cut_master_price',true);
  $director_price = get_post_meta($location_id,'_cmb2_salon_cut_director_price',true);
  $blowdry_price = get_post_meta($location_id,'_cmb2_salon_cut_blowdry_price',true);


  $output .= <<<HTML
    <ul class="salon-cut-list">
      <tr class="titles">
        <li>
          <h3 class="price-type">Stylist <span class="sr-only">Price</span></h3>
          <p class="price-value">{$stylist_price}</p>
        </li>
        <li>
          <h3 class="price-type">Senior <span class="sr-only">Price</span></h3>
          <p class="price-value">{$senior_price}</tp
        </li>
        <li>
          <h3 class="price-type">Master <span class="sr-only">Price</span></h3>
          <p class="price-value">{$master_price}</tp
        </li>
        <li>
          <h3 class="price-type">Director <span class="sr-only">Price</span></h3>
          <p class="price-value">{$director_price}<pd>
        </li>
        <li>
          <h3 class="price-type">Blowdry <span class="sr-only">Price</span></h3>
          <p class="price-value">{$blowdry_price}</p>
        </li>
      </ul>
HTML;

  $output .= apply_filters('the_content', $salon_cut_text);

  $output .= '</div>';

  $output .= '</section>';
  return $output;
}

/**
 * Get Salon Color Pricing Table
 */
function get_services_salon_color() {

  global $post;
  $location_id = $post->ID;

  $services = get_post_meta($location_id,'_cmb2_salon_color_group',true);

  if(!$services) { return false; }

  $output = '';

  $slug = $post->post_name;
  $output .= '<section class="section linked-subpage-section to-top-location" id="'.$slug.'-salon-color"">
  ';
  $output .= '<h2 class="experience-popup-location">Salon Color</h2>';

  ob_start();
  include(locate_template('templates/pricing-table-salon-color.php'));
  $output .= ob_get_clean();

  $output .= '</section>';
  return $output;
}

/**
 * Get Barbershop Pricing Table
 */
function get_services_barbershop() {

  global $post;
  $location_id = $post->ID;

  $services = get_post_meta($location_id,'_cmb2_barbershop_services_group',true);

  if(!$services) { return false; }

  $barbershop_text = apply_filters('the_content', get_post_meta($location_id,'_cmb2_barbershop_services_description',true) );

  $output = '';

  $slug = $post->post_name;
  $output .= '<section class="section linked-subpage-section to-top-location" id="'.$slug.'-barbershop-services">';
  $output .= '<h2 class="experience-popup-location">Barbershop Services</h2>';

  $output .= $barbershop_text;

  ob_start();
  include(locate_template('templates/pricing-table.php'));
  $output .= ob_get_clean();

  $output .= '</section>';
  return $output;
}

/**
 * Get Formal Styling Pricing Table
 */
function get_services_formal_styling() {

  global $post;
  $location_id = $post->ID;

  $services = get_post_meta($location_id,'_cmb2_formal_styling_group',true);

  if(!$services) { return false; }

  $barbershop_text = apply_filters('the_content', get_post_meta($location_id,'_cmb2_formal_styling_description',true) );

  $output = '';

  $slug = $post->post_name;
  $output .= '<section class="section linked-subpage-section to-top-location" id="'.$slug.'-formal-styling">';
  $output .= '<h2>Formal Styling</h2>';

  $output .= $barbershop_text;

  ob_start();
  include(locate_template('templates/pricing-table.php'));
  $output .= ob_get_clean();

  $output .= '</section>';
  return $output;
}

/**
 * Get Waxing Pricing Table
 */
function get_services_waxing() {

  global $post;
  $location_id = $post->ID;

  $services = get_post_meta($location_id,'_cmb2_waxing_lounge_group',true);

  if(!$services) { return false; }

  $output = '';

  $slug = $post->post_name;
  $output .= '<section class="section linked-subpage-section to-top-location" id="'.$slug.'-waxing-lounge">';
  $output .= '<h2>Waxing Lounge</h2>';

  ob_start();
  include(locate_template('templates/pricing-table.php'));
  $output .= ob_get_clean();

  $output .= '</section>';
  return $output;
}

/**
 * Get Tanning Pricing Table
 */
function get_services_tanning() {

  global $post;
  $location_id = $post->ID;

  $services = get_post_meta($location_id,'_cmb2_tanning_group',true);

  if(!$services) { return false; }

  $output = '';

  $slug = $post->post_name;
  $output .= '<section class="section linked-subpage-section to-top-location" id="'.$slug.'-tanning">';

  $output .= '<h2>Tanning</h2>';

  ob_start();
  include(locate_template('templates/pricing-table.php'));
  $output .= ob_get_clean();

  $output .= '</section>';
  return $output;
}

/**
 * Get Tanning Pricing Table
 */
function get_services_bridal() {

  global $post;
  $location_id = $post->ID;

  $bridal_text = get_post_meta($location_id,'_cmb2_bridal_suite_description',true);

  if(!$bridal_text) { return false; }

  $output = '';

  $slug = $post->post_name;
  $output .= '<section class="section linked-subpage-section to-top-location" id="'.$slug.'-bridal">';

  $output .= '<h2>Bridal</h2>';

  $output .= apply_filters('the_content', $bridal_text);
  $output .= '<p><a href="/bridal" class="details-link non-user-content-link">Service &plus; Price Details</a></p>';

  $output .= '</section>';
  return $output;
}

/**
 * Convenience Functions
 */
function get_location_from_term($term) {

  $slug = $term->slug;
  $args = array(
    'name'        => $slug,
    'post_type'   => 'location',
    'numberposts' => 1
  );
  return get_posts($args)[0];
}

function get_link_url($location) {
  $slug = $location->post_name;
  return '/locations/#'.$slug;
}

function get_code($location_id) {
  return get_post_meta($location_id, '_cmb2_code', true);
}