<?php


add_action( 'init', 'create_awards' );

function create_awards() {
  $labels = array(
    'name' => _x('Awards', 'post type general name', 'dswp'),
    'singular_name' => _x('Award', 'post type singular name', 'dswp'),
    'add_new' => _x('Add New award ', 'award ', 'dswp'),
    'add_new_item' => __('Add New award ', 'dswp'),
    'edit_item' => __('Edit award ', 'dswp'),
    'new_item' => __('New award ', 'dswp'),
    'all_items' => __('All awards', 'dswp'),
    'view_item' => __('View award', 'dswp'),
    'search_items' => __('Search award ', 'dswp'),
    'not_found' =>  __('No award found', 'dswp'),
    'not_found_in_trash' => __('No award found in Trash', 'dswp'),
    'parent_item_colon' => '',
    'menu_name' => __('Awards', 'dswp')
  );

  $award_args = array(
  'labels' => $labels,
  'public' => false,
  'publicly_queryable' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'query_var' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  'rewrite' => array('slug' => 'award'),
  'has_archive' => false,
  'menu_position' => 7,
  'menu_icon' => get_template_directory_uri().'/assets/img/admin-icons/award-white.png',
  'supports' => array('author','title','editor','custom-fields' , 'thumbnail', 'page-attributes','revisions'),
);
register_post_type('award',$award_args);
}

/* Customizing the messages: */

function codex_awards_updated_messages( $messages ) {
global $post, $post_ID;

$messages['award'] = array(
  0 => '', // Unused. Messages start at index 1.
  1 => sprintf( __('Award updated. <a href="%s">View award</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  2 => __('Custom field updated.', 'dswp'),
  3 => __('Custom field deleted.', 'dswp'),
  4 => __('award updated.', 'dswp'),
  /* translators: %s: date and time of the revision */
  5 => isset($_GET['revision']) ? sprintf( __('Award restored to revision from %s', 'dswp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
  6 => sprintf( __('Award published. <a href="%s">View award</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  7 => __('Award saved.', 'dswp'),
  8 => sprintf( __('Award submitted. <a target="_blank" href="%s">Preview award</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  9 => sprintf( __('Award scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview award</a>', 'dswp'),
  // translators: Publish box date format, see http://php.net/date
  date_i18n( __( 'M j, Y @ G:i', 'dswp' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
  10 => sprintf( __('Award draft updated. <a target="_blank" href="%s">Preview award</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);

return $messages;
}

?>
