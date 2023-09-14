/* global jQuery:false */
/* global OZEUM_STORAGE:false */

(function() {
	"use strict";

	// Init skin-specific actions on first run
	// Attention! Don't forget to add the class "inited" and check it to prevent re-initialize the elements
	jQuery( document ).on(
		'action.ready_ozeum', function() {

			// TRX Popup plugin button styling
			jQuery( '.trx_popup_container .trx_popup_button' ).addClass( 'color_style_dark' );
		}
	);

})();