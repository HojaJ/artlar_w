<?php
/**
 * The template to display the single post header
 *
 * @package OZEUM
 * @since OZEUM 1.0.62
 */

if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
	ob_start();
	?>
	<div class="post_header_wrap single_style_<?php
		echo esc_attr( ozeum_get_theme_option( 'single_style' ) );
		if ( has_post_thumbnail() || str_replace( 'post-format-', '', get_post_format() ) == 'image' ) {
			echo ' with_featured_image';
		}
	?>">
		<?php
		// Featured image
		ozeum_show_post_featured_image( true );
		// Post title and meta
		ozeum_show_post_title_and_meta( true );
		?>
	</div>
	<?php
	$ozeum_post_header = ob_get_contents();
	ob_end_clean();
	if ( strpos( $ozeum_post_header, 'post_featured' ) !== false
		|| strpos( $ozeum_post_header, 'post_title' ) !== false
		|| strpos( $ozeum_post_header, 'post_meta' ) !== false
	) {
		ozeum_show_layout( $ozeum_post_header );
	}
}
