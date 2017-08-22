<?php
/**
 * Service post type
 */

namespace Firebelly\PostTypes\Service;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Services',
    'singular_name'       => 'Service',
    'menu_name'           => 'Services',
    'parent_item_colon'   => '',
    'all_items'           => 'All Services',
    'view_item'           => 'View Service',
    'add_new_item'        => 'Add New Service',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Service',
    'update_item'         => 'Update Service',
    'search_items'        => 'Search Services',
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
    'label'               => 'service',
    'description'         => 'Services',
    'labels'              => $labels,
    'taxonomies'          => array('service_type'),
    'supports'            => array( 'title', 'editor', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-clipboard',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'service', $args );

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
add_filter('manage_service_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'service' ) {
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

// Custom CMB2 fields for post type
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['service_details'] = array(
    'id'            => 'service_details',
    'title'         => __( 'Service Details', 'cmb2' ),
    'object_types'  => array( 'service', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Service Code',
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
        'type' => 'text',
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
    'object_types' => array( 'service', ),
  ) );

  $hours_group_id = $hours_group->add_field( array(
    'id'          => $prefix . 'hours_group',
    'type'        => 'group',
    'description' => __( 'Note that you must switch Text mode and refresh to reorder the days', 'cmb2' ),
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

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Get Services
 */
function get_services($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'service',
    'orderby' => 'menu_order',
  );

  $service_posts = get_posts($args);
  if (!$service_posts) return false;

  $output = '<ul class="grid-items services-grid';

  foreach ( $service_posts as $post ):
    $output .= '<li class="grid-item service">';
    ob_start();
    include(locate_template('templates/article-service.php'));
    $output .= ob_get_clean();
    $output .= '</li>';
  endforeach;

  $output .= '</ul>';

  return $output;
}
