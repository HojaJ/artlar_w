<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ozeum_gutenberg_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ozeum_gutenberg_theme_setup9', 9 );
	function ozeum_gutenberg_theme_setup9() {

		// Add wide and full blocks support
		add_theme_support( 'align-wide' );

		// Add editor styles to backend
		add_theme_support( 'editor-styles' );
		if ( ozeum_exists_gutenberg() ) {
			if ( ! ozeum_get_theme_setting( 'gutenberg_add_context' ) ) {
                add_editor_style( array(
                         ozeum_get_file_url( 'css/font-icons/css/fontello.css' ),
                         ozeum_get_file_url( 'plugins/gutenberg/gutenberg-preview.css' )
                    )
                );
			}
		} else {
			add_editor_style( ozeum_get_file_url( 'css/editor-style.css' ) );
		}

		if ( ozeum_exists_gutenberg() ) {
			add_action( 'wp_enqueue_scripts', 'ozeum_gutenberg_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'ozeum_gutenberg_responsive_styles', 2000 );
			add_filter( 'ozeum_filter_merge_styles', 'ozeum_gutenberg_merge_styles' );
			add_filter( 'ozeum_filter_merge_styles_responsive', 'ozeum_gutenberg_merge_styles_responsive' );
		}
		add_action( 'enqueue_block_editor_assets', 'ozeum_gutenberg_editor_scripts' );
		add_filter( 'ozeum_filter_localize_script_admin',	'ozeum_gutenberg_localize_script');
		add_action( 'after_setup_theme', 'ozeum_gutenberg_add_editor_colors' );
		if ( is_admin() ) {
			add_filter( 'ozeum_filter_tgmpa_required_plugins', 'ozeum_gutenberg_tgmpa_required_plugins' );
			add_filter( 'ozeum_filter_theme_plugins', 'ozeum_gutenberg_theme_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ozeum_gutenberg_tgmpa_required_plugins' ) ) {
	
	function ozeum_gutenberg_tgmpa_required_plugins( $list = array() ) {
		if ( ozeum_storage_isset( 'required_plugins', 'gutenberg' ) ) {
			if ( ozeum_storage_get_array( 'required_plugins', 'gutenberg', 'install' ) !== false && version_compare( get_bloginfo( 'version' ), '5.0', '<' ) ) {
				$list[] = array(
					'name'     => ozeum_storage_get_array( 'required_plugins', 'gutenberg', 'title' ),
					'slug'     => 'gutenberg',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Filter theme-supported plugins list
if ( ! function_exists( 'ozeum_gutenberg_theme_plugins' ) ) {
	
	function ozeum_gutenberg_theme_plugins( $list = array() ) {
		$group = ! empty( $list['gutenberg']['group'] )
					? $list['gutenberg']['group']
					: ozeum_storage_get_array( 'required_plugins', 'gutenberg', 'group' ); 
		foreach ( $list as $k => $v ) {
			if ( in_array( $k, array( 'coblocks', 'kadence-blocks' ) ) ) {
				if ( empty( $v['group'] ) ) {
					$list[ $k ]['group'] = $group;
				}
				if ( empty( $v['logo'] ) ) {
					$logo = ozeum_get_file_url( "plugins/gutenberg/{$k}.png" );
					$list[ $k ]['logo'] = empty( $logo )
											? ( ! empty( $list['gutenberg']['logo'] )
													? ( strpos( $list['gutenberg']['logo'], '//' ) !== false
														? $list['gutenberg']['logo']
														: ozeum_get_file_url( "plugins/gutenberg/{$list['gutenberg']['logo']}" )
														)
												: ''
												)
											: $logo;
				}
			}
		}
		return $list;
	}
}


// Check if Gutenberg is installed and activated
if ( ! function_exists( 'ozeum_exists_gutenberg' ) ) {
	function ozeum_exists_gutenberg() {
		return function_exists( 'register_block_type' );
	}
}

// Return true if Gutenberg exists and current mode is preview
if ( ! function_exists( 'ozeum_gutenberg_is_preview' ) ) {
	function ozeum_gutenberg_is_preview() {
		return ozeum_exists_gutenberg() 
				&& (
					ozeum_gutenberg_is_block_render_action()
					||
					ozeum_is_post_edit()
					);
	}
}

// Return true if current mode is "Block render"
if ( ! function_exists( 'ozeum_gutenberg_is_block_render_action' ) ) {
	function ozeum_gutenberg_is_block_render_action() {
		return ozeum_exists_gutenberg() 
				&& ozeum_check_url( 'block-renderer' ) && ! empty( $_GET['context'] ) && 'edit' == $_GET['context'];
	}
}

// Return true if content built with "Gutenberg"
if ( ! function_exists( 'ozeum_gutenberg_is_content_built' ) ) {
	function ozeum_gutenberg_is_content_built($content) {
		return ozeum_exists_gutenberg() 
				&& has_blocks( $content );	// This condition is equval to: strpos($content, '<!-- wp:') !== false;
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'ozeum_gutenberg_frontend_scripts' ) ) {
	
	function ozeum_gutenberg_frontend_scripts() {
		if ( ozeum_is_on( ozeum_get_theme_option( 'debug_mode' ) ) ) {
			$ozeum_url = ozeum_get_file_url( 'plugins/gutenberg/gutenberg.css' );
			if ( '' != $ozeum_url ) {
				wp_enqueue_style( 'ozeum-gutenberg', $ozeum_url, array(), null );
			}
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'ozeum_gutenberg_responsive_styles' ) ) {
	
	function ozeum_gutenberg_responsive_styles() {
		if ( ozeum_is_on( ozeum_get_theme_option( 'debug_mode' ) ) ) {
			$ozeum_url = ozeum_get_file_url( 'plugins/gutenberg/gutenberg-responsive.css' );
			if ( '' != $ozeum_url ) {
				wp_enqueue_style( 'ozeum-gutenberg-responsive', $ozeum_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'ozeum_gutenberg_merge_styles' ) ) {
	
	function ozeum_gutenberg_merge_styles( $list ) {
		$list[] = 'plugins/gutenberg/gutenberg.css';
		return $list;
	}
}

// Merge responsive styles
if ( ! function_exists( 'ozeum_gutenberg_merge_styles_responsive' ) ) {
	
	function ozeum_gutenberg_merge_styles_responsive( $list ) {
		$list[] = 'plugins/gutenberg/gutenberg-responsive.css';
		return $list;
	}
}


// Load required styles and scripts for Gutenberg Editor mode
if ( ! function_exists( 'ozeum_gutenberg_editor_scripts' ) ) {
	
	function ozeum_gutenberg_editor_scripts() {
		ozeum_admin_scripts(true);
		ozeum_admin_localize_scripts();
		// Editor styles
		wp_enqueue_style( 'ozeum-gutenberg-editor', ozeum_get_file_url( 'plugins/gutenberg/gutenberg-editor.css' ), array(), null );
		if ( ozeum_get_theme_setting( 'gutenberg_add_context' ) ) {
			wp_enqueue_style( 'ozeum-gutenberg-preview', ozeum_get_file_url( 'plugins/gutenberg/gutenberg-preview.css' ), array(), null );
		}
		// Editor scripts
		wp_enqueue_script( 'ozeum-gutenberg-preview', ozeum_get_file_url( 'plugins/gutenberg/gutenberg-preview.js' ), array( 'jquery' ), null, true );
	}
}

// Add plugin's specific variables to the scripts
if ( ! function_exists( 'ozeum_gutenberg_localize_script' ) ) {
	
	function ozeum_gutenberg_localize_script( $arr ) {
		// Color scheme
		$arr['color_scheme'] = ozeum_get_theme_option( 'color_scheme' );
		// Sidebar position on the single posts
		$arr['sidebar_position'] = 'inherit';
		$arr['expand_content'] = 'inherit';
		$post_type = 'post';
		if ( ozeum_gutenberg_is_preview() && ! empty( $_GET['post'] ) ) {
			$post_type = ozeum_get_edited_post_type();
			$meta = get_post_meta( $_GET['post'], 'ozeum_options', true );
			if ( 'page' != $post_type && ! empty( $meta['sidebar_position_single'] ) ) {
				$arr['sidebar_position'] = $meta['sidebar_position_single'];
			} elseif ( 'page' == $post_type && ! empty( $meta['sidebar_position'] ) ) {
				$arr['sidebar_position'] = $meta['sidebar_position'];
			}
			if ( isset( $meta['expand_content'] ) ) {
				$arr['expand_content'] = $meta['expand_content'];
			}
		}
		if ( 'inherit' == $arr['sidebar_position'] ) {
			if ( 'page' != $post_type ) {
				$arr['sidebar_position'] = ozeum_get_theme_option( 'sidebar_position_single' );
				if ( 'inherit' == $arr['sidebar_position'] ) {
					$arr['sidebar_position'] = ozeum_get_theme_option( 'sidebar_position_blog' );
				}
			}
			if ( 'inherit' == $arr['sidebar_position'] ) {
				$arr['sidebar_position'] = ozeum_get_theme_option( 'sidebar_position' );
			}
		}
		if ( 'inherit' == $arr['expand_content'] ) {
			$arr['expand_content'] = ozeum_get_theme_option( 'expand_content_single' );
			if ( 'inherit' == $arr['expand_content'] && 'post' == $post_type ) {
				$arr['expand_content'] = ozeum_get_theme_option( 'expand_content_blog' );
			}
			if ( 'inherit' == $arr['expand_content'] ) {
				$arr['expand_content'] = ozeum_get_theme_option( 'expand_content' );
			}
		}
		$arr['expand_content'] = (int) $arr['expand_content'];
		return $arr;
	}
}

// Save CSS with custom colors and fonts to the gutenberg-editor-style.css
if ( ! function_exists( 'ozeum_gutenberg_save_css' ) ) {
	add_action( 'ozeum_action_save_options', 'ozeum_gutenberg_save_css', 30 );
	add_action( 'trx_addons_action_save_options', 'ozeum_gutenberg_save_css', 30 );
	function ozeum_gutenberg_save_css() {

		$msg = '/* ' . esc_html__( "ATTENTION! This file was generated automatically! Don't change it!!!", 'ozeum' )
				. "\n----------------------------------------------------------------------- */\n";

		// Get main styles
		$css = apply_filters( 'ozeum_filter_gutenberg_get_styles', ozeum_fgc( ozeum_get_file_dir( 'style.css' ) ) );

		// Append supported plugins styles
		$css .= ozeum_fgc( ozeum_get_file_dir( 'css/__plugins.css' ) );

		// Append theme-vars styles
		$css .= ozeum_customizer_get_css(
			array(
				'colors' => ozeum_get_theme_setting( 'separate_schemes' ) ? false : null,
			)
		);
		
		// Append color schemes
		if ( ozeum_get_theme_setting( 'separate_schemes' ) ) {
			$schemes = ozeum_get_sorted_schemes();
			if ( is_array( $schemes ) ) {
				foreach ( $schemes as $scheme => $data ) {
					$css .= ozeum_customizer_get_css(
						array(
							'fonts'  => false,
							'colors' => $data['colors'],
							'scheme' => $scheme,
						)
					);
				}
			}
		}

		// Append responsive styles
		$css .= apply_filters( 'ozeum_filter_gutenberg_get_styles_responsive', ozeum_fgc( ozeum_get_file_dir( 'css/__responsive.css' ) ) );

		// Add context class to each selector
		if ( ozeum_get_theme_setting( 'gutenberg_add_context' ) && function_exists( 'trx_addons_css_add_context' ) ) {
			$css = trx_addons_css_add_context(
						$css,
						array(
							'context' => '.edit-post-visual-editor ',
							'context_self' => array( 'html', 'body', '.edit-post-visual-editor' )
							)
					);
		} else {
			$css = apply_filters( 'ozeum_filter_prepare_css', $css );
		}

		// Save styles to the file
		ozeum_fpc( ozeum_get_file_dir( 'plugins/gutenberg/gutenberg-preview.css' ), $msg . $css );
	}
}


// Add theme-specific colors to the Gutenberg color picker
if ( ! function_exists( 'ozeum_gutenberg_add_editor_colors' ) ) {
	
	function ozeum_gutenberg_add_editor_colors() {
		$scheme = ozeum_get_scheme_colors();
		$groups = ozeum_storage_get( 'scheme_color_groups' );
		$names  = ozeum_storage_get( 'scheme_color_names' );
		$colors = array();
		foreach( $groups as $g => $group ) {
			foreach( $names as $n => $name ) {
				$c = 'main' == $g ? ( 'text' == $n ? 'text_color' : $n ) : $g . '_' . str_replace( 'text_', '', $n );
				if ( isset( $scheme[ $c ] ) ) {
					$colors[] = array(
						'name'  => ( 'main' == $g ? '' : $group['title'] . ' ' ) . $name['title'],
						'slug'  => $c,
						'color' => $scheme[ $c ]
					);
				}
			}
			// Add only one group of colors
			// Delete next condition (or add false && to them) to add all groups
			if ( 'main' == $g ) {
				break;
			}
		}
		add_theme_support( 'editor-color-palette', $colors );
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( ozeum_exists_gutenberg() ) {
	require_once ozeum_get_file_dir( 'plugins/gutenberg/gutenberg-style.php' );
}
