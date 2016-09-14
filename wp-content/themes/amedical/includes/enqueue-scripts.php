<?php

if ( ! function_exists( 'dswp_scripts' ) ) :
	function dswp_scripts() {

	// Enqueue Main Stylesheet
	wp_enqueue_style( 'Main Stylesheet', get_stylesheet_directory_uri() . '/css/style.css' );

    //wp_enqueue_style( 'Fancybox stylesheet', get_stylesheet_directory_uri() . '/js/vendor/fancybox/jquery.fancybox.css' );

	// Deregister the jquery version bundled with wordpress
	//wp_deregister_script( 'jquery' );

	// Modernizr is used for polyfills and feature detection. Must be placed in header. (Not required)
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr/modernizr.js', array(), '2.8.3', false );

	// Fastclick removes the 300ms delay on click events in mobile environments. Must be placed in header. (Not required)
	//wp_register_script( 'fastclick', get_template_directory_uri() . '/js/vendor/fastclick.js', array(), '1.0.0', false );

	wp_register_script( 'html5shiv', get_template_directory_uri() . '/js/vendor/html5shiv/html5shiv.min.js', array(), '5.5.1', false );

	// This adds support for object-fit and object-position to IEdge 9-13, Android 4.4-, Safari (OSX 9.1-, iOS 9.3-) and skips browsers that already support them.
   	wp_register_script( 'object-fit-images', get_template_directory_uri() . '/js/vendor/object-fit-images/ofi.browser.js', array(), '5.5.1', false );

	// Slick slider
	wp_register_script( 'slick-slider', get_template_directory_uri() . '/js/vendor/slick/slick.min.js', array('jquery'), '5.5.1', false );

    //wp_register_script( 'foundation-select', get_template_directory_uri() . '/js/vendor/foundation-select.js', array(), '1.0.0', false );
    
    //wp_register_script( 'google-maps', '//maps.googleapis.com/maps/api/js?sensor=false&language=en', array(), '1.0.0', false );
    
	// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
	//wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js', array(), '2.1.0', false );

	// Self hosted jQuery placed in the footer. (Comment the script above and uncomment the script below if you want to switch).
	//wp_register_script( 'jquery', get_template_directory_uri() . '/js/vendor/jquery.js', array(), '2.1.3', true );

	// If you'd like to cherry-pick the foundation components you need in your project, head over to Gruntfile.js and see lines 67-88
	// It's a good idea to do this, performance-wise. No need to load everything if you're just going to use the grid anyway, you know :)
    //wp_register_script('map-params',get_template_directory_uri() . '/js/custom/map_params.js', array('google-maps'), '', true );
	wp_register_script( 'foundation', get_template_directory_uri() . '/js/vendor/foundation/foundation.min.js', array('jquery'), '5.5.1', true );
    
    //wp_register_script( 'equlizer', get_template_directory_uri() . '/js/foundation-equlizer.js', array('jquery'), '5.5.1', true );
    //wp_register_script( 'fancybox', get_template_directory_uri() . '/js/vendor/fancybox/jquery.fancybox.js', array('jquery'), '1.5.1', true );
    
    //wp_register_script( 'owl-carousel', get_template_directory_uri() . '/js/vendor/owl.carousel.min.js', array(), '5.5.1', true );
    //wp_register_script( 'datepicker', get_template_directory_uri() . '/js/vendor/datepicker.js', array(), '1.4.0', true );
    //wp_register_script( 'map', get_template_directory_uri() . '/js/custom/map.js', array(), '5.5.1', true );
    //wp_register_script( 'stacktable', get_template_directory_uri() . '/js/vendor/stacktable.js', array(), '1.0', true );
    wp_register_script( 'main', get_template_directory_uri() . '/js/custom/main.js', array('jquery'), '5.5.1', true );

    
    
    
	// Enqueue all registered scripts
	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'html5shiv' );
	wp_enqueue_script( 'foundation' );
   //wp_enqueue_script( 'fancybox' );
   //wp_enqueue_script( 'google-maps' );
   //wp_enqueue_script( 'map-params' );
   //wp_enqueue_script( 'map' );
   wp_enqueue_script( 'object-fit-images' );
   wp_enqueue_script( 'slick-slider' );
   wp_enqueue_script( 'main' );
    

	}

	add_action( 'wp_enqueue_scripts', 'dswp_scripts' );
    
    

endif;

?>
