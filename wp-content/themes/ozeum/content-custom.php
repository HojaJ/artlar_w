<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package OZEUM
 * @since OZEUM 1.0.50
 */

$ozeum_template_args = get_query_var( 'ozeum_template_args' );
if ( is_array( $ozeum_template_args ) ) {
	$ozeum_columns    = empty( $ozeum_template_args['columns'] ) ? 2 : max( 1, $ozeum_template_args['columns'] );
	$ozeum_blog_style = array( $ozeum_template_args['type'], $ozeum_columns );
} else {
	$ozeum_blog_style = explode( '_', ozeum_get_theme_option( 'blog_style' ) );
	$ozeum_columns    = empty( $ozeum_blog_style[1] ) ? 2 : max( 1, $ozeum_blog_style[1] );
}
$ozeum_blog_id       = ozeum_get_custom_blog_id( join( '_', $ozeum_blog_style ) );
$ozeum_blog_style[0] = str_replace( 'blog-custom-', '', $ozeum_blog_style[0] );
$ozeum_expanded      = ! ozeum_sidebar_present() && ozeum_is_on( ozeum_get_theme_option( 'expand_content' ) );
$ozeum_components    = ! empty( $ozeum_template_args['meta_parts'] )
							? ( is_array( $ozeum_template_args['meta_parts'] )
								? join( ',', $ozeum_template_args['meta_parts'] )
								: $ozeum_template_args['meta_parts']
								)
							: ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'meta_parts' ) );
$ozeum_post_format   = get_post_format();
$ozeum_post_format   = empty( $ozeum_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ozeum_post_format );

$ozeum_blog_meta     = ozeum_get_custom_layout_meta( $ozeum_blog_id );
$ozeum_custom_style  = ! empty( $ozeum_blog_meta['scripts_required'] ) ? $ozeum_blog_meta['scripts_required'] : 'none';

if ( ! empty( $ozeum_template_args['slider'] ) || $ozeum_columns > 1 || ! ozeum_is_off( $ozeum_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $ozeum_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( ozeum_is_off( $ozeum_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $ozeum_custom_style ) ) . "-1_{$ozeum_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_format_' . esc_attr( $ozeum_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $ozeum_columns )
					. ' post_layout_' . esc_attr( $ozeum_blog_style[0] )
					. ' post_layout_' . esc_attr( $ozeum_blog_style[0] ) . '_' . esc_attr( $ozeum_columns )
					. ( ! ozeum_is_off( $ozeum_custom_style )
						? ' post_layout_' . esc_attr( $ozeum_custom_style )
							. ' post_layout_' . esc_attr( $ozeum_custom_style ) . '_' . esc_attr( $ozeum_columns )
						: ''
						)
		);
	ozeum_add_blog_animation( $ozeum_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'ozeum_action_show_layout', $ozeum_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $ozeum_template_args['slider'] ) || $ozeum_columns > 1 || ! ozeum_is_off( $ozeum_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
