<?php


add_action( 'init', 'create_partners' );

function create_partners() {

  $slug = $id ="partner";

  $labels  = get_labels_for_custom_post_type('partner','partners');
  $award_args = array(
    'labels' => $labels,
    'public' => false,
    'publicly_queryable' => true,
    'exclude_from_search' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'hierarchical' => false,
    'rewrite' => array('slug' => $slug),
    'has_archive' => false,
    'menu_position' => 7,
    'menu_icon' => 'dashicons-businessman',
    //'menu_icon' => get_template_directory_uri().'/assets/img/admin-icons/'.$id.'-white.png',
    'supports' => array('title','thumbnail'),
  );
  register_post_type($id,$award_args);

}

/* Customizing the messages: */

function codex_partners_updated_messages( $messages ) {
global $post, $post_ID;


  $messages['partner']=get_labels_for_messages('partner','partners',$post_ID);

}

add_filter( 'post_updated_messages', 'codex_partners_updated_messages' );

?>
