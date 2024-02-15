<?php
/**
 *  PS_Walker Navigation Menu template functions
 *
 * @since 1.0.0
 * @uses Walker
 * @uses Walker_Nav_Menu
 */
class PS_Walker extends Walker {

	public mixed $color = 'ps-btn-color-secondary';
	public function __construct( $color = null ) {
		if ( $color !== null ) {
			$this->color = $color;
		}
	}
	public $db_fields = array(
		'parent' => 'menu_item_parent',
		'id'     => 'db_id',
	);

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent    = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$class_names = implode(
			' ',
			apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth )
		);
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . ' >';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';
		$atts['class']  = array( $this->color, 'ps-btn ps-btn-html-tag-button ps-btn-variant-navigation ps-btn-size-none ps-btn-text-size-lg-large ps-btn-text-size-medium ps-btn-content-type-text-only ps-btn-color-secondary w-100 w-lg-auto' );
		if ( $item->current ) {
			$atts['class'][] = 'ps-btn-status-active';
		}
		$atts['class'] = implode( ' ', $atts['class'] );

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title        = apply_filters( 'nav_menu_item_title', $item->title, $item, $args, $depth );
		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

