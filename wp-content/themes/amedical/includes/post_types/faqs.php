<?php


add_action( 'init', 'create_faq' );

function create_faq() {
  $labels = array(
    'name' => _x('Faqs', 'post type general name', 'dswp'),
    'singular_name' => _x('Faq', 'post type singular name', 'dswp'),
    'add_new' => _x('Add New faq ', 'faqs ', 'dswp'),
    'add_new_item' => __('Add New faq ', 'dswp'),
    'edit_item' => __('Edit faq ', 'dswp'),
    'new_item' => __('New faq ', 'dswp'),
    'all_items' => __('All faqs', 'dswp'),
    'view_item' => __('View faq', 'dswp'),
    'search_items' => __('Search faqs ', 'dswp'),
    'not_found' =>  __('No faqs found', 'dswp'),
    'not_found_in_trash' => __('No faqs found in Trash', 'dswp'),
    'parent_item_colon' => '',
    'menu_name' => __('Faqs', 'dswp')
  );
  
  $faqs_args = array(
  'labels' => $labels,
  'public' => true,
  'publicly_queryable' => true,
  'show_ui' => true, 
  'show_in_menu' => true, 
  'query_var' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  //'rewrite' => false,
  'rewrite' => array('slug' => 'faq'),
  'has_archive' => false, 
  'menu_position' => 7,
  'menu_icon' => get_template_directory_uri().'/assets/img/admin-icons/faq-white.png',
  'supports' => array('author','title','editor', 'revisions'),
);
register_post_type('faqs',$faqs_args);
}

/* Customizing the messages: */

function codex_faqs_updated_messages( $messages ) {
global $post, $post_ID;

$messages['faqs'] = array(
  0 => '', // Unused. Messages start at index 1.
  1 => sprintf( __('faqs updated. <a href="%s">View faqs</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  2 => __('Custom field updated.', 'dswp'),
  3 => __('Custom field deleted.', 'dswp'),
  4 => __('faqs updated.', 'dswp'),
  /* translators: %s: date and time of the revision */
  5 => isset($_GET['revision']) ? sprintf( __('faqs restored to revision from %s', 'dswp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
  6 => sprintf( __('faqs published. <a href="%s">View faqs</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
  7 => __('faqs saved.', 'dswp'),
  8 => sprintf( __('faqs submitted. <a target="_blank" href="%s">Preview faqs</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  9 => sprintf( __('faqs scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview faqs</a>', 'dswp'),
  // translators: Publish box date format, see http://php.net/date
  date_i18n( __( 'M j, Y @ G:i', 'dswp' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
  10 => sprintf( __('faqs draft updated. <a target="_blank" href="%s">Preview faqs</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
);

return $messages;
}


function faq_taxonomy() {  
    register_taxonomy(  
        'faq_category',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces). 
        'faqs',        //post type name
        array(  
            'hierarchical' => true,  
            'label' => 'Faq category',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'hierarchical' => true,
                'slug' => 'faqs', 
                'with_front' => true 
            )
        )  
    );  
}  
add_action( 'init', 'faq_taxonomy');


?>