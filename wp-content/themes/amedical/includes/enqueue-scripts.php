<?php

if ( ! function_exists( 'dswp_scripts' ) ) :
	function dswp_scripts() {

	// Enqueue Main Stylesheet
	wp_enqueue_style( 'Main Stylesheet', get_stylesheet_directory_uri() . '/ui/semantic.css' );
	wp_enqueue_style( 'Icon Stylesheet', '//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.4/components/icon.min.css' );
	wp_enqueue_style( 'Bxslider Stylesheet', get_stylesheet_directory_uri() . '/css/jquery.bxslider.css' );

		wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-2.2.4.min.js',array(), '2.2.4', true );
	wp_register_script( 'semantic', get_template_directory_uri() . '/ui/semantic.min.js', array('jquery'), '1.5.1', true );
	wp_register_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'), '1.5.1', true );
	wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array('jquery','semantic','bxslider'), '1.5.1', true );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'semantic' );
	wp_enqueue_script( 'bxslider' );
	wp_enqueue_script( 'main' );


	}

	add_action( 'wp_enqueue_scripts', 'dswp_scripts' );

endif;

?>
