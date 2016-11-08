<?php


add_action( 'init', 'create_slider' );

function create_slider() {
  $labels = array(
    'name' => _x('Sliders', 'post type general name', 'dswp'),
    'singular_name' => _x('Slider', 'post type singular name', 'dswp'),
    'add_new' => _x('Add New slider ', 'slider ', 'dswp'),
    'add_new_item' => __('Add New slider ', 'dswp'),
    'edit_item' => __('Edit slider ', 'dswp'),
    'new_item' => __('New slider ', 'dswp'),
    'all_items' => __('All sliders', 'dswp'),
    'view_item' => __('View slider', 'dswp'),
    'search_items' => __('Search sliders ', 'dswp'),
    'not_found' =>  __('No sliders found', 'dswp'),
    'not_found_in_trash' => __('No sliders found in Trash', 'dswp'),
    'parent_item_colon' => '',
    'menu_name' => __('Sliders', 'dswp')
  );

  $slider_args = array(
  'labels' => $labels,
  'public' => false,
  'publicly_queryable' => true,
  'show_ui' => true,
  'show_in_menu' => true,
  'query_var' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  'rewrite' => false,
  'has_archive' => false,
  'menu_position' => 7,
  'menu_icon' => 'dashicons-slides', //https://developer.wordpress.org/resource/dashicons/
  'supports' => array('author','title','editor', 'revisions','thumbnail'),
);
register_post_type('slider',$slider_args);
}


function slider_taxonomy() {
    register_taxonomy(
        'slider_category',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'slider',        //post type name
        array(
            'hierarchical' => false,
            'label' => 'Slider category',  //Display name
            'query_var' => true,
            'rewrite' => false
        )
    );
}
add_action( 'init', 'slider_taxonomy');


?>
