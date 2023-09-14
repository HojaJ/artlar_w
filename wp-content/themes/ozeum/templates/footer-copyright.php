<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package OZEUM
 * @since OZEUM 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$ozeum_copyright_scheme = ozeum_get_theme_option( 'copyright_scheme' );
if ( ! empty( $ozeum_copyright_scheme ) && ! ozeum_is_inherit( $ozeum_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $ozeum_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$ozeum_copyright = ozeum_get_theme_option( 'copyright' );
			if ( ! empty( $ozeum_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$ozeum_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $ozeum_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$ozeum_copyright = ozeum_prepare_macros( $ozeum_copyright );
				// Display copyright
                echo wp_kses( nl2br( $ozeum_copyright ), 'ozeum_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
