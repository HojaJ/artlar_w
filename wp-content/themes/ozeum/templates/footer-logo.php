<?php
/**
 * The template to display the site logo in the footer
 *
 * @package OZEUM
 * @since OZEUM 1.0.10
 */

// Logo
if ( ozeum_is_on( ozeum_get_theme_option( 'logo_in_footer' ) ) ) {
	$ozeum_logo_image = ozeum_get_logo_image( 'footer' );
	$ozeum_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $ozeum_logo_image['logo'] ) || ! empty( $ozeum_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $ozeum_logo_image['logo'] ) ) {
					$ozeum_attr = ozeum_getimagesize( $ozeum_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $ozeum_logo_image['logo'] ) . '"'
								. ( ! empty( $ozeum_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $ozeum_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'ozeum' ) . '"'
								. ( ! empty( $ozeum_attr[3] ) ? ' ' . wp_kses_data( $ozeum_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $ozeum_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $ozeum_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
