<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package OZEUM
 * @since OZEUM 1.0.22
 */

// If this theme is a free version of premium theme
if ( ! defined( 'OZEUM_THEME_FREE' ) ) {
	define( 'OZEUM_THEME_FREE', false );
}
if ( ! defined( 'OZEUM_THEME_FREE_WP' ) ) {
	define( 'OZEUM_THEME_FREE_WP', false );
}

// If this theme is a part of Envato Elements
if ( ! defined( 'OZEUM_THEME_IN_ENVATO_ELEMENTS' ) ) {
	define( 'OZEUM_THEME_IN_ENVATO_ELEMENTS', false );
}

// If this theme support external updates
if ( ! defined( 'OZEUM_THEME_ALLOW_UPDATE' ) ) {
	define( 'OZEUM_THEME_ALLOW_UPDATE', true );
}

// If this theme uses multiple skins
if ( ! defined( 'OZEUM_ALLOW_SKINS' ) ) {
	define( 'OZEUM_ALLOW_SKINS', true );
}
if ( ! defined( 'OZEUM_DEFAULT_SKIN' ) ) {
	define( 'OZEUM_DEFAULT_SKIN', 'default' );
}
if ( ! defined( 'OZEUM_REMEMBER_SKIN' ) ) {
	define( 'OZEUM_REMEMBER_SKIN', false );
}



// Theme storage
// Attention! Must be in the global namespace to compatibility with WP CLI
//-------------------------------------------------------------------------
$GLOBALS['OZEUM_STORAGE'] = array(

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'       => 'env-themerex',

	// Generate Personal token from Envato to automatic upgrade theme
	'upgrade_token_url'   => '//build.envato.com/create-token/?default=t&purchase:download=t&purchase:list=t',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'      => '//ozeum.themerex.net',
	'theme_doc_url'       => '//ozeum.themerex.net/doc',

	'theme_upgrade_url'   => '//upgrade.themerex.net/',

	'theme_demofiles_url' => '//demofiles.themerex.net/ozeum/',
	
	'theme_rate_url'      => '//themeforest.net/download',

	'theme_custom_url' => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash',

    'theme_download_url'  => 'themeforest.net/item/ozeum-art-gallery-and-museum-wordpress-theme/25312661',

    'theme_support_url'   => '//themerex.net/support/',

    'theme_video_url'     => '//www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',

    'theme_privacy_url'   => '//themerex.net/privacy-policy/',

    'portfolio_url'       => '//themerex.net/premium/',


	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'    => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'          => array(
		// By size
		'xxl'        => array( 'max' => 1679 ),
		'xl'         => array( 'max' => 1439 ),
		'lg'         => array( 'max' => 1279 ),
		'md_over'    => array( 'min' => 1024 ),
		'md'         => array( 'max' => 1023 ),
		'sm'         => array( 'max' => 767 ),
		'sm_wp'      => array( 'max' => 600 ),
		'xs'         => array( 'max' => 479 ),
		// By device
		'wide'       => array(
			'min' => 2160
		),
		'desktop'    => array(
			'min' => 1680,
			'max' => 2159,
		),
		'notebook'   => array(
			'min' => 1280,
			'max' => 1679,
		),
		'tablet'     => array(
			'min' => 768,
			'max' => 1279,
		),
		'not_mobile' => array(
			'min' => 768
		),
		'mobile'     => array(
			'max' => 767
		),
	),
);


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'ozeum_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'ozeum_importer_set_options', 9 );
	function ozeum_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
            $rtl_slug = is_rtl() ? '-rtl' : '';
            $rtl_url = is_rtl() ? 'rtl.' : '';
            // Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Allow import/export functionality
			$options['allow_import'] = true;
			$options['allow_export'] = false;
			// Prepare demo data
            $options['demo_url'] = esc_url( ozeum_get_protocol() . '://demofiles.themerex.net/ozeum'. $rtl_slug .'/' );
			// Required plugins
			$options['required_plugins'] = array_keys( ozeum_storage_get( 'required_plugins' ) );
			// Set number of thumbnails (usually 3 - 5) to regenerate at once when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title']       = esc_html__( 'Ozeum Demo', 'ozeum' );

            $options['files']['default']['domain_dev']  =  esc_url( 'http://' . $rtl_url . 'ozeum.dv.themerex.net' );  // Developers domain
            $options['files']['default']['domain_demo'] = esc_url( 'http://' . $rtl_url . 'ozeum.themerex.net' );   // Demo-site domain

			// If theme need more demo - just copy 'default' and change required parameter
			
			//--> $options['files']['dark_demo'] = $options['files']['default'];
			//--> $options['files']['dark_demo']['title'] = esc_html__('Dark Demo', 'ozeum');
			
			// The array with theme-specific banners, displayed during demo-content import.
			// If array with banners is empty - the banners are uploaded directly from demo-content server.
			$options['banners'] = array();
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'ozeum_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'ozeum_ocdi_set_options', 9 );
	function ozeum_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Prepare demo data
			$options['demo_url'] = esc_url( ozeum_get_protocol() . ':' . ozeum_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( ozeum_storage_get( 'required_plugins' ) );
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Ozeum OCDI Demo', 'ozeum' );
			$options['files']['ocdi']['domain_demo'] = esc_url( ozeum_get_protocol() . ':' . ozeum_storage_get( 'theme_demo_url' ) );

			// If theme need more demo - just copy 'default' and change required parameter
			//--> $options['files']['dota']['title'] = esc_html__('Ozeum Demo', 'ozeum');
			//--> $options['files']['dota']['domain_demo'] = esc_url(ozeum_get_protocol().'://ozeum.themerex.net');

		}
		return $options;
	}
}



// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$ozeum_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'ozeum' ),
	'page_builders' => esc_html__( 'Page Builders', 'ozeum' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'ozeum' ),
	'socials'       => esc_html__( 'Socials and Communities', 'ozeum' ),
	'events'        => esc_html__( 'Events and Appointments', 'ozeum' ),
	'content'       => esc_html__( 'Content', 'ozeum' ),
	'other'         => esc_html__( 'Other', 'ozeum' ),
);
$ozeum_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'ozeum' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'ozeum' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $ozeum_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'ozeum' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'ozeum' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $ozeum_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'ozeum' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'ozeum' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $ozeum_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'ozeum' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'ozeum' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $ozeum_theme_required_plugins_groups['page_builders'],
	),
	'vc-extensions-bundle'       => array(
		'title'       => esc_html__( 'WPBakery PageBuilder extensions bundle', 'ozeum' ),
		'description' => esc_html__( "Many shortcodes for the WPBakery PageBuilder", 'ozeum' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'vc-extensions-bundle.png',
		'group'       => $ozeum_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'ozeum' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'ozeum' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $ozeum_theme_required_plugins_groups['ecommerce'],
	),
    'elegro-payment'             => array(
        'title'       => esc_html__( 'Elegro Crypto Payment', 'ozeum' ),
        'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'ozeum' ),
        'required'    => false,
        'logo'        => 'elegro-payment.png',
        'group'       => $ozeum_theme_required_plugins_groups['ecommerce'],
    ),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'ozeum' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'ozeum' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $ozeum_theme_required_plugins_groups['socials'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'ozeum' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $ozeum_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'ozeum' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'ozeum' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $ozeum_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'ozeum' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'essential-grid.png',
		'group'       => $ozeum_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'ozeum' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $ozeum_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'ozeum' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'ozeum' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $ozeum_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'ozeum' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'ozeum' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $ozeum_theme_required_plugins_groups['other'],
	),
    'trx_popup'                  => array(
        'title'       => esc_html__( 'ThemeREX Popup', 'ozeum' ),
        'description' => esc_html__( "Add popup to your site.", 'ozeum' ),
        'required'    => false,
        'logo'        => 'trx_popup.png',
        'group'       => $ozeum_theme_required_plugins_groups['other'],
    ),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'ozeum' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'ozeum' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $ozeum_theme_required_plugins_groups['other'],
	)

);

