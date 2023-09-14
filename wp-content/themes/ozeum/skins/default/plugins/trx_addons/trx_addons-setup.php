<?php
/* Theme-specific action to configure ThemeREX Addons components
------------------------------------------------------------------------------- */


/* ThemeREX Addons components
------------------------------------------------------------------------------- */
if ( ! function_exists( 'ozeum_trx_addons_theme_specific_components' ) ) {
	add_filter( 'trx_addons_filter_components_editor', 'ozeum_trx_addons_theme_specific_components' );
	function ozeum_trx_addons_theme_specific_components( $enable = false ) {
		return OZEUM_THEME_FREE
					? false     // Free version
					: false;     // Pro version or Developer mode
	}
}

if ( ! function_exists( 'ozeum_trx_addons_theme_specific_setup1' ) ) {
	add_action( 'after_setup_theme', 'ozeum_trx_addons_theme_specific_setup1', 1 );
	function ozeum_trx_addons_theme_specific_setup1() {
		if ( ozeum_exists_trx_addons() ) {
			add_filter( 'trx_addons_api_list', 'ozeum_trx_addons_api_list' );
			add_filter( 'trx_addons_cpt_list', 'ozeum_trx_addons_cpt_list' );
			add_filter( 'trx_addons_sc_list', 'ozeum_trx_addons_sc_list' );
			add_filter( 'trx_addons_widgets_list', 'ozeum_trx_addons_widgets_list' );
		}
	}
}

if ( ! function_exists( 'ozeum_trx_addons_theme_specific_setup' ) ) {
	add_action( 'after_setup_theme', 'ozeum_trx_addons_theme_specific_setup' );
	function ozeum_trx_addons_theme_specific_setup() {
		if ( ozeum_exists_trx_addons() ) {
			if ( ! is_admin() ) {
				add_action( 'ozeum_action_before_post_meta', 'ozeum_trx_addons_action_before_post_meta' );
			}
		}
	}
}

// API
if ( ! function_exists( 'ozeum_trx_addons_api_list' ) ) {
	
	function ozeum_trx_addons_api_list( $list = array() ) {
		// To do: Enable/Disable Third-party plugins API via add/remove it in the list

		// If it's a free version - leave only basic set
		if ( OZEUM_THEME_FREE ) {
			$free_api = array( 'elementor', 'instagram_feed', 'woocommerce', 'contact-form-7' );
			foreach ( $list as $k => $v ) {
				if ( ! in_array( $k, $free_api ) ) {
					unset( $list[ $k ] );
				}
			}
		}
		return $list;
	}
}


// CPT
if ( ! function_exists( 'ozeum_trx_addons_cpt_list' ) ) {
	
	function ozeum_trx_addons_cpt_list( $list = array() ) {
		// To do: Enable/Disable CPT via add/remove it in the list

		// If it's a free version - leave only basic set
		if ( OZEUM_THEME_FREE ) {
			$free_cpt = array( 'layouts', 'portfolio', 'post', 'services', 'team', 'testimonials' );
			foreach ( $list as $k => $v ) {
				if ( ! in_array( $k, $free_cpt ) ) {
					unset( $list[ $k ] );
				}
			}
		}
		return $list;
	}
}

// Shortcodes
if ( ! function_exists( 'ozeum_trx_addons_sc_list' ) ) {
	
	function ozeum_trx_addons_sc_list( $list = array() ) {
		// To do: Add/Remove shortcodes into list
		// If you add new shortcode - in the theme's folder must exists /trx_addons/shortcodes/new_sc_name/new_sc_name.php

		// If it's a free version - leave only basic set
		if ( OZEUM_THEME_FREE ) {
			$free_shortcodes = array( 'action', 'anchor', 'blogger', 'button', 'form', 'icons', 'price', 'promo', 'socials' );
			foreach ( $list as $k => $v ) {
				if ( ! in_array( $k, $free_shortcodes ) ) {
					unset( $list[ $k ] );
				}
			}
		}
		return $list;
	}
}

