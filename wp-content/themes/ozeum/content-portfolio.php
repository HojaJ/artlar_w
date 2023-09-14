<?php
/**
 * The Portfolio template to display the content
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
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
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

	$ozeum_image_hover = ! empty( $ozeum_template_args['hover'] ) && ! ozeum_is_inherit( $ozeum_template_args['hover'] )
								? $ozeum_template_args['hover']
								: ozeum_get_theme_option( 'image_hover' );

	if ( 'dots' == $ozeum_image_hover ) {
		$ozeum_post_link   = empty( $ozeum_template_args['no_links'] )
								? ( ! empty( $ozeum_template_args['link'] )
									? $ozeum_template_args['link']
									: get_permalink()
									)
								: '';
		$ozeum_target      = ! empty( $ozeum_post_link ) && false === strpos( $ozeum_post_link, home_url() )
									? ' target="_blank" rel="nofollow"'
									: '';
	}

	// Featured image
	ozeum_show_post_featured(
		array(
			'hover'         => $ozeum_image_hover,
			'no_links'      => ! empty( $ozeum_template_args['no_links'] ),
			'thumb_size'    => ozeum_get_thumb_size(
									strpos( ozeum_get_theme_option( 'body_style' ), 'full' ) !== false || $ozeum_columns < 3
										? 'masonry-big'
										: 'masonry'
								),
			'show_no_image' => true,
			'class'         => 'dots' == $ozeum_image_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $ozeum_image_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $ozeum_post_link )
												? '<a href="' . esc_url( $ozeum_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $ozeum_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
		)
	);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!