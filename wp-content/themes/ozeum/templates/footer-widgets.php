<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package OZEUM
 * @since OZEUM 1.0.10
 */

// Footer sidebar
$ozeum_footer_name    = ozeum_get_theme_option( 'footer_widgets' );
$ozeum_footer_present = ! ozeum_is_off( $ozeum_footer_name ) && is_active_sidebar( $ozeum_footer_name );
if ( $ozeum_footer_present ) {
	ozeum_storage_set( 'current_sidebar', 'footer' );
	$ozeum_footer_wide = ozeum_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $ozeum_footer_name ) ) {
		dynamic_sidebar( $ozeum_footer_name );
	}
	$ozeum_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $ozeum_out ) ) {
		$ozeum_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $ozeum_out );
		$ozeum_need_columns = true;   //or check: strpos($ozeum_out, 'columns_wrap')===false;
		if ( $ozeum_need_columns ) {
			$ozeum_columns = max( 0, (int) ozeum_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $ozeum_columns ) {
				$ozeum_columns = min( 4, max( 1, ozeum_tags_count( $ozeum_out, 'aside' ) ) );
			}
			if ( $ozeum_columns > 1 ) {
				$ozeum_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $ozeum_columns ) . ' widget', $ozeum_out );
			} else {
				$ozeum_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $ozeum_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $ozeum_footer_wide ) {
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
				ozeum_show_layout( $ozeum_out );
				do_action( 'ozeum_action_after_sidebar' );
				if ( $ozeum_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $ozeum_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
