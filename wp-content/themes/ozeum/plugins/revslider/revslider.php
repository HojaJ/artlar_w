<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ozeum_revslider_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ozeum_revslider_theme_setup9', 9 );
	function ozeum_revslider_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ozeum_revslider_tgmpa_required_plugins' ) ) {
	
	function ozeum_revslider_tgmpa_required_plugins( $list = array() ) {
		if ( ozeum_storage_isset( 'required_plugins', 'revslider' ) && ozeum_storage_get_array( 'required_plugins', 'revslider', 'install' ) !== false && ozeum_is_theme_activated() ) {
			$path = ozeum_get_plugin_source_path( 'plugins/revslider/revslider.zip' );
			if ( ! empty( $path ) || ozeum_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => ozeum_storage_get_array( 'required_plugins', 'revslider', 'title' ),
					'slug'     => 'revslider',
					'source'   => ! empty( $path ) ? $path : 'upload://revslider.zip',
					'version'  => '6.5.7',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( ! function_exists( 'ozeum_exists_revslider' ) ) {
	function ozeum_exists_revslider() {
		return function_exists( 'rev_slider_shortcode' );
	}
}
