/* global jQuery:false */
/* global OZEUM_STORAGE:false */

jQuery( window ).load(function() {
	"use strict";
	ozeum_gutenberg_first_init();
	// Create the observer to reinit visual editor after switch from code editor to visual editor
	var ozeum_observers = {};
	if (typeof window.MutationObserver !== 'undefined') {
		ozeum_create_observer('check_visual_editor', jQuery('.block-editor').eq(0), function(mutationsList) {
			var gutenberg_editor = jQuery('.edit-post-visual-editor:not(.ozeum_inited)').eq(0);
			if (gutenberg_editor.length > 0) ozeum_gutenberg_first_init();
		});
	}

	function ozeum_gutenberg_first_init() {
		var gutenberg_editor = jQuery( '.edit-post-visual-editor:not(.ozeum_inited)' ).eq( 0 );
		if ( 0 == gutenberg_editor.length ) {
			return;
		}
		
		// Add color scheme to the wrapper (instead '.editor-block-list__layout')
		jQuery( '.block-editor-writing-flow' ).addClass( 'scheme_' + OZEUM_STORAGE['color_scheme'] );
		
		// Decorate sidebar placeholder
		gutenberg_editor.addClass( 'sidebar_position_' + OZEUM_STORAGE['sidebar_position'] );
		if ( OZEUM_STORAGE['expand_content'] > 0 ) {
			gutenberg_editor.addClass( 'expand_content' );
		}
		if ( OZEUM_STORAGE['sidebar_position'] == 'left' ) {
			gutenberg_editor.prepend( '<div class="editor-post-sidebar-holder"></div>' );
		} else if ( OZEUM_STORAGE['sidebar_position'] == 'right' ) {
			gutenberg_editor.append( '<div class="editor-post-sidebar-holder"></div>' );
		}

		gutenberg_editor.addClass('ozeum_inited');
	}

	// Create mutations observer
	function ozeum_create_observer(id, obj, callback) {
		if (typeof window.MutationObserver !== 'undefined' && obj.length > 0) {
			if (typeof ozeum_observers[id] == 'undefined') {
				ozeum_observers[id] = new MutationObserver(callback);
				ozeum_observers[id].observe(obj.get(0), { attributes: false, childList: true, subtree: true });
			}
			return true;
		}
		return false;
	}
} );
