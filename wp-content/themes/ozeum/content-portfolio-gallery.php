<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

$ozeum_template_args = get_query_var( 'ozeum_template_args' );
if ( is_array( $ozeum_template_args ) ) {
	$ozeum_columns    = empty( $ozeum_template_args['columns'] ) ? 2 : max( 1, $ozeum_template_args['columns'] );
	$ozeum_blog_style = array( $ozeum_template_args['type'], $ozeum_columns );
} else {
	$ozeum_blog_style = explode( '_', ozeum_get_theme_option( 'blog_style' ) );
	$ozeum_columns    = empty( $ozeum_blog_style[1] ) ? 2 : max( 1, $ozeum_blog_style[1] );
}
$ozeum_post_format = get_post_format();
$ozeum_post_format = empty( $ozeum_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ozeum_post_format );
$ozeum_image       = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

?><div class="
<?php
if ( ! empty( $ozeum_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo 'masonry_item masonry_item-1_' . esc_attr( $ozeum_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $ozeum_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $ozeum_columns )
		. ' post_layout_gallery'
		. ' post_layout_gallery_' . esc_attr( $ozeum_columns )
	);
	ozeum_add_blog_animation( $ozeum_template_args );
	?>
	data-size="
		<?php
		if ( ! empty( $ozeum_image[1] ) && ! empty( $ozeum_image[2] ) ) {
			echo intval( $ozeum_image[1] ) . 'x' . intval( $ozeum_image[2] );}
		?>
	"
	data-src="
		<?php
		if ( ! empty( $ozeum_image[0] ) ) {
			echo esc_url( $ozeum_image[0] );}
		?>
	"
>
<?php

	// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	// Featured image
	$ozeum_image_hover = 'icon';
if ( in_array( $ozeum_image_hover, array( 'icons', 'zoom' ) ) ) {
	$ozeum_image_hover = 'dots';
}
$ozeum_components = ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'meta_parts' ) );
ozeum_show_post_featured(
	array(
		'hover'         => $ozeum_image_hover,
		'no_links'      => ! empty( $ozeum_template_args['no_links'] ),
		'thumb_size'    => ozeum_get_thumb_size( strpos( ozeum_get_theme_option( 'body_style' ), 'full' ) !== false || $ozeum_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only'    => true,
		'show_no_image' => true,
		'post_info'     => '<div class="post_details">'
						. '<h2 class="post_title">'
							. ( empty( $ozeum_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>'
								: esc_html( get_the_title() )
								)
						. '</h2>'
						. '<div class="post_description">'
							. ( ! empty( $ozeum_components )
								? ozeum_show_post_meta(
									apply_filters(
										'ozeum_filter_post_meta_args', array(
											'components' => $ozeum_components,
											'seo'      => false,
											'echo'     => false,
										), $ozeum_blog_style[0], $ozeum_columns
									)
								)
								: ''
								)
							. ( empty( $ozeum_template_args['hide_excerpt'] )
								? '<div class="post_description_content">' . get_the_excerpt() . '</div>'
								: ''
								)
							. ( empty( $ozeum_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__( 'Learn more', 'ozeum' ) . '</span></a>'
								: ''
								)
						. '</div>'
					. '</div>',
	)
);
?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
