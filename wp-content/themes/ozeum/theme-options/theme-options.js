/* global jQuery:false */
/* global OZEUM_STORAGE:false */

//-------------------------------------------
// Theme Options fields manipulations
//-------------------------------------------

jQuery( window ).on( 'scroll', function() {

	"use strict";

	var header = jQuery( '.ozeum_options_header' );
	if ( header.length !== 0 ) {
		var placeholder = jQuery( '.ozeum_options_header_placeholder' );
		if ( jQuery( '.ozeum_options_header_placeholder' ).length === 0 ) {
			jQuery( '.ozeum_options_header' ).before( '<div class="ozeum_options_header_placeholder"></div>' );
			placeholder = jQuery( '.ozeum_options_header_placeholder' );
		}
		if ( placeholder.length !== 0 ) {
			header.toggleClass( 'sticky', placeholder.offset().top <= jQuery( window ).scrollTop() + jQuery( '#wpadminbar' ).height() );
		}
	}
} );

jQuery( document ).ready( function() {

	"use strict";

	// Save options
	jQuery( '.ozeum_options_button_submit' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.ozeum_options' ).find( 'form' );
			form.submit();
			e.preventDefault();
			return false;
		} );

	// Reset options
	jQuery( '.ozeum_options_button_reset' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.ozeum_options' ).find( 'form' );
			if ( typeof trx_addons_msgbox_confirm != 'undefined' ) {
				trx_addons_msgbox_confirm(
					OZEUM_STORAGE[ 'msg_reset_confirm' ],
					OZEUM_STORAGE[ 'msg_reset' ],
					function( btn ) {
						if ( btn === 1 ) {
							form.find( 'input[name="ozeum_options_field_reset_options"]' ).val( 1 );
							form.submit();
						}
					}
				);
			} else if ( confirm( OZEUM_STORAGE[ 'msg_reset_confirm' ] ) ) {
				form.find( 'input[name="ozeum_options_field_reset_options"]' ).val( 1 ).end().submit();
			}
			e.preventDefault();
			return false;
		} );

	// Export options
	jQuery( '.ozeum_options_button_export' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.ozeum_options' ).find( 'form' ),
				data = '';
			form.find('[data-param]').each( function() {
				form
					.find('[name="ozeum_options_field_' + jQuery(this).data('param') + '"],[name^="ozeum_options_field_' + jQuery(this).data('param') + '["]')
					.each(function() {
						var fld = jQuery(this),
							fld_name = fld.attr('name'),
							fld_type = fld.attr('type') ? fld.attr('type') : fld.get(0).tagName.toLowerCase();
						if ( fld_type == 'checkbox' ) {
							data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.get(0).checked ? fld.val() : 0 );
						} else if ( fld_type != 'radio' || fld.get(0).checked ) {
							data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.val() );
						}
					});
			});
			if ( typeof trx_addons_msgbox_info != 'undefined' ) {
				trx_addons_msgbox_info(
					jQuery.ozeum_encoder.encode( data ),
					OZEUM_STORAGE[ 'msg_export' ] + ': ' + OZEUM_STORAGE[ 'msg_export_options' ],
					'info',
					0
				);
			} else {
				alert( OZEUM_STORAGE[ 'msg_export_options' ] + ':\n\n' + jQuery.ozeum_encoder.encode( data ) );
			}
			e.preventDefault();
			return false;
		} );

	// Import options
	jQuery( '.ozeum_options_button_import' )
		.on( 'click', function( e ) {
			var form = jQuery( this ).parents( '.ozeum_options' ).find( 'form' ),
				data = '';
			if ( typeof trx_addons_msgbox_dialog != 'undefined' ) {
				trx_addons_msgbox_dialog(
					'<textarea rows="10" cols="100"></textarea>',
					OZEUM_STORAGE[ 'msg_import' ] + ': ' + OZEUM_STORAGE[ 'msg_import_options' ],
					null,
					function(btn, box) {
						if ( btn === 1 ) {
							ozeum_options_import_data( box.find('textarea').val() );
						}
					}
				);
			} else if ( ( data = prompt( OZEUM_STORAGE[ 'msg_import_options' ], '' ) ) !== '' ) {
				ozeum_options_import_data( data );
			}

			function ozeum_options_import_data( data ) {
				if ( data ) {
					data = jQuery.ozeum_encoder.decode( data ).split( '&' );
					for ( var i in data ) {
						var param = data[i].split('=');
						if ( param.length == 2 && param[0].substr(-6) != '_nonce' ) {
							var fld = form.find('[name="'+param[0]+'"]'),
								val = decodeURIComponent(param[1]);
							if ( fld.attr('type') == 'radio' || fld.attr('type') == 'checkbox' ) {
								fld.removeAttr( 'checked' );
								fld.each( function() {
									var item = jQuery(this);
									if ( item.val() == val ) {
										item.get(0).checked = true;
										item.attr('checked', 'checked');
									}
								} );
							} else {
								fld.val( val );
							}
						}
					}
					form.submit();
				} else {
					if ( typeof trx_addons_msgbox_warning != 'undefined' ) {
						trx_addons_msgbox_warning(
							OZEUM_STORAGE[ 'msg_import_error' ],
							OZEUM_STORAGE[ 'msg_import' ]
						);
					}
				}
			}

			e.preventDefault();
			return false;

		} );

	// Create preset with options
	jQuery( '.ozeum_options_presets_add' )
		.on( 'click', function( e ) {
			if ( typeof trx_addons_msgbox_dialog != 'undefined' ) {
				var preset_name = '';
				trx_addons_msgbox_dialog(
					'<label>' + OZEUM_STORAGE[ 'msg_presets_add' ]
						+ '<br><input type="text" value="" name="preset_name">'
						+ '</label>',
					OZEUM_STORAGE[ 'msg_presets' ],
					null,
					function(btn, box) {
						if ( btn === 1 ) {
							var preset_name = box.find('input[name="preset_name"]').val();
							if ( preset_name !== '' ) {
								ozeum_options_presets_create( preset_name );
							}
						}
					}
				);
			} else if ( ( preset_name = prompt( OZEUM_STORAGE[ 'msg_presets_add' ], '' ) ) !== '' ) {
				ozeum_options_presets_create( preset_name );
			}
			// Create new preset: send it to server and add to the presets list
			function ozeum_options_presets_create( preset_name ) {
				var form = jQuery( '.ozeum_tabs' ),
					data = '';
				form.find('[data-param]').each( function() {
					form
						.find('[name="ozeum_options_field_' + jQuery(this).data('param') + '"],[name^="ozeum_options_field_' + jQuery(this).data('param') + '["]')
						.each(function() {
							var fld = jQuery(this),
								fld_name = fld.attr('name'),
								fld_type = fld.attr('type') ? fld.attr('type') : fld.get(0).tagName.toLowerCase();
							if ( fld_name == 'ozeum_options_field_presets' ) {
								return;
							} else if ( fld.parents('.ozeum_options_item').hasClass( 'ozeum_options_inherit_on' ) ) {
								data += ( data ? '&' : '' ) + fld_name + '=inherit';
							} else if ( fld_type == 'checkbox' ) {
								data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.get(0).checked ? fld.val() : 0 );
							} else if ( fld_type != 'radio' || fld.get(0).checked ) {
								data += ( data ? '&' : '' ) + fld_name + '=' + encodeURIComponent( fld.val() );
							}
						});
				});
				data = jQuery.ozeum_encoder.encode( data );
				jQuery.post(OZEUM_STORAGE['ajax_url'], {
					action: 'ozeum_add_options_preset',
					nonce: OZEUM_STORAGE['ajax_nonce'],
					preset_name: preset_name,
					preset_data: data,
					preset_type: jQuery( '.ozeum_options_presets_list' ).data( 'type' )
				}).done(function(response) {
					var rez = {};
					if (response === '' || response === 0) {
						rez = { error: OZEUM_STORAGE['msg_ajax_error'] };
					} else {
						try {
							rez = JSON.parse(response);
						} catch (e) {
							rez = { error: OZEUM_STORAGE['msg_ajax_error'] };
							console.log(response);
						}
					}
					if ( rez.success ) {
						var presets_list = jQuery( '.ozeum_options_presets_list' ).get(0),
							idx = ozeum_find_listbox_item_by_text( presets_list, preset_name );
						if ( idx >= 0 ) {
							presets_list.options[idx].value = data;
						} else {
							ozeum_add_listbox_item( presets_list, data, preset_name );
						}
						ozeum_select_listbox_item_by_text( presets_list, preset_name );
					}
					if ( typeof window.trx_addons_msgbox != 'undefined' ) {
						trx_addons_msgbox({
							msg: rez.error ? rez.error : rez.success,
							hdr: OZEUM_STORAGE[ 'msg_presets' ],
							icon: rez.error ? 'cancel' : 'check',
							type: rez.error ? 'error' : 'success',
							delay: 0,
							buttons: [ TRX_ADDONS_STORAGE['msg_caption_ok'] ],
							callback: null
						});
					} else {
						alert( rez.error ? rez.error : rez.success );
					}
				});
			}
			e.preventDefault();
			return false;
		} );

	// Apply selected preset
	jQuery( '.ozeum_options_presets_apply' )
		.on( 'click', function( e ) {
			var preset_data = jQuery( '.ozeum_options_presets_list' ).val();
			if ( preset_data !== '' ) {
				if ( typeof trx_addons_msgbox_confirm != 'undefined' ) {
					trx_addons_msgbox_confirm(
						OZEUM_STORAGE[ 'msg_presets_apply' ],
						OZEUM_STORAGE[ 'msg_presets' ],
						function(btn, box) {
							if ( btn === 1 ) {
								ozeum_options_presets_apply( preset_data );
							}
						}
					);
				} else if ( confirm( OZEUM_STORAGE[ 'msg_presets_apply' ] ) ) {
					ozeum_options_presets_apply( preset_data );
				}
			}
			function ozeum_options_presets_apply( data ) {
				var form = jQuery( '.ozeum_tabs' );
				data = jQuery.ozeum_encoder.decode( data ).split( '&' );
				for ( var i in data ) {
					var param = data[i].split('=');
					if ( param.length == 2 && param[0].substr(-6) != '_nonce' && param[0].substr(-8) != '_presets' ) {
						var fld = form.find('[name="'+param[0]+'"]'),
							type = fld.parents('[data-type]').data( 'type' ),
							val = decodeURIComponent(param[1]);
						if ( val != 'inherit' ) {
							if ( type == 'switch' ) {
								if ( val != 'inherit' ) {
									fld.next().get( 0 ).checked = val == 1;
									fld.next().trigger('change');
								}
							} else if ( type == 'image' ) {
								var images = val.split( ','),
									preview = fld.next();
								preview.empty();
								for (var img=0; img < images.length; img++) {
									if ( images[img].trim() !== '' ) {
										preview
											.append(
												'<span class="ozeum_media_selector_preview_image" tabindex="0">'
													+ '<img src="' + images[img].trim() + '">'
													+ '</span>'
											)
											.css( {
												'display': 'block'
											} );
									}
								}
							} else if ( fld.attr('type') == 'radio' || fld.attr('type') == 'checkbox' ) {
								fld.removeAttr( 'checked' );
								fld.each( function() {
									var item = jQuery(this);
									if ( item.val() == val ) {
										item.get(0).checked = true;
										item.attr('checked', 'checked');
									}
								} );
							} else {
								fld.val( val );
							}
							fld.trigger( 'change' );
						}
						var item = fld.parents( '.ozeum_options_item' );
						if ( ( val == 'inherit' && ! item.hasClass( 'ozeum_options_inherit_on' ) )
							|| ( val != 'inherit' && ! item.hasClass( 'ozeum_options_inherit_off' ) )
						) {
							item.find( '.ozeum_options_inherit_lock' ).trigger( 'click' );
						}
					}
				}
			}
			e.preventDefault();
			return false;
		} );

	// Delete selected preset
	jQuery( '.ozeum_options_presets_delete' )
		.on( 'click', function( e ) {
			var presets_list = jQuery( '.ozeum_options_presets_list' ).get(0),
				preset_data  = ozeum_get_listbox_selected_value( presets_list ),
				preset_name  = ozeum_get_listbox_selected_text( presets_list );
			if ( preset_data ) {
				if ( typeof trx_addons_msgbox_confirm != 'undefined' ) {
					trx_addons_msgbox_confirm(
						OZEUM_STORAGE[ 'msg_presets_delete' ],
						OZEUM_STORAGE[ 'msg_presets' ],
						function(btn, box) {
							if ( btn === 1 ) {
								ozeum_options_presets_delete( preset_name );
							}
						}
					);
				} else if ( confirm( OZEUM_STORAGE[ 'msg_presets_delete' ] ) ) {
					ozeum_options_presets_delete( preset_name );
				}
			}
			function ozeum_options_presets_delete( preset_name ) {
				jQuery.post(OZEUM_STORAGE['ajax_url'], {
					action: 'ozeum_delete_options_preset',
					nonce: OZEUM_STORAGE['ajax_nonce'],
					preset_name: preset_name,
					preset_type: jQuery( '.ozeum_options_presets_list' ).data( 'type' )
				}).done(function(response) {
					var rez = {};
					if (response === '' || response === 0) {
						rez = { error: OZEUM_STORAGE['msg_ajax_error'] };
					} else {
						try {
							rez = JSON.parse(response);
						} catch (e) {
							rez = { error: OZEUM_STORAGE['msg_ajax_error'] };
							console.log(response);
						}
					}
					if ( rez.success ) {
						ozeum_del_listbox_item_by_text( presets_list, preset_name );
						ozeum_select_listbox_item_by_value( presets_list, '' );
					}
					if ( typeof window.trx_addons_msgbox != 'undefined' ) {
						trx_addons_msgbox({
							msg: rez.error ? rez.error : rez.success,
							hdr: OZEUM_STORAGE[ 'msg_presets' ],
							icon: rez.error ? 'cancel' : 'check',
							type: rez.error ? 'error' : 'success',
							delay: 0,
							buttons: [ TRX_ADDONS_STORAGE['msg_caption_ok'] ],
							callback: null
						});
					} else {
						alert( rez.error ? rez.error : rez.success );
					}
				});
			}
			e.preventDefault();
			return false;
		} );

	// Toggle checkbox value
	jQuery( '.ozeum_options input[type="checkbox"]' )
		.on( 'change', function() {
			var fld = jQuery(this).prev();
			fld.val( jQuery(this).get(0).checked ? 1 : 0 );
		} );

	// Init checkbox
	jQuery( '.ozeum_options_item_checkbox:not(.inited)' ).addClass( 'inited' )
		.on( 'keydown', '.ozeum_options_item_holder', function( e ) {
			// If 'Enter' or 'Space' is pressed - switch state of the checkbox
			if ( [ 13, 32 ].indexOf( e.which ) >= 0 ) {
				jQuery( this ).prev().get( 0 ).checked = ! jQuery( this ).prev().get( 0 ).checked;
				e.preventDefault();
				return false;
			}
			return true;
		} );
	
	// Init switch
	jQuery( '.ozeum_options_item_switch:not(.inited)' ).addClass( 'inited' )
		.on( 'keydown', '.ozeum_options_item_holder', function( e ) {
			// If 'Enter', 'Space',  Left' or 'Right' arrow is pressed - switch state of the checkbox
			if ( [ 13, 32, 37, 39 ].indexOf( e.which ) >= 0 ) {
				jQuery( this ).prev().get( 0 ).checked = ! jQuery( this ).prev().get( 0 ).checked;
				e.preventDefault();
				return false;
			}
			return true;
		} );
	
	// Init radio
	jQuery( '.ozeum_options_item_radio:not(.inited)' ).addClass( 'inited' )
		.on( 'keydown', '.ozeum_options_item_holder', function( e ) {
			// If 'Enter' or 'Space' is pressed - switch state of the checkbox
			if ( [ 13, 32 ].indexOf( e.which ) >= 0 ) {
				jQuery( this ).parents( 'ozeum_options_item_field' ).find( 'input:checked' ).each( function() {
					this.checked = false;
				});
				jQuery( this ).prev().get( 0 ).checked = true;
				e.preventDefault();
				return false;
			}
			return true;
		} );

	// Toggle inherit button and cover
	jQuery( '#ozeum_options_tabs' )
		.on( 'keydown', '.ozeum_options_inherit_lock', function( e ) {
			// If 'Enter' or 'Space' is pressed - trigger click on this object
			if ( [ 13, 32 ].indexOf( e.which ) >= 0 ) {
				jQuery( this ).trigger( 'click' );
				e.preventDefault();
				return false;
			}
			return true;
		} )
		.on( 'click', '.ozeum_options_inherit_lock,.ozeum_options_inherit_cover', function (e) {
			var parent  = jQuery( this ).parents( '.ozeum_options_item' );
			var inherit = parent.hasClass( 'ozeum_options_inherit_on' );
			if (inherit) {
				parent.removeClass( 'ozeum_options_inherit_on' ).addClass( 'ozeum_options_inherit_off' );
				parent.find( '.ozeum_options_inherit_cover' ).fadeOut().find( 'input[type="hidden"]' ).val( '' ).trigger('change');
			} else {
				parent.removeClass( 'ozeum_options_inherit_off' ).addClass( 'ozeum_options_inherit_on' );
				parent.find( '.ozeum_options_inherit_cover' ).fadeIn().find( 'input[type="hidden"]' ).val( 'inherit' ).trigger('change');

			}
			e.preventDefault();
			return false;
		} );

	// Button with action
	jQuery('.ozeum_options_item_button input[type="button"]:not(.inited),.ozeum_options_item_button .ozeum_options_button:not(.inited)').addClass('inited')
		.on('click', function(e) {
			var button = jQuery(this),
				cb = button.data('callback');
			if (cb !== undefined && typeof window[cb] !== 'undefined') {
				window[cb]();
			} else {
				jQuery.post(OZEUM_STORAGE['ajax_url'], {
					action: button.data('action'),
					nonce: OZEUM_STORAGE['ajax_nonce']
				}).done(function(response) {
					var rez = {};
					if (response === '' || response === 0) {
						rez = { error: OZEUM_STORAGE['msg_ajax_error'] };
					} else {
						try {
							rez = JSON.parse(response);
						} catch (e) {
							rez = { error: OZEUM_STORAGE['msg_ajax_error'] };
							console.log(response);
						}
					}
					if ( typeof window.trx_addons_msgbox != 'undefined' ) {
						trx_addons_msgbox({
							msg: typeof rez.data != 'undefined' ? rez.data : '',
							hdr: '',
							icon: 'check',
							type: 'success',
							delay: 0,
							buttons: [ TRX_ADDONS_STORAGE['msg_caption_ok'] ],
							callback: null
						});
					} else {
						alert(rez.error ? rez.error : rez.success);
					}
				});
			}
			e.preventDefault();
			return false;
		} );


	// Refresh linked field
	jQuery( '#ozeum_options_tabs' )
		.on( 'change', '[data-linked] select,[data-linked] input', function (e) {
			var chg_name          = jQuery( this ).parent().data( 'param' );
			var chg_value         = jQuery( this ).val();
			var linked_name       = jQuery( this ).parent().data( 'linked' );
			var linked_data       = jQuery( '#ozeum_options_tabs [data-param="' + linked_name + '"]' );
			var linked_field      = linked_data.find( 'select' );
			var linked_field_type = 'select';
			if (linked_field.length == 0) {
				linked_field      = linked_data.find( 'input' );
				linked_field_type = 'input';
			}
			var linked_lock = linked_data.parent().parent().find( '.ozeum_options_inherit_lock' ).addClass( 'ozeum_options_wait' );
			// Prepare data
			var data = {
				action: 'ozeum_get_linked_data',
				nonce: OZEUM_STORAGE['ajax_nonce'],
				chg_name: chg_name,
				chg_value: chg_value
			};
			jQuery.post(
				OZEUM_STORAGE['ajax_url'], data, function(response) {
					var rez = {};
					try {
						rez = JSON.parse( response );
					} catch (e) {
						rez = { error: OZEUM_STORAGE['msg_ajax_error'] };
						console.log( response );
					}
					if (rez.error === '') {
						if (linked_field_type == 'select') {
							var opt_list = '';
							for (var i in rez.list) {
								opt_list += '<option value="' + i + '">' + rez.list[i] + '</option>';
							}
							linked_field.html( opt_list );
						} else {
							linked_field.val( rez.value );
						}
						linked_lock.removeClass( 'ozeum_options_wait' );
					}
				}
			);
			e.preventDefault();
			return false;
		} );

	// Blur the "load fonts" fields - regenerate options lists in the font-family controls
	jQuery( '.ozeum_options [name^="ozeum_options_field_load_fonts"]' ).on( 'focusout', ozeum_options_update_load_fonts );

	// Change theme fonts options if load fonts is changed
	function ozeum_options_update_load_fonts() {
		var opt_list = [], i, tag, sel, opt, name = '', family = '', val = '', new_val = '', sel_idx = 0;
		for (i = 1; i <= ozeum_options_vars['max_load_fonts']; i++) {
			name = jQuery( '[name="ozeum_options_field_load_fonts-' + i + '-name"]' ).val();
			if (name == '') {
				continue;
			}
			family = jQuery( '[name="ozeum_options_field_load_fonts-' + i + '-family"]' ).val();
			opt_list.push( [name, family] );
		}
		for (tag in ozeum_theme_fonts) {
			sel = jQuery( '[name="ozeum_options_field_' + tag + '_font-family"]' );
			if (sel.length == 1) {
				opt     = sel.find( 'option' );
				sel_idx = sel.find( ':selected' ).index();
				// Remove empty options
				if (opt_list.length < opt.length - 1) {
					for (i = opt.length - 1; i > opt_list.length; i--) {
						opt.eq( i ).remove();
					}
				}
				// Add new options
				if (opt_list.length >= opt.length) {
					for (i = opt.length - 1; i <= opt_list.length - 1; i++) {
						val = '&quot;' + opt_list[i][0] + '&quot;' + (opt_list[i][1] != 'inherit' ? ',' + opt_list[i][1] : '');
						sel.append( '<option value="' + val + '">' + opt_list[i][0] + '</option>' );
					}
				}
				// Set new value
				new_val = '';
				for (i = 0; i < opt_list.length; i++) {
					val = '"' + opt_list[i][0] + '"' + (opt_list[i][1] != 'inherit' ? ',' + opt_list[i][1] : '');
					if (sel_idx - 1 == i) {
						new_val = val;
					}
					opt.eq( i + 1 ).val( val ).text( opt_list[i][0] );
				}
				sel.val( sel_idx > 0 && sel_idx <= opt_list.length && new_val ? new_val : 'inherit' );
			}
		}
	}

	// Check for dependencies
	//-----------------------------------------------------------------------------
	function ozeum_options_start_check_dependencies() {
		jQuery( '.ozeum_options .ozeum_options_section' ).each(
			function () {
				ozeum_options_check_dependencies( jQuery( this ) );
			}
		);
	}
	// Check all inner dependencies
	jQuery( document ).ready( ozeum_options_start_check_dependencies );
	// Check external dependencies (for example, "Page template" in the page edit mode)
	jQuery( window ).on( 'load', ozeum_options_start_check_dependencies );
	// Check dependencies on any field change
	jQuery( '.ozeum_options .ozeum_options_item_field [name^="ozeum_options_field_"]' ).on(
		'change', function () {
			ozeum_options_check_dependencies( jQuery( this ).parents( '.ozeum_options_section' ) );
		}
	);

	// Return value of the field
	function ozeum_options_get_field_value(fld, num) {
		var ctrl = fld.parents( '.ozeum_options_item_field' );
		var val  = fld.attr( 'type' ) == 'checkbox' || fld.attr( 'type' ) == 'radio'
				? (ctrl.find( '[name^="ozeum_options_field_"]:checked' ).length > 0
					? (num === true
						? ctrl.find( '[name^="ozeum_options_field_"]:checked' ).parent().index() + 1
						: (ctrl.find( '[name^="ozeum_options_field_"]:checked' ).val() !== ''
							&& '' + ctrl.find( '[name^="ozeum_options_field_"]:checked' ).val() != '0'
								? ctrl.find( '[name^="ozeum_options_field_"]:checked' ).val()
								: 1
							)
						)
					: 0
					)
				: (num === true ? fld.find( ':selected' ).index() + 1 : fld.val());
		if (val === undefined || val === null) {
			val = '';
		}
		return val;
	}

	// Check for dependencies
	function ozeum_options_check_dependencies(cont) {
		cont.find( '.ozeum_options_item_field' ).each(
			function() {
				var ctrl = jQuery( this ), id = ctrl.data( 'param' );
				if (id === undefined) {
					return;
				}
				var depend = false;
				for (var fld in ozeum_dependencies) {
					if (fld == id) {
						depend = ozeum_dependencies[id];
						break;
					}
				}
				if (depend) {
					var dep_cnt    = 0, dep_all = 0;
					var dep_cmp    = typeof depend.compare != 'undefined' ? depend.compare.toLowerCase() : 'and';
					var dep_strict = typeof depend.strict != 'undefined';
					var fld        = null, val = '', name = '', subname = '';
					var parts      = '', parts2 = '';
					for (var i in depend) {
						if (i == 'compare' || i == 'strict') {
							continue;
						}
						dep_all++;
						name    = i;
						subname = '';
						if (name.indexOf( '[' ) > 0) {
							parts   = name.split( '[' );
							name    = parts[0];
							subname = parts[1].replace( ']', '' );
						}
						if (name.charAt( 0 ) == '#' || name.charAt( 0 ) == '.') {
							fld = jQuery( name );
							if (fld.length > 0 && ! fld.hasClass( 'ozeum_inited' )) {
								fld.addClass( 'ozeum_inited' ).on(
									'change', function () {
										jQuery( '.ozeum_options .ozeum_options_section' ).each(
											function () {
												ozeum_options_check_dependencies( jQuery( this ) );
											}
										);
									}
								);
							}
						} else {
							fld = cont.find( '[name="ozeum_options_field_' + name + '"]' );
						}
						if (fld.length > 0) {
							val = ozeum_options_get_field_value( fld );
							if (subname !== '') {
								parts = val.split( '|' );
								for (var p = 0; p < parts.length; p++) {
									parts2 = parts[p].split( '=' );
									if (parts2[0] == subname) {
										val = parts2[1];
									}
								}
							}
							for (var j in depend[i]) {
								if (
									(depend[i][j] == 'not_empty' && val !== '')   // Main field value is not empty - show current field
									|| (depend[i][j] == 'is_empty' && val === '') // Main field value is empty - show current field
									|| (val !== '' && ( ! isNaN( depend[i][j] )   // Main field value equal to specified value - show current field
													? val == depend[i][j]
													: (dep_strict
															? val == depend[i][j]
															: ('' + val).indexOf( depend[i][j] ) == 0
														)
												)
									)
									|| (val !== '' && ("" + depend[i][j]).charAt( 0 ) == '^' && ('' + val).indexOf( depend[i][j].substr( 1 ) ) == -1)
																				// Main field value not equal to specified value - show current field
								) {
									dep_cnt++;
									break;
								}
							}
						} else {
							dep_all--;
						}
						if (dep_cnt > 0 && dep_cmp == 'or') {
							break;
						}
					}
					if (((dep_cnt > 0 || dep_all == 0) && dep_cmp == 'or') || (dep_cnt == dep_all && dep_cmp == 'and')) {
						ctrl.parents( '.ozeum_options_item' ).show().removeClass( 'ozeum_options_no_use' );
					} else {
						ctrl.parents( '.ozeum_options_item' ).hide().addClass( 'ozeum_options_no_use' );
					}
				}

				// Individual dependencies
				//------------------------------------

				// Remove 'false' to disable color schemes less then main scheme!
				// This behavious is not need for the version with sorted schemes (leave false)
				if (false && id == 'color_scheme') {
					fld = ctrl.find( '[name="ozeum_options_field_' + id + '"]' );
					if (fld.length > 0) {
						val     = ozeum_options_get_field_value( fld );
						var num = ozeum_options_get_field_value( fld, true );
						cont.find( '.ozeum_options_item_field' ).each(
							function() {
								var ctrl2 = jQuery( this ), id2 = ctrl2.data( 'param' );
								if (id2 == undefined) {
									return;
								}
								if (id2 == id || id2.substr( -7 ) != '_scheme') {
									return;
								}
								var fld2 = ctrl2.find( '[name="ozeum_options_field_' + id2 + '"]' ),
								val2     = ozeum_options_get_field_value( fld2 );
								if (fld2.attr( 'type' ) != 'radio') {
									fld2 = fld2.find( 'option' );
								}
								fld2.each(
									function(idx2) {
										var dom_obj      = jQuery( this ).get( 0 );
										dom_obj.disabled = idx2 != 0 && idx2 < num;
										if (dom_obj.disabled) {
											if (jQuery( this ).val() == val2) {
												if (fld2.attr( 'type' ) == 'radio') {
													fld2.each(
														function(idx3) {
															jQuery( this ).get( 0 ).checked = idx3 == 0;
														}
													);
												} else {
													fld2.each(
														function(idx2) {
																						jQuery( this ).get( 0 ).selected = idx3 == 0;
														}
													);
												}
											}
										}
									}
								);
							}
						);
					}
				}
			}
		);
	}

} );
