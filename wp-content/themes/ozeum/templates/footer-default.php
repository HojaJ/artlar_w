<?php
/**
 * The template to display default site footer
 *
 * @package OZEUM
 * @since OZEUM 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$ozeum_footer_scheme = ozeum_get_theme_option( 'footer_scheme' );
if ( ! empty( $ozeum_footer_scheme ) && ! ozeum_is_inherit( $ozeum_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $ozeum_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/footer-socials' ) );

	// Menu
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/footer-menu' ) );

	// Copyright area
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
