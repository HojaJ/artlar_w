<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'ozeum_elegro_payment_get_css' ) ) {
	add_filter( 'ozeum_filter_get_css', 'ozeum_elegro_payment_get_css', 10, 2 );
	function ozeum_elegro_payment_get_css( $css, $args ) {

		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS
#btn-buy {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
#btn-buy:hover {
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_hover']};
}

CSS;
		}

		return $css;
	}
}

