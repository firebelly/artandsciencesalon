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
        'name' => 'Short Name',
        'id'   => $prefix . 'short_name',
        'description' => 'To be used for short, informal name.  (If not specified, the first word of the full name will be taken.)',
        'type' => 'text',
      ),
      array(
        'name' => 'Quote (optional)',
        'id'   => $prefix . 'quote',
        'type' => 'textarea',
        'desc' => 'Include quotation marks ("") if applicable.'
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
    'description' => __( 'List of days and locations this person is available.', 'cmb2' ),
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
      'show_option_none' => true,
      'options'          => array(
        'Monday'     => __( 'Monday', 'cmb2' ),
        'Tuesday'    => __( 'Tuesday', 'cmb2' ),
        'Wednesday'  => __( 'Wednesday', 'cmb2' ),
        'Thursday'   => __( 'Thursday', 'cmb2' ),
        'Friday'     => __( 'Friday', 'cmb2' ),
        'Saturday'   => __( 'Saturday', 'cmb2' ),
        'Sunday'     => __( 'Sunday', 'cmb2' ),
      ),
  ) );

  $days_group->add_group_field( $group_field_id, array(
      'name' => 'Pattern',
      'desc' => 'Lowercase.  Parentheses will be added. Ex: every other week',
      'id'   => 'pattern',
      'type' => 'text',
  ) );

  $days_group->add_group_field( $group_field_id, array(
    'name'     => 'Location',
    'id'       => 'location',
    'type'     => 'select',
    'show_option_none' => true,
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
    'description' => __( 'List of services and pricing for this person.', 'cmb2' ),
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
    'desc'     => 'Include the dollar sign ($) if needed.',
  ) );

  $pricing_group->add_group_field( $pricing_group_id, array(
    'name'     => 'Pricing details',
    'id'       => 'details',
    'desc'     => 'Lowercase.  Parentheses will be added. Ex: "free for returning customers".',
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
    'description' => __( 'List of social media links for this person.' ),
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
      'show_option_none' => true,
      'options' => array(
        'pinterest' => 'Pinterest',
        'instagram' => 'Instagram',
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
 * Add descriptions to featured images in social impact galleries
 */
add_filter( 'admin_post_thumbnail_html', __NAMESPACE__ . '\add_featured_image_instruction');
function add_featured_image_instruction( $content ) {

  // Possible image instructions
   $desc = '<p>(Untreated. 800px width advised. Will be cropped 1:1 square [top-weighted].)</p><p>Profile picture of this person to be used wherever they appear on the site and within their bio popups.</p>';

  if( get_current_screen()->id != 'person') return $content; // This function is only concerned with pages.

  return $content . $desc;

}

/**
 * Shorten a full name to a first name
 */
function get_short_name($person) {

  $short_name = get_post_meta($person->ID, '_cmb2_short_name', true);
  if ($short_name) {
    return $short_name;
  }
  // If a short name is not provided, take first word of full name
  return explode(' ',trim($person->post_title))[0];

}

/**
 * Get Service Section Nav
 */
function get_people_section_nav($location) {

  $output = '';
  $output .= '<nav class="subpage-section-nav hide-during-page-load">';
  $output .= '<ul class="subpage-section-list">';


  $slug = $location->post_name;
  $location_id = $location->ID;
  $people_types = get_terms([
    'taxonomy'=>'person_type',
    'slug' => ['colorist', 'master-colorist', 'senior-colorist', 'director-colorist','stylist', 'master-stylist', 'senior-stylist', 'director-stylist','barber','aesthetician']
  ]);

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
 * Get List of People For A Location
 */
function get_people_list($location, $slug_array) {

  $args = array(
    'numberposts' => -1,
    'post_type' => 'person',
    'orderby' => 'title',
    'order' => 'ASC',
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'locations',
        'field' => 'slug',
        'terms' => $location->post_name
      ),
      array(
        'taxonomy' => 'person_type',
        'field' => 'slug',
        'terms' => $slug_array
      )
    )
  );

  $people = get_posts($args);

  if(!$people) { return false; }

  $output = '';

  $output .= '<ul class="people-list semantic-only-list">';


  foreach ($people as $person) :
    $output .= '<li class="people-list-item"><a href="/stylists/#'.$location->post_name.'-'.$person->post_name.'">'.$person->post_title.'</a></li>';
  endforeach;

  $output  .= '</ul>';

  return $output;
}

/**
 * Get person for person grid
 * person (the object )
 */
function get_person_markup($person,$formal=false,$popup=true,$location=false) {

  $output = '';


  $full_name = $person->post_title;
  $name = $formal ? $full_name : \Firebelly\PostTypes\People\get_short_name($person);
  $thumb_url = \Firebelly\Media\get_post_thumbnail_url($person->ID,'gallery-thumb',true);
  $thumb_preload_url = \Firebelly\Media\get_post_thumbnail_url($person->ID,'preload',true);
  $slug = $person->post_name;
  $id = ($location ? $location->post_name.'-' : '' ).$person->post_name;
  $permalink = get_permalink($person);
  $no_popup = $popup ? '' : 'no-popup';
  $title = get_post_meta($person->ID,'_cmb2_title',true);

  $output .= <<<HTML
    <article id="{$id}" class="stylist person {$no_popup}" data-slug="{$slug}" data-page-title="{$full_name}" data-page-url="{$permalink}">
HTML;

  $output .= '<div class="grid-content'.($popup ? ' open-person-popup' : '').'">';

  $output .= <<<HTML
      <div class="thumbnail-wrap">
        <div data-src="{$thumb_url}" data-preload-src="{$thumb_preload_url}" class="thumbnail lazy"></div>
      </div>
      <h4 class="stylist-name">{$name}</h4>
HTML;
  
  $output .= $formal ? '<h4 class="stylist-title">'.$title.'</h4>' : '';

  $output .= '</div>';

  if($popup) {
    ob_start();
    $post = $person;
    include(locate_template('templates/person-popup.php'));
    $output .= ob_get_clean();
  }

  $output .= '</article>';

  return $output;
}
