<?php
/**
 * Plugin's options
 *
 * @package ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// -----------------------------------------------------------------
// -- Customizable theme options
// -----------------------------------------------------------------

// Load current values for each customizable option
if ( !function_exists('trx_addons_load_options') ) {
	function trx_addons_load_options() {
		global $TRX_ADDONS_STORAGE;
		$options = apply_filters('trx_addons_filter_load_options', get_option('trx_addons_options'));
		if (isset($TRX_ADDONS_STORAGE['options']) && is_array($TRX_ADDONS_STORAGE['options'])) {
			foreach ($TRX_ADDONS_STORAGE['options'] as $k=>$v) {
				if (isset($v['std'])) {
					$val = isset($_GET[$k]) 
								? $_GET[$k] 
								: (isset($options[$k])
									? $options[$k]
									: $v['std']
								);
					/*
					if (is_array($v['std'])) {
						foreach ($v['std'] as $k1=>$v1) {
							if (!isset($val[$k1])) $val[$k1] = $v1;
						}
					}
					*/
					$TRX_ADDONS_STORAGE['options'][$k]['val'] = $val;
				}
			}
			$TRX_ADDONS_STORAGE['options'] = apply_filters('trx_addons_filter_after_load_options', $TRX_ADDONS_STORAGE['options']);
		}
	}
}


// Check if option exists
if (!function_exists('trx_addons_check_option')) {
	function trx_addons_check_option($name) {
		global $TRX_ADDONS_STORAGE;
		return isset($TRX_ADDONS_STORAGE['options'][$name]);
	}
}


// Return customizable option value
if (!function_exists('trx_addons_get_option')) {
	function trx_addons_get_option($name, $defa='', $strict_mode=true) {
		global $TRX_ADDONS_STORAGE;
		$rez = $defa;
		$part = '';
		if (strpos($name, '[')!==false) {
			$tmp = explode('[', $name);
			$name = $tmp[0];
			$part = substr($tmp[1], 0, -1);
		}

		// If options are loaded and specified name is not exists and 'strict_mode' is on - display warning message
		// and dump call's stack
		if ( isset($TRX_ADDONS_STORAGE['options']) && !isset($TRX_ADDONS_STORAGE['options'][$name]) && $strict_mode ) {
			$s = '';
			if ( function_exists( 'ddo' ) ) {
				$s = debug_backtrace();
				array_shift($s);
				$s = ddo($s, 0, 3);
			}
			wp_die(
				// Translators: Add option's name to the message
				esc_html( sprintf( __( 'Undefined option "%s"', 'trx_addons' ), $name ) )
				. ( ! empty( $s )
						? ' ' . esc_html( __( 'called from:', 'trx_addons' ) ) . "<pre>" . wp_kses_data( $s ) . '</pre>'
						: ''
						)
			);
		}
		// Override option from GET
		if (isset($_GET[$name])) {
			if (empty($part))
				$rez = $_GET[$name];
			else if (isset($_GET[$name][$part]))
				$rez = $_GET[$name][$part];
		// Get saved option value
		} else if (isset($TRX_ADDONS_STORAGE['options'][$name]['val'])) {
			if (empty($part))
				$rez = $TRX_ADDONS_STORAGE['options'][$name]['val'];
			else if (isset($TRX_ADDONS_STORAGE['options'][$name]['val'][$part]))
				$rez = $TRX_ADDONS_STORAGE['options'][$name]['val'][$part];
		}
		return $rez;
	}
}

// Get dependencies list from the Plugin's Options
if ( !function_exists('trx_addons_get_options_dependencies') ) {
	function trx_addons_get_options_dependencies($options=null) {
		global $TRX_ADDONS_STORAGE;
		if (!$options) $options = $TRX_ADDONS_STORAGE['options'];
		$depends = array();
		foreach ($options as $k=>$v) {
			if (isset($v['dependency'])) 
				$depends[$k] = $v['dependency'];
		}
		return $depends;
	}
}

// Return option name
if ( !function_exists( 'trx_addons_get_option_title' ) ) {
	function trx_addons_get_option_title($post_type, $key, $val=null) {
		global $TRX_ADDONS_STORAGE;
		if (!empty($post_type)) {
			if ($val === null)
				return !empty($TRX_ADDONS_STORAGE['meta_box_'.$post_type][$key]['options']) 
									? $TRX_ADDONS_STORAGE['meta_box_'.$post_type][$key]['options'] 
									: array();
			else
				return !empty($TRX_ADDONS_STORAGE['meta_box_'.$post_type][$key]['options'][$val]) 
									? $TRX_ADDONS_STORAGE['meta_box_'.$post_type][$key]['options'][$val] 
									: (!empty($val) ? ucfirst($val) : '');
		} else {
			if ($val === null)
				return !empty($TRX_ADDONS_STORAGE['options'][$key]['options']) 
									? $TRX_ADDONS_STORAGE['options'][$key]['options'] 
									: array();
			else
				return !empty($TRX_ADDONS_STORAGE['options'][$key]['options'][$val]) 
									? $TRX_ADDONS_STORAGE['options'][$key]['options'][$val] 
									: (!empty($val) ? ucfirst($val) : '');
		}
	}
}