// Widgets
if ( ! function_exists( 'ozeum_trx_addons_widgets_list' ) ) {
	
	function ozeum_trx_addons_widgets_list( $list = array() ) {
		// To do: Add/Remove widgets into list
		// If you add widget - in the theme's folder must exists /trx_addons/widgets/new_widget_name/new_widget_name.php

		// If it's a free version - leave only basic set
		if ( OZEUM_THEME_FREE ) {
			$free_widgets = array( 'aboutme', 'banner', 'contacts', 'flickr', 'popular_posts', 'recent_posts', 'slider', 'socials' );
			foreach ( $list as $k => $v ) {
				if ( ! in_array( $k, $free_widgets ) ) {
					unset( $list[ $k ] );
				}
			}
		}
		return $list;
	}
}

// Add mobile menu to the plugin's cached menu list
if ( ! function_exists( 'ozeum_trx_addons_menu_cache' ) ) {
	add_filter( 'trx_addons_filter_menu_cache', 'ozeum_trx_addons_menu_cache' );
	function ozeum_trx_addons_menu_cache( $list = array() ) {
		if ( in_array( '#menu_main', $list ) ) {
			$list[] = '#menu_mobile';
		}
		$list[] = '.menu_mobile_inner > nav > ul';
		return $list;
	}
}

// Add theme-specific vars into localize array
if ( ! function_exists( 'ozeum_trx_addons_localize_script' ) ) {
	add_filter( 'ozeum_filter_localize_script', 'ozeum_trx_addons_localize_script' );
	function ozeum_trx_addons_localize_script( $arr ) {
		$arr['alter_link_color'] = ozeum_get_scheme_color( 'alter_link' );
		return $arr;
	}
}


// Shortcodes support
//------------------------------------------------------------------------

// Add new output types (layouts) in the shortcodes
if ( ! function_exists( 'ozeum_trx_addons_sc_type' ) ) {
	add_filter( 'trx_addons_sc_type', 'ozeum_trx_addons_sc_type', 10, 2 );
	function ozeum_trx_addons_sc_type( $list, $sc ) {
		// To do: check shortcode slug and if correct - add new 'key' => 'title' to the list
		if ( 'trx_sc_blogger' == $sc ) {
			$list = ozeum_array_merge( $list, ozeum_get_list_blog_styles( false, 'sc' ) );
		}
        if ( 'trx_sc_title' == $sc ) {
            $list['decoration'] = 'Decoration';
        }
        if ( 'trx_sc_title' == $sc ) {
            $list['extra'] = 'Extra';
        }
        if ( 'trx_sc_icons' == $sc ) {
            $list['list'] = 'List';
        }
        if ( 'trx_sc_events' == $sc ) {
            $list['extra'] = 'Extra';
        }
		return $list;
	}
}

// Add params values to the shortcode's atts
if ( ! function_exists( 'ozeum_trx_addons_sc_prepare_atts' ) ) {
	add_filter( 'trx_addons_filter_sc_prepare_atts', 'ozeum_trx_addons_sc_prepare_atts', 10, 2 );
	function ozeum_trx_addons_sc_prepare_atts( $atts, $sc ) {
		if ( 'trx_sc_blogger' == $sc ) {
			$list = ozeum_get_list_blog_styles( false, 'sc' );
			if ( isset( $list[ $atts['type'] ] ) ) {
				$custom_type = '';
				if ( strpos( $atts['type'], 'blog-custom-' ) === 0 ) {
					$blog_id = ozeum_get_custom_blog_id( $atts['type'] );
					$blog_meta = ozeum_get_custom_layout_meta( $blog_id );
					$custom_type = ! empty( $blog_meta['scripts_required'] ) ? $blog_meta['scripts_required'] : 'custom';
				}
				// Classes for the container with posts
				$columns = $atts['columns'] > 0
								? $atts['columns']
								: ( 1 < $atts['count']
									? $atts['count']
									: ( -1 == $atts['count']
										? 3
										: 1
										)
									);
				$atts['posts_container'] = 'posts_container'
					. ' ' . esc_attr( $atts['type'] ) . '_wrap'
					. ( $columns > 1
							? ' ' . esc_attr( $atts['type'] ) . '_' . $columns 
							: '' )
					. ( in_array( $atts['type'], array( 'portfolio', 'gallery' ) )
							? ' masonry_wrap' . ( $columns > 1 ? ' masonry_' . $columns : '' )
							: '' )
					. ( 'gallery' == $atts['type']
							? ' portfolio_wrap' . ( $columns > 1 ? ' portfolio_' . $columns : '' )
							: '' )
					. ( in_array( $atts['type'], array( 'classic', 'excerpt', 'plain' ) ) && $columns > 1
							? ' columns_wrap columns_padding_bottom' 
							: '' )
					. ( ! empty( $custom_type )
							? ( in_array( $custom_type, array( 'gallery', 'portfolio', 'masonry' ) )
								? ' ' . esc_attr( $custom_type ) . '_wrap' . ( $columns > 1 ? ' ' . esc_attr( $custom_type . '_' . $columns ) : '' )
								: ' columns_wrap columns_padding_bottom' )
							: '' )
					;
				// Scripts for masonry and portfolio
				if ( in_array( $atts['type'], array( 'gallery', 'portfolio', 'masonry' ) ) || in_array( $custom_type, array( 'gallery', 'portfolio', 'masonry' ) ) ) {
                    ozeum_lazy_load_off();
				    ozeum_load_masonry_scripts();
				}
			}
		}
		return $atts;
	}
}


