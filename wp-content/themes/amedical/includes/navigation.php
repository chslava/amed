<?php

/**
 * Register Menus
 * http://codex.wordpress.org/Function_Reference/register_nav_menus#Examples
 */
register_nav_menus(array(
	'top-m' => 'Header top menu',
	'main-m' => 'Header main menu',
	'footer-m' => 'Footer main menu',
));

/**
 * Topbar menu left
 */
if ( ! function_exists( 'top_menu' ) ) {
	function top_menu() {
	    wp_nav_menu(array(
	        'container' => false,                           // remove nav container
	        'container_class' => 'is-dropdown-submenu-parent opens-right',   // class of container
	        'menu' => '',                                   // menu name
	        'menu_class' => '',           									// adding custom nav class
	        'theme_location' => 'top-m',                // where it's located in the theme
	        'before' => '',                                 // before each link <a>
	        'after' => '',                                  // after each link </a>
	        'link_before' => '',                            // before each link text
	        'link_after' => '',                             // after each link text
					'items_wrap' => '<ul data-dropdown-menu="ddzc8q-dropdown-menu" id="%1$s" class="menu dropdown %2$s">%3$s</ul>',
	        'depth' => 5,                                   // limit the depth of the nav
	        'fallback_cb' => false,                         // fallback function (see below)
	        'walker' => new Top_Menu_Walker()
	    ));
	}
}

/**
 * Topbar main menu
 */
if ( ! function_exists( 'main_menu' ) ) {
	function main_menu() {
	    wp_nav_menu(array(
	        'container' => false,                           // remove nav container
	        'container_class' => '',                        // class of container
	        'menu' => '',                                   // menu name
	        'menu_class' => 'main-m main',           // adding custom nav class
	        'theme_location' => 'top-bar-m',                // where it's located in the theme
	        'before' => '',                                 // before each link <a>
	        'after' => '',                                  // after each link </a>
	        'link_before' => '',                            // before each link text
	        'link_after' => '',                             // after each link text
	        'depth' => 5,                                   // limit the depth of the nav
	        'fallback_cb' => false,                         // fallback function (see below)
	        'walker' => new Main_Menu_Walker()
	    ));
	}
}


/**
 * Footer main menu
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'footer_menu' ) ) {
	function footer_menu() {
	    wp_nav_menu(array(
	        'container' => false,                           // remove nav container
	        'container_class' => '',                        // class of container
	        'menu' => '',                                   // menu name
	        'menu_class' => 'two-columns',            		  // adding custom nav class
	        'theme_location' => 'footer-m',                // where it's located in the theme
	        'before' => '',                                 // before each link <a>
	        'after' => '',                                  // after each link </a>
	        'link_before' => '',                            // before each link text
	        'link_after' => '',                             // after each link text
	        'depth' => 5,                                   // limit the depth of the nav
	        'fallback_cb' => false,                         // fallback function (see below)
	        'walker' => new Footer_Menu_Walker()
	    ));
	}
}



?>