// Plugin's options - user can change it
if (!function_exists('trx_addons_init_options')) {
	add_action( 'after_setup_theme', 'trx_addons_init_options', 3 );
	function trx_addons_init_options() {
		global $TRX_ADDONS_STORAGE;

		$TRX_ADDONS_STORAGE['options'] = apply_filters('trx_addons_filter_options', array_merge(
			array(
				// Section 'General' - main options
				'general_section' => array(
					"title" => esc_html__('General', 'trx_addons'),
					"desc" => wp_kses_data( __('General options', 'trx_addons') ),
					'icon' => 'trx_addons_icon-generic',
					"type" => "section"
				),
				'general_info' => array(
					"title" => esc_html__('General Settings', 'trx_addons'),
					"desc" => wp_kses_data( __("General settings of the ThemeREX Addons", 'trx_addons') ),
					"type" => "info"
				),
				'debug_mode' => array(
					"title" => esc_html__('Debug mode', 'trx_addons'),
					"desc" => wp_kses_data( __('Enable debug functions and theme profiler output.', 'trx_addons') )
							. '<br>'
							. wp_kses_data( __('Attention! When the "Debug Mode" is on, the original .css and .js files are being used. When it is turned off, composed files that contain many scripts and styles are used! Composed files must not be edited! If you want to change scripts or styles of plugins and/or of the theme, turn the "Debug mode" on, apply the changes to the original files, check if everything works, and turn the "Debug mode" off again. Composed files are being rewritten every time you save plugin\'s and the theme\'s options.', 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				"disable_widgets_block_editor" => array(
                    "title" => esc_html__('Disable new Widgets Block Editor', 'trx_addons'),
                    "desc" => wp_kses_data( __('Attention! If after the update to WordPress 5.8+ you are having trouble editing widgets or working in Customizer - disable new Widgets Block Editor (used in WordPress 5.8+ instead of a classic widgets panel)', 'trx_addons') ),
                    "std" => "1",
                    "type" => "switch"
                ),
				'move_styles_to_head' => array(
					"title" => esc_html__('Move styles to the head', 'trx_addons'),
					"desc" => wp_kses_data( __('Capture page output and move all tags "style" from the body to the head (for the W3C validation)', 'trx_addons') ),
					"std" => "1",
					"type" => "switch"
				),
				'move_scripts_to_footer' => array(
					"title" => esc_html__('Move javascripts to the footer', 'trx_addons'),
					"desc" => wp_kses_data( __('Move all tags "script" to the footer to increase page loading speed in the frontend', 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'async_scripts_load' => array(
					"title" => esc_html__('Load javascripts asynchronously', 'trx_addons'),
					"desc" => wp_kses_data( __('Add attribute "defer" to all tags "script" in the frontend', 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'async_scripts_exclude' => array(
					"title" => esc_html__('Exclude javascripts from asynchronous loading', 'trx_addons'),
					"desc" => wp_kses_data( __('Comma separated list the url fragments of the scripts you want to exclude from asynchronous loading (if there are any problems with them). Attention! System scripts (jquery, modernizr, elementor, etc.) are included in this list by default', 'trx_addons') ),
					"std" => "",
					"type" => "text"
				),
				'remove_ver_from_url' => array(
					"title" => esc_html__('Remove parameter "ver=" from URL', 'trx_addons'),
					"desc" => wp_kses_data( __('Remove parameter "ver=" from URLs of the styles and scripts to enable caching this files', 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'ajax_views' => array(
					"title" => esc_html__('Views counter via AJAX', 'trx_addons'),
					"desc" => wp_kses_data(__('Increment views counter via AJAX or PHP. Check it if you use caching system on your site', 'trx_addons')),
					"std" => 0,
					"type" => "switch"
				),
				'retina_ready' => array(
					"title" => esc_html__('Image dimensions', 'trx_addons'),
					"desc" => wp_kses_data( __('Which dimensions will be used for the uploaded images: "Original" or "Retina ready" (twice enlarged)', 'trx_addons') ),
					"std" => "1",
					"size" => "medium",
					"options" => array(
						"1" => esc_html__("Original", 'trx_addons'), 
						"2" => esc_html__("Retina", 'trx_addons')
						),
					"type" => 'radio'
				),
				'images_quality' => array(
					"title" => esc_html__('Quality for cropped images', 'trx_addons'),
					"desc" => wp_kses_data( __('Quality (1-100) to save cropped images. Attention! After change the image quality, you need to regenerate all thumbnails!', 'trx_addons') ),
					"std" => 60,
					"type" => "text"
				),
				'page_preloader' => array(
					"title" => esc_html__("Show page preloader", 'trx_addons'),
					"desc" => wp_kses_data( __("Select one of predefined styles for the page preloader or upload preloader image", 'trx_addons') ),
					"std" => "none",
					"options" => apply_filters('trx_addons_filter_preloaders_list', array(
						'none'   => esc_html__('Hide preloader', 'trx_addons'),
						'circle' => esc_html__('Circle', 'trx_addons'),
						'square' => esc_html__('Square', 'trx_addons'),
						'dots'   => esc_html__('Dots', 'trx_addons'),
						'custom' => esc_html__('Custom', 'trx_addons')
						)),
					"type" => "radio"
				),
				'page_preloader_bg_color' => array(
					"title" => esc_html__('Page preloader bg color',  'trx_addons'),
					"desc" => wp_kses_data( __('Select background color for the page preloader. If empty - not use background color',  'trx_addons') ),
					"dependency" => array(
						"page_preloader" => array('^none')
					),
					"std" => "#ffffff",
					"type" => "color"
				),
				'page_preloader_image' => array(
					"title" => esc_html__('Page preloader image',  'trx_addons'),
					"desc" => wp_kses_data( __('Select or upload page preloader image for your site. If empty - site not using preloader',  'trx_addons') ),
					"dependency" => array(
						"page_preloader" => array('custom')
					),
					"std" => "",
					"type" => "image"
				),
				'scroll_progress' => array(
					'title' => esc_html__( 'Scroll progress bar', 'trx_addons' ),
					'desc' => wp_kses_data( __( 'Display scroll progress bar', 'trx_addons' ) ),
					'std' => 'hide',
					'options' => array(
						'hide' => esc_html__( 'Hide', 'trx_addons' ),
						'top' => esc_html__( 'Top', 'trx_addons' ),
						'bottom' => esc_html__( 'Bottom', 'trx_addons' ),
					),
					'type' => 'select',
				),
				'scroll_to_top' => array(
					"title" => esc_html__('Add "Scroll to Top"', 'trx_addons'),
					"desc" => wp_kses_data( __('Add "Scroll to Top" button when page is scrolled down', 'trx_addons') ),
					"std" => "1",
					"type" => "switch"
				),
				'animate_inner_links' => array(
					"title" => esc_html__('Animate inner links', 'trx_addons'),
					"desc" => wp_kses_data( __('Add "Smooth Scroll" to the inner page links (started with "#")', 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'add_target_blank' => array(
					"title" => esc_html__('Open external links in a new window', 'trx_addons'),
					"desc" => wp_kses_data( __('Add parameter target="_blank" to all external links', 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'popup_engine' => array(
					"title" => esc_html__('Popup Engine', 'trx_addons'),
					"desc" => wp_kses_data( __('Select script to show popup windows with images and any other html code', 'trx_addons') ),
					"std" => "magnific",
					"options" => array(
						"none" => esc_html__("None", 'trx_addons'),
						'magnific' => esc_html__("Magnific Popup", 'trx_addons')
					),
					"type" => "radio"
				),
				'menu_info' => array(
					"title" => esc_html__('Menu', 'trx_addons'),
					"desc" => wp_kses_data( __("Menu parameters", 'trx_addons') ),
					"type" => "info"
				),
				'menu_cache' => array(
					"title" => esc_html__('Use menu cache', 'trx_addons'),
					"desc" => wp_kses_data( __('Use cache for the menu (increase theme speed, decrease queries number). Attention! Please, save menu again after change permalink settings! Uncheck this option if you use WPML!', 'trx_addons') ),
					"std" => 0,
					"type" => "switch"
				),
				'menu_collapse' => array(
					"title" => esc_html__('Collapse menu', 'trx_addons'),
					"desc" => wp_kses_data( __("To group menu items if they don't fit in one line", 'trx_addons') ),
					"std" => 0,
					"type" => "switch"
				),
				"menu_collapse_icon" => array(
					"title" => esc_html__("Icon", 'trx_addons'),
					"desc" => wp_kses_data( __('Select icon of the menu item with collapsed elements', 'trx_addons') ),
					"std" => "trx_addons_icon-ellipsis-vert",
					"options" => array(),
					"style" => trx_addons_get_setting('icons_type'),
					"type" => "icons"
				),
				'menu_stretch' => array(
					"title" => esc_html__('Stretch a submenu with layouts', 'trx_addons'),
					"desc" => wp_kses_data( __("Stretch a submenu with layouts (only the first level) to content width", 'trx_addons') ),
					"std" => 0,
					"type" => "switch"
				),
				'breadcrumbs_max_level' => array(
					"title" => esc_html__('Breadcrumbs nestings', 'trx_addons'),
					"desc" => wp_kses_data( __('Max nesting level of the breadcrumbs. If empty or 0 - display all breadcrumbs elements!', 'trx_addons') ),
					"std" => 3,
					"type" => "text"
				),
				'login_info' => array(
					"title" => esc_html__('Login and Registration', 'trx_addons'),
					"desc" => wp_kses_data( __("Specify parameters of the User's Login and Registration", 'trx_addons') ),
					"type" => "info"
				),
				'login_via_ajax' => array(
					"title" => esc_html__('Login via AJAX', 'trx_addons'),
					"desc" => wp_kses_data( __('Login via AJAX or use direct link on the WP Login page. Uncheck it if you have problem with any login plugin.', 'trx_addons') ),
					"std" => "1",
					"type" => "switch"
				),
				'login_via_socials' => array(
					"title" => esc_html__('Login via social profiles',  'trx_addons'),
					"desc" => wp_kses_data( __('Specify shortcode from your Social Login Plugin or any HTML/JS code to make Social Login section',  'trx_addons') ),
					"std" => "",
					"type" => "textarea"
				),
				"notify_about_new_registration" => array(
					"title" => esc_html__('Notify about new registration', 'trx_addons'),
					"desc" => wp_kses_data( __("Send E-mail with a new registration data to the site admin e-mail and/or to the new user's e-mail", 'trx_addons') ),
					"std" => "no",
					"options" => array(
						'no'    => esc_html__('No', 'trx_addons'),
						'both'  => esc_html__('Both', 'trx_addons'),
						'admin' => esc_html__('Admin', 'trx_addons'),
						'user'  => esc_html__('User', 'trx_addons')
					),
					"type" => "radio"
				),
			

				// Section 'API Keys'
				'api_section' => array(
					"title" => esc_html__('API', 'trx_addons'),
					"desc" => wp_kses_data( __("API Keys for some Web-services", 'trx_addons') ),
					'icon' => 'trx_addons_icon-network',
					"type" => "section"
				),
				
				'api_google_info' => array(
					"title" => esc_html__('Google API', 'trx_addons'),
					"desc" => wp_kses_data( __("Control loading Google API script and specify Google API Key to access Google map services", 'trx_addons') ),
					"type" => "info"
				),
			),

			! trx_addons_components_is_allowed('sc', 'googlemap') ? array() :
			array(
				'api_google_load' => array(
					"title" => esc_html__('Load Google API script', 'trx_addons'),
					"desc" => wp_kses_data( __("Uncheck this field to disable loading Google API script if it loaded by another plugin", 'trx_addons') ),
					"std" => "1",
					"type" => "switch"
				),
				'api_google' => array(
					"title" => esc_html__('Google API Key', 'trx_addons'),
					"desc" => wp_kses_data( __("Insert Google API Key for browsers into the field above", 'trx_addons') ),
					"dependency" => array(
						"api_google_load" => array('1')
					),
					"std" => "",
					"type" => "text"
				),
				'api_google_marker' => array(
					"title" => esc_html__('Marker icon', 'trx_addons'),
					"desc" => wp_kses_data( __('Default icon to show markers on the Google maps ', 'trx_addons') ),
					"std" => '',
					"type" => "image"
				),
				'api_google_cluster' => array(
					"title" => esc_html__('Cluster icon', 'trx_addons'),
					"desc" => wp_kses_data( __('Icon to join markers to the cluster on the Google maps ', 'trx_addons') ),
					"std" => '',
					"type" => "image"
				),
			),

			array(
				'api_google_analitics' => array(
					"title" => esc_html__('Google Analitics code',  'trx_addons'),
					"desc" => wp_kses_data( __('Specify Google Analitics code or/and any other html/js code to be inserted before the closing tag &lt;/head&gt;" on each page of this site',  'trx_addons') ),
					"std" => "",
					"type" => "textarea"
				),
				'api_google_remarketing' => array(
					"title" => esc_html__('Google Remarketing code',  'trx_addons'),
					"desc" => wp_kses_data( __('Specify Google Remarketing code or/and any other html/js code to be inserted before the closing tag &lt;/body&gt;" on each page of this site',  'trx_addons') ),
					"std" => "",
					"type" => "textarea"
				)
			),

			! trx_addons_components_is_allowed('sc', 'yandexmap') ? array() :
			array(
				'api_yandex_info' => array(
					"title" => esc_html__('Yandex API', 'trx_addons'),
					"desc" => wp_kses_data( __("Control loading Yandex API script and specify Yandex API Key to access Yandex map enterprise services", 'trx_addons') ),
					"type" => "info"
				),
				'api_yandex_load' => array(
					"title" => esc_html__('Load Yandex API script', 'trx_addons'),
					"desc" => wp_kses_data( __("Uncheck this field to disable loading Yandex API script if it loaded by another plugin", 'trx_addons') ),
					"std" => "1",
					"type" => "switch"
				),
				'api_yandex' => array(
					"title" => esc_html__('Yandex API Key', 'trx_addons'),
					"desc" => wp_kses_data( __("Insert Yandex API Key (if you have enterprise access, not need for free version Yandex API)", 'trx_addons') ),
					"dependency" => array(
						"api_yandex_load" => array('1')
					),
					"std" => "",
					"type" => "text"
				),
				'api_yandex_marker' => array(
					"title" => esc_html__('Marker icon', 'trx_addons'),
					"desc" => wp_kses_data( __('Default icon to show markers on the Yandex maps ', 'trx_addons') ),
					"std" => '',
					"type" => "image"
				),
				'api_yandex_cluster' => array(
					"title" => esc_html__('Cluster icon', 'trx_addons'),
					"desc" => wp_kses_data( __('Icon to join markers to the cluster on the Yandex maps ', 'trx_addons') ),
					"std" => '',
					"type" => "image"
				)
			),

			! trx_addons_components_is_allowed('sc', 'osmap') ? array() :
			array(
				'api_openstreet_info' => array(
					"title" => esc_html__('OpenStreetMap API', 'trx_addons'),
					"desc" => wp_kses_data( __("Control loading OpenStreetMap API script and style", 'trx_addons') ),
					"type" => "info"
				),
				'api_openstreet_load' => array(
					"title" => esc_html__('Load OpenStreetMap API script and style', 'trx_addons'),
					"desc" => wp_kses_data( __("Uncheck this field to disable loading OpenStreetMap API script and style if its loaded by another plugin", 'trx_addons') ),
					"std" => "1",
					"type" => "switch"
				),
				'api_openstreet_tiler' => array(
					"title" => esc_html__('OpenStreetMap tiler', 'trx_addons'),
					"desc" => wp_kses_data( __("Select type of the OpenStreetMap tiler", 'trx_addons') ),
					"options" => trx_addons_get_list_sc_osmap_tilers(),
					"std" => "vector",
					"type" => 'radio'
				),
				'api_openstreet_tiler_vector' => array(
					"title" => esc_html__("List of styles of the map tiler", 'trx_addons'),
					"desc" => wp_kses_data( __("Specify title, slug and URL to JSON with map style from any compatible tiler service. Token and maxZoom are optional (Token is need to access to the some services, MaxZoom is need for some tiles)", 'trx_addons') ),
					"dependency" => array(
						"api_openstreet_tiler" => array('vector')
					),
					"clone" => true,
					"std" => array(),
					"type" => "group",
					"fields" => array(
						"title" => array(
							"title" => esc_html__("Title", 'trx_addons'),
							"class" => "trx_addons_column-1_5",
							"std" => "",
							"type" => "text"
						),
						"slug" => array(
							"title" => esc_html__("Style slug (replace {style} in the next URL)", 'trx_addons'),
							"class" => "trx_addons_column-1_5",
							"std" => "",
							"type" => "text"
						),
						"url" => array(
							"title" => esc_html__("URL to JSON from the tiler service", 'trx_addons'),
							"class" => "trx_addons_column-1_5",
							"std" => "",
							"type" => "text"
						),
						"maxzoom" => array(
							"title" => esc_html__("Max Zoom", 'trx_addons'),
							"class" => "trx_addons_column-1_5",
							"min" => 1,
							"max" => 21,
							"std" => 18,
							"type" => "slider"
						),
						"token" => array(
							"title" => esc_html__("Access token (if need)", 'trx_addons'),
							"class" => "trx_addons_column-1_5",
							"std" => "",
							"type" => "text"
						),
					)
				),
				'api_openstreet_tiler_raster' => array(
					"title" => esc_html__("List of styles of the map tiler", 'trx_addons'),
					"desc" => wp_kses_data( __("Specify title, slug and URL to tiles with map style from any compatible tiler service. MaxZoom is an optional (if need for current tiles)", 'trx_addons') ),
					"dependency" => array(
						"api_openstreet_tiler" => array('raster')
					),
					"clone" => true,
					"std" => array(),
					"type" => "group",
					"fields" => array(
						"title" => array(
							"title" => esc_html__("Title", 'trx_addons'),
							"class" => "trx_addons_column-1_4",
							"std" => "",
							"type" => "text"
						),
						"slug" => array(
							"title" => esc_html__("Style slug (replace {style} in the next URL)", 'trx_addons'),
							"class" => "trx_addons_column-1_4",
							"std" => "",
							"type" => "text"
						),
						"url" => array(
							"title" => esc_html__("URL to map images from the tiler service", 'trx_addons'),
							"class" => "trx_addons_column-1_4",
							"std" => "",
							"type" => "text"
						),
						"maxzoom" => array(
							"title" => esc_html__("Max Zoom", 'trx_addons'),
							"class" => "trx_addons_column-1_5",
							"min" => 1,
							"max" => 21,
							"std" => 18,
							"type" => "slider"
						),
					)
				),
				'api_openstreet_marker' => array(
					"title" => esc_html__('Marker icon', 'trx_addons'),
					"desc" => wp_kses_data( __('Default icon to show markers on the OpenStreet maps ', 'trx_addons') ),
					"std" => '',
					"type" => "image"
				),
				'api_openstreet_cluster' => array(
					"title" => esc_html__('Cluster icon', 'trx_addons'),
					"desc" => wp_kses_data( __('Icon to join markers to the cluster on the Openstreet maps ', 'trx_addons') ),
					"std" => '',
					"type" => "image"
				)
			),
			
			array(
				'api_fb_info' => array(
					"title" => esc_html__('Facebook API', 'trx_addons'),
					"desc" => wp_kses_data( __("Facebook admins ID and other API keys", 'trx_addons') ),
					"type" => "info"
				),
				'api_fb_app_id' => array(
					"title" => esc_html__('Facebook App ID', 'trx_addons'),
					"desc" => wp_kses_data( __("Insert Facebook Application (admins) ID to insert it to the section head", 'trx_addons') ),
					"std" => "",
					"type" => "text"
				)
			),

			!trx_addons_components_is_allowed('widgets', 'instagram') ? array() :
			array(
				'api_instagram_info' => array(
					"title" => esc_html__('Instagram API', 'trx_addons'),
					"desc" => wp_kses_data( __("Get Access Token from Instagram to show photos from your account", 'trx_addons') ),
					"type" => "info"
				),
				'api_instagram_client_id' => array(
					"title" => esc_html__('Client ID', 'trx_addons'),
					"desc" => wp_kses_data( __("Client ID from Instagram Application", 'trx_addons') ),
					"std" => "",
					"type" => "text"
				),
				'api_instagram_client_secret' => array(
					"title" => esc_html__('Client Secret', 'trx_addons'),
					"desc" => wp_kses_data( __("Client Secret from Instagram Application", 'trx_addons') ),
					"std" => "",
					"type" => "text"
				),
				'api_instagram_get_access_token' => array(
					"title" => esc_html__('Access Token', 'trx_addons'),
					"desc" => wp_kses_data( __("Press this button to get Access Token from Instagram.", 'trx_addons') )
							. '<br>'
							. wp_kses_data( __("<b>Attention!</b> Before pressing this button you must log in to your account on Instagram!", 'trx_addons') ),
					"caption" => esc_html__('Get Access Token', 'trx_addons'),
					"std" => "trx_addons_api_instagram_get_access_token",
					"callback" => "trx_addons_api_instagram_get_access_token",
					"type" => "button"
				),
				'api_instagram_access_token' => array(
					"title" => esc_html__('Access Token', 'trx_addons'),
					"desc" => wp_kses_data( __("Access Token from Instagram Application", 'trx_addons') ),
					"std" => "",
					//"readonly" => true,		// Enable field to allow paste access token from another site
					"type" => "text"
				)
			),
			
			array(
				// Section 'Socials and Share'
				'socials_section' => array(
					"title" => esc_html__('Socials', 'trx_addons'),
					"desc" => wp_kses_data( __("Links to the social profiles and post's share settings", 'trx_addons') ),
					'icon' => 'trx_addons_icon-share-2',
					"type" => "section"
				),
				'socials_info' => array(
					"title" => esc_html__('Links to your social profiles', 'trx_addons'),
					"desc" => wp_kses_data( __("Links to your favorites social networks", 'trx_addons') ),
					"type" => "info"
				),
				'socials' => array(
					"title" => esc_html__("Socials", 'trx_addons'),
					"desc" => wp_kses_data( __("Clone fields group and select icon/image, specify social network's title and URL to your profile", 'trx_addons') ),
					"translate" => true,
					"clone" => true,
					"std" => array(array()),
					"type" => "group",
					"fields" => array(
						'name' => array(
							"title" => esc_html__("Icon", 'trx_addons'),
							"desc" => wp_kses_data( __('Select icon of this network', 'trx_addons') ),
							"class" => "trx_addons_column-1_5 trx_addons_new_row",
							"std" => "",
							"options" => array(),
							"style" => trx_addons_get_setting('icons_type'),
							"type" => "icons"
						),
						'title' => array(
							"title" => esc_html__('Title', 'trx_addons'),
							"desc" => wp_kses_data( __("Social network's name. If empty - icon's name will be used", 'trx_addons') ),
							"class" => "trx_addons_column-2_5",
							"std" => "",
							"type" => "text"
						),
						'url' => array(
							"title" => esc_html__('URL to your profile', 'trx_addons'),
							"desc" => wp_kses_data( __("Specify URL of your profile in this network", 'trx_addons') ),
							"class" => "trx_addons_column-2_5",
							"std" => "",
							"type" => "text"
						),
					)
				),

				'share_info' => array(
					"title" => esc_html__('URL to share posts', 'trx_addons'),
					"desc" => wp_kses_post( __("Specify URLs to share your posts in the social networks. If empty - no share post in this social network.<br>You can use next macros to include post's parts into the URL:<br><br>{link} - post's URL,<br>{title} - title of the post,<br>{descr} - excerpt of the post,<br>{image} - post's featured image URL,<br>{id} - post's ID", 'trx_addons') ),
					"type" => "info"
				),
				'share' => array(
					"title" => esc_html__("Share", 'trx_addons'),
					"desc" => wp_kses_data( __("Clone fields group and select icon/image, specify social network's title and URL to share posts", 'trx_addons') ),
					"translate" => true,
					"clone" => true,
					"std" => array(
						array('name'=>'trx_addons_icon-twitter', 'url'=>trx_addons_get_share_url('twitter')),
						array('name'=>'trx_addons_icon-facebook', 'url'=>trx_addons_get_share_url('facebook')),
						//array('name'=>'trx_addons_icon-gplus', 'url'=>trx_addons_get_share_url('gplus'), 'title'=>esc_html__('Google+', 'trx_addons')),
						//array('name'=>'trx_addons_icon-tumblr', 'url'=>trx_addons_get_share_url('tumblr')),
						//array('name'=>'trx_addons_icon-mail', 'url'=>trx_addons_get_share_url('email'), 'title'=>esc_html__('E-mail', 'trx_addons'))
					),
					"type" => "group",
					"fields" => array(
						'name' => array(
							"title" => esc_html__("Icon", 'trx_addons'),
							"desc" => wp_kses_data( __('Select icon of this network', 'trx_addons') ),
							"class" => "trx_addons_column-1_5 trx_addons_new_row",
							"std" => "",
							"options" => array(),
							"style" => trx_addons_get_setting('socials_type'),
							"type" => "icons"
						),
						'title' => array(
							"title" => esc_html__('Title', 'trx_addons'),
							"desc" => wp_kses_data( __("Social network's name. If empty - icon's name will be used", 'trx_addons') ),
							"class" => "trx_addons_column-2_5",
							"std" => "",
							"type" => "text"
						),
						'url' => array(
							"title" => esc_html__('URL to sharer', 'trx_addons'),
							"desc" => wp_kses_data( __("Specify URL to share your posts in this network", 'trx_addons') ),
							"class" => "trx_addons_column-2_5",
							"std" => "",
							"type" => "text"
						),
					)
				),
				'add_og_tags' => array(
					"title" => esc_html__('Add Open Graph tags', 'trx_addons'),
					"desc" => wp_kses_data( __("Open Graph tags are responsible for the information (picture, title, description) that appears on the wall of the user, when he clicks Share on your blog. They are used by many popular social networks such as Facebook", 'trx_addons') ),
					"std" => "1",
					"type" => "switch"
				),
				
				'emotions_info' => array(
					"title" => esc_html__('Emotions', 'trx_addons'),
					"desc" => wp_kses_data( __("Create the set of emotions to mark each post", 'trx_addons') ),
					"type" => "info"
				),
				'emotions_allowed' => array(
					"title" => esc_html__('Allow extended emotions', 'trx_addons'),
					"desc" => wp_kses_data( __("Allow extended emotions or use simple likes counter", 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'emotions' => array(
					"title" => esc_html__("Emotions", 'trx_addons'),
					"desc" => wp_kses_data( __("Clone fields group to add a new emotion", 'trx_addons') ),
					"translate" => true,
					"clone" => true,
					"std" => array(array()),
					"type" => "group",
					"dependency" => array(
						"emotions_allowed" => array('1')
					),
					"fields" => array(
						'name' => array(
							"title" => esc_html__("Icon", 'trx_addons'),
							"desc" => wp_kses_data( __('Select icon of this emotion', 'trx_addons') ),
							"class" => "trx_addons_column-1_4 trx_addons_new_row",
							"std" => "",
							"options" => array(),
							"style" => trx_addons_get_setting('icons_type'),
							"type" => "icons"
						),
						'title' => array(
							"title" => esc_html__('Title', 'trx_addons'),
							"desc" => wp_kses_data( __("Emotion's name. If empty - icon's name will be used", 'trx_addons') ),
							"class" => "trx_addons_column-3_4",
							"std" => "",
							"type" => "text"
						),
					)
				),
			
			
				// Section 'Shortcodes'
				'sc_section' => array(
					"title" => esc_html__('Shortcodes', 'trx_addons'),
					"desc" => wp_kses_data( __("Shortcodes settings", 'trx_addons') ),
					'icon' => 'trx_addons_icon-editor-code',
					"type" => "section"
				),
				'sc_anchor_info' => array(
					"title" => esc_html__('Anchor', 'trx_addons'),
					"desc" => wp_kses_data( __("Settings of the 'Anchor' shortcode", 'trx_addons') ),
					"type" => "info"
				),
				'scroll_to_anchor' => array(
					"title" => esc_html__('Scroll to Anchor', 'trx_addons'),
					"desc" => wp_kses_data( __('Scroll to Prev/Next anchor on mouse wheel', 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'update_location_from_anchor' => array(
					"title" => esc_html__('Update location from Anchor', 'trx_addons'),
					"desc" => wp_kses_data( __("Update browser location bar form the anchor's href when page is scrolling", 'trx_addons') ),
					"std" => "0",
					"type" => "switch"
				),
				'sc_form_info' => array(
					"title" => esc_html__('Form fields', 'trx_addons'),
					"desc" => wp_kses_data( __("Settings of the hover effects on the Form fields and post comments", 'trx_addons') ),
					"type" => "info"
				),
				'input_hover' => array(
					"title" => esc_html__("Input field's hover", 'trx_addons'),
					"desc" => wp_kses_data( __("Select the default hover effect of the shortcode 'form' input fields and of the comment's form (if theme support)", 'trx_addons') ),
					"std" => 'default',
					"options" => trx_addons_get_list_input_hover(),
					"type" => "select"
				),
			
		
				// Section 'Theme Specific'
				'theme_specific_section' => array(
					"title" => esc_html__('Theme specific', 'trx_addons'),
					"desc" => wp_kses_data( __("Theme specific settings", 'trx_addons') ),
					'icon' => 'trx_addons_icon-wrench',
					"type" => "section"
				),
				'columns_info' => array(
					"title" => esc_html__('Columns Grid', 'trx_addons'),
					"desc" => wp_kses_data( __("Theme-specific classes to use it instead plugin's internal classes to create columns", 'trx_addons') ),
					"type" => "info"
				),
				'columns_wrap_class' => array(
					"title" => esc_html__("Column's wrap class", 'trx_addons'),
					"desc" => wp_kses_data( __("Specify theme specific class for the column's wrap. If empty - use plugin's internal grid", 'trx_addons') ),
					"std" => '',
					"type" => "text"
				),
				'columns_wrap_class_fluid' => array(
					"title" => esc_html__("Column's wrap class for fluid columns", 'trx_addons'),
					"desc" => wp_kses_data( __("Specify theme specific class for the fluid column's wrap. If empty - use plugin's internal grid", 'trx_addons') ),
					"std" => '',
					"type" => "text"
				),
				'column_class' => array(
					"title" => esc_html__('Class for the single column', 'trx_addons'),
					"desc" => wp_kses_data( __("For example: column-$1_$2, where $1 - column width, $2 - total columns: column-1_4, column-2_3, etc. If empty - use plugin's internal grid", 'trx_addons') ),
					"std" => "",
					"type" => "text"
				)
			)
		));

		trx_addons_load_options();
	}
}


// Fill 'options' arrays when its need in the admin mode
if (!function_exists('trx_addons_before_show_options')) {
	add_filter('trx_addons_filter_before_show_options', 'trx_addons_before_show_options', 10, 2);
	function trx_addons_before_show_options($options, $post_type, $group='') {
		static $icons_list = false, $images_list = false, $svg_list = false;

		foreach ($options as $id=>$field) {

			// Recursive call for options type 'group'
			if ($field['type'] == 'group' && !empty($field['fields'])) {
				$options[$id]['fields'] = trx_addons_before_show_options($field['fields'], $post_type, $id);
				continue;
			}
			
			// Skip elements without param 'options'
			if (!isset($field['options']) || count($field['options'])>0) continue;

			// Fill the 'Socials' and 'Share' arrays or any 'icons' params type
			if (($is_social = in_array($group, array('socials', 'share')) && $id=='name') || $field['type']=='icons') {
					
				// Images list
				if ( (!empty($field['style']) && $field['style']=='images') 
					|| (empty($field['style']) && trx_addons_get_setting($is_social ? 'socials_type' : 'icons_type') == 'images')) {
					if ($images_list === false) $images_list = trx_addons_get_list_files('css/icons.png', 'png');
					$options[$id]['options'] = $images_list;
					
				// SVG list
				} else if ( (!empty($field['style']) && $field['style']=='svg') 
					|| (empty($field['style']) && trx_addons_get_setting($is_social ? 'socials_type' : 'icons_type') == 'svg')) {
					if ($svg_list === false) $svg_list = trx_addons_get_list_files('css/icons.svg', 'svg');
					$options[$id]['options'] = $svg_list;

				// Icons list
				} else {	//if ( (!empty($field['style']) && $field['style']=='icons') 
							//		|| (empty($field['style']) && trx_addons_get_setting($is_social ? 'socials_type' : 'icons_type') == 'icons')) {
					if ($icons_list === false) $icons_list = trx_addons_array_from_list(trx_addons_get_list_icons_classes());
					$options[$id]['options'] = $icons_list;
				}
			}
		}
		return $options;
	}
}


// Prepare complex field value to put into single tag's value
if (!function_exists('trx_addons_options_put_field_value')) {
	function trx_addons_options_put_field_value($field) {
		if (is_array($field['val'])) {
			$val = '';
			foreach ($field['val'] as $k=>$v) {
				$val .= ($val ? '|' : '') . $k . '=' . $v;
			}
		} else
			$val = $field['val'];
		return $val;
	}
}


// Get complex field value from POST
if (!function_exists('trx_addons_options_get_field_value')) {
	function trx_addons_options_get_field_value($name, $field) {
		$val = isset($_POST['trx_addons_options_field_'.$name])
							? trx_addons_get_value_gp('trx_addons_options_field_'.$name)
							: ( in_array( $field['type'], array( 'checkbox', 'switch' ) ) ? 0 : '');
		if (is_array($field['std']) && !is_array($val)) {
			if (!empty($val)) {
				$tmp = explode('|', $val);
				$val = array();
				foreach ($tmp as $v) {
					$v = explode('=', $v);
					$val[$v[0]] = $v[1];
				}
			} else
				$val = array();
		}
		return $val;
	}
}


// -----------------------------------------------------------------
// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
// -- Internal theme settings
// -----------------------------------------------------------------

// Internal plugin settings - user can't change it
if (!function_exists('trx_addons_init_settings')) {
	add_action( 'after_setup_theme', 'trx_addons_init_settings', 2 );
	function trx_addons_init_settings() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['settings'] = apply_filters('trx_addons_init_settings', array(
			
			// Type of socials icons: images|icons|svg - Use images or icons as pictograms of the social networks
			'socials_type' => 'icons',
			
			// Type of other icons: images|icons|svg - Use images or icons as pictograms in other shortcodes (not socials)
			'icons_type' => 'icons',
			
			// Type of icons selector: vc|internal - Use standard VC (SOW, Elementor) parameters for icons or use internal popup with theme icons
			'icons_selector' => 'vc',
			
			// Add custom layouts to the VC templates
			'layouts_to_wpb_js_templates' => false,
			
			// Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)
			'gutenberg_safe_mode' => array('elementor'),	// vc,elementor
			
			// Use our function to add context to the Gutenberg editor styles (true)
			// or core Gutenberg function (false)
			'gutenberg_add_context' => false,

			// Modify core blocks - add our parameters and classes
			'modify_gutenberg_blocks' => true,

			// Allow our shortcodes and widgets as blocks in the Gutenberg
			'allow_gutenberg_blocks' => true,

			// Allow upload SVG (disabled by default for security reasons)
			'allow_upload_svg' => false,
			
			// Allow theme loading profiler (if 'debug_mode' is 'on')
			'allow_profiler' => false,

			// Put subtitle over the title in the shortcodes
			'subtitle_above_title' => true,

			// Add our breakpoints to the Responsive section of each element
			// 'add' - add our breakpoints after Elementor's
			// 'replace' - add our breakpoints instead Elementor's
			// 'none' - don't add our breakpoints (using only Elementor's)
			'add_hide_on_xxx' => 'replace',

			// Position of tabs in the plugin's options
			'options_tabs_position' => 'vertical'
		));
	}
}


// Return internal setting value
if (!function_exists('trx_addons_get_setting')) {
	function trx_addons_get_setting($name, $default=-999999) {
		global $TRX_ADDONS_STORAGE;
		// If specified name is not exists:
		// 		if default value is not specified - display warning message and dump call's stack
		// 		else - return default value
		if ( !isset($TRX_ADDONS_STORAGE['settings'][$name]) ) {
			if ($default != -999999)
				return $default;
			else if (defined('WP_CLI'))
				return false;
			else {
				$s = '';
				if ( function_exists( 'ddo' ) ) {
					$s = debug_backtrace();
					array_shift($s);
					$s = ddo($s, 0, 3);
				}
				wp_die(
					// Translators: Add option's name to the message
					esc_html( sprintf( __( 'Undefined setting "%s"', 'trx_addons' ), $name ) )
					. ( ! empty( $s )
							? ' ' . esc_html( __( 'called from:', 'trx_addons' ) ) . "<pre>" . wp_kses_data( $s ) . '</pre>'
							: ''
							)
				);
			}
		} else
			return $TRX_ADDONS_STORAGE['settings'][$name];
	}
}
