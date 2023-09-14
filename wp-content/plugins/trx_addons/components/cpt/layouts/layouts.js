/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).on('action.ready_trx_addons', function() {
	"use strict";

	var $window          = jQuery( window ),
		_window_height   = $window.height(),
		_window_width    = $window.width(),
		$document        = jQuery( document ),
		$body            = jQuery( 'body' ),
		$adminbar        = jQuery('#wpadminbar'),
		_adminbar_height = trx_addons_adminbar_height();


	// Handle fixed rows
	//---------------------------------------------------------
	if ( ! TRX_ADDONS_STORAGE['pagebuilder_preview_mode'] && ! $body.hasClass( 'sc_layouts_row_fixed_inited' ) ) {
		var rows = jQuery('.sc_layouts_row_fixed'),
			rows_always = jQuery('.sc_layouts_row_fixed_always'),
			last_scroll_offset = -1;

		// If page contain fixed rows
		if (rows.length > 0) {
			// Add placeholders after each row
			rows.each(function(idx) {
				var row = rows.eq(idx);
				if ( ! row.next().hasClass('sc_layouts_row_fixed_placeholder') ) {
					row.after('<div class="sc_layouts_row_fixed_placeholder" style="background-color:'+row.css('background-color')+';"></div>');
				}
			});
			$document
				.on('action.scroll_trx_addons', function() {
					trx_addons_cpt_layouts_fix_rows(rows, rows_always, false);
				})
				.on('action.resize_trx_addons', function() {
					// Update global values
					_window_height   = $window.height();
					_window_width    = $window.width();
					_adminbar_height = trx_addons_adminbar_height();
					trx_addons_cpt_layouts_fix_rows(rows, rows_always, true);
				});
			$body.addClass( 'sc_layouts_row_fixed_inited' );
		}
	}

	// Fix/unfix rows
	function trx_addons_cpt_layouts_fix_rows(rows, rows_always, resize) {
		if ( _window_width < TRX_ADDONS_STORAGE['mobile_breakpoint_fixedrows_off'] ) {
			rows.each(function(idx) {
				var row = rows.eq(idx);
				if ( ! row.hasClass('sc_layouts_row_fixed_always')) {
					row.removeClass('sc_layouts_row_fixed_on').css({'top': 'auto'});
				}
			});
			if (rows_always.length === 0)
				return;
			else
				rows = rows_always;
		}
		
		var scroll_offset = $window.scrollTop();
		var rows_offset = _adminbar_height;

		// Hide fixed rows on scroll down
		if ( TRX_ADDONS_STORAGE['hide_fixed_rows'] > 0 ) {
			if ( last_scroll_offset >= 0 ) {
				var event = '';
				// Scroll down
				if ( scroll_offset > last_scroll_offset ) {
					if ( scroll_offset > _window_height * 0.6667 && ! $body.hasClass( 'hide_fixed_rows' ) ) {
						$body.addClass( 'hide_fixed_rows' );
						event = 'off';
					}
				// Scroll up
				} else if ( scroll_offset < last_scroll_offset ) {
					if ( $body.hasClass( 'hide_fixed_rows' ) ) {
						$body.removeClass( 'hide_fixed_rows' );
						event = 'on';
					}
				}
				if ( event ) {
					$document.trigger('action.sc_layouts_row_fixed_' + event);
/*
					var cur_time = 1000,
						interval = 50,
						timer = setInterval( function() {
							cur_time -= interval;
							if ( cur_time > 0 ) {
								$document.trigger('action.sc_layouts_row_fixed_' + event);
							} else {
								clearInterval( timer );
							}
						}, interval );
*/
				}
			}
			last_scroll_offset = scroll_offset;
		}

		rows.each(function(idx) {
			var row = rows.eq(idx);
			var placeholder = row.next();
			var h = row.outerHeight();
			if ((row.css('display')=='none' || h === 0) && !row.hasClass('sc_layouts_row_hide_unfixed')) {
				placeholder.height(0);
				return;
			}
			var offset = parseInt(row.hasClass('sc_layouts_row_fixed_on') ? placeholder.offset().top : row.offset().top, 10);
			if (isNaN(offset)) offset = 0;
			// Fix/unfix row
			if (scroll_offset + rows_offset <= offset) {
				if (row.hasClass('sc_layouts_row_fixed_on')) {
					row.addClass('sc_layouts_row_fixed_animation_off');
					setTimeout( function() {
						row.removeClass('sc_layouts_row_fixed_on sc_layouts_row_fixed_animation_off').css({'top': 'auto'});
						$document.trigger('action.sc_layouts_row_fixed_off');
					}, trx_addons_apply_filters( 'trx_addons_filter_sc_layouts_row_fixed_off_timeout', 0 ) );
				}
			} else {
				if (!row.hasClass('sc_layouts_row_fixed_on')) {
					if (rows_offset + h < _window_height * 0.33) {
						placeholder.height(h);
						row.addClass('sc_layouts_row_fixed_on').css({'top': rows_offset+'px'});
						h = row.outerHeight();
						$document.trigger('action.sc_layouts_row_fixed_on');
					}
				} else if (resize && row.hasClass('sc_layouts_row_fixed_on') && row.offset().top != rows_offset) {
					row.css({'top': rows_offset+'px'});
				}
				rows_offset += h;
			}
		});
	}
});
