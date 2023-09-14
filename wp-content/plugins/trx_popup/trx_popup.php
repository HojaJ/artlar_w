<?php
/**
* Plugin Name: ThemeREX Pop-Up
* Plugin URI: https://themerex.net/
* Description: Add pop-up on your site
* Version: 1.1.3
* Author: ThemeREX
* Author URI: https://themerex.net/
**/

if (!defined('TRX_POPUP_URL'))	{ define('TRX_POPUP_URL', plugin_dir_url(__FILE__)); }

// Load required styles and scripts in the frontend
if ( !function_exists( 'trx_popup_load_scripts_front' ) ) {
	add_action( 'wp_enqueue_scripts', 'trx_popup_load_scripts_front' );
	function trx_popup_load_scripts_front() {
		wp_enqueue_style( 'trx-popup-style', TRX_POPUP_URL . 'css/style.css', array(), null );
		wp_enqueue_style( 'trx-popup-custom', TRX_POPUP_URL . 'css/custom.css', array(), null );;
        wp_enqueue_style( 'trx-popup-stylesheet', TRX_POPUP_URL . 'css/fonts/Inter/stylesheet.css', array(), null );
		wp_enqueue_script( 'trx-popup-cookie', TRX_POPUP_URL . 'js/jquery.cookie.js', array('jquery'), null, true );
		wp_enqueue_script( 'trx-popup-script', TRX_POPUP_URL . 'js/trx_popup.script.js', array('jquery'), null, true );
	}
}

// Load required styles and scripts in the backend
if ( !function_exists( 'trx_popup_load_scripts_admin' ) ) {
	add_action( 'admin_enqueue_scripts', 'trx_popup_load_scripts_admin' );
	function trx_popup_load_scripts_admin() {
		wp_enqueue_media();
		wp_enqueue_style( 'trx-popup-style-admin', TRX_POPUP_URL . 'css/admin.css', array(), null );
        wp_enqueue_script( 'trx-popup-script-admin', TRX_POPUP_URL . 'js/trx_popup.admin.js', array('jquery'), null, true);
	}
}

// Get plugin option
if ( !function_exists( 'trx_popup_get_option' ) ) {
    function trx_popup_get_option($name, $default='') {
        if ( !empty($name) ) {
            $options = get_option( 'trx-popup-options' );
            if ( !empty($options) ) {
                if ( array_key_exists($name, $options) ) {
                    return !empty($options[$name]) ? $options[$name] : $default;
                }
            }
        }
        return $default;
    }
}

// Check if timer is end
if ( !function_exists( 'trx_popup_is_timer_end' ) ) {
	function trx_popup_is_timer_end() {
		$timer = !empty(trx_popup_get_option('date')) ? trx_popup_get_option('date') : '';
		$timer .= !empty(trx_popup_get_option('time')) ? ' ' . trx_popup_get_option('time') : '';
		if ( !empty($timer) ) {
			$current = date('Y-m-d H:i');
			if ( $current > $timer ) {
				return true;
			}
		}  
		return false;
	}
}

// Return true if Elementor exists and current mode is edit
if ( !function_exists( 'trx_popup_elm_is_edit_mode' ) ) {
	function trx_popup_elm_is_edit_mode() {
		if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			return true;
		}
		return false;
	}
}

// Load popup template
if ( !function_exists( 'trx_popup_load_template' ) ) {
	add_action( 'wp_footer', 'trx_popup_load_template' );
	function trx_popup_load_template() {
		if ( !trx_popup_elm_is_edit_mode() ){
			$pages = trx_popup_get_option('pages');
			if ( !empty($pages) ) {
				$list = explode( ",", $pages );
				$id = get_the_ID();
				if ( !in_array($id, $list) ) {
					return;
				}
			}
			include ('templates/tpl.default.php');			
		}
	}
}

// Rewrite custom styles
if ( !function_exists( 'trx_popup_rewrite_custom_css' ) ) {
	add_action( 'update_option_trx-popup-options', 'trx_popup_rewrite_custom_css', 10, 3 );
    function trx_popup_rewrite_custom_css($old_value='', $value='', $option='') {
    	$custom_css_file = dirname(__FILE__) . '/css/custom.css';
    	if ( file_exists( $custom_css_file ) ) {
    		$custom_css = trx_popup_custom_css();
    		if ( !empty($custom_css) ) {
				file_put_contents($custom_css_file, $custom_css);
    		}
    	}
    	if ( get_option('trx-popup-custom-css') == false ) {
    		add_option('trx-popup-custom-css', 'saved');
    	}
    }
}

// Rewrite custom styles after site import
if ( !function_exists( 'trx_popup_rewrite_custom_css_after_import' ) ) {
	add_action( 'init', 'trx_popup_rewrite_custom_css_after_import' );
	function trx_popup_rewrite_custom_css_after_import() {
		if ( get_option('trx-popup-options') != false && get_option('trx-popup-custom-css') == false ) {
			trx_popup_rewrite_custom_css();
		}
	}
}

// Plugin's options
require_once plugin_dir_path(__FILE__) . 'includes/plugin.options.php';

// Plugin's styles
require_once plugin_dir_path(__FILE__) . 'includes/plugin.styles.php';