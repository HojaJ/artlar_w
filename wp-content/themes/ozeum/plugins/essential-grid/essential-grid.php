<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ozeum_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ozeum_essential_grid_theme_setup9', 9 );
	function ozeum_essential_grid_theme_setup9() {
		if ( ozeum_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'ozeum_essential_grid_frontend_scripts', 1100 );
			add_filter( 'ozeum_filter_merge_styles', 'ozeum_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ozeum_essential_grid_tgmpa_required_plugins' ) ) {
	
	function ozeum_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( ozeum_storage_isset( 'required_plugins', 'essential-grid' ) && ozeum_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && ozeum_is_theme_activated() ) {
			$path = ozeum_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || ozeum_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => ozeum_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '3.0.12',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'ozeum_exists_essential_grid' ) ) {
	function ozeum_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' ) || defined('ESG_PLUGIN_PATH');
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'ozeum_essential_grid_frontend_scripts' ) ) {
	
	function ozeum_essential_grid_frontend_scripts() {
		if ( ozeum_is_on( ozeum_get_theme_option( 'debug_mode' ) ) ) {
			$ozeum_url = ozeum_get_file_url( 'plugins/essential-grid/essential-grid.css' );
			if ( '' != $ozeum_url ) {
				wp_enqueue_style( 'ozeum-essential-grid', $ozeum_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'ozeum_essential_grid_merge_styles' ) ) {
	
	function ozeum_essential_grid_merge_styles( $list ) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}

