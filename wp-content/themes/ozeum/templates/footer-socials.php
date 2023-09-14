<?php
/**
 * The template to display the socials in the footer
 *
 * @package OZEUM
 * @since OZEUM 1.0.10
 */


// Socials
if ( ozeum_is_on( ozeum_get_theme_option( 'socials_in_footer' ) ) ) {
	$ozeum_output = ozeum_get_socials_links();
	if ( '' != $ozeum_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php ozeum_show_layout( $ozeum_output ); ?>
			</div>
		</div>
		<?php
	}
}
