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
			$menuParameters = array(
			  'container'       => false,
			  'echo'            => false,
				'theme_location' 	=> 'top-m',
			  'items_wrap'      => '%3$s',
			  'depth'           => 0,
				'walker' 					=> new Top_Menu_Walker()
			);
			echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
	}
}

/**
 * Topbar main menu
 */
if ( ! function_exists( 'main_menu' ) ) {
	function main_menu() {
			$menuParameters = array(
				'container'       => false,
				'echo'            => false,
				'theme_location' 	=> 'main-m',
				'items_wrap'      => '%3$s',
				'depth'           => 0,
				'walker' 					=> new Main_Menu_Walker()
			);
		  echo strip_tags(wp_nav_menu( $menuParameters ), '<a><i><div>' );
	}
}


/**
 * Footer main menu
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'footer_menu' ) ) {
	function footer_menu() {

		$menuParameters = array(
			'container'       => false,
			'echo'            => false,
			'theme_location' 	=> 'footer-m',
			'items_wrap'      => '%3$s',
			'depth'           => 0,
			'walker' 					=> new Footer_Menu_Walker()
		);
		echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );

	}
}



?>
