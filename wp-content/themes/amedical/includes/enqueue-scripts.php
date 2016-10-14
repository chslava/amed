<?php


define("__STYLE_CSS_VERSION__",filemtime(get_stylesheet_directory() . '/css/style.css'));
define("__MAIN_JS_VERSION__",filemtime(get_stylesheet_directory() . '/js/main.js'));
define("__GA_JS_VERSION__",filemtime(get_stylesheet_directory() . '/js/ga.js'));


if ( ! function_exists( 'dswp_scripts' ) ) :
	function dswp_scripts() {

  //wp_deregister_script('jquery');
	// Enqueue Main Stylesheet
	wp_enqueue_style( 'Main Stylesheet', get_stylesheet_directory_uri() . '/ui/semantic.css' );
	wp_enqueue_style( 'Icon Stylesheet', '//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.4/components/icon.min.css' );
	wp_enqueue_style( 'Bxslider Stylesheet', get_stylesheet_directory_uri() . '/css/jquery.bxslider.css' );
	wp_enqueue_style( 'Custom Stylesheet', get_stylesheet_directory_uri() . '/css/style.css?v='.__STYLE_CSS_VERSION__,__STYLE_CSS_VERSION__ );

	//wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-2.2.4.min.js',array(), '2.2.4', true )
	wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js',array(), '', true);
	wp_register_script( 'ga', get_template_directory_uri() . '/js/ga.js?v='.__GA_JS_VERSION__, array('semantic'), __GA_JS_VERSION__, true );
	wp_register_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'), '1.5.1', true );
	wp_register_script( 'semantic', get_template_directory_uri() . '/ui/semantic.min.js', array('jquery','bxslider'), '1.5.1', true );
	wp_register_script( 'main', get_template_directory_uri() . '/js/main.js?v='.__MAIN_JS_VERSION__, array('jquery','bxslider','semantic'), __MAIN_JS_VERSION__, true );

	//wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bxslider' );
	wp_enqueue_script( 'semantic' );
	wp_enqueue_script( 'ga' );
	wp_enqueue_script( 'main' );


	}

	add_action( 'wp_enqueue_scripts', 'dswp_scripts' );

endif;

?>
