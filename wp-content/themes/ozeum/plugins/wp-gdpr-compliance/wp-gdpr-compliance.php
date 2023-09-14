<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ozeum_wp_gdpr_compliance_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ozeum_wp_gdpr_compliance_theme_setup9', 9 );
	function ozeum_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ozeum_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	
	function ozeum_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
		if ( ozeum_storage_isset( 'required_plugins', 'wp-gdpr-compliance' ) && ozeum_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'install' ) !== false ) {
			$list[] = array(
				'name'     => ozeum_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'title' ),
				'slug'     => 'wp-gdpr-compliance',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'ozeum_exists_wp_gdpr_compliance' ) ) {
	function ozeum_exists_wp_gdpr_compliance() {
		return class_exists( 'WPGDPRC\WPGDPRC' );
	}
}
