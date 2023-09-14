<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ozeum_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ozeum_elegro_payment_theme_setup9', 9 );
	function ozeum_elegro_payment_theme_setup9() {
		if ( ozeum_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'ozeum_elegro_payment_frontend_scripts', 1100 );
			add_filter( 'ozeum_filter_merge_styles', 'ozeum_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ozeum_elegro_payment_tgmpa_required_plugins' ) ) {
	
	function ozeum_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( ozeum_storage_isset( 'required_plugins', 'woocommerce' ) && ozeum_storage_isset( 'required_plugins', 'elegro-payment' ) && ozeum_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => ozeum_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'ozeum_exists_elegro_payment' ) ) {
	function ozeum_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'ozeum_elegro_payment_frontend_scripts' ) ) {
	
	function ozeum_elegro_payment_frontend_scripts() {
		if ( ozeum_is_on( ozeum_get_theme_option( 'debug_mode' ) ) ) {
			$ozeum_url = ozeum_get_file_url( 'plugins/elegro-payment/elegro-payment.css' );
			if ( '' != $ozeum_url ) {
				wp_enqueue_style( 'ozeum-elegro-payment', $ozeum_url, array(), null );
			}
		}
	}
}


// Merge custom styles
if ( ! function_exists( 'ozeum_elegro_payment_merge_styles' ) ) {
	
	function ozeum_elegro_payment_merge_styles( $list ) {
		$list[] = 'plugins/elegro-payment/elegro-payment.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ozeum_exists_elegro_payment() ) {
	require_once ozeum_get_file_dir( 'plugins/elegro-payment/elegro-payment-style.php' );
}
