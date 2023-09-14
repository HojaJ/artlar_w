<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

if ( ozeum_sidebar_present() ) {
	
	$ozeum_sidebar_type = ozeum_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $ozeum_sidebar_type && ! ozeum_is_layouts_available() ) {
		$ozeum_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $ozeum_sidebar_type ) {
		// Default sidebar with widgets
		$ozeum_sidebar_name = ozeum_get_theme_option( 'sidebar_widgets' );
		ozeum_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $ozeum_sidebar_name ) ) {
			dynamic_sidebar( $ozeum_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$ozeum_sidebar_id = ozeum_get_custom_sidebar_id();
		do_action( 'ozeum_action_show_layout', $ozeum_sidebar_id );
	}
	$ozeum_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $ozeum_out ) ) {
		$ozeum_sidebar_position    = ozeum_get_theme_option( 'sidebar_position' );
		$ozeum_sidebar_position_ss = ozeum_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $ozeum_sidebar_position );
			echo ' sidebar_' . esc_attr( $ozeum_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $ozeum_sidebar_type );

			if ( 'float' == $ozeum_sidebar_position_ss ) {
				echo ' sidebar_float';
			}
			$ozeum_sidebar_scheme = ozeum_get_theme_option( 'sidebar_scheme' );
			if ( ! empty( $ozeum_sidebar_scheme ) && ! ozeum_is_inherit( $ozeum_sidebar_scheme ) ) {
				echo ' scheme_' . esc_attr( $ozeum_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php
			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="ozeum_skip_link_anchor" href="#"></a>
			<?php
			// Single posts banner before sidebar
			ozeum_show_post_banner( 'sidebar' );
			// Button to show/hide sidebar on mobile
			if ( in_array( $ozeum_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$ozeum_title = apply_filters( 'ozeum_filter_sidebar_control_title', 'float' == $ozeum_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'ozeum' ) : '' );
				$ozeum_text  = apply_filters( 'ozeum_filter_sidebar_control_text', 'above' == $ozeum_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'ozeum' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $ozeum_title ); ?>"><?php echo esc_html( $ozeum_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'ozeum_action_before_sidebar' );
				ozeum_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $ozeum_out ) );
				do_action( 'ozeum_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