// Add new params to the default shortcode's atts
if ( ! function_exists( 'ozeum_trx_addons_sc_atts' ) ) {
	add_filter( 'trx_addons_sc_atts', 'ozeum_trx_addons_sc_atts', 10, 2 );
	function ozeum_trx_addons_sc_atts( $atts, $sc ) {

		// Param 'scheme'
		if ( in_array(
			$sc, array(
				'trx_sc_action',
				'trx_sc_blogger',
				'trx_sc_cars',
				'trx_sc_courses',
				'trx_sc_content',
				'trx_sc_dishes',
				'trx_sc_events',
				'trx_sc_form',
				'trx_sc_googlemap',
				'trx_sc_yandexmap',
				'trx_sc_osmap',
				'trx_sc_layouts',
				'trx_sc_portfolio',
				'trx_sc_price',
				'trx_sc_promo',
				'trx_sc_properties',
				'trx_sc_services',
				'trx_sc_team',
				'trx_sc_testimonials',
				'trx_sc_title',
				'trx_widget_audio',
				'trx_widget_twitter',
				'trx_sc_layouts_container',
			)
		) ) {
			$atts['scheme'] = 'inherit';
		}
		// Param 'color_style'
		if ( in_array(
			$sc, array(
				'trx_sc_action',
				'trx_sc_blogger',
				'trx_sc_cars',
				'trx_sc_courses',
				'trx_sc_content',
				'trx_sc_dishes',
				'trx_sc_events',
				'trx_sc_form',
				'trx_sc_icons',
				'trx_sc_googlemap',
				'trx_sc_yandexmap',
				'trx_sc_osmap',
				'trx_sc_portfolio',
				'trx_sc_price',
				'trx_sc_promo',
				'trx_sc_properties',
				'trx_sc_services',
				'trx_sc_team',
				'trx_sc_testimonials',
				'trx_sc_title',
				'trx_widget_audio',
				'trx_widget_twitter'
			)
		) ) {
			$atts['color_style'] = 'default';
		}
		if ( in_array(
			$sc, array(
				'trx_sc_button',
			)
		) ) {
			if ( is_array( $atts['buttons'] ) ) {
				foreach( $atts['buttons'] as $k => $v ) {
					$atts['buttons'][ $k ]['color_style'] = 'default';
				}
			}
		}
		return $atts;
	}
}

// Add new params to the shortcodes VC map
if ( ! function_exists( 'ozeum_trx_addons_sc_map' ) ) {
	add_filter( 'trx_addons_sc_map', 'ozeum_trx_addons_sc_map', 10, 2 );
	function ozeum_trx_addons_sc_map( $params, $sc ) {

		// Param 'scheme'
		if ( in_array(
			$sc, array(
				'trx_sc_action',
				'trx_sc_blogger',
				'trx_sc_cars',
				'trx_sc_courses',
				'trx_sc_content',
				'trx_sc_dishes',
				'trx_sc_events',
				'trx_sc_form',
				'trx_sc_googlemap',
				'trx_sc_yandexmap',
				'trx_sc_osmap',
				'trx_sc_layouts',
				'trx_sc_portfolio',
				'trx_sc_price',
				'trx_sc_promo',
				'trx_sc_properties',
				'trx_sc_services',
				'trx_sc_skills',
				'trx_sc_socials',
				'trx_sc_table',
				'trx_sc_team',
				'trx_sc_testimonials',
				'trx_sc_title',
				'trx_widget_audio',
				'trx_widget_twitter',
				'trx_sc_layouts_container',
			)
		) ) {
			if ( empty( $params['params'] ) || ! is_array( $params['params'] ) ) {
				$params['params'] = array();
			}
			$params['params'][] = array(
				'param_name'  => 'scheme',
				'heading'     => esc_html__( 'Color scheme', 'ozeum' ),
				'description' => wp_kses_data( __( 'Select color scheme to decorate this block', 'ozeum' ) ),
				'group'       => esc_html__( 'Colors', 'ozeum' ),
				'admin_label' => true,
				'value'       => array_flip( ozeum_get_list_schemes( true ) ),
				'type'        => 'dropdown',
			);
		}
		// Param 'color_style'
		$param = array(
			'param_name'       => 'color_style',
			'heading'          => esc_html__( 'Color style', 'ozeum' ),
			'description'      => wp_kses_data( __( 'Select color style to decorate this block', 'ozeum' ) ),
			'edit_field_class' => 'vc_col-sm-4',
			'admin_label'      => true,
			'value'            => array_flip( ozeum_get_list_sc_color_styles() ),
			'type'             => 'dropdown',
		);
		if ( in_array( $sc, array( 'trx_sc_button' ) ) ) {
			if ( empty( $params['params'] ) || ! is_array( $params['params'] ) ) {
				$params['params'] = array();
			}
			foreach ( $params['params'] as $k => $p ) {
				if ( 'buttons' == $p['param_name'] ) {
					if ( ! empty( $p['params'] ) ) {
						$new_params = array();
						foreach ( $p['params'] as $v ) {
							$new_params[] = $v;
							if ( 'size' == $v['param_name'] ) {
								$new_params[] = $param;
							}
						}
						$params['params'][ $k ]['params'] = $new_params;
					}
				}
			}
		} elseif ( in_array(
			$sc, array(
				'trx_sc_action',
				'trx_sc_blogger',
				'trx_sc_cars',
				'trx_sc_courses',
				'trx_sc_content',
				'trx_sc_dishes',
				'trx_sc_events',
				'trx_sc_form',
				'trx_sc_icons',
				'trx_sc_googlemap',
				'trx_sc_yandexmap',
				'trx_sc_osmap',
				'trx_sc_portfolio',
				'trx_sc_price',
				'trx_sc_promo',
				'trx_sc_properties',
				'trx_sc_services',
				'trx_sc_skills',
				'trx_sc_socials',
				'trx_sc_table',
				'trx_sc_team',
				'trx_sc_testimonials',
				'trx_sc_title',
				'trx_widget_audio',
				'trx_widget_twitter',
			)
		) ) {
			if ( empty( $params['params'] ) || ! is_array( $params['params'] ) ) {
				$params['params'] = array();
			}
			$new_params = array();
			foreach ( $params['params'] as $v ) {
				if ( in_array( $v['param_name'], array( 'title_style', 'title_tag', 'title_align' ) ) ) {
					$v['edit_field_class'] = 'vc_col-sm-6';
				}
				$new_params[] = $v;
				if ( 'title_align' == $v['param_name'] ) {
					if ( ! empty( $v['group'] ) ) {
						$param['group'] = $v['group'];
					}
					$param['edit_field_class'] = 'vc_col-sm-6';
					$new_params[]              = $param;
				}
			}
			$params['params'] = $new_params;
		}
		return $params;
	}
}



// Add classes to the shortcode's output from new params
if ( ! function_exists( 'ozeum_trx_addons_sc_output' ) ) {
	add_filter( 'trx_addons_sc_output', 'ozeum_trx_addons_sc_output', 10, 4 );
	function ozeum_trx_addons_sc_output( $output, $sc, $atts, $content ) {
		$sc = str_replace( array( 'trx_widget', 'trx_' ), array( 'sc_widget', '' ), $sc );
		if ( substr( $sc, -3 ) == 'map' ) {
			$sc = str_replace( 'map', 'map_content', $sc );
		}
		if ( ! empty( $atts['scheme'] ) && ! ozeum_is_inherit( $atts['scheme'] ) ) {
			$output = str_replace( 'class="' . esc_attr( $sc ) . ' ', 'class="' . esc_attr( $sc ) . ' scheme_' . esc_attr( $atts['scheme'] ) . ' ', $output );
		}
		if ( ! empty( $atts['color_style'] ) && ! ozeum_is_inherit( $atts['color_style'] ) && 'default' != $atts['color_style'] ) {
			$output = str_replace( 'class="' . esc_attr( $sc ) . ' ', 'class="' . esc_attr( $sc ) . ' color_style_' . esc_attr( $atts['color_style'] ) . ' ', $output );
		}
		return $output;
	}
}

// Add color_style to the button items
if ( ! function_exists( 'ozeum_trx_addons_sc_item_link_classes' ) ) {
	add_filter( 'trx_addons_filter_sc_item_link_classes', 'ozeum_trx_addons_sc_item_link_classes', 10, 3 );
	function ozeum_trx_addons_sc_item_link_classes( $class, $sc, $atts=array() ) {
		if ( 'sc_button' == $sc ) {
			if ( ! empty( $atts['color_style'] ) && ! ozeum_is_inherit( $atts['color_style'] ) && 'default' != $atts['color_style'] ) {
				$class .= ' color_style_' . esc_attr( $atts['color_style'] );
			}
		}
		return $class;
	}
}



// Return tag for the item's title
if ( ! function_exists( 'ozeum_trx_addons_sc_item_title_tag' ) ) {
	add_filter( 'trx_addons_filter_sc_item_title_tag', 'ozeum_trx_addons_sc_item_title_tag' );
	function ozeum_trx_addons_sc_item_title_tag( $tag = '' ) {
		return 'h1' == $tag ? 'h2' : $tag;
	}
}

// Return args for the item's button
if ( ! function_exists( 'ozeum_trx_addons_sc_item_button_args' ) ) {
	add_filter( 'trx_addons_filter_sc_item_button_args', 'ozeum_trx_addons_sc_item_button_args', 10, 3 );
	function ozeum_trx_addons_sc_item_button_args( $args, $sc, $sc_args ) {
		if ( ! empty( $sc_args['color_style'] ) ) {
			$args['color_style'] = $sc_args['color_style'];
		}
		return $args;
	}
}

// Add new styles to the Google map
if ( ! function_exists( 'ozeum_trx_addons_sc_googlemap_styles' ) ) {
	add_filter( 'trx_addons_filter_sc_googlemap_styles', 'ozeum_trx_addons_sc_googlemap_styles' );
	function ozeum_trx_addons_sc_googlemap_styles( $list ) {
		$list['dark'] = esc_html__( 'Dark', 'ozeum' );
		return $list;
	}
}


// Remove input hover effects
if ( !function_exists( 'ozeum_filter_get_list_input_hover' ) ) {
    add_filter( 'trx_addons_filter_get_list_input_hover', 'ozeum_filter_get_list_input_hover');
    function ozeum_filter_get_list_input_hover($list) {
        unset($list['accent']);
        unset($list['path']);
        unset($list['jump']);
        unset($list['underline']);
        unset($list['iconed']);
        return $list;
    }
}



// Show reactions in the single posts
if ( ! function_exists( 'ozeum_trx_addons_action_before_post_meta' ) ) {
	
	function ozeum_trx_addons_action_before_post_meta() {
		if ( ozeum_exists_trx_addons() ) {
			if ( is_single() && ! is_attachment() && ! trx_addons_sc_stack_check() ) {
                // Emotions
                if ( trx_addons_is_on( trx_addons_get_option( 'emotions_allowed' ) ) ) {
                    trx_addons_get_post_reactions( true );
                }
            }
		}
	}
}


// WP Editor addons
//------------------------------------------------------------------------

// Theme-specific configure of the WP Editor
if ( ! function_exists( 'ozeum_trx_addons_tiny_mce_style_formats' ) ) {
	add_filter( 'trx_addons_filter_tiny_mce_style_formats', 'ozeum_trx_addons_tiny_mce_style_formats' );
	function ozeum_trx_addons_tiny_mce_style_formats( $style_formats ) {
		// Add style 'Circle' to the 'List styles'
		if ( is_array( $style_formats ) && count( $style_formats ) > 0 ) {
			foreach ( $style_formats as $k => $v ) {
				if ( esc_html__( 'List styles', 'ozeum' ) == $v['title'] ) {
                    $style_formats[ $k ]['items'][] = array(
                        'title'    => esc_html__( 'Circle', 'ozeum' ),
                        'selector' => 'ul',
                        'classes'  => 'trx_addons_list trx_addons_list_circle',
                    );
                }
                if ( esc_html__( 'Inline', 'ozeum' ) == $v['title'] ) {
                    $style_formats[ $k ]['items'][] = array(
                        'title'    => esc_html__( 'Copyright', 'ozeum' ),
                        'inline' => 'span',
                        'classes'  => 'trx_addons_copyright',
                    );
                }
			}
		}
		return $style_formats;
	}
}


// Setup team and portflio pages
//------------------------------------------------------------------------

// Disable override header image on team and portfolio pages
if ( ! function_exists( 'ozeum_trx_addons_allow_override_header_image' ) ) {
	add_filter( 'ozeum_filter_allow_override_header_image', 'ozeum_trx_addons_allow_override_header_image' );
	function ozeum_trx_addons_allow_override_header_image( $allow ) {
		return is_single()
				&& (
					ozeum_is_team_page()
					|| ozeum_is_cars_page()
					|| ozeum_is_cars_agents_page()
					|| ozeum_is_properties_agents_page()
					)
				? false
				: $allow;
	}
}


// Change thumb size for the team items
if ( ! function_exists( 'ozeum_trx_addons_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_thumb_size', 'ozeum_trx_addons_thumb_size', 10, 2 );
	function ozeum_trx_addons_thumb_size( $thumb_size = '', $type = '' ) {
		// ToDo: Change team members image's size (default is 'avatar'):
       if ($type == 'team-default') $thumb_size = ozeum_get_thumb_size('rectangle');
       if ($type == 'team-short') $thumb_size = ozeum_get_thumb_size('rectangle');

		return $thumb_size;
	}
}

// Change thumb size for the events list
if ( ! function_exists( 'ozeum_trx_addons_events_list_thumb_size' ) ) {
    add_filter('tribe_event_featured_image_size', 'ozeum_trx_addons_events_list_thumb_size', 10, 2);
    function ozeum_trx_addons_events_list_thumb_size($thumb_size = '')    {
        if ( tribe_is_list_view() || tribe_is_day() ) {
            $thumb_size = ozeum_get_thumb_size('rectangle');
        }
        return $thumb_size;
    }
}



// Modify layouts of some components
//------------------------------------------------------------------------

// Return theme specific title layout for the slider
if ( ! function_exists( 'ozeum_trx_addons_slider_title' ) ) {
	add_filter( 'trx_addons_filter_slider_title', 'ozeum_trx_addons_slider_title', 10, 2 );
	function ozeum_trx_addons_slider_title( $title, $data ) {
		$title = '';
		if ( ! empty( $data['title'] ) ) {
			$title .= '<h3 class="slide_title">'
						. ( ! empty( $data['link'] ) ? '<a href="' . esc_url( $data['link'] ) . '">' : '' )
							. esc_html( $data['title'] )
						. ( ! empty( $data['link'] ) ? '</a>' : '' )
					. '</h3>';
		}
		if ( ! empty( $data['cats'] ) ) {
			$title .= sprintf( '<div class="slide_cats">%s</div>', $data['cats'] );
		}
		return $title;
	}
}
