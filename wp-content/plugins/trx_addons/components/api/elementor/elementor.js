/* global jQuery:false, elementorFrontend:false */

(function() {

	"use strict";

	var trx_addons_once_resize = false;

	var $body = jQuery( 'body' );

	jQuery( document ).on( 'action.init_hidden_elements', function(e, cont) {
		// Disable Elementor's lightbox on the .esgbox links
		//jQuery('.elementor-widget-container a.esgbox').attr('data-elementor-open-lightbox', 'no');
		cont.find('a.esgbox').attr('data-elementor-open-lightbox', 'no');

		// Disable Elementor's lightbox on every link to the large image
		cont.find('a[href$=".jpg"],a[href$=".jpeg"],a[href$=".png"],a[href$=".gif"]').attr('data-elementor-open-lightbox', 'no');

		// or Disable Elementor's lightbox only on the standard gallery
		//cont.find('.wp-block-gallery a[href$=".jpg"],.wp-block-gallery a[href$=".jpeg"],.wp-block-gallery a[href$=".png"],.wp-block-gallery a[href$=".gif"]').attr('data-elementor-open-lightbox', 'no');
	} );

	jQuery( window ).on( 'elementor/frontend/init', function() {

		if ( typeof window.elementorFrontend !== 'undefined' && typeof window.elementorFrontend.hooks !== 'undefined' ) {

			// If Elementor is in the Editor's Preview mode
			if ( elementorFrontend.isEditMode() ) {

				// Init elements after creation
				elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $cont ) {

					// Add 'sc_layouts_item'
					var body = $cont.parents('body');
					if ( body.hasClass('cpt_layouts-template') || body.hasClass('cpt_layouts-template-default') || body.hasClass('single-cpt_layouts') ) {
						body.find('.elementor-element.elementor-widget').addClass('sc_layouts_item');
					}
					
					// Remove TOC if exists (rebuild on init_hidden_elements)
					jQuery('#toc_menu').remove();

					// Init hidden elements (widgets, shortcodes) when its added to the preview area
					jQuery(document).trigger('action.init_hidden_elements', [$cont]);

					// Trigger 'resize' actions after the element is added (inited)
					if ( $cont.parents('.elementor-section-stretched').length > 0 && !trx_addons_once_resize ) {
						trx_addons_once_resize = true;
						jQuery(document).trigger('action.resize_trx_addons', [$cont.parents('.elementor-section-stretched')]);
					} else {
						jQuery(document).trigger('action.resize_trx_addons', [$cont]);
					}
			
					trx_addons_elementor_animate_items();

				} );

				// First init - add wrap 'sc_layouts_item'
				var body = jQuery('body');
				if (body.hasClass('cpt_layouts-template') || body.hasClass('cpt_layouts-template-default') || body.hasClass('single-cpt_layouts'))
					jQuery('.elementor-element.elementor-widget').addClass('sc_layouts_item');

				// First init - refresh theme-specific shapes
				jQuery('.elementor-shape').each(function() {
					var shape = jQuery(this).data('shape');
					if (shape!==undefined && shape.indexOf('trx_addons_')==0)
						trx_addons_load_shape(jQuery(this), shape);
				});

				// Load theme-specific shape to the container
				function trx_addons_load_shape(cont, shape) {
					if (cont.length > 0 && shape !== '') {
						cont.empty().attr( 'data-shape', shape );
						shape = TRX_ADDONS_STORAGE['shapes_url'] + shape.replace('trx_addons_', '') + '.svg';
						jQuery.get( shape, function( data ) {
							cont.append(data.childNodes[0]).attr('data-negative', 'false');
						} );
					}
				}

				// Shift elements down under fixed rows
				elementorFrontend.hooks.addFilter( 'frontend/handlers/menu_anchor/scroll_top_distance', function( scrollTop ) {
					return scrollTop - trx_addons_fixed_rows_height();
				} );

			// If Elementor is in Frontend
			} else {
				// Add page settings to the elementorFrontend object
				// in the frontend for non-Elementor pages (blog pages, categories, tags, etc.)
				if (typeof elementorFrontend.config !== 'undefined'
					&& typeof elementorFrontend.config.settings !== 'undefined'
					&& typeof elementorFrontend.config.settings.general === 'undefined'
				) {
					elementorFrontend.config.settings.general = {
						'elementor_stretched_section_container': TRX_ADDONS_STORAGE['elementor_stretched_section_container']
					};
				}
				// Call 'resize' handlers after Elementor inited
				// Use setTimeout to run our code after Elementor's stretch row code!
				setTimeout(function() {
					trx_addons_once_resize = true;
					jQuery(document).trigger('action.resize_trx_addons');
				}, 0);
			}
		}

	});


	// Move entrance animation parameters from the shortcode's wrapper to the items
	// to make sequental or random animation item by item
	jQuery( document ).on( 'action.init_hidden_elements', function(e, cont) {
		trx_addons_elementor_animate_items();
	} );

	window.trx_addons_elementor_animate_items = function( force ) {
		jQuery('[class*="animation_type_"]:not(.animation_type_block)' + ( ! force ? ':not(.animated-separate)' : '' )).each( function() {
			var sc = jQuery(this),
				sc_name = sc.data('widget_type');
			if ( sc_name ) {
				sc_name = sc_name.split('.');
				sc_name = '.' + sc_name[0].replace('trx_', '') + '_item';
				if ( sc.find( sc_name ).length == 0 ) {
					sc_name = '.post_item';
					if ( sc.find( sc_name ).length == 0 ) {
						sc_name = '[class*="column-"]';
					}
				}
			} else {
				sc_name = '[class*="column-"]';
			}
			var items = sc.find( sc_name );
			if ( items.length == 0 ) {
				sc.addClass( 'animation_type_block' );
				return;
			}
			var cid         = sc.data('model-cid'),
				params      = cid ? trx_addons_elementor_get_settings_by_cid( cid, ['_animation'] ) : sc.data('settings'),
				item_params = {},
				item_speed  = sc.hasClass( 'animated-slow' )
								? 'animated-slow'
								: ( sc.hasClass( 'animated-fast' )
									? 'animated-fast'
									: ''
									);
			if ( ! params ) {
				return;
			}
			for (var i in params) {
				if (i.substr(0, 10) == '_animation' || i.substr(0, 9) == 'animation') {
					item_params[i] = params[i];
					delete params[i];
				}
			}
			sc.removeClass('elementor-invisible animated '
					+ trx_addons_elementor_animate_items_animation( item_params ) 
					+ ( sc.data('last-animation') ? ' ' + sc.data('last-animation') : '' )
					)
				.addClass('animated-separate')
				.data( 'last-animation', trx_addons_elementor_animate_items_animation( item_params ) );
			if ( ! cid ) {
				sc.data('settings', params);
			}
			if ( item_speed != '' ) {
				sc.removeClass( item_speed );
			}
			sc.data( 'animation-settings', item_params );
			items.each( function(idx) {
				var item = jQuery(this);
				if ( item_speed != '' ) {
					item.addClass( item_speed );
				}
				item.addClass('elementor-invisible animated-item');
			} );

			if ( force ) {
				trx_addons_elementor_animate_items_scroll( force );
			}
		} );
	};

	function trx_addons_elementor_get_settings_by_cid( cid, keys ) {
		if ( typeof elementorFrontend != 'undefined' ) {
			var settings = elementorFrontend.config.elements.data[cid].attributes;
			if ( keys ) {
				var params = {};
				for ( var s in settings ) {
					for ( var i = 0; i < keys.length; i++ ) {
						if ( s.indexOf( keys[i] ) == 0 ) {
							params[s] = settings[s];
							break;
						}
					}
				}
				return params;
			}
			return settings;
		}
		return false;
	}

	// Add entrance animation for items (Elementor is not init its)
	jQuery(document).on('action.scroll_trx_addons', function() {
		trx_addons_elementor_animate_items_scroll();
	} );

	function trx_addons_elementor_animate_items_scroll( force ) {
		jQuery('[class*="animated-item"]' + ( ! force ? ':not(.animated)' : '' )).each(function(idx) {
			var item = jQuery(this);
			if (item.offset().top + 50 < jQuery(window).scrollTop() + jQuery(window).height() && ( force || ! item.hasClass('animated') ) ) {
				var sc = item.parents( '.animated-separate' );
				var item_params = sc.data('animation-settings'),
					item_delay = trx_addons_elementor_animate_items_delay(item_params, sc, idx),
					item_animation = trx_addons_elementor_animate_items_animation(item_params);
				if ( force ) {
					item.removeClass( item_animation + ( item.data('last-animation') ? ' ' + item.data('last-animation') : '' ) )
						.addClass('elementor-invisible')
						.data('last-animation', item_animation);
				} else {
					item.addClass('animated');
				}
				setTimeout( function() {
					item.removeClass('elementor-invisible').addClass(item_animation);
				}, item_delay );
			}
		});
	}

	function trx_addons_elementor_animate_items_delay( params, sc, idx ) {
		return sc.hasClass( 'animation_type_sequental' )
					? ( params && params._animation_delay ? params._animation_delay : 150 ) * idx
					: trx_addons_random( 0, params && params._animation_delay ? params._animation_delay : 1500 );
	}

	function trx_addons_elementor_animate_items_animation( params ) {
		var device = $body.data( 'elementor-device-mode' );
		if ( ! device || device == 'desktop' ) {
			device = '';
		} else {
			device = '_' + device;
		}
		return params
			? ( typeof params["_animation" + device] != 'undefined' ? params["_animation" + device] : params["_animation"] )
			: '';
	}

})();