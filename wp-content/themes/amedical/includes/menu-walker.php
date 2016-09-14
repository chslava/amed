<?php
/**
 * Customize the output of menus for Foundation top bar
 */
 // Top menu
if ( ! class_exists( 'Top_Menu_Walker' ) ) :
class Top_Menu_Walker extends Walker_Nav_Menu {

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->has_children = ! empty( $children_elements[ $element->ID ] );
		$element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
		$element->classes[] = ( $element->has_children && 1 !== $max_depth ) ? 'has-dropdown' : '';

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $object, $depth, $args );

		//$output .= ( 0 == $depth ) ? '<li class="divider"></li>' : '';

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;


		$output .= $item_html;
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"sub-menu dropdown\">\n";
	}

}
endif;


// Main menu
if ( ! class_exists( 'Main_Menu_Walker' ) ) :
class Main_Menu_Walker extends Walker_Nav_Menu {

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->has_children = ! empty( $children_elements[ $element->ID ] );
		$element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
		$element->classes[] = ( $element->has_children && 1 !== $max_depth ) ? 'has-dropdown' : '';

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}


	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$item_html = '';

		parent::start_el( $item_html, $object, $depth, $args );

		$classes = empty( $object->classes ) ? array() : (array) $object->classes;

		// Home menu
		if ( in_array( 'home', $classes ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<a href="'.get_home_url().'"><span class="icon-home"></span></a><div class="line"></div>', $item_html );
		}

		if ( in_array( 'first-item', $classes  ) ) {
			$item_html .= '<div class="line"></div>';
		}

		if ( in_array( 'mob-menu', $classes ) ){
			$item_html = '';
		}

		$output .= $item_html;
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<div class=\"sub-menu\"><div class=\"row\"><div class=\"small-6 columns\"><ul class=\"two-columns\">\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent</ul></div><div class=\"small-6 columns\"><img src='".get_bloginfo('template_directory')."/images/coffee.png'></div></div>\n";
	}

}
endif;

// Footer menu
if ( ! class_exists( 'Footer_Menu_Walker' ) ) :
class Footer_Menu_Walker extends Walker_Nav_Menu {

 function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
	 $element->has_children = ! empty( $children_elements[ $element->ID ] );
	 $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
	 $element->classes[] = ( $element->has_children && 1 !== $max_depth ) ? 'has-dropdown' : '';

	 parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
 }

 function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
	 $item_html = '';
	 parent::start_el( $item_html, $object, $depth, $args );

	 //$output .= ( 0 == $depth ) ? '<li class="divider"></li>' : '';

		//$classes = empty( $object->classes ) ? array() : (array) $object->classes;

		if($object->xfn != ''){
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<a href="'.get_home_url().'">$1</a><a href="'.get_home_url().'" class="'.$object->post_excerpt.'">'.$object->xfn.'</a>', $item_html );
		}

	 $classes = empty( $object->classes ) ? array() : (array) $object->classes;

	 $output .= $item_html;
 }

 function start_lvl( &$output, $depth = 0, $args = array() ) {
	 $output .= "\n<ul class=\"two-columns\">\n";
 }

}
endif;



?>
