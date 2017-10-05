<?php
/**
 * Social Impact Gallery post type
 */

namespace Firebelly\PostTypes\SocialImpact;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Social Impact Galleries',
    'singular_name'       => 'Gallery',
    'menu_name'           => 'Social Impact Galleries',
    'parent_item_colon'   => '',
    'all_items'           => 'All Social Impact Galleries',
    'view_item'           => 'View Gallery',
    'add_new_item'        => 'Add New Gallery',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Gallery',
    'update_item'         => 'Update Gallery',
    'search_items'        => 'Search Social Impact Galleries',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => 'social-impact',
    'with_front'          => false,
    'pages'               => false,
    'feeds'               => false,
  );
  $args = array(
    'label'               => 'social-impact',
    'description'         => 'Social Impact Galleries',
    'labels'              => $labels,
    'taxonomies'          => array(''),
    'supports'            => array( 'title', 'editor', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-images-alt2',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
  );
  register_post_type( 'si-gallery', $args );

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
add_filter('manage_si-gallery_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'si-gallery' ) {
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

  $meta_boxes['Gallery Images'] = array(
    'id'            => 'si-gallery_images',
    'title'         => __( 'Gallery Images', 'cmb2' ),
    'object_types'  => array( 'si-gallery', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'description'   => 'Minimu 1200px width resolution. Thumbnails will be square cropped, but on click user will see full dimensions in popup.',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
      array(
        'name' => 'Images',
        'desc' => '',
        'id'   => $prefix.'images',
        'type' => 'file_list',
        'preview_size' => array( 200, 200 ),
        'query_args' => array( 'type' => 'image' ), // Only images attachment
        'text' => array(
          'add_upload_files_text' => 'Add or Upload Images'
        ),
      ),
    ),
  );


  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );