<?php
/**
 * The Header: Logo and main menu
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( ozeum_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'ozeum_action_before_body' );
	?>

	<div class="body_wrap">

		<div class="page_wrap">
			
			<?php
			$ozeum_full_post_loading = ( is_singular( 'post' ) || is_singular( 'attachment' ) ) && ozeum_get_value_gp( 'action' ) == 'full_post_loading';
			$ozeum_prev_post_loading = ( is_singular( 'post' ) || is_singular( 'attachment' ) ) && ozeum_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $ozeum_full_post_loading && ! $ozeum_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="ozeum_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to content", 'ozeum' ); ?></a>
				<?php if ( ozeum_sidebar_present() ) { ?>
				<a class="ozeum_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to sidebar", 'ozeum' ); ?></a>
				<?php } ?>
				<a class="ozeum_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="1"><?php esc_html_e( "Skip to footer", 'ozeum' ); ?></a>
				
				<?php
				// Header
				$ozeum_header_type = ozeum_get_theme_option( 'header_type' );
				if ( 'custom' == $ozeum_header_type && ! ozeum_is_layouts_available() ) {
					$ozeum_header_type = 'default';
				}

				get_template_part( apply_filters( 'ozeum_filter_get_template_part', "templates/header-{$ozeum_header_type}" ) );

				// Side menu
				if ( in_array( ozeum_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-navi-mobile' ) );

			}
			
			// Single posts banner after header
			ozeum_show_post_banner( 'header' );
			?>

			<div class="page_content_wrap">
				<?php
				// Single posts banner on the background
				if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
					ozeum_show_post_banner( 'background' );
				}

				// Single post thumbnail and title
				get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/single-styles/' . ozeum_get_theme_option( 'single_style' ) ) );

				// Widgets area above page content
				$ozeum_body_style   = ozeum_get_theme_option( 'body_style' );
				$ozeum_widgets_name = ozeum_get_theme_option( 'widgets_above_page' );
				$ozeum_show_widgets = ! ozeum_is_off( $ozeum_widgets_name ) && is_active_sidebar( $ozeum_widgets_name );
				if ( $ozeum_show_widgets ) {
					if ( 'fullscreen' != $ozeum_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					ozeum_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $ozeum_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}
				}

				// Content area
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $ozeum_body_style ? '_fullscreen' : ''; ?>">

					<div class="content">
						<?php
						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="ozeum_skip_link_anchor" href="#"></a>
						<?php
						// Widgets area inside page content
						ozeum_create_widgets_area( 'widgets_above_content' );
