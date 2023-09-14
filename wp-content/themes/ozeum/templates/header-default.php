<?php
/**
 * The template to display default site header
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

$ozeum_header_css   = '';
$ozeum_header_image = get_header_image();
$ozeum_header_video = ozeum_get_header_video();
if ( ! empty( $ozeum_header_image ) && ozeum_trx_addons_featured_image_override( is_singular() || ozeum_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$ozeum_header_image = ozeum_get_current_mode_image( $ozeum_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $ozeum_header_image ) || ! empty( $ozeum_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $ozeum_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $ozeum_header_image ) {
		echo ' ' . esc_attr( ozeum_add_inline_css_class( 'background-image: url(' . esc_url( $ozeum_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( ozeum_is_on( ozeum_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight ozeum-full-height';
	}
	$ozeum_header_scheme = ozeum_get_theme_option( 'header_scheme' );
	if ( ! empty( $ozeum_header_scheme ) && ! ozeum_is_inherit( $ozeum_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $ozeum_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $ozeum_header_video ) ) {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( ozeum_is_on( ozeum_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
