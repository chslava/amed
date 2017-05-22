<?php

if ( ! function_exists( 'dswp_theme_support' ) ) :
function dswp_theme_support() {
	// Add language support
	// load_theme_textdomain( 'dswp', get_template_directory() . '/languages' );

	// Add menu support
	add_theme_support( 'menus' );

	// Add post thumbnail support: http://codex.wordpress.org/Post_Thumbnails
	add_theme_support( 'post-thumbnails' );
	// set_post_thumbnail_size(150, 150, false);

    add_image_size( 'slide-big', 1440, 650, true ); // (cropped)
	add_image_size( 'brand-logo', 150, 68, true); // (cropped)
	add_image_size( 'partner-logo', 270, 80); // (NOT cropped)
	add_image_size( 'homepage-blog-image', 580, 380, true); // (cropped)
	add_image_size( 'services-images', 380, 260	, true); // (cropped)
	add_image_size( 'side-content-image', 610, 409, true);
	add_image_size( 'service-side-content-image', 460, 580, true);
	add_image_size( 'contact-side-content-image', 413, 620, true);
	add_image_size( 'news-blog-image', 760, 315, true); // added by Eugene
	add_image_size( 'news-gallery-thumb', 220, 150, true); // added by Eugene

	// rss thingy
	// add_theme_support( 'automatic-feed-links' );

	// Add post formarts support: http://codex.wordpress.org/Post_Formats
	// add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );

	// Enable support for HTML5 markup.
	add_theme_support('html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	));

	add_theme_support('title-tag');
}

add_action( 'after_setup_theme', 'dswp_theme_support' );
endif;



/* function image_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop){
    if ( !$crop ) return null; // let the wordpress default function handle this

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}

add_filter('image_resize_dimensions', 'image_crop_dimensions', 10, 6);
*/
?>
