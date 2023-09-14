<?php
/**
 * The template to display default site footer
 *
 * @package OZEUM
 * @since OZEUM 1.0.10
 */

$ozeum_footer_id = ozeum_get_custom_footer_id();
$ozeum_footer_meta = get_post_meta( $ozeum_footer_id, 'trx_addons_options', true );
if ( ! empty( $ozeum_footer_meta['margin'] ) ) {
	ozeum_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( ozeum_prepare_css_value( $ozeum_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $ozeum_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $ozeum_footer_id ) ) ); ?>
						<?php
						$ozeum_footer_scheme = ozeum_get_theme_option( 'footer_scheme' );
						if ( ! empty( $ozeum_footer_scheme ) && ! ozeum_is_inherit( $ozeum_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $ozeum_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'ozeum_action_show_layout', $ozeum_footer_id );
	?>
</footer><!-- /.footer_wrap -->
