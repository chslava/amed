<?php

function wpdocs_theme_add_editor_styles() {
    add_editor_style( 'editor-style.css');
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );


// Various clean up functions
// Removing some items
 require_once('includes/cleanup.php');

// Enqueue scripts
// what scripts should be imported
 require_once('includes/enqueue-scripts.php');

// Image settings goes here
 require_once('includes/theme-support.php');

//Register options
 require_once('includes/option_pages.php');

// Widgets should be registred here
 require_once('includes/widget-areas.php');

// Menus goes here
 require_once('includes/navigation.php');

 // WPML lang menu
  require_once('includes/wpml-lang-menu.php');

// Menu walker for custom menu structures
 require_once('includes/menu-walker.php');

// Gravity forms split in columns http://stackoverflow.com/questions/26308742/gravity-forms-columns-side-by-side
 require_once('includes/gravity-forms-columns.php');


// Gravity forms split in columns http://stackoverflow.com/questions/26308742/gravity-forms-columns-side-by-side
require_once('includes/reusable_functions.php');


// Add post types
require_once('includes/post_types/partners.php');


function wpdocs_excerpt_more( $more ) {
 return '...';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );



function wpb_mce_buttons_2($buttons) {
 array_unshift($buttons, 'styleselect');
 return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');



/*
* Callback function to filter the MCE settings
*/

function my_mce_before_init_insert_formats( $init_array ) {

// Define the style_formats array

 $style_formats = array(
  /*
  * Each array child is a format with it's own settings
  * Notice that each array has title, block, classes, and wrapper arguments
  * Title is the label which will be visible in Formats menu
  * Block defines whether it is a span, div, selector, or inline style
  * Classes allows you to define CSS classes
  * Wrapper whether or not to add a new block-level element around any selected elements
  */
     array (
         'title' => 'List styles',
         'items' => array(
             array(
                 'title' => 'Circle list',
                 'selector' => 'ul',
                 'classes' => 'circles-list',

             ),
             array(
                 'title' => 'Circle list small',
                 'selector' => 'ul',
                 'classes' => 'small circles-list',
             ),
         )),

     array (
         'title' => 'Headers',
         'items' => array(
             array(
                 'title' => 'h1 decored centred',
                 'selector' => 'h1',
                 'classes' => 'centered decored ui header',
             ),
             array (
                 'title' => 'h1 decored left',
                 'selector' => 'h1',
                 'classes' => 'left decored ui header',
             ),
             array(
                 'title' => 'h2 decored centred',
                 'selector' => 'h2',
                 'classes' => 'centered decored ui header',
             ),
             array (
                 'title' => 'h2 decored left',
                 'selector' => 'h2',
                 'classes' => 'left decored ui header',
             ),
             array(
                 'title' => 'h3 decored centred',
                 'selector' => 'h3',
                 'classes' => 'centered decored ui header',
             ),
             array (
                 'title' => 'h3 decored left',
                 'selector' => 'h3',
                 'classes' => 'left decored ui header',
             ),
         )
     ),
     array (
         'title' => 'Buttons',
         'items' => array(
             array(
                 'title' => 'Basic button',
                 'selector' => 'a',
                 'classes' => 'ui basic button',
             ),
             array(
                 'title' => 'Primary button',
                 'selector' => 'a',
                 'classes' => 'ui primary button',
             )
         )),

 );
 // Insert the array, JSON ENCODED, into 'style_formats'
 $init_array['style_formats'] = json_encode( $style_formats );

 return $init_array;

}

// YOAST REMOVE LINKS
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

function timersys_remove_links($link_output, $link ){
  //print_r($link);
    if( $link['text'] == 'Par mums' ||
        $link['text'] == 'About us' ||
        $link['text'] == 'Jaunumi' ||
        $link['text'] == 'Об A.Medical' ) {
        $link_output = '';
    }
    return $link_output;
}

/**
* @author: Eugene Kudriashov
*/
// Custom pagination for Amedical theme.
if ( !function_exists( 'dswp_amedical_pagination' ) ) :
function dswp_amedical_pagination() {
    global $paged;
    if(empty($paged)) $paged = 1;
    if($pages == '') {
        global $wp_query; 
        $pages = $wp_query->max_num_pages;
        if(!$pages) {
            $pages = 1;
        }
    }
    if(1 != $pages) :
        $prev_link = ($paged <= 1) ? '#' : get_pagenum_link($paged - 1);
        $next_link = ($paged == $pages) ? '#' : get_pagenum_link($paged + 1); ?>
        <div class="pagination-menu">
            <a href="<?php echo $prev_link; ?>" class="pagination-left">
                <div class="icon-left-arrow-icon"></div>
            </a>
            <div class="pagination-items">
            <?php 
                for ($i=1; $i <= $pages; $i++) {
                    echo ($paged == $i) ? '<a class="pagination-item current" href="#">'.$i.'</a>' : '<a class="pagination-item" href="'.get_pagenum_link($i).'">'.$i.'</a>';
                }
            ?>
            </div>  
            <a href="<?php echo $next_link; ?>" class="pagination-right">
                <div class="icon-right-arrow-icon"></div>
            </a>   
        </div>
    <?php endif;
}
endif;