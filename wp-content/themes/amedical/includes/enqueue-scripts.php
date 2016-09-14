<?php

if ( ! function_exists( 'dswp_scripts' ) ) :
	function dswp_scripts() {

	// Enqueue Main Stylesheet
	wp_enqueue_style( 'Main Stylesheet', get_stylesheet_directory_uri() . '/ui/semantic.css' );
	/*wp_register_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr/modernizr.js', array(), '2.8.3', false );
	wp_register_script( 'html5shiv', get_template_directory_uri() . '/js/vendor/html5shiv/html5shiv.min.js', array(), '5.5.1', false );
	wp_register_script( 'object-fit-images', get_template_directory_uri() . '/js/vendor/object-fit-images/ofi.browser.js', array(), '5.5.1', false );
	wp_register_script( 'slick-slider', get_template_directory_uri() . '/js/vendor/slick/slick.min.js', array('jquery'), '5.5.1', false );
	wp_register_script( 'foundation', get_template_directory_uri() . '/js/vendor/foundation/foundation.min.js', array('jquery'), '5.5.1', true );
	wp_register_script( 'main', get_template_directory_uri() . '/js/custom/main.js', array('jquery'), '5.5.1', true );
*/
	// Enqueue all registered scripts
/*	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'html5shiv' );
	wp_enqueue_script( 'foundation' );
	wp_enqueue_script( 'object-fit-images' );
	wp_enqueue_script( 'slick-slider' );
	wp_enqueue_script( 'main' );*/


	}

	add_action( 'wp_enqueue_scripts', 'dswp_scripts' );



endif;

?>
