<?php 

include_once(WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php');

if(!class_exists('Yeti_Product_Cat_Walker')) {
	class Yeti_Product_Cat_Walker extends WC_Product_Cat_List_Walker {
		public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
			$output .= '<li class="cat-item cat-item-' . $cat->term_id;

			if ( $args['current_category'] == $cat->term_id ) {
				$output .= ' current-cat';
			}

			if ( $args['has_children'] && $args['hierarchical'] ) {
				$output .= ' cat-parent';
			}

			if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
				$output .= ' current-cat-parent';
			}

			$output .= '"><a href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '">';
			$output .= _x( $cat->name, 'product category name', 'omeo' );
			if ( $args['show_count'] ) {
				$output .= ' (' . $cat->count . ')';
			}
			$output .= '</a>';
		}
	}
}