<?php
/**
 * The template to display Admin notices
 *
 * @package OZEUM
 * @since OZEUM 1.0.64
 */

$ozeum_theme_obj  = wp_get_theme();
$ozeum_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$ozeum_skins_args = get_query_var( 'ozeum_skins_notice_args' );

?>
<div class="ozeum_admin_notice ozeum_skins_notice update-nag">
	<?php
	// Theme image
	$ozeum_theme_img = ozeum_get_file_url( 'screenshot.jpg' );
	if ( '' != $ozeum_theme_img ) {
		?>
		<div class="ozeum_notice_image"><img src="<?php echo esc_url( $ozeum_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'ozeum' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="ozeum_notice_title">
		<?php esc_html_e( 'New skins available', 'ozeum' ); ?>
	</h3>
	<?php

	// Description
	$ozeum_total      = $ozeum_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$ozeum_skins_msg  = $ozeum_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( ($ozeum_total === 1) ? esc_html__('%d new version', 'ozeum') :  esc_html__('%d new versions', 'ozeum'), $ozeum_total ) . '</strong>'
							: '';
	$ozeum_total      = $ozeum_skins_args['free'];
	$ozeum_skins_msg .= $ozeum_total > 0
							? ( ! empty( $ozeum_skins_msg ) ? ' ' . esc_html__( 'and', 'ozeum' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( ($ozeum_total === 1) ? esc_html__('%d free skin', 'ozeum') :  esc_html__('%d free skins', 'ozeum'), $ozeum_total ) . '</strong>'
							: '';
	$ozeum_total      = $ozeum_skins_args['pay'];
	$ozeum_skins_msg .= $ozeum_skins_args['pay'] > 0
							? ( ! empty( $ozeum_skins_msg ) ? ' ' . esc_html__( 'and', 'ozeum' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( ($ozeum_total === 1) ? esc_html__('%d paid skin', 'ozeum') :  esc_html__('%d paid skins', 'ozeum') ) . '</strong>'
							: '';
	?>
	<div class="ozeum_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'ozeum' ), $ozeum_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="ozeum_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $ozeum_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'ozeum' );
			?>
		</a>
		<?php
		// Dismiss
		?>
		<a href="#" data-notice="skins" class="ozeum_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="ozeum_hide_notice_text"><?php esc_html_e( 'Dismiss', 'ozeum' ); ?></span></a>
	</div>
</div>
