<?php
/**
 * Customize the output of menus for Foundation top bar
 */
 // Top menu
if ( ! class_exists( 'Top_Menu_Walker' ) ) :
class Top_Menu_Walker extends Walker_Nav_Menu {

	 function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

		$atts = array();
		$atts['title']  = ! empty( $object->attr_title ) ? $object->attr_title : '';
		$atts['target'] = ! empty( $object->target )     ? $object->target     : '';
		$atts['rel']    = ! empty( $object->xfn )        ? $object->xfn        : '';
		$atts['href']   = ! empty( $object->url )        ? $object->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $object, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
		    if ( ! empty( $value ) ) {
		        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
		        $attributes .= ' ' . $attr . '="' . $value . '"';
		    }
		}

		$output .= '<a'. $attributes .' class="item">';
		$output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
		$output .= '</a>';
  }

}
endif;


// Main menu
if ( ! class_exists( 'Main_Menu_Walker' ) ) :
class Main_Menu_Walker extends Walker_Nav_Menu {

	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

	 $item_html = '';

	 $atts = array();
	 $atts['title']  = ! empty( $object->attr_title ) ? $object->attr_title : '';
	 $atts['target'] = ! empty( $object->target )     ? $object->target     : '';
	 $atts['rel']    = ! empty( $object->xfn )        ? $object->xfn        : '';
	 $atts['href']   = ! empty( $object->url )        ? $object->url        : '';

	 $atts = apply_filters( 'nav_menu_link_attributes', $atts, $object, $args );

	 $attributes = '';
	 foreach ( $atts as $attr => $value ) {
			 if ( ! empty( $value ) ) {
					 $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					 $attributes .= ' ' . $attr . '="' . $value . '"';
			 }
	 }

	 $classes = empty( $object->classes ) ? array() : (array) $object->classes;

	 // Home menu
	 if ( in_array( 'home', $classes ) ) {
		 $item_html .= '<a'. $attributes .' class="item"><i class="icon-home-icon"></i></a>';
	 }else{
		 $item_html .= '<a'. $attributes .' class="item">';
		 $item_html .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
		 $item_html .= '</a>';
	 }

	 $output .= $item_html;

 }


}
endif;

// Footer menu
if ( ! class_exists( 'Footer_Menu_Walker' ) ) :
class Footer_Menu_Walker extends Walker_Nav_Menu {

	function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {

	 $atts = array();
	 $atts['title']  = ! empty( $object->attr_title ) ? $object->attr_title : '';
	 $atts['target'] = ! empty( $object->target )     ? $object->target     : '';
	 $atts['rel']    = ! empty( $object->xfn )        ? $object->xfn        : '';
	 $atts['href']   = ! empty( $object->url )        ? $object->url        : '';

	 $atts = apply_filters( 'nav_menu_link_attributes', $atts, $object, $args );

	 $attributes = '';
	 foreach ( $atts as $attr => $value ) {
			 if ( ! empty( $value ) ) {
					 $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					 $attributes .= ' ' . $attr . '="' . $value . '"';
			 }
	 }

	 $output .= '<a'. $attributes .' class="item">';
	 $output .= $args->link_before . apply_filters( 'the_title', $object->title, $object->ID ) . $args->link_after;
	 $output .= '</a>';
 }

}
endif;



?>
