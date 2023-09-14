<?php
/**
 * Skins support: Main skin file for the skin 'Default'
 *
 * Load scripts and styles,
 * and other operations that affect the appearance and behavior of the theme
 * when the skin is activated
 *
 * @package OZEUM
 * @since OZEUM 1.0.46
 */



// SKIN SETUP
//--------------------------------------------------------------------

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
if ( ! function_exists( 'ozeum_skin_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'ozeum_skin_theme_setup1', 1 );
	function ozeum_skin_theme_setup1() {
		// ToDo: Set default values for typography, color schemes, etc.

		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// !!! START SECTION: If skins are not used - move this section to the theme-setup.php !!!
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

		// Theme fonts: Google and/or custom fonts
		//--------------------------------------------
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		ozeum_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Cardo',
					'family' => 'serif',
					'styles' => '400,400italic,700',     // Parameter 'style' used only for the Google fonts
				),
				// Font-face packed with theme
				array(
					'name'   => 'Metropolis',
					'family' => 'sans-serif',
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		ozeum_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		
		
		

		ozeum_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'ozeum' ),
					'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.6055em;',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.6em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '3.125em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.1855em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '1.6255em',
					'margin-bottom'   => '0.7455em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '2.500em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.3655em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '1.4855em',
					'margin-bottom'   => '0.7855em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '1.875em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.2415em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '1.8455em',
					'margin-bottom'   => '1.0355em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '1.500em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.2752em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '1.9355em',
					'margin-bottom'   => '1.1255em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '1.125em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.455em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '2em',
					'margin-bottom'   => '1.2em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '0.875em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.4706em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '2.7em',
					'margin-bottom'   => '0.9412em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'ozeum' ),
					'description'     => esc_html__( 'Font settings of the text case of the logo', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '1.8em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '23px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.8px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'ozeum' ),
					'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'ozeum' ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em', // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'ozeum' ),
					'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'ozeum' ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'ozeum' ),
					'description'     => esc_html__( 'Font settings of the main menu items', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.8px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'ozeum' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'ozeum' ),
					'font-family'     => '"Metropolis",sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.8px',
				),
                'decor' => array(
                    'title'           => esc_html__( 'Decoration', 'ozeum' ),
                    'description'     => esc_html__( 'Decoration Font', 'ozeum' ),
                    'font-family'     => '"Cardo",serif',
                ),
			)
		);
		

		// Color schemes: default values
		//--------------------------------------------
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'ozeum' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#f7f6ec', //ok
					'bd_color'         => '#c9c8bf', //ok

					// Text and links colors
					'text'             => '#6d6d65', //ok
					'text_light'       => '#93938f', //ok
					'text_dark'        => '#13130d', //ok
					'text_link'        => '#c9a050', //ok
					'text_hover'       => '#13130d', //ok
					'text_link2'       => '#80d572',
					'text_hover2'      => '#8be77c',
					'text_link3'       => '#ddb837',
					'text_hover3'      => '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#eeede0', //ok
					'alter_bg_hover'   => '#e1dfd0', //ok
					'alter_bd_color'   => '#c9c8bf', //ok
					'alter_bd_hover'   => '#606060', //ok
					'alter_text'       => '#6d6d65', //ok
					'alter_light'      => '#93938f', //ok
					'alter_dark'       => '#13130d', //ok
					'alter_link'       => '#c9a050', //ok
					'alter_hover'      => '#13130d', //ok
					'alter_link2'      => '#8be77c',
					'alter_hover2'     => '#80d572',
					'alter_link3'      => '#eec432',
					'alter_hover3'     => '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#13130d', //ok
					'extra_bg_hover'   => '#3e3e34', //ok
					'extra_bd_color'   => '#3e3e34', //ok
					'extra_bd_hover'   => '#7f7e6e', //ok
					'extra_text'       => '#949380', //ok
					'extra_light'      => '#706f62', //ok
					'extra_dark'       => '#f7f6ec', //ok
					'extra_link'       => '#949380', //ok
					'extra_hover'      => '#c9a050', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#f7f6ec', //ok
					'input_bg_hover'   => '#f7f6ec', //ok
					'input_bd_color'   => '#c9c8bf', //ok
					'input_bd_hover'   => '#606060', //ok
					'input_text'       => '#6d6d65', //ok
					'input_light'      => '#93938f', //ok
					'input_dark'       => '#13130d', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#3e3e34', //ok
					'inverse_bd_hover' => '#7f7e6e', //ok
					'inverse_text'     => '#949380', //ok
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#13130d', //ok
					'inverse_link'     => '#ebe9cf', //ok
					'inverse_hover'    => '#ebe9cf', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					
					//--> 'new_color1'         => '#rrggbb',
					//--> 'alter_new_color1'   => '#rrggbb',
					//--> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'ozeum' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#1e1e19', //ok
					'bd_color'         => '#3e3e34', //ok

					// Text and links colors
					'text'             => '#949380', //ok
					'text_light'       => '#686860', //ok
					'text_dark'        => '#ebe9cf', //ok
					'text_link'        => '#c9a050', //ok
					'text_hover'       => '#ebe9cf', //ok
					'text_link2'       => '#80d572',
					'text_hover2'      => '#8be77c',
					'text_link3'       => '#ddb837',
					'text_hover3'      => '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#13130d', //ok
					'alter_bg_hover'   => '#2a2a23', //ok
					'alter_bd_color'   => '#3e3e34', //ok
					'alter_bd_hover'   => '#7f7e6e', //ok
					'alter_text'       => '#949380', //ok
					'alter_light'      => '#686860', //ok
					'alter_dark'       => '#ebe9cf', //ok
					'alter_link'       => '#c9a050', //ok
					'alter_hover'      => '#ebe9cf', //ok
					'alter_link2'      => '#8be77c',
					'alter_hover2'     => '#80d572',
					'alter_link3'      => '#eec432',
					'alter_hover3'     => '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#13130d', //ok #f7f6ec
					'extra_bg_hover'   => '#3e3e34', //ok #c9c8bf
					'extra_bd_color'   => '#3e3e34', //ok #3e3e34
					'extra_bd_hover'   => '#7f7e6e', //ok #7f7e6e
					'extra_text'       => '#949380', //ok #6d6d65
					'extra_light'      => '#706f62', //ok #7e7e77
					'extra_dark'       => '#ebe9cf', //ok #13130d
					'extra_link'       => '#949380', //ok #ebe9cf
					'extra_hover'      => '#c9a050', //ok #c9a050
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#13130d', //ok
					'input_bg_hover'   => '#13130d', //ok
					'input_bd_color'   => '#3e3e34', //ok
					'input_bd_hover'   => '#7f7e6e', //ok
					'input_text'       => '#949380', //ok
					'input_light'      => '#686860', //ok
					'input_dark'       => '#ebe9cf', //ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#3e3e34', //ok
					'inverse_bd_hover' => '#7f7e6e', //ok
					'inverse_text'     => '#949380', //ok 
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#13130d', //ok
					'inverse_link'     => '#ebe9cf', //ok
					'inverse_hover'    => '#13130d', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					
					//--> 'new_color1'         => '#rrggbb',
					//--> 'alter_new_color1'   => '#rrggbb',
					//--> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		ozeum_storage_set( 'schemes', $schemes );
		ozeum_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		
		//---> ozeum_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'ozeum' ),
		//---> 	'description' => __( 'Description of the new color 1', 'ozeum' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		ozeum_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_01'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.1,
                ),
                'text_dark_02'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.2,
                ),
                'text_dark_04'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.4,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_06'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.6,
                ),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
                'inverse_dark_0'      => array(
                    'color' => 'inverse_dark',
                    'alpha' => 0,
                ),
                'inverse_link_02'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.2,
                ),
                'inverse_link_04'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.4,
                ),
                'inverse_link_07'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.7,
                ),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
                'text_hover_blend'   => array(
                    'color'      => 'text_hover',
                    'hue'        => 2,
                    'saturation' => -5,
                    'brightness' => 5,
                ),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -7,
					'brightness' => 7,
				),
			)
		);

		// Theme specific thumb sizes
		//--------------------------------------------
		ozeum_storage_set(
			'theme_thumbs', apply_filters(
				'ozeum_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'ozeum-thumb-huge'        => array(
						'size'  => array( 1170, 658, true ),
						'title' => esc_html__( 'Huge image', 'ozeum' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'ozeum-thumb-big'         => array(
						'size'  => array( 770, 433, true ),
						'title' => esc_html__( 'Large image', 'ozeum' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'ozeum-thumb-med'         => array(
						'size'  => array( 370, 208, true ),
						'title' => esc_html__( 'Medium image', 'ozeum' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'ozeum-thumb-tiny'        => array(
						'size'  => array( 90, 90, true ),
						'title' => esc_html__( 'Small square avatar', 'ozeum' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'ozeum-thumb-masonry-big' => array(
						'size'  => array( 770, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'ozeum' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'ozeum-thumb-masonry'     => array(
						'size'  => array( 370, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'ozeum' ),
						'subst' => 'trx_addons-thumb-masonry',
					),

                    // Medium square image (image posts-list)
                    'ozeum-thumb-square'        => array(
                        'size'  => array( 370, 370, true ),
                        'title' => esc_html__( 'Medium square image', 'ozeum' ),
                        'subst' => 'trx_addons-thumb-square',
                    ),

                    // Big rectangle image ( list events, team )
                    'ozeum-thumb-rectangle'        => array(
                        'size'  => array( 740, 474, true ),
                        'title' => esc_html__( 'Big rectangle image', 'ozeum' ),
                        'subst' => 'trx_addons-thumb-rectangle',
                    ),
				)
			)
		);
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// !!! END SECTION: If skins are not used - move this section to the theme-setup.php !!!
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	}
}

// Set theme specific importer options
if ( ! function_exists( 'ozeum_skin_importer_set_options' ) ) {
	add_filter('trx_addons_filter_importer_options', 'ozeum_skin_importer_set_options', 9);
	function ozeum_skin_importer_set_options($options = array()) {
		if ( is_array( $options ) ) {
			// ToDo: Prepare dummy-data installer's options
			
			//---> $options['demo_type']                         = 'skin_slug';
			//---> $options['files']['skin_slug']                = $options['files']['default'];
			//---> $options['files']['skin_slug']['title']       = esc_html__('Default Demo', 'ozeum');
			//---> $options['files']['skin_slug']['domain_dev']  = esc_url( ozeum_get_protocol() . '://skin.domain.dev' );
			//---> $options['files']['skin_slug']['domain_demo'] = esc_url( ozeum_get_protocol() . '://skin.domain.demo' );
		}
		return $options;
	}
}


// Filter to add in the required plugins list
// Priority 11 to add new plugins to the end of the list
if ( ! function_exists( 'ozeum_skin_tgmpa_required_plugins' ) ) {
	add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_skin_tgmpa_required_plugins', 11 );
	function ozeum_skin_tgmpa_required_plugins( $list = array() ) {
		// ToDo: Check if plugin is in the 'required_plugins' and add his parameters to the TGMPA-list
		//       Replace 'skin-specific-plugin-slug' to the real slug of the plugin
		if ( ozeum_storage_isset( 'required_plugins', 'skin-specific-plugin-slug' ) ) {
			$list[] = array(
				'name'     => ozeum_storage_get_array( 'required_plugins', 'skin-specific-plugin-slug', 'title' ),
				'slug'     => 'skin-specific-plugin-slug',
				'required' => false,
			);
		}
		return $list;
	}
}


// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'ozeum_skin_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'ozeum_skin_theme_setup3', 3 );
	function ozeum_skin_theme_setup3() {
		// ToDo: Add / Modify theme options, color schemes, required plugins, etc.
		
		// Example 1: to add 'elementor-specific-plugin-slug' to the 'required_plugins' if theme use Elementor:
		//--->	if ( ozeum_storage_isset( 'required_plugins', 'elementor' ) && ozeum_storage_get_array( 'required_plugins', 'elementor', 'install' ) !== false ) {
		//--->		ozeum_storage_set_array(
		//--->			'required_plugins',
		//--->			'elementor-specific-plugin-slug',
		//--->			array(
		//--->				'title'       => esc_html__( 'Elementor specific addons', 'ozeum' ),
		//--->				'description' => '',
		//--->				'required'    => false,
		//--->				'logo'        => ozeum_get_file_url( 'plugins/'elementor-specific-plugin-slug'/logo.png' ),
		//--->				'group'       => ozeum_storage_get_array( 'required_plugins', 'elementor', 'group' ),
		//--->			)
		//--->		);
		//--->	}
		
		// Example 2: to add 'new_hover' to the 'image':
		//--->	ozeum_storage_set_array2( 'options', 'image_hover', 'options',
		//--->		array_merge(
		//--->			ozeum_storage_get_array( 'options', 'image_hover', 'options', array() ),
		//--->			array(
		//--->				'new_hover'	=> esc_html__('New hover',	'ozeum'),
		//--->			)
		//--->		)
		//--->	);
	}
}

// Filter to add/remove components of ThemeREX Addons when current skin is active
if ( ! function_exists( 'ozeum_skin_trx_addons_default_components' ) ) {
	add_filter('trx_addons_filter_load_options', 'ozeum_skin_trx_addons_default_components', 20);
	function ozeum_skin_trx_addons_default_components($components) {
		// ToDo: Set key value in the array $components to 0 (disable component) or 1 (enable component)
		
		//---> $components['components_components_reviews'] = 1;
		return $components;
	}
}

// Filter to add/remove CPT
if ( ! function_exists( 'ozeum_skin_trx_addons_cpt_list' ) ) {
	add_filter('trx_addons_cpt_list', 'ozeum_skin_trx_addons_cpt_list');
	function ozeum_skin_trx_addons_cpt_list( $list = array() ) {
		// ToDo: Unset CPT slug from list to disable CPT when current skin is active
		
		//---> unset( $list['portfolio'] );
		return $list;
	}
}

// Filter to add/remove shortcodes
if ( ! function_exists( 'ozeum_skin_trx_addons_sc_list' ) ) {
	add_filter('trx_addons_sc_list', 'ozeum_skin_trx_addons_sc_list');
	function ozeum_skin_trx_addons_sc_list( $list = array() ) {
		// ToDo: Unset shortcode's slug from list to disable shortcode when current skin is active
		

		// Also can be used to add/remove/modify shortcodes params
		
		//---> $list['blogger']['templates']['default']['new_template_slug'] = array(
		//--->		'title' => __('Title of the new template', 'ozeum'),
		//--->		'layout' => array(
		//--->			'featured' => array(),
		//--->			'content' => array('meta_categories', 'title', 'excerpt', 'meta', 'readmore')
		//--->		)
		//---> );
		return $list;
	}
}

// Filter to add/remove widgets
if ( ! function_exists( 'ozeum_skin_trx_addons_widgets_list' ) ) {
	add_filter('trx_addons_widgets_list', 'ozeum_skin_trx_addons_widgets_list');
	function ozeum_skin_trx_addons_widgets_list( $list = array() ) {
		// ToDo: Unset widget's slug from list to disable widget when current skin is active
		
		//---> unset( $list['aboutme'] );
		return $list;
	}
}



// SCRIPTS AND STYLES
//--------------------------------------------------

// Enqueue skin-specific scripts
// Priority 1050 -  before main theme plugins-specific (1100)
if ( ! function_exists( 'ozeum_skin_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'ozeum_skin_frontend_scripts', 1050 );
	function ozeum_skin_frontend_scripts() {
		$ozeum_url = ozeum_get_file_url( ozeum_skins_get_current_skin_dir() . 'css/style.css' );
		if ( '' != $ozeum_url ) {
			wp_enqueue_style( 'ozeum-skin-' . esc_attr( ozeum_skins_get_current_skin_name() ), $ozeum_url, array(), null );
		}
		$ozeum_url = ozeum_get_file_url( ozeum_skins_get_current_skin_dir() . 'skin.js' );
		if ( '' != $ozeum_url ) {
			wp_enqueue_script( 'ozeum-skin-' . esc_attr( ozeum_skins_get_current_skin_name() ), $ozeum_url, array( 'jquery' ), null, true );
		}

	}
}


// Plugins support
$ozeum_required_plugins = ozeum_storage_get( 'required_plugins' );
if ( is_array( $ozeum_required_plugins ) ) {
    foreach ( $ozeum_required_plugins as $ozeum_plugin_slug => $ozeum_plugin_data ) {
        $ozeum_plugin_slug = ozeum_esc( $ozeum_plugin_slug );
        $ozeum_plugin_path = ozeum_get_file_dir( ozeum_skins_get_current_skin_dir() ).sprintf( 'plugins/%1$s/%1$s.php', $ozeum_plugin_slug );
        if ( file_exists( $ozeum_plugin_path ) ) {
            require_once $ozeum_plugin_path;
        }
    }
}
