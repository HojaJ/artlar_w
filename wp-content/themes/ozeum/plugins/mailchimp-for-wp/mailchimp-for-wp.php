<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ozeum_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ozeum_mailchimp_theme_setup9', 9 );
	function ozeum_mailchimp_theme_setup9() {
		if ( ozeum_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'ozeum_mailchimp_frontend_scripts', 1100 );
			add_filter( 'ozeum_filter_merge_styles', 'ozeum_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ozeum_mailchimp_tgmpa_required_plugins' ) ) {
	
	function ozeum_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( ozeum_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && ozeum_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => ozeum_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'ozeum_exists_mailchimp' ) ) {
	function ozeum_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'ozeum_mailchimp_frontend_scripts' ) ) {
	
	function ozeum_mailchimp_frontend_scripts() {
		if ( ozeum_is_on( ozeum_get_theme_option( 'debug_mode' ) ) ) {
			$ozeum_url = ozeum_get_file_url( 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' );
			if ( '' != $ozeum_url ) {
				wp_enqueue_style( 'ozeum-mailchimp', $ozeum_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'ozeum_mailchimp_merge_styles' ) ) {
	
	function ozeum_mailchimp_merge_styles( $list ) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ozeum_exists_mailchimp() ) {
	require_once ozeum_get_file_dir( 'plugins/mailchimp-for-wp/mailchimp-for-wp-style.php' );
}

