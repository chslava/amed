<?php

/**
 * Start cleanup functions
 * ----------------------------------------------------------------------------
 */



if ( ! function_exists( 'dswp_start_cleanup' ) ) :
function dswp_start_cleanup() {

	// launching operation cleanup
	add_action( 'init', 'dswp_cleanup_head' );

	// remove WP version from RSS
	add_filter( 'the_generator', 'dswp_remove_rss_version' );

	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'dswp_remove_wp_widget_recent_comments_style', 1 );

	// clean up comment styles in the head
	add_action( 'wp_head', 'dswp_remove_recent_comments_style', 1 );

	// clean up gallery output in wp
	add_filter( 'dswp_gallery_style', 'dswp_gallery_style' );

	// additional post related cleaning
	add_filter( 'get_dswp_image_tag_class', 'dswp_image_tag_class', 0, 4 );
	add_filter( 'get_image_tag', 'dswp_image_editor', 0, 4 );

}
add_action( 'after_setup_theme','dswp_start_cleanup' );
endif;
/**
 * Clean up head
 * ----------------------------------------------------------------------------
 */

if ( ! function_exists( 'dswp_cleanup_head' ) ) :
function dswp_cleanup_head() {

	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );

	// Category feed links
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// Post and comment feed links
	remove_action( 'wp_head', 'feed_links', 2 );

	// Windows Live Writer
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Index link
	remove_action( 'wp_head', 'index_rel_link' );

	// Previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

	// Start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

	// Canonical
  //remove_action( 'wp_head', 'rel_canonical', 10, 0 );

	// Shortlink
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

	// Links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	// WP version
	remove_action( 'wp_head', 'wp_generator' );

	// Remove WP version from css
	add_filter( 'style_loader_src', 'dswp_remove_wp_ver_css_js', 9999 );

	// Remove WP version from scripts
	add_filter( 'script_loader_src', 'dswp_remove_wp_ver_css_js', 9999 );

	// Prevent unneccecary info from being displayed
	add_filter( 'login_errors',create_function( '$a', 'return null;' ) );

}
endif;

// remove WP version from RSS
if ( ! function_exists( 'dswp_remove_rss_version' ) ) :
function dswp_remove_rss_version() { return ''; }
endif;

if ( ! function_exists( 'dswp_remove_wp_ver_css_js' ) ) :
// remove WP version from scripts
function dswp_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src ); }
	return $src;
}
endif;

// remove injected CSS for recent comments widget
if ( ! function_exists( 'dswp_remove_wp_widget_recent_comments_style' ) ) :
function dswp_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
	  remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}
endif;

// remove injected CSS from recent comments widget
if ( ! function_exists( 'dswp_remove_recent_comments_style' ) ) :
function dswp_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ) {
	remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}
endif;

// remove injected CSS from gallery
if ( ! function_exists( 'dswp_gallery_style' ) ) :
function dswp_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}
endif;

/**
 * Clean up image tags
 * ----------------------------------------------------------------------------
 */


// Remove default inline style of wp-caption


if ( ! function_exists( 'dswp_fixed_img_caption_shortcode' ) ) :
add_shortcode( 'wp_caption', 'dswp_fixed_img_caption_shortcode' );
add_shortcode( 'caption', 'dswp_fixed_img_caption_shortcode' );
function dswp_fixed_img_caption_shortcode($attr, $content = null) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( '' != $output ) {
		return $output; }
	extract(shortcode_atts(array(
		'id'    => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => '',
		'class'   => '',
	), $attr));
	if ( 1 > (int) $width || empty($caption) ) {
		return $content; }

	$markup = '<figure';
	if ( $id ) { $markup .= ' id="' . esc_attr( $id ) . '"'; }
	if ( $class ) { $markup .= ' class="' . esc_attr( $class ) . '"'; }
	$markup .= '>';
	$markup .= do_shortcode( $content ) . '<figcaption>' . $caption . '</figcaption></figure>';
	return $markup;
}
endif;


// Wrap images with figure tag - Credit: Robert O'Rourke - http://bit.ly/1q0WHFs
/*
if ( ! function_exists( 'img_unauto' ) ) :
function img_unautop($pee) {
	$pee = preg_replace( '/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee );
	return $pee;
}
*/



// Remove unused Visual composer elements
if (function_exists( 'vc_remove_element' )):
vc_remove_element( "vc_text_separator" );
vc_remove_element( "vc_message" );
vc_remove_element( "vc_facebook" );
vc_remove_element( "vc_tweetmeme" );
vc_remove_element( "vc_googleplus" );
vc_remove_element( "vc_pinterest" );
vc_remove_element( "vc_toggle" );
vc_remove_element( "vc_single_image" );
vc_remove_element( "vc_images_carousel" );
vc_remove_element( "vc_tabs" );
vc_remove_element( "vc_tour" );
vc_remove_element( "vc_accordion" );
vc_remove_element( "vc_posts_slider" );
vc_remove_element( "vc_widget_sidebar" );
vc_remove_element( "vc_gmaps" );
vc_remove_element( "vc_raw_html" );
vc_remove_element( "vc_raw_js" );
vc_remove_element( "vc_flickr" );
vc_remove_element( "vc_progress_bar" );
vc_remove_element( "vc_pie" );
vc_remove_element( "vc_empty_space" );
vc_remove_element( "vc_custom_heading" );
vc_remove_element( "vc_basic_grid" );
vc_remove_element( "vc_media_grid" );
vc_remove_element( "vc_masonry_media_grid" );
vc_remove_element( "vc_icon" );
vc_remove_element( "woocommerce_cart" );
vc_remove_element( "woocommerce_checkout" );
vc_remove_element( "woocommerce_order_tracking" );
vc_remove_element( "woocommerce_my_account" );
vc_remove_element( "recent_products" );
vc_remove_element( "featured_products" );
vc_remove_element( "product" );
vc_remove_element( "products" );
vc_remove_element( "add_to_cart" );
vc_remove_element( "add_to_cart_url" );
vc_remove_element( "product_page" );
vc_remove_element( "product_category" );
vc_remove_element( "product_categories" );
vc_remove_element( "sale_products" );
vc_remove_element( "best_selling_products" );
vc_remove_element( "top_rated_products" );
vc_remove_element( "product_attribute" );
vc_remove_element( "vc_wp_text" );
vc_remove_element( "vc_wp_posts" );
vc_remove_element( "vc_wp_categories" );
vc_remove_element( "vc_wp_archives" );
vc_remove_element( "vc_wp_rss" );
endif;

// Remove comments page in menu
/*
function dswp_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'dswp_disable_comments_admin_menu');
*/

?>
