<?php
/**
 * Lookbook post type
 */

namespace Firebelly\PostTypes\Lookbook;
use Firebelly\Utils;

/**
 * Register Custom Post Type
 */
function post_type() {

  $labels = array(
    'name'                => 'Lookbooks',
    'singular_name'       => 'Lookbook',
    'menu_name'           => 'Lookbooks',
    'parent_item_colon'   => '',
    'all_items'           => 'All Lookbooks',
    'view_item'           => 'View Lookbook',
    'add_new_item'        => 'Add New Lookbook',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Lookbook',
    'update_item'         => 'Update Lookbook',
    'search_items'        => 'Search Lookbooks',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => 'lookbooks',
    'with_front'          => false,
    'pages'               => false,
    'feeds'               => false,
  );
  $args = array(
    'label'               => 'lookbook',
    'description'         => 'Lookbooks',
    'labels'              => $labels,
    'taxonomies'          => array('category'),
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
  register_post_type( 'lookbook', $args );

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
add_filter('manage_lookbook_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'lookbook' ) {
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

  $meta_boxes['Lookbook Images'] = array(
    'id'            => 'lookbook_images',
    'title'         => __( 'Lookbook Images', 'cmb2' ),
    'object_types'  => array( 'lookbook', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
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
        'desc'   => '(Untreated. 1600px width advised.  The image thumbnail will be cropped to 1:1 square aspect ratio desktop [top-weighted]--so put important content center top. When the user clicks on the thumbnail, they will view the image in its original aspect ratio.)',
      ),
    ),
  );


  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

/**
 * Add descriptions to featured images in lookbooks
 */
add_filter( 'admin_post_thumbnail_html', __NAMESPACE__ . '\add_featured_image_instruction');
function add_featured_image_instruction( $content ) {

  // Possible image instructions
   $desc = '<p>(Untreated. 1600px width for landscape OR 900px height for advised. 1200px  The banner version will be cropped to 5:3 aspect ratio desktop [top-weighted], 1:1 square ratio on mobile--so put important content center top.  The thumbnail version will be cropped 1:1.)</p><p>Banner image at top of this lookbook\'s gallery and also the thumbnail for this gallery on the Lookbook page.</p>';

  if( get_current_screen()->id != 'lookbook') return $content; // This function is only concerned with pages.

  return $content .= $desc;

}