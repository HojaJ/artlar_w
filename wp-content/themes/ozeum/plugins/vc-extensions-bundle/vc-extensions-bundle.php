<?php
/* WPBakery PageBuilder Extensions Bundle support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ozeum_vc_extensions_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ozeum_vc_extensions_theme_setup9', 9 );
	function ozeum_vc_extensions_theme_setup9() {
		if ( ozeum_exists_vc() && ozeum_exists_vc_extensions() ) {
			add_action( 'wp_enqueue_scripts', 'ozeum_vc_extensions_frontend_scripts', 1100 );
			add_filter( 'ozeum_filter_merge_styles', 'ozeum_vc_extensions_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_vc_extensions_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ozeum_vc_extensions_tgmpa_required_plugins' ) ) {
	
	function ozeum_vc_extensions_tgmpa_required_plugins( $list = array() ) {
		if ( ozeum_storage_isset( 'required_plugins', 'vc-extensions-bundle' ) && ozeum_storage_get_array( 'required_plugins', 'vc-extensions-bundle', 'install' ) !== false && ozeum_is_theme_activated() ) {
			$path = ozeum_get_plugin_source_path( 'plugins/vc-extensions-bundle/vc-extensions-bundle.zip' );
			if ( ! empty( $path ) || ozeum_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => ozeum_storage_get_array( 'required_plugins', 'vc-extensions-bundle', 'title' ),
					'slug'     => 'vc-extensions-bundle',
					'source'   => ! empty( $path ) ? $path : 'upload://vc-extensions-bundle.zip',
					'version'  => '3.6.1',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if VC Extensions installed and activated
if ( ! function_exists( 'ozeum_exists_vc_extensions' ) ) {
	function ozeum_exists_vc_extensions() {
		return class_exists( 'Vc_Manager' ) && class_exists( 'VC_Extensions_CQBundle' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'ozeum_vc_extensions_frontend_scripts' ) ) {
	
	function ozeum_vc_extensions_frontend_scripts() {
		if ( ozeum_is_on( ozeum_get_theme_option( 'debug_mode' ) ) ) {
			$ozeum_url = ozeum_get_file_url( 'plugins/vc-extensions-bundle/vc-extensions-bundle.css' );
			if ( '' != $ozeum_url ) {
				wp_enqueue_style( 'ozeum-vc-extensions-bundle', $ozeum_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'ozeum_vc_extensions_merge_styles' ) ) {
	
	function ozeum_vc_extensions_merge_styles( $list ) {
		$list[] = 'plugins/vc-extensions-bundle/vc-extensions-bundle.css';
		return $list;
	}
}

