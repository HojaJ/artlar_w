<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'ozeum_trx_popup_get_css' ) ) {
    add_filter( 'ozeum_filter_get_css', 'ozeum_trx_popup_get_css', 10, 2 );
    function ozeum_trx_popup_get_css( $css, $args ) {

        if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
            $fonts         = $args['fonts'];
            $css['fonts'] .= <<<CSS
			
.trx_popup_subtitle {
	{$fonts['decor_font-family']}
}

CSS;
        }

        if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
            $colors         = $args['colors'];
            $css['colors'] .= <<<CSS

.trx_popup_close {
}

.trx_popup_close::after,
.trx_popup_close::before {
	background: {$colors['alter_text']};
}

.trx_popup_container {
	background: {$colors['alter_bg_color']};
}

.trx_popup_subtitle {
	color: {$colors['alter_text']};
}

.trx_popup_title {
	color: {$colors['alter_dark']};
}

.trx_popup_button {
}

.trx_popup_button:hover {
}

CSS;
        }

        return $css;
    }
}
