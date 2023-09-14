<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

$ozeum_args = get_query_var( 'ozeum_logo_args' );

// Site logo
$ozeum_logo_type   = isset( $ozeum_args['type'] ) ? $ozeum_args['type'] : '';
$ozeum_logo_image  = ozeum_get_logo_image( $ozeum_logo_type );
$ozeum_logo_text   = ozeum_is_on( ozeum_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$ozeum_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $ozeum_logo_image['logo'] ) || ! empty( $ozeum_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $ozeum_logo_image['logo'] ) ) {
			if ( empty( $ozeum_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric( $ozeum_logo_image['logo'] ) && $ozeum_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$ozeum_attr = ozeum_getimagesize( $ozeum_logo_image['logo'] );
				echo '<img src="' . esc_url( $ozeum_logo_image['logo'] ) . '"'
						. ( ! empty( $ozeum_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $ozeum_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $ozeum_logo_text ) . '"'
						. ( ! empty( $ozeum_attr[3] ) ? ' ' . wp_kses_data( $ozeum_attr[3] ) : '' )
						. '>';
			}
		} else {
			ozeum_show_layout( ozeum_prepare_macros( $ozeum_logo_text ), '<span class="logo_text">', '</span>' );
			ozeum_show_layout( ozeum_prepare_macros( $ozeum_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
