<?php


add_action( 'init', 'create_events' );

function create_events() {
  $labels = array(
    'name' => _x('Events', 'post type general name', 'dswp'),
    'singular_name' => _x('Event', 'post type singular name', 'dswp'),
    'add_new' => _x('Add New event ', 'event ', 'dswp'),
    'add_new_item' => __('Add New event ', 'dswp'),
    'edit_item' => __('Edit event ', 'dswp'),
    'new_item' => __('New event ', 'dswp'),
    'all_items' => __('All events', 'dswp'),
    'view_item' => __('View event', 'dswp'),
    'search_items' => __('Search event ', 'dswp'),
    'not_found' =>  __('No event found', 'dswp'),
    'not_found_in_trash' => __('No event found in Trash', 'dswp'),
    'parent_item_colon' => '',
    'menu_name' => __('Events', 'dswp')
  );

  $event_args = array(
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'query_var' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  //'rewrite' => false,
  'rewrite' => array('slug' => 'events'),
  'has_archive' => false,
  'menu_position' => 7,
  'menu_icon' => get_template_directory_uri().'/assets/img/admin-icons/events-white.png',
  'supports' => array('author','title','editor','custom-fields' , 'thumbnail', 'revisions')
);
register_post_type('event',$event_args);
}

/* Customizing the messages: */

function codex_events_updated_messages( $messages ) {
global $post, $post_ID;

$messages['event'] = array(
  0 => '', // Unused. Messages start at index 1.
  1 => sprintf( __('event updated. <a href="%s">View event</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  2 => __('Custom field updated.', 'dswp'),
  3 => __('Custom field deleted.', 'dswp'),
  4 => __('event updated.', 'dswp'),
  /* translators: %s: date and time of the revision */
  5 => isset($_GET['revision']) ? sprintf( __('event restored to revision from %s', 'dswp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
  6 => sprintf( __('event published. <a href="%s">View event</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  7 => __('event saved.', 'dswp'),
  8 => sprintf( __('event submitted. <a target="_blank" href="%s">Preview event</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  9 => sprintf( __('event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', 'dswp'),
  // translators: Publish box date format, see http://php.net/date
  date_i18n( __( 'M j, Y @ G:i', 'dswp' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
  10 => sprintf( __('event draft updated. <a target="_blank" href="%s">Preview event</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);

return $messages;
}





?>
