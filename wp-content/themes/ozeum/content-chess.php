<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

$ozeum_template_args = get_query_var( 'ozeum_template_args' );
if ( is_array( $ozeum_template_args ) ) {
	$ozeum_columns    = empty( $ozeum_template_args['columns'] ) ? 1 : max( 1, min( 3, $ozeum_template_args['columns'] ) );
	$ozeum_blog_style = array( $ozeum_template_args['type'], $ozeum_columns );
} else {
	$ozeum_blog_style = explode( '_', ozeum_get_theme_option( 'blog_style' ) );
	$ozeum_columns    = empty( $ozeum_blog_style[1] ) ? 1 : max( 1, min( 3, $ozeum_blog_style[1] ) );
}
$ozeum_expanded    = ! ozeum_sidebar_present() && ozeum_is_on( ozeum_get_theme_option( 'expand_content' ) );
$ozeum_post_format = get_post_format();
$ozeum_post_format = empty( $ozeum_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ozeum_post_format );

?><article id="post-<?php the_ID(); ?>"	data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item'
		. ' post_layout_chess'
		. ' post_layout_chess_' . esc_attr( $ozeum_columns )
		. ' post_format_' . esc_attr( $ozeum_post_format )
		. ( ! empty( $ozeum_template_args['slider'] ) ? ' slider-slide swiper-slide' : '' )
	);
	ozeum_add_blog_animation( $ozeum_template_args );
	?>
>

	<?php
	// Add anchor
	if ( 1 == $ozeum_columns && ! is_array( $ozeum_template_args ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode( '[trx_sc_anchor id="post_' . esc_attr( get_the_ID() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" icon="' . esc_attr( ozeum_get_post_icon() ) . '"]' );
	}

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$ozeum_hover = ! empty( $ozeum_template_args['hover'] ) && ! ozeum_is_inherit( $ozeum_template_args['hover'] )
						? $ozeum_template_args['hover']
						: ozeum_get_theme_option( 'image_hover' );
	ozeum_show_post_featured(
		array(
			'class'         => 1 == $ozeum_columns && ! is_array( $ozeum_template_args ) ? 'ozeum-full-height' : '',
			'hover'         => $ozeum_hover,
			'no_links'      => ! empty( $ozeum_template_args['no_links'] ),
			'show_no_image' => true,
			'thumb_ratio'   => '1:1',
			'thumb_bg'      => true,
			'thumb_size'    => ozeum_get_thumb_size(
				strpos( ozeum_get_theme_option( 'body_style' ), 'full' ) !== false
										? ( 1 < $ozeum_columns ? 'huge' : 'original' )
										: ( 2 < $ozeum_columns ? 'big' : 'huge' )
			),
		)
	);

	?>
	<div class="post_inner"><div class="post_inner_content"><div class="post_header entry-header">
		<?php
			do_action( 'ozeum_action_before_post_title' );

			// Post title
			if ( empty( $ozeum_template_args['no_links'] ) ) {
				the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			} else {
				the_title( '<h3 class="post_title entry-title">', '</h3>' );
			}

			do_action( 'ozeum_action_before_post_meta' );

			// Post meta
			$ozeum_components = ! empty( $ozeum_template_args['meta_parts'] )
									? ( is_array( $ozeum_template_args['meta_parts'] )
										? join( ',', $ozeum_template_args['meta_parts'] )
										: $ozeum_template_args['meta_parts']
										)
									: ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'meta_parts' ) );
			$ozeum_post_meta  = empty( $ozeum_components ) || in_array( $ozeum_hover, array( 'border', 'pull', 'slide', 'fade' ) )
										? ''
										: ozeum_show_post_meta(
											apply_filters(
												'ozeum_filter_post_meta_args', array(
													'components' => $ozeum_components,
													'seo'  => false,
													'echo' => false,
												), $ozeum_blog_style[0], $ozeum_columns
											)
										);
			ozeum_show_layout( $ozeum_post_meta );
			?>
		</div><!-- .entry-header -->

		<div class="post_content entry-content">
			<?php
			// Post content area
			if ( empty( $ozeum_template_args['hide_excerpt'] ) && ozeum_get_theme_option( 'excerpt_length' ) > 0 ) {
				ozeum_show_post_content( $ozeum_template_args, '<div class="post_content_inner">', '</div>' );
			}
			// Post meta
			if ( in_array( $ozeum_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				ozeum_show_layout( $ozeum_post_meta );
			}
			// More button
			if ( empty( $ozeum_template_args['no_links'] ) && ! in_array( $ozeum_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				ozeum_show_post_more_link( $ozeum_template_args, '<p>', '</p>' );
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
