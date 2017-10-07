<?php
/**
 * Person post type
 */

namespace Firebelly\PostTypes\People;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'People',
    'singular_name'       => 'Person',
    'menu_name'           => 'People',
    'parent_item_colon'   => '',
    'all_items'           => 'All People',
    'view_item'           => 'View Person',
    'add_new_item'        => 'Add New Person',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Person',
    'update_item'         => 'Update Person',
    'search_items'        => 'Search People',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => 'stylist',
    'with_front'          => false,
    'pages'               => false,
    'feeds'               => false,
  );
  $args = array(
    'label'               => 'person',
    'description'         => 'People',
    'labels'              => $labels,
    'taxonomies'          => array('person_type', 'locations'),
    'supports'            => array( 'title', 'editor', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-groups',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'person', $args );

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
add_filter('manage_person_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'person' ) {
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

  $meta_boxes['person_details'] = array(
    'id'            => 'person_details',
    'title'         => __( 'Person Details', 'cmb2' ),
    'object_types'  => array( 'person', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Quote',
        'id'   => $prefix . 'quote',
        'type' => 'textarea',
      ),
      array(
        'name' => 'Title/Position',
        'id'   => $prefix . 'title',
        'type' => 'text',
      ),
    ),
  );

  /**
   * Days
   */
  $days_group = new_cmb2_box( array(
    'id'           => $prefix . 'days_box',
    'title'        => __( 'Days Available', 'cmb2' ),
    'priority'      => 'low',
    'object_types' => array( 'person', ),
  ) );

  $group_field_id = $days_group->add_field( array(
    'id'          => $prefix . 'days_group',
    'type'        => 'group',
    'description' => __( 'Note that you must switch Text mode and refresh to reorder the days', 'cmb2' ),
    'options'     => array(
        'group_title'   => __( 'Day {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Day', 'cmb2' ),
        'remove_button' => __( 'Remove Day', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $days_group->add_group_field( $group_field_id, array(
      'name' => 'Day',
      'id'   => 'day',
      'type'             => 'select',
      'show_option_none' => false,
      'default'          => 'Monday',
      'options'          => array(
        'Monday'    => __( 'Monday', 'cmb2' ),
        'Tuesday'   => __( 'Tuesday', 'cmb2' ),
        'Wednesday' => __( 'Wednesday', 'cmb2' ),
        'Thursday'  => __( 'Thursday', 'cmb2' ),
        'Friday'    => __( 'Friday', 'cmb2' ),
        'Saturday'  => __( 'Saturday', 'cmb2' ),
        'Sunday'    => __( 'Sunday', 'cmb2' ),
      ),
  ) );

  $days_group->add_group_field( $group_field_id, array(
      'name' => 'Pattern',
      'desc' => 'Ex: every other week',
      'id'   => 'pattern',
      'type' => 'text',
  ) );

  $days_group->add_group_field( $group_field_id, array(
    'name'     => 'Location',
    'id'       => 'location',
    'type'     => 'select',
    'options'  => \Firebelly\CMB2\get_post_options(['post_type' => 'location', 'numberposts' => -1]),
  ) );

  /**
   * Pricing
   */
  $pricing_group = new_cmb2_box( array(
    'id'           => $prefix . 'pricing_box',
    'title'        => __( 'Pricing', 'cmb2' ),
    'priority'      => 'low',
    'object_types' => array( 'person', ),
  ) );

  $pricing_group_id = $pricing_group->add_field( array(
    'id'          => $prefix . 'pricing_group',
    'type'        => 'group',
    'description' => __( 'Note that you must switch Text mode and refresh to reorder the days', 'cmb2' ),
    'options'     => array(
        'group_title'   => __( 'Service {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Service', 'cmb2' ),
        'remove_button' => __( 'Remove Service', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $pricing_group->add_group_field( $pricing_group_id, array(
    'name' => 'Service',
    'id'   => 'service',
    'type' => 'text',
  ) );

  $pricing_group->add_group_field( $pricing_group_id, array(
    'name'     => 'Price',
    'id'       => 'price',
    'type'     => 'text',
    'desc'     => 'Include the dollar sign ($) if needed',
  ) );

  $pricing_group->add_group_field( $pricing_group_id, array(
    'name'     => 'Pricing details',
    'id'       => 'details',
    'desc'     => 'Ex: free for returning customers',
    'type'     => 'text',
  ) );

  /**
   * Lookbooks
   */
  $lookbook_group = new_cmb2_box( array(
    'id'           => $prefix . 'lookbook_box',
    'title'        => __( 'Lookbooks', 'cmb2' ),
    'priority'      => 'low',
    'object_types' => array( 'person', ),
  ) );

  $lookbook_group_id = $lookbook_group->add_field( array(
    'id'          => $prefix . 'lookbook_group',
    'type'        => 'group',
    'description' => __( 'Social media links' ),
    'options'     => array(
        'group_title'   => __( 'Link {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Link', 'cmb2' ),
        'remove_button' => __( 'Remove Link', 'cmb2' ),
    ),
  ) );

  $lookbook_group->add_group_field( $lookbook_group_id, array(
      'name' => 'Source',
      'id'   => 'source',
      'type' => 'select',
      'options' => array(
        'pinterest' => 'Pinterest',
        'instagram' => 'Instagram',
        'tumblr'    => 'Tumblr',
      ),
  ) );

  $lookbook_group->add_group_field( $lookbook_group_id, array(
    'name'     => 'Link Url',
    'id'       => 'url',
    'type'     => 'text',
  ) );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Get Service Section Nav
 */
function get_people_section_nav($location) {

  $output = '';
  $output .= '<nav class="subpage-section-nav hide-during-page-load">';
  $output .= '<ul class="subpage-section-list">';


  $slug = $location->post_name;
  $location_id = $location->ID;
  $people_types = get_terms(['taxonomy'=>'person_type']);

   foreach ($people_types as $people_type):
      $people = get_posts([
        'numberposts' => -1,
        'post_type' => 'person',
        'orderby' => 'menu_order',
        'tax_query' => array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'locations',
            'field' => 'name',
            'terms' => $location->post_title
          ),
          array(
            'taxonomy' => 'person_type',
            'field' => 'slug',
            'terms' => $people_type
          )
        )
      ]);

      if (!empty($people)):
        $output .= '<li class="subpage-section-list-item"><a href="#'.$slug.'-'.$people_type->slug.'" class="smoothscroll">'.$people_type->name.'</a></li>';
      endif;
    endforeach;


  $output.= '</ul></nav>';

  return $output;
}


/**
 * Get People
 */
function get_people($options=[]) {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'menu_order',
  );

  $person_posts = get_posts($args);
  if (!$person_posts) return false;

  $output = '<ul class="grid-items people-grid';

  foreach ( $person_posts as $post ):
    $output .= '<li class="grid-item person">';
    ob_start();
    include(locate_template('templates/article-person.php'));
    $output .= ob_get_clean();
    $output .= '</li>';
  endforeach;

  $output .= '</ul>';

  return $output;
}
