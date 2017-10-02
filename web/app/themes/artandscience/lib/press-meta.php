<?php
/**
 * Press Page Meta/Admin Functions, Filters, Hooks
 */

namespace Firebelly\PostTypes\Pages\Press;

/**
 * Custom CMB2 fields for page
 */
function register_metaboxes() {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  /**
   * Contact
   */
  $awards_group = new_cmb2_box( array(
    'id'           => $prefix . 'awards_box',
    'title'        => __( 'Awards', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'press'),
  ) );

  $awards_group_id = $awards_group->add_field( array(
    'id'          => $prefix . 'awards_group',
    'type'        => 'group',
    'options'     => array(
        'group_title'   => __( 'Award {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Award', 'cmb2' ),
        'remove_button' => __( 'Remove Award', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $awards_group->add_group_field( $awards_group_id, array(
      'name' => 'Award Name',
      'id'   => 'name',
      'type'     => 'wysiwyg',
      'description' => 'Use editor styling for italics or links',
      'options' => array(
        'media_buttons' => false,
        'textarea_rows' => 1,
        'teeny' => true,
        'wpautop' => false, // use wpautop?
      ),
  ) );

  $awards_group->add_group_field( $awards_group_id, array(
      'name' => 'Source',
      'id'   => 'source',
      'type'     => 'wysiwyg',
      'description' => 'Use editor styling for italics or links',
      'options' => array(
        'media_buttons' => false,
        'textarea_rows' => 1,
        'teeny' => true,
        'wpautop' => false, // use wpautop?
      ),
  ) );

  /**
   * Media Inquiries
   */
  $press_media_inquiries = new_cmb2_box( array(
    'id'            => 'press_media_inquiries_metabox',
    'title'         => __( 'Media Inquiries', 'sage' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'press'),
    'context'       => 'normal',
    'priority'      => 'default',
    'show_names'    => true,
    'description' => 'Contact info for media inquiries',
    )
  );
  $press_media_inquiries -> add_field( array(
      'name' => 'Contact Name',
      'id'   => $prefix.'media_inquiries_name',
      'type' => 'text',
  ) );

  $press_media_inquiries -> add_field( array(
      'name' => 'Contact Title',
      'id'   => $prefix.'media_inquiries_title',
      'type' => 'text',
  ) );

  $press_media_inquiries -> add_field( array(
      'name' => 'Contact Email',
      'id'   => $prefix.'media_inquiries_email',
      'type' => 'text',
  ) );

  $press_media_inquiries -> add_field( array(
      'name' => 'Contact Number',
      'id'   => $prefix.'media_inquiries_number',
      'type' => 'text',
      'description' => 'Seperate with spaces, e.g.: "312 787 4247"',
  ) );

  /**
  * Notable Press
  */
  $notable_press_group = new_cmb2_box( array(
    'id'           => $prefix . 'notable_press_box',
    'title'        => __( 'Notable Press', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'press'),
  ) );

  $notable_press_group_id = $notable_press_group->add_field( array(
    'id'          => $prefix . 'notable_press_group',
    'type'        => 'group',
    'description' => __( '&lt;i&gt;Text surrounded like this will be italic&lt;/i&gt;', 'cmb2' ),
    'options'     => array(
        'group_title'   => __( 'Press Entry {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Press Entry', 'cmb2' ),
        'remove_button' => __( 'Remove Press Entry', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $notable_press_group->add_group_field( $notable_press_group_id, array(
      'name' => 'Name',
      'id'   => 'name',
      'type'     => 'wysiwyg',
      'description' => 'Use editor styling for italics or links',
      'options' => array(
        'media_buttons' => false,
        'textarea_rows' => 1,
        'teeny' => true,
        'wpautop' => false, // use wpautop?
      ),
  ) );

  $notable_press_group->add_group_field( $notable_press_group_id, array(
      'name' => 'Source',
      'id'   => 'source',
      'type'     => 'wysiwyg',
      'description' => 'Use editor styling for italics or links',
      'options' => array(
        'media_buttons' => false,
        'textarea_rows' => 1,
        'teeny' => true,
        'wpautop' => false, // use wpautop?
      ),
  ) );



  /**
   * Additional Sections
   */
  $additional_sections_group = new_cmb2_box( array(
    'id'           => $prefix . 'additional_sections_box',
    'title'        => __( 'Additional Sections', 'cmb2' ),
    'priority'      => 'default',
    'object_types'  => array( 'page', ), // Post type
    'show_on'       => array( 'key' => 'slug', 'value' => 'press'),
  ) );

  $additional_sections_group_id = $additional_sections_group->add_field( array(
    'id'          => $prefix . 'additional_sections_group',
    'type'        => 'group',
    'description' => __( 'Note that you must switch Text mode and refresh to reorder these additional sections', 'cmb2' ),
    'options'     => array(
        'group_title'   => __( 'Section {#}', 'cmb2' ),
        'add_button'    => __( 'Add Another Section', 'cmb2' ),
        'remove_button' => __( 'Remove Section', 'cmb2' ),
        'sortable'      => true, // beta
    ),
  ) );

  $additional_sections_group->add_group_field( $additional_sections_group_id, array(
      'name' => 'Section Title',
      'id'   => 'title',
      'type' => 'text',
  ) );

  $additional_sections_group->add_group_field( $additional_sections_group_id, array(
    'name'     => 'Section Content',
    'id'       => 'content',
    'type'     => 'wysiwyg',
    'desc'     => 'A list or paragraph',
    'options' => array(
      'media_buttons' => false,
    ),
  ) );

}
add_action( 'cmb2_admin_init', __NAMESPACE__ . '\register_metaboxes', 10 );


/**
 * Style press meta-boxes
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

    #_cmb2_awards_box iframe, #_cmb2_notable_press_box iframe {
      height: 48px !important;

    }
  </style>
HTML;
}
add_action('admin_head', __NAMESPACE__ . '\admin_styling');


function get_awards() {

  $awards = get_post_meta(get_the_ID(),'_cmb2_awards_group',true);

  $output = '';
  $output .= '<table class="awards-table leader-table"><tbody>';

  foreach ($awards as $award) :

    // Safely grab repeating group array values
    $name = isset($award['name']) ? $award['name'] : '';
    $source = isset($award['source']) ? $award['source'] : '';

    // Output markup
    $output .= <<<HTML
            <tr class="leader-row">
              <th class="leader-left" scope="row"><div class="leader-text">{$name}</div></th>
              <td class="leader-right"><div class="leader-text">{$source}</div></td>
            </tr>
HTML;

  endforeach;

  $output .= '</tr></tbody></table>';

  return $output;

}

function get_media_inquiries() {

  $name = get_post_meta(get_the_ID(),'_cmb2_media_inquiries_name',true);
  $title = get_post_meta(get_the_ID(),'_cmb2_media_inquiries_title',true);
  $email = get_post_meta(get_the_ID(),'_cmb2_media_inquiries_email',true);
  $number = get_post_meta(get_the_ID(),'_cmb2_media_inquiries_number',true);

  $output = '';

    // Output markup
    $output .= <<<HTML
      <div class="name line">{$name}</div>
      <div class="title line">{$title}</div>
      <div class="email line"><a href="mailto:{$email}" target="_blank">{$email}</a></div>
      <div class="number line">{$number}</div>
HTML;

  return $output;

}

function get_notable_press() {

  $notable_press = get_post_meta(get_the_ID(),'_cmb2_notable_press_group',true);

  $output = '';
  $output .= '<table class="notable_press-table leader-table"><tbody>';

  foreach ($notable_press as $press_entry) :

    // Safely grab repeating group array values
    $name = isset($press_entry['name']) ? $press_entry['name'] : '';
    $source = isset($press_entry['source']) ? $press_entry['source'] : '';

    // Output markup
    $output .= <<<HTML
            <tr class="leader-row">
              <th class="leader-left" scope="row"><div class="leader-text">{$name}</div></th>
              <td class="leader-right"><div class="leader-text">{$source}</div></td>
            </tr>
HTML;

  endforeach;

  $output .= '</tr></tbody></table>';

  return $output;

}


function get_additional_sections() {

  $additional_sections = get_post_meta(get_the_ID(),'_cmb2_additional_sections_group',true);

  $output = '';

  foreach ($additional_sections as $press_entry) :

    // Safely grab repeating group array values
    $title = isset($press_entry['title']) ? $press_entry['title'] : '';
    $content = isset($press_entry['content']) ? apply_filters('the_content',$press_entry['content']) : '';

    // Output markup
    $output .= <<<HTML
      <div class="additional-section">
        <h2>{$title}</h2>
        {$content}
      </div>
HTML;

  endforeach;

  return $output;

}