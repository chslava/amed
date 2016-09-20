<?Php

// reusable functions comes here
// here we put functions which could be reused again in other project
// not specific to current theme

function base_url() {
    // current blog base url
    global $blog_id;
    return get_site_url($blog_id);
}

function base_url_lang() {
    //retrieve current language base url
    global $sitepress;
    if ($sitepress->get_default_language() == ICL_LANGUAGE_CODE) {
        //do something
        return base_url();
    } else {
        return base_url() . "/" . ICL_LANGUAGE_CODE;
    }
}

function print_menu($location, $menu_class, $depth = 0, $level = 0, $menu_id = "") {
    // most common parameters for getting the menu printout
    // if theme has several menus this code is recopied in several places
    // thats why its taken out in function
    $defaults = array(
        'theme_location' => $location,
        'menu' => '',
        'container' => '',
        'container_class' => '',
        'container_id' => '',
        'menu_class' => $menu_class,
        'menu_id' => $menu_id,
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth' => $depth,
        'walker' => new Foundationpress_Top_Bar_Walker()
    );

    wp_nav_menu($defaults);
}

function get_labels_for_custom_post_type($singular_label, $multiple_label) {
    //if there is lot of post types then this code is used several times
    // moved out to function with parameters

    $labels = array(
        'name' => _x(ucfirst($multiple_label), 'post type general name', 'vetfocus'),
        'singular_name' => _x(ucfirst($singular_label), 'post type singular name', 'vetfocus'),
        'add_new' => _x("Add new $singular_label", 'customer quote', 'vetfocus'),
        'add_new_item' => __("Add new $singular_label", 'vetfocus'),
        'edit_item' => __("Edit $singular_label", 'vetfocus'),
        'new_item' => __("New $singular_label", 'vetfocus'),
        'all_items' => __("All $multiple_label", 'vetfocus'),
        'view_item' => __("View $singular_label", 'vetfocus'),
        'search_items' => __("Search $multiple_label", 'vetfocus'),
        'not_found' => __("No $multiple_label found", 'vetfocus'),
        'not_found_in_trash' => __("No $multiple_label found in Trash", 'vetfocus'),
        'parent_item_colon' => '',
        'menu_name' => __(ucfirst($multiple_label), 'vetfocus')
    );
    return $labels;
}

function get_labels_for_messages($singular_label,$multiple_label, $post_ID){


    return array(

        0 => '', // Unused. Messages start at index 1.
        1 => sprintf( __(ucfirst($singular_label).' updated. <a href="%s">View '.$singular_label.'</a>', 'dswp'), esc_url( get_permalink($post_ID))),
        2 => __('Custom field updated.', 'dswp'),
        3 => __('Custom field deleted.', 'dswp'),
        4 => __(ucfirst($singular_label).' updated.', 'dswp'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf( __(ucfirst($singular_label).' restored to revision from %s', 'dswp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __(ucfirst($singular_label).' published. <a href="%s">View '.$singular_label.'</a>', 'dswp'), esc_url( get_permalink($post_ID) ) ),
        7 => __(ucfirst($singular_label).' saved.', 'dswp'),
        8 => sprintf(
            __(ucfirst($singular_label).' submitted. <a target="_blank" href="%s">Preview '.$singular_label.'</a>', 'dswp'),
            esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) )
        ),
        9 => sprintf(
            __(ucfirst($singular_label).' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview '.$singular_label.'</a>', 'dswp'),
            date_i18n(
                __( 'M j, Y @ G:i', 'dswp'), strtotime( get_the_date($post_ID))
            ),
            esc_url( get_permalink($post_ID))
        ),
        10 => sprintf( __(ucfirst($singular_label).' draft updated. <a target="_blank" href="%s">Preview '.$singular_label.'</a>', 'dswp'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),

    );
}

function get_args_for_custom_post_type($slug, $labels) {
    //seting up moust commong args for the custom post type
    //if there is several post types this part is redudant most of the time
    //so moved out in function
    $args = array(
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
        'menu_icon' => get_template_directory_uri() . "/assets/img/admin-icons/$slug-white.png",
        'supports' => array('author', 'title', 'editor', 'custom-fields', 'thumbnail', 'page-attributes', 'revisions'),
    );

    return $args;
}

if (!function_exists("icl_object_id")) {

    //TODO have to test this function, not sure if its works correctly...
    // just added this that if 
    function icl_object_id($object_id, $type) {
        return apply_filters('wpml_object_id', intval($object_id), $type);
    }

}
