<?php
// Add plugin-specific vars to the custom CSS
if ( ! function_exists( 'ozeum_elm_add_theme_vars' ) ) {
	add_filter( 'ozeum_filter_add_theme_vars', 'ozeum_elm_add_theme_vars', 10, 2 );
	function ozeum_elm_add_theme_vars( $rez, $vars ) {
		foreach ( array( 10, 20, 30, 40, 60 ) as $m ) {
			if ( substr( $vars['page'], 0, 2 ) != '{{' ) {
				$rez[ "page{$m}" ]    = ( $vars['page'] + $m ) . 'px';
				$rez[ "content{$m}" ] = ( $vars['page'] - $vars['gap'] - $vars['sidebar'] + $m ) . 'px';
			} else {
				$rez[ "page{$m}" ]    = "{{ data.page{$m} }}";
				$rez[ "content{$m}" ] = "{{ data.content{$m} }}";
			}
		}
		return $rez;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'ozeum_elm_get_css' ) ) {
	add_filter( 'ozeum_filter_get_css', 'ozeum_elm_get_css', 10, 2 );
	function ozeum_elm_get_css( $css, $args ) {

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			extract( $args['vars'] );
			$css['vars'] .= <<<CSS
/* No gap */
.elementor-section.elementor-section-boxed > .elementor-column-gap-no {
	max-width: $page;
}
/* Narrow: 5px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-narrow {
	max-width: $page10;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: $page10; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-narrow {
	width: $content10; 
}

/* Default: 10px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-default {
	max-width: $page20;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: $page20;
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-default {
	width: $content20;
}

/* Extended: 15px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-extended {
	max-width: $page30;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: $page30; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-extended {
	width: $content30; 
}

/* Wide: 20px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-wide {
	max-width: $page40;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: $page40; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wide {
	width: $content40; 
}

/* Wider: 30px */
.elementor-section.elementor-section-boxed > .elementor-column-gap-wider {
	max-width: $page60;
}
.elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: $page60; 
}
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-boxed:not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider,
.sidebar_show .content_wrap .elementor-section.elementor-section-justified.elementor-section-full_width:not(.elementor-section-stretched):not(.elementor-inner-section) > .elementor-container.elementor-column-gap-wider {
	width: $content60; 
}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

/* Shape above and below rows */
.elementor-shape .elementor-shape-fill {
	fill: {$colors['bg_color']};
}

/* Divider */

.elementor-divider-separator {
	border-color: {$colors['bd_color']};
}


/* Progress Bar */
.elementor-widget-progress .elementor-title { 
    color: {$colors['text_dark']};
}
.elementor-widget-progress .elementor-progress-text,
.elementor-widget-progress .elementor-progress-percentage {
    color: {$colors['text_dark']};
}
.elementor-widget-progress .elementor-progress-wrapper {
    background-color:  {$colors['alter_bd_color']};
}
.elementor-widget-progress .elementor-progress-bar {
    background-color:  {$colors['text_link']};
}
/* Toggle */
.elementor-widget-toggle .elementor-toggle .elementor-tab-title { 
    color: {$colors['text_dark']};
}
.elementor-widget-toggle .elementor-toggle .elementor-tab-title a {
    color: inherit;
}
.elementor-widget-toggle .elementor-toggle .elementor-tab-content {
   color: {$colors['text']};
   border-color: {$colors['bd_color']};
}

/* Alert */
.elementor-alert-info {
    background-color:  {$colors['extra_bg_color']};
    border-color: {$colors['inverse_link']};
}
.elementor-alert-info .elementor-alert-title {
   color: {$colors['inverse_link']}; 
}
.elementor-alert-info .elementor-alert-description {
   color: {$colors['text']}; 
}
.elementor-alert-info .elementor-alert-dismiss {
    color: {$colors['text_light']};
}
.elementor-alert-info .elementor-alert-dismiss:hover {
    color: {$colors['inverse_link']};
}
.elementor-alert-info .elementor-alert-description .alert_link {
	color:{$colors['inverse_link']};
}
.elementor-alert-info .elementor-alert-description .alert_link:before {
	background-color: {$colors['inverse_link']};
}
.elementor-alert-info .elementor-alert-description .alert_link:after {
	border-color: {$colors['inverse_link_04']};
}
.elementor-alert-info .elementor-alert-description .alert_link:hover,
.elementor-alert-info .elementor-alert-description .alert_link:focus {
	color:{$colors['inverse_link']} ;
}
.elementor-alert-info .elementor-alert-description .alert_link:hover:before,
.elementor-alert-info .elementor-alert-description .alert_link:focus:before {
	background-color: {$colors['inverse_link']};
}
.elementor-alert-info .elementor-alert-description .alert_link:hover:after,
.elementor-alert-info .elementor-alert-description .alert_link:focus:after {
	border-color: {$colors['inverse_link']};
}


CSS;
		}

		return $css;
	}
}
