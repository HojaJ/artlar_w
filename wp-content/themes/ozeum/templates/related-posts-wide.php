<?php
/**
 * The template 'Style 5' to displaying related posts
 *
 * @package OZEUM
 * @since OZEUM 1.0.54
 */

$ozeum_link        = get_permalink();
$ozeum_post_format = get_post_format();
$ozeum_post_format = empty( $ozeum_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ozeum_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $ozeum_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	ozeum_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'ozeum_filter_related_thumb_size', ozeum_get_thumb_size( (int) ozeum_get_theme_option( 'related_posts' ) == 1 ? 'big' : 'med' ) ),
		)
	);
	?>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $ozeum_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'ozeum' );
			} else {
				the_title();
			}
		?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $ozeum_link ); ?>" class="post_meta_item post_date"><?php echo wp_kses_data( ozeum_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
