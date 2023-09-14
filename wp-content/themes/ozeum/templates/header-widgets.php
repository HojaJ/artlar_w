<?php
/**
 * The template to display the widgets area in the header
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

// Header sidebar
$ozeum_header_name    = ozeum_get_theme_option( 'header_widgets' );
$ozeum_header_present = ! ozeum_is_off( $ozeum_header_name ) && is_active_sidebar( $ozeum_header_name );
if ( $ozeum_header_present ) {
	ozeum_storage_set( 'current_sidebar', 'header' );
	$ozeum_header_wide = ozeum_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $ozeum_header_name ) ) {
		dynamic_sidebar( $ozeum_header_name );
	}
	$ozeum_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $ozeum_widgets_output ) ) {
		$ozeum_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $ozeum_widgets_output );
		$ozeum_need_columns   = strpos( $ozeum_widgets_output, 'columns_wrap' ) === false;
		if ( $ozeum_need_columns ) {
			$ozeum_columns = max( 0, (int) ozeum_get_theme_option( 'header_columns' ) );
			if ( 0 == $ozeum_columns ) {
				$ozeum_columns = min( 6, max( 1, ozeum_tags_count( $ozeum_widgets_output, 'aside' ) ) );
			}
			if ( $ozeum_columns > 1 ) {
				$ozeum_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $ozeum_columns ) . ' widget', $ozeum_widgets_output );
			} else {
				$ozeum_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $ozeum_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $ozeum_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $ozeum_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'ozeum_action_before_sidebar' );
				ozeum_show_layout( $ozeum_widgets_output );
				do_action( 'ozeum_action_after_sidebar' );
				if ( $ozeum_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $ozeum_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
