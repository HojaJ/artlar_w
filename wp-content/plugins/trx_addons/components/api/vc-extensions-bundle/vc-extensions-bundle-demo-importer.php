<?php
/**
 * Plugin support: WPBakery PageBuilder Extensions Bundle (Importer support)
 *
 * @package ThemeREX Addons
 * @since v1.5
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check VC Extensions in the required plugins
if ( !function_exists( 'trx_addons_vc_extensions_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins', 'trx_addons_vc_extensions_importer_required_plugins', 10, 2 );
	function trx_addons_vc_extensions_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'vc-extensions-bundle')!==false && !trx_addons_exists_vc_extensions())
			$not_installed .= '<br>' . esc_html__('WPBakery PageBuilder Extensions Bundle', 'trx_addons');
		return $not_installed;
	}
}
