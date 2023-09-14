<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package OZEUM
 * @since OZEUM 1.0.06
 */

$ozeum_header_css   = '';
$ozeum_header_image = get_header_image();
$ozeum_header_video = ozeum_get_header_video();
if ( ! empty( $ozeum_header_image ) && ozeum_trx_addons_featured_image_override( is_singular() || ozeum_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$ozeum_header_image = ozeum_get_current_mode_image( $ozeum_header_image );
}

$ozeum_header_id = ozeum_get_custom_header_id();
$ozeum_header_meta = get_post_meta( $ozeum_header_id, 'trx_addons_options', true );
if ( ! empty( $ozeum_header_meta['margin'] ) ) {
	ozeum_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( ozeum_prepare_css_value( $ozeum_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $ozeum_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $ozeum_header_id ) ) ); ?>
				<?php
				echo ! empty( $ozeum_header_image ) || ! empty( $ozeum_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'ozeum_action_show_layout', $ozeum_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
