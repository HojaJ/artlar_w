<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'ozeum_wpml_get_css' ) ) {
	add_filter( 'ozeum_filter_get_css', 'ozeum_wpml_get_css', 10, 2 );
	function ozeum_wpml_get_css( $css, $args ) {
		return $css;
	}
}

