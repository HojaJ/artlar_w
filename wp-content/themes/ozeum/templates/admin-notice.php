<?php
/**
 * The template to display Admin notices
 *
 * @package OZEUM
 * @since OZEUM 1.0.1
 */

$ozeum_theme_obj = wp_get_theme();
?>
<div class="ozeum_admin_notice ozeum_welcome_notice update-nag">
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
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'ozeum' ),
				$ozeum_theme_obj->name . ( OZEUM_THEME_FREE ? ' ' . __( 'Free', 'ozeum' ) : '' ),
				$ozeum_theme_obj->version
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="ozeum_notice_text">
		<p class="ozeum_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $ozeum_theme_obj->description ) );
			?>
		</p>
		<p class="ozeum_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'ozeum' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="ozeum_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=ozeum_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'ozeum' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" data-notice="admin" class="ozeum_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="ozeum_hide_notice_text"><?php esc_html_e( 'Dismiss', 'ozeum' ); ?></span></a>
	</div>
</div>
