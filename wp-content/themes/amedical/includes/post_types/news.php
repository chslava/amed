<?php


add_action( 'init', 'create_news' );

function create_news() {
  $labels = array(
    'name' => _x('News', 'post type general name', 'dswp'),
    'singular_name' => _x('News', 'post type singular name', 'dswp'),
    'add_new' => _x('Add New news ', 'news ', 'dswp'),
    'add_new_item' => __('Add New news ', 'dswp'),
    'edit_item' => __('Edit news ', 'dswp'),
    'new_item' => __('New news ', 'dswp'),
    'all_items' => __('All news', 'dswp'),
    'view_item' => __('View news', 'dswp'),
    'search_items' => __('Search news ', 'dswp'),
    'not_found' =>  __('No news found', 'dswp'),
    'not_found_in_trash' => __('No news found in Trash', 'dswp'),
    'parent_item_colon' => '',
    'menu_name' => __('News', 'dswp')
  );
  
  $news_args = array(
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true, 
  'show_in_menu' => true, 
  'query_var' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  //'rewrite' => false,
  'rewrite' => array('slug' => 'hotel/news'),
  'has_archive' => false, 
  'menu_position' => 7,
  'menu_icon' => get_template_directory_uri().'/assets/img/admin-icons/news-white.png',
  'supports' => array('author','title','editor','custom-fields' , 'thumbnail', 'revisions'),
  'taxonomies' => array('news_category') 
);
register_post_type('post',$news_args);
}

/* Customizing the messages: */

function codex_news_updated_messages( $messages ) {
global $post, $post_ID;

$messages['news'] = array(
  0 => '', // Unused. Messages start at index 1.
  1 => sprintf( __('news updated. <a href="%s">View news</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  2 => __('Custom field updated.', 'dswp'),
  3 => __('Custom field deleted.', 'dswp'),
  4 => __('news updated.', 'dswp'),
  /* translators: %s: date and time of the revision */
  5 => isset($_GET['revision']) ? sprintf( __('news restored to revision from %s', 'dswp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
  6 => sprintf( __('news published. <a href="%s">View news</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  7 => __('news saved.', 'dswp'),
  8 => sprintf( __('news submitted. <a target="_blank" href="%s">Preview news</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  9 => sprintf( __('news scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview news</a>', 'dswp'),
  // translators: Publish box date format, see http://php.net/date
  date_i18n( __( 'M j, Y @ G:i', 'dswp' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
  10 => sprintf( __('news draft updated. <a target="_blank" href="%s">Preview news</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);

return $messages;
}



?>