<?php

namespace Firebelly\Utils;

/**
 * Bump up # search results
 */
function search_queries( $query ) {
  if ( !is_admin() && is_search() ) {
    $query->set( 'posts_per_page', 40 );
  }
  return $query;
}
add_filter( 'pre_get_posts', __NAMESPACE__ . '\\search_queries' );

/**
 * Custom li'l excerpt function
 */
function get_excerpt( $post, $length=15, $force_content=false ) {
  $excerpt = trim($post->post_excerpt);
  if (!$excerpt || $force_content) {
    $excerpt = $post->post_content;
    $excerpt = strip_shortcodes( $excerpt );
    $excerpt = apply_filters( 'the_content', $excerpt );
    $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
    $excerpt_length = apply_filters( 'excerpt_length', $length );
    $excerpt = wp_trim_words( $excerpt, $excerpt_length );
  }
  return $excerpt;
}

/**
 * Get top ancestor for post
 */
function get_top_ancestor($post){
  if (!$post) return;
  $ancestors = $post->ancestors;
  if ($ancestors) {
    return end($ancestors);
  } else {
    return $post->ID;
  }
}

/**
 * Get first term for post
 */
function get_first_term($post, $taxonomy='category') {
  $return = false;
  if ($terms = get_the_terms($post->ID, $taxonomy))
    $return = array_pop($terms);
  return $return;
}

/**
 * Get page content from slug
 */
function get_page_content($slug) {
  $return = false;
  if ($page = get_page_by_path($slug))
    $return = apply_filters('the_content', $page->post_content);
  return $return;
}

/**
 * Get category for post
 */
function get_category($post) {
  if ($category = get_the_category($post)) {
    return $category[0];
  } else return false;
}

/**
 * Get num_pages for category given slug + per_page
 */
function get_total_pages($category, $per_page) {
  $cat_info = get_category_by_slug($category);
  $num_pages = ceil($cat_info->count / $per_page);
  return $num_pages;
}

/**
 * Get Page Blocks
 */
function get_page_blocks($post) {
  $output = '';
  $page_blocks = get_post_meta($post->ID, '_cmb2_page_blocks', true);
  if ($page_blocks) {
    foreach ($page_blocks as $page_block) {
      if (empty($page_block['hide_block'])) {
        $block_title = $block_body = '';
        if (!empty($page_block['title']))
          $block_title = $page_block['title'];
        if (!empty($page_block['body'])) {
          $block_body = apply_filters('the_content', $page_block['body']);
          $output .= '<div class="page-block">';
          if ($block_title) {
            $output .= '<h2 class="flag">' . $block_title . '</h2>';
          }
          $output .= '<div class="user-content">' . $block_body . '</div>';
          $output .= '</div>';
        }
      }
    }
  }
  return $output;
}

/**
 * Register custom taxonomies
 */
function custom_taxonomies() {
  register_taxonomy(
    'locations',
    'person',
    array(
      'labels' => array(
        'name' => 'Locations',
        'add_new_item' => 'Add New Location',
        'new_item_name' => "New Location"
        ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'show_admin_column' => true,
      'hierarchical' => true
    )
  );
  register_taxonomy(
    'person_type',
    'person',
    array(
      'labels' => array(
        'name' => 'Position Types',
        'add_new_item' => 'Add New Position Type',
        'new_item_name' => "New Position Type"
        ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'show_admin_column' => true,
      'hierarchical' => true
    )
  );
}
add_action( 'init', __NAMESPACE__ . '\\custom_taxonomies', 0 );

// Add slugs as classes to each nav item
function add_slug_class_to_menu_item($output){
  $ps = get_option('permalink_structure');
  if(!empty($ps)){
    $idstr = preg_match_all('/<li id="menu-item-(\d+)/', $output, $matches);
    foreach($matches[1] as $mid){
      $id = get_post_meta($mid, '_menu_item_object_id', true);
      $slug = basename(get_permalink($id));
      $output = preg_replace('/menu-item-'.$mid.'">/', 'menu-item-'.$mid.' menu-item-'.$slug.'">', $output, 1);
    }
  }
  return $output;
}
add_filter( 'wp_nav_menu', __NAMESPACE__ . '\\add_slug_class_to_menu_item' );