if ( OZEUM_THEME_FREE ) {
	unset( $ozeum_theme_required_plugins['js_composer'] );
	unset( $ozeum_theme_required_plugins['vc-extensions-bundle'] );
	unset( $ozeum_theme_required_plugins['easy-digital-downloads'] );
	unset( $ozeum_theme_required_plugins['give'] );
	unset( $ozeum_theme_required_plugins['bbpress'] );
	unset( $ozeum_theme_required_plugins['booked'] );
	unset( $ozeum_theme_required_plugins['content_timeline'] );
	unset( $ozeum_theme_required_plugins['mp-timetable'] );
	unset( $ozeum_theme_required_plugins['learnpress'] );
	unset( $ozeum_theme_required_plugins['the-events-calendar'] );
	unset( $ozeum_theme_required_plugins['calculated-fields-form'] );
	unset( $ozeum_theme_required_plugins['essential-grid'] );
	unset( $ozeum_theme_required_plugins['revslider'] );
	unset( $ozeum_theme_required_plugins['ubermenu'] );
	unset( $ozeum_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $ozeum_theme_required_plugins['envato-market'] );
}

// Add plugins list to the global storage
$GLOBALS['OZEUM_STORAGE']['required_plugins'] = $ozeum_theme_required_plugins;



// THEME-SPECIFIC BLOG LAYOUTS
//----------------------------------------------
$ozeum_theme_blog_styles = array(
	'excerpt' => array(
		'title'   => esc_html__( 'Standard', 'ozeum' ),
		'archive' => 'index-excerpt',
		'item'    => 'content-excerpt',
		'styles'  => 'excerpt',
		'icon'    => "images/theme-options/blog-style/excerpt.png",
	),
	'plain' => array(
		'title'   => esc_html__( 'Plain', 'ozeum' ),
		'archive' => 'index-plain',
		'item'    => 'content-plain',
		'styles'  => 'plain',
		'icon'    => "images/theme-options/blog-style/plain.png",
	),
	'classic' => array(
		'title'   => esc_html__( 'Classic', 'ozeum' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'classic',
		'icon'    => "images/theme-options/blog-style/classic-%d.png",
		'new_row' => true,
	),
);
if ( ! OZEUM_THEME_FREE ) {
	$ozeum_theme_blog_styles['masonry']   = array(
		'title'   => esc_html__( 'Masonry', 'ozeum' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'masonry',
		'icon'    => "images/theme-options/blog-style/masonry-%d.png",
		'new_row' => true,
	);
	$ozeum_theme_blog_styles['portfolio'] = array(
		'title'   => esc_html__( 'Portfolio', 'ozeum' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio',
		'columns' => array( 2, 3, 4 ),
		'styles'  => 'portfolio',
		'icon'    => "images/theme-options/blog-style/portfolio-%d.png",
		'new_row' => true,
	);
	$ozeum_theme_blog_styles['gallery']   = array(
		'title'   => esc_html__( 'Gallery', 'ozeum' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio-gallery',
		'columns' => array( 2, 3, 4 ),
		'styles'  => array( 'portfolio', 'gallery' ),
		'icon'    => "images/theme-options/blog-style/gallery-%d.png",
		'new_row' => true,
	);
	$ozeum_theme_blog_styles['chess']     = array(
		'title'   => esc_html__( 'Chess', 'ozeum' ),
		'archive' => 'index-chess',
		'item'    => 'content-chess',
		'columns' => array( 1, 2, 3 ),
		'styles'  => 'chess',
		'icon'    => "images/theme-options/blog-style/chess-%d.png",
		'new_row' => true,
	);
}

// Add list of blog styles to the global storage
$GLOBALS['OZEUM_STORAGE']['blog_styles'] = $ozeum_theme_blog_styles;



// THEME-SPECIFIC SINGLE POST LAYOUTS
//----------------------------------------------
$ozeum_theme_single_styles = array(
	'in-over'    => array(
		'title'       => esc_html__( 'Standard 1', 'ozeum' ),
		'description' => esc_html__( 'The image inside the content area, the title over image', 'ozeum' ),
		'styles'      => 'in-over',
		'icon'        => "images/theme-options/single-style/in-over.png",
	),
	'in-sticky'  => array(
		'title'       => esc_html__( 'Standard 2', 'ozeum' ),
		'description' => esc_html__( 'The image inside the content area, the title is stick at the bottom side of the image', 'ozeum' ),
		'styles'      => 'in-sticky',
		'icon'        => "images/theme-options/single-style/in-sticky.png",
	),
	'in-below'   => array(
		'title'       => esc_html__( 'Standard 3', 'ozeum' ),
		'description' => esc_html__( 'The image inside the content area, the title below image', 'ozeum' ),
		'styles'      => 'in-below',
		'icon'        => "images/theme-options/single-style/in-below.png",
	),
	'in-above'   => array(
		'title'       => esc_html__( 'Standard 4', 'ozeum' ),
		'description' => esc_html__( 'The image inside the content area, the title above image', 'ozeum' ),
		'styles'      => 'in-above',
		'icon'        => "images/theme-options/single-style/in-above.png",
	),
	'out-over-boxed'   => array(
		'title'       => esc_html__( 'Boxed 1', 'ozeum' ),
		'description' => esc_html__( 'Boxed image above the content area, the title over image', 'ozeum' ),
		'styles'      => 'out-over-boxed',
		'new_row'     => true,
		'icon'        => "images/theme-options/single-style/out-over-boxed.png",
	),
	'out-sticky-boxed' => array(
		'title'       => esc_html__( 'Boxed 2', 'ozeum' ),
		'description' => esc_html__( 'Boxed image above the content area, the title is stick at the bottom side of the image', 'ozeum' ),
		'styles'      => 'out-sticky-boxed',
		'icon'        => "images/theme-options/single-style/out-sticky-boxed.png",
	),
	'out-below-boxed'  => array(
		'title'       => esc_html__( 'Boxed 3', 'ozeum' ),
		'description' => esc_html__( 'Boxed image above the content area, the title below image', 'ozeum' ),
		'styles'      => 'out-below-boxed',
		'icon'        => "images/theme-options/single-style/out-below-boxed.png",
	),
	'out-over-fullwidth'   => array(
		'title'       => esc_html__( 'Fullwidth 1', 'ozeum' ),
		'description' => esc_html__( 'Fullwidth image above the content area, the title over image', 'ozeum' ),
		'styles'      => 'out-over-fullwidth',
		'new_row'     => true,
		'icon'        => "images/theme-options/single-style/out-over-fullwidth.png",
	),
	'out-sticky-fullwidth' => array(
		'title'       => esc_html__( 'Fullwidth 2', 'ozeum' ),
		'description' => esc_html__( 'Fullwidth image above the content area, the title is stick at the bottom side of the image', 'ozeum' ),
		'styles'      => 'out-sticky-fullwidth',
		'icon'        => "images/theme-options/single-style/out-sticky-fullwidth.png",
	),
	'out-below-fullwidth'  => array(
		'title'       => esc_html__( 'Fullwidth 3', 'ozeum' ),
		'description' => esc_html__( 'Fullwidth image above the content area, the title below image', 'ozeum' ),
		'styles'      => 'out-below-fullwidth',
		'icon'        => "images/theme-options/single-style/out-below-fullwidth.png",
	),
);

// Add list of single post styles to the global storage
$GLOBALS['OZEUM_STORAGE']['single_styles'] = $ozeum_theme_single_styles;


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'ozeum_customizer_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'ozeum_customizer_theme_setup1', 1 );
	function ozeum_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		ozeum_storage_set(
			'settings', array(

				'duplicate_options'       => 'child',                   // none  - use separate options for the main and the child-theme
																		// child - duplicate theme options from the main theme to the child-theme only
																		// both  - sinchronize changes in the theme options between main and child themes

				'customize_refresh'       => 'auto',                    // Refresh method for preview area in the Appearance - Customize:
																		// auto - refresh preview area on change each field with Theme Options
																		// manual - refresh only obn press button 'Refresh' at the top of Customize frame

				'options_tabs_position'   => 'vertical',                // Position of tabs in the Theme and ThemeREX Addons options

				'allow_subtabs'           => true,						// Display sections as subtabs of panels in the Theme Options.
																		// If false - show sections as accordion.

				'max_load_fonts'          => 5,                         // Max fonts number to load from Google fonts or from uploaded fonts

				'comment_after_name'      => true,                      // Place 'comment' field after the 'name' and 'email'

				'show_author_avatar'      => true,                      // Display author's avatar in the post meta

				'icons_selector'          => 'internal',                // Icons selector in the shortcodes:
																		// vc (default) - standard VC (very slow) or Elementor's icons selector (not support images and svg)
																		// internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

				'icons_type'              => 'icons',                   // Type of icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present icons
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'socials_type'            => 'icons',                   // Type of socials icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present social networks
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'check_min_version'       => true,                      // Check if exists a .min version of .css and .js and return path to it
																		// instead the path to the original file
																		// (if debug_mode is on and modification time of the original file < time of the .min file)

				'autoselect_menu'         => false,                     // Show any menu if no menu selected in the location 'main_menu'
																		// (for example, the theme is just activated)

				'disable_jquery_ui'       => false,                     // Prevent loading custom jQuery UI libraries in the third-party plugins

				'use_mediaelements'       => true,                      // Load script "Media Elements" to play video and audio

				'tgmpa_upload'            => false,                     // Allow upload not pre-packaged plugins via TGMPA

				'allow_no_image'          => false,                     // Allow to use theme-specific image placeholder if no image present in the blog, related posts, post navigation, etc.

				'separate_schemes'        => true,                      // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

				'allow_fullscreen'        => false,                     // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
																		// In the Page Options this styles are present always
																		// (can be removed if filter 'ozeum_filter_allow_fullscreen' return false)

				'attachments_navigation'  => false,                     // Add arrows on the single attachment page to navigate to the prev/next attachment

				'gutenberg_safe_mode'     => array(),                   // 'vc', 'elementor' - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)

				'gutenberg_add_context'   => false,                     // Add context to the Gutenberg editor styles with our method (if true - use if any problem with editor styles) or use native Gutenberg way via add_editor_style() (if false - used by default)

				'modify_gutenberg_blocks' => true,                      // Modify core blocks - add our parameters and classes

				'allow_gutenberg_blocks'  => true,                      // Allow our shortcodes and widgets as blocks in the Gutenberg (not ready yet - in the development now)

				'subtitle_above_title'    => true,                      // Put subtitle above the title in the shortcodes

				'add_hide_on_xxx'         => 'replace',                 // Add our breakpoints to the Responsive section of each element
																		// 'add' - add our breakpoints after Elementor's
																		// 'replace' - add our breakpoints instead Elementor's
																		// 'none' - don't add our breakpoints (using only Elementor's)
			)
		);

		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		ozeum_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'ozeum' ),
					'description' => esc_html__( 'Colors of the main content area', 'ozeum' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'ozeum' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'ozeum' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'ozeum' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'ozeum' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'ozeum' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'ozeum' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'ozeum' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'ozeum' ),
				),
			)
		);
		ozeum_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'ozeum' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'ozeum' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'ozeum' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'ozeum' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'ozeum' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'ozeum' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'ozeum' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'ozeum' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'ozeum' ),
					'description' => esc_html__( 'Color of the plain text inside this block', 'ozeum' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'ozeum' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'ozeum' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'ozeum' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'ozeum' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'ozeum' ),
					'description' => esc_html__( 'Color of the links inside this block', 'ozeum' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'ozeum' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'ozeum' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Link 2', 'ozeum' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'ozeum' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Link 2 hover', 'ozeum' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'ozeum' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Link 3', 'ozeum' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'ozeum' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Link 3 hover', 'ozeum' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'ozeum' ),
				),
			)
		);
		
		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		ozeum_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Parameters to set order of schemes in the css
		ozeum_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if ( ! function_exists( 'ozeum_create_theme_options' ) ) {

	function ozeum_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'ozeum' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( ozeum_storage_get( 'schemes' ) ) < 2;

		ozeum_storage_set(

			'options', array(

				// 'Logo & Site Identity'
				//---------------------------------------------
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'ozeum' ),
					'desc'     => '',
					'priority' => 10,
					'icon'     => 'icon-home-2',
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'ozeum' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'ozeum' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'ozeum' ) ),
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'ozeum' ),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'logo_zoom'                     => array(
					'title'      => esc_html__( 'Logo zoom', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Zoom the logo (set 1 to leave original size). For this parameter to affect images, their max-height should be specified in "em" instead of "px" when creating a header. In this case maximum size of logo depends on the actual size of the picture.', 'ozeum' ) ),
					'std'        => 1,
					'min'        => 0.2,
					'max'        => 2,
					'step'       => 0.1,
					'refresh'    => false,
					'show_value' => true,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'slider',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'ozeum' ) ),
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'ozeum' ) ),
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'ozeum' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'ozeum' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'ozeum' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'ozeum' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_side'                     => array(
					'title' => esc_html__( 'Logo for the side menu', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu', 'ozeum' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'logo_side_retina'              => array(
					'title'      => esc_html__( 'Logo for the side menu on Retina', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'ozeum' ) ),
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'image',
				),



				// 'General settings'
				//---------------------------------------------
				'general'                       => array(
					'title'    => esc_html__( 'General', 'ozeum' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'icon'     => 'icon-settings',
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'ozeum' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'ozeum' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'qsetup'   => esc_html__( 'General', 'ozeum' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => ozeum_get_list_body_styles( false ),
					'type'     => 'choice',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'ozeum' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1170,
					'min'        => 1000,
					'max'        => 1600,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'page',               // SASS variable's name to preview changes 'on fly'
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'slider',
				),
				'page_boxed_extra'             => array(
					'title'      => esc_html__( 'Boxed page extra spaces', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Width of the extra side space on boxed pages', 'ozeum' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'std'        => 60,
					'min'        => 0,
					'max'        => 150,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'page_boxed_extra',   // SASS variable's name to preview changes 'on fly'
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'ozeum' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'ozeum' ),
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Page margins', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Add margins above and below the content area', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'options'  => ozeum_get_list_remove_margins(),
					'type'     => 'choice',
				),

				'general_menu_info'             => array(
					'title' => esc_html__( 'Navigation', 'ozeum' ),
					'desc'  => '',
					'type'  => OZEUM_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_side'                     => array(
					'title'    => esc_html__( 'Sidemenu position', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position of the side menu - panel with icons (ancors) for inner-page navigation. Use this menu if shortcodes "Ancor" are present on the page.', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'      => 'none',
					'options'  => array(
						'hide'  => array(
										'title' => esc_html__( 'No menu', 'ozeum' ),
										'icon'  => 'images/theme-options/menu-side/hide.png',
									),
						'left'  => array(
										'title' => esc_html__( 'Left menu', 'ozeum' ),
										'icon'  => 'images/theme-options/menu-side/left.png',
									),
						'right' => array(
										'title' => esc_html__( 'Right menu', 'ozeum' ),
										'icon'  => 'images/theme-options/menu-side/right.png',
									),
					),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'choice',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'menu_side' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'menu_side' => array( 'left', 'right' ),
						'menu_side_icons' => array( 1 )
					),
					'std'        => 0,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'ozeum' ) ),
					'std'   => 1,
					'type'  => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'ozeum' ),
					'options'  => array(),
					'type'     => 'choice',
				),
				'sidebar_position_ss'       => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'ozeum' ),
					'desc'     => wp_kses_data( __( "Select position to move sidebar (if it's not hidden) on the small screen - above or below the content", 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_ss_single'
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'ozeum' ),
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type'              => array(
					'title'    => esc_html__( 'Sidebar style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => ozeum_get_list_header_footer_types(),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style'                 => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type' => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
						'sidebar_type'     => array( 'default')
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'ozeum' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'ozeum' ) ),
					'std'        => 370,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'ozeum' ) ),
					'std'        => 30,
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Expand content', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'ozeum' ) ),
					'refresh' => false,
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'options' => ozeum_get_list_expand_content(),
					'std'     => 1,
					'type'    => 'choice',
				),

				'general_widgets_info'          => array(
					'title' => esc_html__( 'Additional widgets', 'ozeum' ),
					'desc'  => '',
					'type'  => OZEUM_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page'            => array(
					'title'    => esc_html__( 'Widgets at the top of the page', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'ozeum' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content'         => array(
					'title'    => esc_html__( 'Widgets above the content', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'ozeum' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content'         => array(
					'title'    => esc_html__( 'Widgets below the content', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'ozeum' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page'            => array(
					'title'    => esc_html__( 'Widgets at the bottom of the page', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'ozeum' ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'ozeum' ) ),
					'std'        => 0,
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'show_value' => true,
					'units'      => 'px',
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => 'hidden',   //OZEUM_THEME_FREE ? 'hidden' : 'slider'
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'ozeum' ),
					'desc'  => '',
					'type'  => OZEUM_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'ozeum' ) ),
					'std'   => 0,
					'type'  => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'ozeum'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'ozeum') ),
                    "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'ozeum'), 'ozeum_kses_content' ),
					"type"  => "textarea"
				),



				// 'Header'
				//---------------------------------------------
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'ozeum' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'icon'     => 'icon-header',
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'std'      => 'default',
					'options'  => ozeum_get_list_header_footer_types(),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => 'main-header',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill the whole screen. Used only if the header has a background image', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'std'      => 0,
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 1,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header zoom', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'ozeum' ) ),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'show_value' => true,
					'refresh' => false,
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'slider',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'ozeum' ) ),
					'type'  => 'info',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'ozeum' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'ozeum' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'select',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'dependency' => array(
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => ozeum_get_list_range( 0, 6 ),
					'type'       => 'select',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'ozeum' ),
					'desc'  => '',
					'type'  => OZEUM_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'ozeum' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'std'      => 0,
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'ozeum' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'ozeum' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'ozeum' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'ozeum' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'ozeum' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'ozeum' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'ozeum' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'ozeum' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),



				// 'Footer'
				//---------------------------------------------
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'ozeum' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'icon'     => 'icon-footer',
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'ozeum' ),
					),
					'std'      => 'default',
					'options'  => ozeum_get_list_header_footer_types(),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'ozeum' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => 'main-footer',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'ozeum' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'ozeum' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => ozeum_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'ozeum' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'ozeum' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'ozeum' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'ozeum' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'ozeum' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! ozeum_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'ozeum' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y} by ThemeRex. All rights reserved.', 'ozeum' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),



				// 'Mobile version'
				//---------------------------------------------
				'mobile'                        => array(
					'title'    => esc_html__( 'Mobile', 'ozeum' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 55,
					'icon'     => 'icon-smartphone',
					'type'     => 'section',
				),

				'mobile_header_info'            => array(
					'title' => esc_html__( 'Header on the mobile device', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_mobile'            => array(
					'title'    => esc_html__( 'Header style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_header_footer_types( true ),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_mobile'           => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'dependency' => array(
						'header_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_mobile'        => array(
					'title'    => esc_html__( 'Header position', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),

				'mobile_sidebar_info'           => array(
					'title' => esc_html__( 'Sidebar on the mobile device', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => 'choice',
				),
				'sidebar_type_mobile'           => array(
					'title'    => esc_html__( 'Sidebar style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_header_footer_types( true ),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_mobile'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on mobile devices', 'ozeum' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
						'sidebar_type_mobile' => array( 'default' )
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_mobile'         => array(
					'title'   => esc_html__( 'Expand content', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden on mobile devices', 'ozeum' ) ),
					'refresh' => false,
					'dependency' => array(
						'sidebar_position_mobile' => array( 'hide', 'inherit' ),
					),
					'std'     => 'inherit',
					'options' => ozeum_get_list_expand_content( true ),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'choice',
				),

				'mobile_footer_info'           => array(
					'title' => esc_html__( 'Footer on the mobile device', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'footer_type_mobile'           => array(
					'title'    => esc_html__( 'Footer style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_header_footer_types( true ),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'footer_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'dependency' => array(
						'footer_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets_mobile'        => array(
					'title'      => esc_html__( 'Footer widgets', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'ozeum' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns_mobile'        => array(
					'title'      => esc_html__( 'Footer columns', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'ozeum' ) ),
					'dependency' => array(
						'footer_type_mobile'    => array( 'default' ),
						'footer_widgets_mobile' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => ozeum_get_list_range( 0, 6 ),
					'type'       => 'select',
				),



				// 'Blog'
				//---------------------------------------------
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'ozeum' ) ),
					'priority' => 70,
					'icon'     => 'icon-page',
					'type'     => 'panel',
				),


				// Blog - Posts page
				//---------------------------------------------
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'ozeum' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'ozeum' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'ozeum' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'ozeum' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'ozeum' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'ozeum' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => array(
						'excerpt'  => esc_html__( 'Excerpt', 'ozeum' ),
						'fullpost' => esc_html__( 'Full post', 'ozeum' ),
					),
					'type'       => 'radio',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'ozeum' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 45,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'ozeum' ) ),
					'std'     => 2,
					'options' => ozeum_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'ozeum' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'options'    => array(
						'pages'    => array(
											'title' => esc_html__( 'Page numbers', 'ozeum' ),
											'icon'  => 'images/theme-options/pagination/page-numbers.png',
											),
						'links'    => array(
											'title' => esc_html__( 'Older/Newest', 'ozeum' ),
											'icon'  => 'images/theme-options/pagination/older-newest.png',
											),
						'more'     => array(
											'title' => esc_html__( 'Load more', 'ozeum' ),
											'icon'  => 'images/theme-options/pagination/load-more.png',
											),
						'infinite' => array(
											'title' => esc_html__( 'Infinite scroll', 'ozeum' ),
											'icon'  => 'images/theme-options/pagination/infinite-scroll.png',
											),
					),
					'type'       => 'choice',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Post animation', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'none',
					'options'    => array(),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'disable_animation_on_mobile'   => array(
					'title'      => esc_html__( 'Disable animation on mobile', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Disable any posts animation on mobile devices', 'ozeum' ) ),
					'std'        => 0,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style'                               => array( 'portfolio', 'gallery' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'video_in_popup'                => array(
					'title'      => esc_html__( 'Open video in the popup on a blog archive', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Open the video from posts in the popup (if plugin "ThemeREX Addons" is installed) or play the video instead the cover image', 'ozeum' ) ),
					'std'        => 0,
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare'                                  => 'or',
						'#page_template'                           => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'type'       => 'switch',
				),
				'open_full_post_in_blog'        => array(
					'title'      => esc_html__( 'Open full post in blog', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Allow to open the full version of the post directly in the blog feed. Attention! Applies only to 1 column layouts!', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'        => 0,
					'type'       => 'switch',
				),
				'open_full_post_hide_author'    => array(
					'title'      => esc_html__( 'Hide author bio', 'ozeum' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when open the full version of the post directly in the blog feed.", 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'open_full_post_hide_related'   => array(
					'title'      => esc_html__( 'Hide related posts', 'ozeum' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when open the full version of the post directly in the blog feed.", 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'open_full_post_in_blog' => array( 1 ),
					),
					'std'        => 1,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_header_footer_types( true ),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_fullheight_blog'        => array(
					'title'    => esc_html__( 'Header fullheight', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_checkbox_values( true ),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_wide_blog'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'ozeum' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_checkbox_values( true ),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'ozeum' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'ozeum' ),
					'type'    => 'choice',
				),
				'sidebar_position_ss_blog'  => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'ozeum' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'qsetup'   => esc_html__( 'General', 'ozeum' ),
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type_blog'           => array(
					'title'    => esc_html__( 'Sidebar style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => ozeum_get_list_header_footer_types(),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_blog'            => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'ozeum' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
						'sidebar_type_blog'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'ozeum' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Expand content', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'ozeum' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => ozeum_get_list_expand_content( true ),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'choice',
				),

				'blog_widgets_info'             => array(
					'title' => esc_html__( 'Additional widgets', 'ozeum' ),
					'desc'  => '',
					'type'  => OZEUM_THEME_FREE ? 'hidden' : 'info',
				),
				'widgets_above_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the top of the page', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'ozeum' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_above_content_blog'    => array(
					'title'   => esc_html__( 'Widgets above the content', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'ozeum' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_content_blog'    => array(
					'title'   => esc_html__( 'Widgets below the content', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'ozeum' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'widgets_below_page_blog'       => array(
					'title'   => esc_html__( 'Widgets at the bottom of the page', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'ozeum' ) ),
					'std'     => 'hide',
					'options' => array(),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'ozeum' ),
					'desc'  => wp_kses_data( __( "Select or upload an image used as placeholder for posts without a featured image. Placeholder is used on the blog stream page only (no placeholder in single post), and only in those styles of it where non-using featured image doesn't seem appropriate.", 'ozeum' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'ozeum' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'ozeum' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'ozeum' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'ozeum' ),
						'columns' => esc_html__( 'Mini-cards', 'ozeum' ),
					),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'ozeum' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'ozeum' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=0|date=1|views=0|likes=0|comments=0|author=0|share=0|edit=0',
					'options'    => ozeum_get_list_meta_parts(),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'checklist',
				),
				'use_blog_archive_pages'        => array(
					'title'      => esc_html__( 'Use "Blog Archive" page settings on the post list', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Apply options and content of pages created with the template "Blog Archive" for some type of posts and / or taxonomy when viewing feeds of posts of this type and taxonomy.', 'ozeum' ) ),
					'std'        => 0,
					'type'       => 'switch',
				),

				// Blog - Single posts
				//---------------------------------------------
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'ozeum' ) ),
					'type'  => 'section',
				),

				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_single'            => array(
					'title'    => esc_html__( 'Header style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_header_footer_types( true ),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'header_style_single'           => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'dependency' => array(
						'header_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_single'        => array(
					'title'    => esc_html__( 'Header position', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_fullheight_single'      => array(
					'title'    => esc_html__( 'Header fullheight', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'ozeum' ) ),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_checkbox_values( true ),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'header_wide_single'            => array(
					'title'      => esc_html__( 'Header fullwidth', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'ozeum' ) ),
					'dependency' => array(
						'header_type_single' => array( 'default' ),
					),
					'std'      => 'inherit',
					'options'  => ozeum_get_list_checkbox_values( true ),
					'type'     => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),

				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'ozeum' ) ),
					'std'     => 'inherit',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'options' => array(),
					'type'    => 'choice',
				),
				'sidebar_position_ss_single'    => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the single posts on the small screen - above or below the content', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
					'options'  => array(),
					'type'     => 'radio',
				),
				'sidebar_type_single'           => array(
					'title'    => esc_html__( 'Sidebar style', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'default',
					'options'  => ozeum_get_list_header_footer_types(),
					'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
				),
				'sidebar_style_single'            => array(
					'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                    'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'custom' ),
					),
					'std'        => 'sidebar-custom-sidebar',
					'options'    => array(),
					'type'       => 'select',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
						'sidebar_type_single'     => array( 'default' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_single'         => array(
					'title'   => esc_html__( 'Expand content', 'ozeum' ),
					'desc'    => wp_kses_data( __( 'Expand the content width on the single posts if the sidebar is hidden', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'refresh' => false,
					'std'     => 'inherit',
					'options' => ozeum_get_list_expand_content( true ),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'choice',
				),

				'blog_single_title_info'        => array(
					'title' => esc_html__( 'Featured image and title', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'single_style'                  => array(
					'title'      => esc_html__( 'Single style', 'ozeum' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'        => 'in-below',
					'qsetup'     => esc_html__( 'General', 'ozeum' ),
					'options'    => array(),
					'type'       => 'choice',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'ozeum' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'   => '',
					'hidden' => true,
					'type'  => 'text',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'ozeum' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'ozeum' ) ),
					'std'   => 1,
					'type'  => 'switch',
				),
				'meta_parts_single'             => array(
					'title'      => esc_html__( 'Post meta', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'ozeum' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'ozeum' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|date=1|views=0|likes=0|comments=0|author=0|share=0|edit=0',
					'options'    => ozeum_get_list_meta_parts(),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'checklist',
				),
				'show_share_links'              => array(
					'title' => esc_html__( 'Show share links', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Display share links on the single post', 'ozeum' ) ),
					'std'   => 1,
					'type'  => ! ozeum_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'ozeum' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'ozeum' ) ),
					'std'   => 1,
					'type'  => 'switch',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'ozeum' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'std'      => 1,
					'type'     => 'switch',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'classic',
					'options'    => array(
						'modern'  => esc_html__( 'Modern', 'ozeum' ),
						'classic' => esc_html__( 'Classic', 'ozeum' ),
						'wide'    => esc_html__( 'Wide', 'ozeum' ),
						'list'    => esc_html__( 'List', 'ozeum' ),
						'short'   => esc_html__( 'Short', 'ozeum' ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'inside'        => esc_html__( 'Inside the content (fullwidth)', 'ozeum' ),
						'inside_left'   => esc_html__( 'At left side of the content', 'ozeum' ),
						'inside_right'  => esc_html__( 'At right side of the content', 'ozeum' ),
						'below_content' => esc_html__( 'After the content', 'ozeum' ),
						'below_page'    => esc_html__( 'After the content & sidebar', 'ozeum' ),
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'related_position_inside'       => array(
					'title'      => esc_html__( 'Before # paragraph', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Before what paragraph should related posts appear? If 0 - randomly.', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'inside_left', 'inside_right' ),
					),
					'std'        => 2,
					'options'    => ozeum_get_list_range( 0, 9 ),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'min'        => 1,
					'max'        => 9,
					'show_value' => true,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'slider',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page?', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'below_content', 'below_page' ),
					),
					'std'        => 2,
					'options'    => ozeum_get_list_range( 1, 6 ),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'ozeum'),
						'side'    => esc_html__('Side', 'ozeum'),
						'outside' => esc_html__('Outside', 'ozeum'),
						'top'     => esc_html__('Top', 'ozeum'),
						'bottom'  => esc_html__('Bottom', 'ozeum')
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'select',
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'ozeum'),
						'bottom'  => esc_html__('Bottom', 'ozeum')
					),
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space between slides', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Space between slides in the related posts slider', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'ozeum' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'text',
				),
				'posts_navigation_info'      => array(
					'title' => esc_html__( 'Posts navigation', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'posts_navigation'           => array(
					'title'   => esc_html__( 'Show posts navigation', 'ozeum' ),
					'desc'    => wp_kses_data( __( "Show posts navigation on the single post's pages", 'ozeum' ) ),
					'std'     => 'links',
					'options' => array(
						'none'   => esc_html__('None', 'ozeum'),
						'links'  => esc_html__('Prev/Next links', 'ozeum'),
						'scroll' => esc_html__('Autoload next post', 'ozeum')
					),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'posts_navigation_fixed'     => array(
					'title'      => esc_html__( 'Fixed posts navigation', 'ozeum' ),
					'desc'       => wp_kses_data( __( "Make posts navigation fixed position. Display it when the content of the article is inside the window.", 'ozeum' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'links' ),
					),
					'std'        => 1,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_scroll_which_block'  => array(
					'title'   => esc_html__( 'Which block to load?', 'ozeum' ),
					'desc'    => wp_kses_data( __( "Load only the content of the next article or the article and sidebar together?", 'ozeum' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'     => 'article',
					'options' => array(
						'article' => array(
										'title' => esc_html__( 'Only content', 'ozeum' ),
										'icon'  => 'images/theme-options/posts-navigation-scroll-which-block/article.png',
									),
						'wrapper' => array(
										'title' => esc_html__( 'Full post', 'ozeum' ),
										'icon'  => 'images/theme-options/posts-navigation-scroll-which-block/wrapper.png',
									),
					),
					'type'    => OZEUM_THEME_FREE ? 'hidden' : 'choice',
				),
				'posts_navigation_scroll_hide_author'  => array(
					'title'      => esc_html__( 'Hide author bio', 'ozeum' ),
					'desc'       => wp_kses_data( __( "Hide author bio after post content when infinite scroll is used.", 'ozeum' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_scroll_hide_related'  => array(
					'title'      => esc_html__( 'Hide related posts', 'ozeum' ),
					'desc'       => wp_kses_data( __( "Hide related posts after post content when infinite scroll is used.", 'ozeum' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 0,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_navigation_scroll_hide_comments' => array(
					'title'      => esc_html__( 'Hide comments', 'ozeum' ),
					'desc'       => wp_kses_data( __( "Hide comments after post content when infinite scroll is used.", 'ozeum' ) ),
					'dependency' => array(
						'posts_navigation' => array( 'scroll' ),
					),
					'std'        => 1,
					'type'       => OZEUM_THEME_FREE ? 'hidden' : 'switch',
				),
				'posts_banners_info'      => array(
					'title' => esc_html__( 'Posts banners', 'ozeum' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_banner_link'     => array(
					'title' => esc_html__( 'Header banner link', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'header_banner_img'     => array(
					'title' => esc_html__( 'Header banner image', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'header_banner_height'  => array(
					'title' => esc_html__( 'Header banner height', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'type'       => 'text',
				),
				'header_banner_code'     => array(
					'title'      => esc_html__( 'Header banner code', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'footer_banner_link'     => array(
					'title' => esc_html__( 'Footer banner link', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'footer_banner_img'     => array(
					'title' => esc_html__( 'Footer banner image', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'footer_banner_height'  => array(
					'title' => esc_html__( 'Footer banner height', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Specify minimal height of the banner (in "px" or "em"). For example: 15em', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'type'       => 'text',
				),
				'footer_banner_code'     => array(
					'title'      => esc_html__( 'Footer banner code', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'sidebar_banner_link'     => array(
					'title' => esc_html__( 'Sidebar banner link', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'sidebar_banner_img'     => array(
					'title' => esc_html__( 'Sidebar banner image', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'sidebar_banner_code'     => array(
					'title'      => esc_html__( 'Sidebar banner code', 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'background_banner_link'     => array(
					'title' => esc_html__( "Post's background banner link", 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Insert URL of the banner', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'   => '',
					'type'  => 'text',
				),
				'background_banner_img'     => array(
					'title' => esc_html__( "Post's background banner image", 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select image to display at the backgound', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'background_banner_code'     => array(
					'title'      => esc_html__( "Post's background banner code", 'ozeum' ),
					'desc'       => wp_kses_data( __( 'Embed html code', 'ozeum' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Banners', 'ozeum' ),
					),
					'std'        => '',
					'allow_html' => true,
					'type'       => 'textarea',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),



				// 'Colors'
				//---------------------------------------------
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'ozeum' ),
					'desc'     => '',
					'priority' => 300,
					'icon'     => 'icon-customizer',
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'ozeum' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'ozeum' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'ozeum' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'ozeum' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'ozeum' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'ozeum' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'menu_scheme'                   => array(
					'title'    => esc_html__( 'Sidemenu Color Scheme', 'ozeum' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'ozeum' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes || OZEUM_THEME_FREE ? 'hidden' : 'radio',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'ozeum' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'ozeum' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'ozeum' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'ozeum' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'radio',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'ozeum' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'ozeum' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'ozeum' ),
					'desc'        => '',
					'std'         => '$ozeum_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'spectrum', //'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Huge priority is used to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);



		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			//---------------------------------------------
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'ozeum' ),
				'desc'     => '',
				'priority' => 200,
				'icon'     => 'icon-text',
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'ozeum' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'ozeum' ) )
						. wp_kses_data( __( 'Press "Refresh" button to reload preview area after the all fonts are changed', 'ozeum' ) ),
				'type'  => 'section',
			),
			'load_fonts_info'   => array(
				'title' => esc_html__( 'Load fonts', 'ozeum' ),
				'desc'  => '',
				'type'  => 'info',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'ozeum' ) )
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'ozeum' ) ),
				'class'   => 'ozeum_column-1_3 ozeum_new_row',
				'refresh' => false,
				'std'     => '$ozeum_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= ozeum_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( ozeum_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'ozeum' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'ozeum' ),
				'desc'    => '',
				'class'   => 'ozeum_column-1_3 ozeum_new_row',
				'refresh' => false,
				'std'     => '$ozeum_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'ozeum' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'ozeum' ) )
							: '',
				'class'   => 'ozeum_column-1_3',
				'refresh' => false,
				'std'     => '$ozeum_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'ozeum' ),
					'serif'      => esc_html__( 'serif', 'ozeum' ),
					'sans-serif' => esc_html__( 'sans-serif', 'ozeum' ),
					'monospace'  => esc_html__( 'monospace', 'ozeum' ),
					'cursive'    => esc_html__( 'cursive', 'ozeum' ),
					'fantasy'    => esc_html__( 'fantasy', 'ozeum' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'ozeum' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'ozeum' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'ozeum' ) )
							: '',
				'class'   => 'ozeum_column-1_3',
				'refresh' => false,
				'std'     => '$ozeum_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = ozeum_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'ozeum' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses_data( sprintf( __( 'Font settings of the "%s" tag.', 'ozeum' ), $tag ) ),
				'type'  => 'section',
			);
			$fonts[ "{$tag}_info" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'ozeum' ), $tag ) ),
				'desc'  => '',
				'type'  => 'info',
			);
			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				// Skip property 'text-decoration' for the main text
				if ( 'text-decoration' == $css_prop && 'p' == $tag ) {
					continue;
				}

				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'ozeum' ),
						'100'     => esc_html__( '100 (Light)', 'ozeum' ),
						'200'     => esc_html__( '200 (Light)', 'ozeum' ),
						'300'     => esc_html__( '300 (Thin)', 'ozeum' ),
						'400'     => esc_html__( '400 (Normal)', 'ozeum' ),
						'500'     => esc_html__( '500 (Semibold)', 'ozeum' ),
						'600'     => esc_html__( '600 (Semibold)', 'ozeum' ),
						'700'     => esc_html__( '700 (Bold)', 'ozeum' ),
						'800'     => esc_html__( '800 (Black)', 'ozeum' ),
						'900'     => esc_html__( '900 (Black)', 'ozeum' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'ozeum' ),
						'normal'  => esc_html__( 'Normal', 'ozeum' ),
						'italic'  => esc_html__( 'Italic', 'ozeum' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'ozeum' ),
						'none'         => esc_html__( 'None', 'ozeum' ),
						'underline'    => esc_html__( 'Underline', 'ozeum' ),
						'overline'     => esc_html__( 'Overline', 'ozeum' ),
						'line-through' => esc_html__( 'Line-through', 'ozeum' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'ozeum' ),
						'none'       => esc_html__( 'None', 'ozeum' ),
						'uppercase'  => esc_html__( 'Uppercase', 'ozeum' ),
						'lowercase'  => esc_html__( 'Lowercase', 'ozeum' ),
						'capitalize' => esc_html__( 'Capitalize', 'ozeum' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$ozeum_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		ozeum_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			ozeum_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'ozeum' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'ozeum' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! ozeum_check_url( 'customize.php' ) ) {
			ozeum_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'ozeum' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'ozeum' ) ),
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'ozeum' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'ozeum_options_get_list_cpt_options' ) ) {
	function ozeum_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"content_info_{$cpt}"           => array(
				'title' => esc_html__( 'Content', 'ozeum' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"body_style_{$cpt}"             => array(
				'title'    => esc_html__( 'Body style', 'ozeum' ),
				'desc'     => wp_kses_data( __( 'Select width of the body content', 'ozeum' ) ),
				'std'      => 'inherit',
				'options'  => ozeum_get_list_body_styles( true ),
				'type'     => 'choice',
			),
			"boxed_bg_image_{$cpt}"         => array(
				'title'      => esc_html__( 'Boxed bg image', 'ozeum' ),
				'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'ozeum' ) ),
				'dependency' => array(
					"body_style_{$cpt}" => array( 'boxed' ),
				),
				'std'        => 'inherit',
				'type'       => 'image',
			),
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'ozeum' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
				'std'     => 'inherit',
				'options' => ozeum_get_list_header_footer_types( true ),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'radio',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'ozeum' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => OZEUM_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'ozeum' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'ozeum' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'radio',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'ozeum' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'ozeum' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'ozeum' ),
					1         => esc_html__( 'Yes', 'ozeum' ),
					0         => esc_html__( 'No', 'ozeum' ),
				),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'radio',
			),
			"header_widgets_{$cpt}"         => array(
				'title'   => esc_html__( 'Header widgets', 'ozeum' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select set of widgets to show in the header on the %s pages', 'ozeum' ), $title ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => 'select',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'ozeum' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				// Translators: Add CPT name to the title
				'title'   => sprintf( __( 'Sidebar position on the %s list', 'ozeum' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the %s list', 'ozeum' ), $title ) ),
				'std'     => 'right',
				'options' => array(),
				'type'    => 'choice',
			),
			"sidebar_position_ss_{$cpt}"    => array(
				// Translators: Add CPT name to the title
				'title'    => sprintf( __( 'Sidebar position on the %s list on the small screen', 'ozeum' ), $title ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'ozeum' ) ),
				'std'      => 'below',
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'options'  => array(),
				'type'     => 'radio',
			),
			"sidebar_type_{$cpt}"           => array(
				// Translators: Add CPT name to the title
				'title'    => sprintf( __( 'Sidebar style on the %s list', 'ozeum' ), $title ),
				'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'default',
				'options'  => ozeum_get_list_header_footer_types(),
				'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
			),
			"sidebar_style_{$cpt}"          => array(
				'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
					"sidebar_type_{$cpt}"     => array( 'custom' ),
				),
				'std'        => 'sidebar-custom-sidebar',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_widgets_{$cpt}"        => array(
				// Translators: Add CPT name to the title
				'title'      => sprintf( __( 'Sidebar widgets on the %s list', 'ozeum' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select sidebar to show on the %s list', 'ozeum' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
					"sidebar_type_{$cpt}"     => array( 'default' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_position_single_{$cpt}"       => array(
				'title'   => esc_html__( 'Sidebar position on the single post', 'ozeum' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the single posts of the %s', 'ozeum' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'choice',
			),
			"sidebar_position_ss_single_{$cpt}"    => array(
				'title'    => esc_html__( 'Sidebar position on the single post on the small screen', 'ozeum' ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'ozeum' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'below',
				'options'  => array(),
				'type'     => 'radio',
			),
			"sidebar_type_single_{$cpt}"           => array(
				// Translators: Add CPT name to the title
				'title'    => esc_html__( 'Sidebar style on the single post', 'ozeum' ),
				'desc'     => wp_kses_data( __( 'Choose whether to use the default sidebar or sidebar Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'default',
				'options'  => ozeum_get_list_header_footer_types(),
				'type'     => OZEUM_THEME_FREE || ! ozeum_exists_trx_addons() ? 'hidden' : 'radio',
			),
			"sidebar_style_single_{$cpt}"          => array(
				'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
                'desc'       => wp_kses( __( 'Select custom sidebar from Layouts Builder', 'ozeum' ), 'ozeum_kses_content' ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
					"sidebar_type_single_{$cpt}"     => array( 'custom' ),
				),
				'std'        => 'sidebar-custom-sidebar',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_widgets_single_{$cpt}"        => array(
				'title'      => esc_html__( 'Sidebar widgets on the single post', 'ozeum' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select widgets to show in the sidebar on the single posts of the %s', 'ozeum' ), $title ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
					"sidebar_type_single_{$cpt}"     => array( 'default' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"expand_content_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden or leave it narrow', 'ozeum' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options' => ozeum_get_list_expand_content( true ),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'choice',
			),
			"expand_content_single_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content on the single post', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Expand the content width on the single post if the sidebar is hidden', 'ozeum' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options' => ozeum_get_list_expand_content( true ),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'choice',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'ozeum' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'ozeum' ) ),
				'std'     => 'inherit',
				'options' => ozeum_get_list_header_footer_types( true ),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'radio',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'ozeum' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'ozeum' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => OZEUM_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'ozeum' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'ozeum' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'ozeum' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'ozeum' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => ozeum_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'ozeum' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'ozeum' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'switch',
			),

			"widgets_info_{$cpt}"           => array(
				'title' => esc_html__( 'Additional panels', 'ozeum' ),
				'desc'  => '',
				'type'  => OZEUM_THEME_FREE ? 'hidden' : 'info',
			),
			"widgets_above_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the top of the page', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the top of the page (above content and sidebar)', 'ozeum' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_above_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets above the content', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the beginning of the content area', 'ozeum' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_content_{$cpt}"  => array(
				'title'   => esc_html__( 'Widgets below the content', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the ending of the content area', 'ozeum' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
			),
			"widgets_below_page_{$cpt}"     => array(
				'title'   => esc_html__( 'Widgets at the bottom of the page', 'ozeum' ),
				'desc'    => wp_kses_data( __( 'Select widgets to show at the bottom of the page (below content and sidebar)', 'ozeum' ) ),
				'std'     => 'hide',
				'options' => array(),
				'type'    => OZEUM_THEME_FREE ? 'hidden' : 'select',
			),
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'ozeum_options_get_list_choises' ) ) {
	add_filter( 'ozeum_filter_options_get_list_choises', 'ozeum_options_get_list_choises', 10, 2 );
	function ozeum_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = ozeum_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = ozeum_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = ozeum_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = ozeum_get_list_schemes( 'color_scheme' != $id );
			} else if ( strpos( $id, 'sidebar_style' ) === 0 ) {
				$list = ozeum_get_list_sidebar_styles( strpos( $id, 'sidebar_style_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = ozeum_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_ss' ) === 0 ) {
				$list = ozeum_get_list_sidebars_positions_ss( strpos( $id, 'sidebar_position_ss_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = ozeum_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = ozeum_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = ozeum_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = ozeum_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = ozeum_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = ozeum_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = ozeum_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = ozeum_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'single_style' ) === 0 ) {
				$list = ozeum_get_list_single_styles( strpos( $id, 'single_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = ozeum_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = ozeum_array_merge( array( 0 => esc_html__( '- Select category -', 'ozeum' ) ), ozeum_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = ozeum_get_list_animations_in();
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = ozeum_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = ozeum_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}
