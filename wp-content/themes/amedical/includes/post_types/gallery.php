<?php


add_action( 'init', 'create_gallery' );

function create_gallery() {
  $labels = array(
    'name' => _x('Galleries', 'post type general name', 'dswp'),
    'singular_name' => _x('Gallery', 'post type singular name', 'dswp'),
    'add_new' => _x('Add New gallery ', 'gallery ', 'dswp'),
    'add_new_item' => __('Add New gallery ', 'dswp'),
    'edit_item' => __('Edit gallery ', 'dswp'),
    'new_item' => __('New gallery ', 'dswp'),
    'all_items' => __('All galleries', 'dswp'),
    'view_item' => __('View gallery', 'dswp'),
    'search_items' => __('Search gallery ', 'dswp'),
    'not_found' =>  __('No gallery found', 'dswp'),
    'not_found_in_trash' => __('No gallery found in Trash', 'dswp'),
    'parent_item_colon' => '',
    'menu_name' => __('Galleries', 'dswp')
  );
  
  $gallery_args = array(
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true, 
  'show_in_menu' => true, 
  'query_var' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  //'rewrite' => false,
  'rewrite' => array('slug' => 'hotel/gallery'),
  'has_archive' => false, 
  'menu_position' => 7,
  'menu_icon' => get_template_directory_uri().'/assets/img/admin-icons/gallery-white.png',
  'supports' => array('author','title','editor','custom-fields' , 'thumbnail', 'revisions'),
  'taxonomies' => array('gallery_category') 
);
register_post_type('gallery',$gallery_args);
}

/* Customizing the messages: */

function codex_gallery_updated_messages( $messages ) {
global $post, $post_ID;

$messages['gallery'] = array(
  0 => '', // Unused. Messages start at index 1.
  1 => sprintf( __('gallery updated. <a href="%s">View gallery</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  2 => __('Custom field updated.', 'dswp'),
  3 => __('Custom field deleted.', 'dswp'),
  4 => __('gallery updated.', 'dswp'),
  /* translators: %s: date and time of the revision */
  5 => isset($_GET['revision']) ? sprintf( __('gallery restored to revision from %s', 'dswp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
  6 => sprintf( __('gallery published. <a href="%s">View gallery</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  7 => __('gallery saved.', 'dswp'),
  8 => sprintf( __('gallery submitted. <a target="_blank" href="%s">Preview gallery</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  9 => sprintf( __('gallery scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview gallery</a>', 'dswp'),
  // translators: Publish box date format, see http://php.net/date
  date_i18n( __( 'M j, Y @ G:i', 'dswp' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
  10 => sprintf( __('gallery draft updated. <a target="_blank" href="%s">Preview gallery</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);

return $messages;
}



function gallery_taxonomy()
{  
    register_taxonomy(  
        'gallery_category',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
        'gallery',            //post type name
        array(  
            'hierarchical' => true,  
            'label' => 'Gallery category',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'hotel/gallery', // This controls the base slug that will display before each term
                'with_front' => true // display the category base before 
            )
        )  
    );  
}  
add_action( 'init', 'gallery_taxonomy');

?>