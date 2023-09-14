<?php
/* ThemeREX Popup
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ozeum_trx_popup_theme_setup9')) {
    add_action('after_setup_theme', 'ozeum_trx_popup_theme_setup9', 9);
    function ozeum_trx_popup_theme_setup9()
    {
        if (ozeum_exists_trx_popup()) {
            add_action('wp_enqueue_scripts', 'ozeum_trx_popup_frontend_styles', 1100);
            add_filter('ozeum_filter_merge_styles', 'ozeum_trx_popup_merge_styles');
        }


        // Add plugin-specific colors and fonts to the custom CSS
        if (ozeum_exists_trx_popup()) {
            require_once ozeum_get_file_dir('plugins/trx_popup/trx_popup-style.php');
        }

        // Add admin panel integration
        if ( is_admin() ) {
            add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_trx_popup_tgmpa_required_plugins' );
        }
    }
}

// Enqueue custom scripts
if (!function_exists('ozeum_trx_popup_frontend_styles')) {
    
    function ozeum_trx_popup_frontend_styles()
    {
        if (ozeum_is_on(ozeum_get_theme_option('debug_mode'))) {
            $ozeum_url = ozeum_get_file_url('plugins/trx_popup/trx_popup.css');
            if ('' != $ozeum_url) {
                wp_enqueue_style( 'ozeum-trx-popup', $ozeum_url, array(), null);
            }
        }
    }
}

// Merge custom scripts
if (!function_exists('ozeum_trx_popup_merge_styles')) {
    
    function ozeum_trx_popup_merge_styles($list)
    {
        $list[] = 'plugins/trx_popup/trx_popup.css';
        return $list;
    }
}

// Check if TRX Popup installed and activated
if (!function_exists('ozeum_exists_trx_popup')) {
    function ozeum_exists_trx_popup()
    {
        return defined('TRX_POPUP_URL');
    }
}
