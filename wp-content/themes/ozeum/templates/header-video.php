<?php
/**
 * The template to display the background video in the header
 *
 * @package OZEUM
 * @since OZEUM 1.0.14
 */
$ozeum_header_video = ozeum_get_header_video();
$ozeum_embed_video  = '';
if ( ! empty( $ozeum_header_video ) && ! ozeum_is_from_uploads( $ozeum_header_video ) ) {
	if ( ozeum_is_youtube_url( $ozeum_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $ozeum_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php ozeum_show_layout( ozeum_get_embed_video( $ozeum_header_video ) ); ?></div>
		<?php
	}
}
