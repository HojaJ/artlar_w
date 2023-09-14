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
	$ozeum_columns    = empty( $ozeum_template_args['columns'] ) ? 2 : max( 1, $ozeum_template_args['columns'] );
	$ozeum_blog_style = array( $ozeum_template_args['type'], $ozeum_columns );
} else {
	$ozeum_blog_style = explode( '_', ozeum_get_theme_option( 'blog_style' ) );
	$ozeum_columns    = empty( $ozeum_blog_style[1] ) ? 2 : max( 1, $ozeum_blog_style[1] );
}
$ozeum_expanded   = ! ozeum_sidebar_present() && ozeum_is_on( ozeum_get_theme_option( 'expand_content' ) );

$ozeum_components = ! empty( $ozeum_template_args['meta_parts'] )
						? ( is_array( $ozeum_template_args['meta_parts'] )
							? join( ',', $ozeum_template_args['meta_parts'] )
							: $ozeum_template_args['meta_parts']
							)
						: ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'meta_parts' ) );

$ozeum_post_format = get_post_format();
$ozeum_post_format = empty( $ozeum_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ozeum_post_format );

?><div class="<?php
	if ( ! empty( $ozeum_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( 'classic' == $ozeum_blog_style[0] ? 'column' : 'masonry_item masonry_item' ) . '-1_' . esc_attr( $ozeum_columns );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $ozeum_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $ozeum_columns )
				. ' post_layout_' . esc_attr( $ozeum_blog_style[0] )
				. ' post_layout_' . esc_attr( $ozeum_blog_style[0] ) . '_' . esc_attr( $ozeum_columns )
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

	// Featured image
	$ozeum_hover = ! empty( $ozeum_template_args['hover'] ) && ! ozeum_is_inherit( $ozeum_template_args['hover'] )
						? $ozeum_template_args['hover']
						: ozeum_get_theme_option( 'image_hover' );
	ozeum_show_post_featured(
		array(
			'thumb_size' => ozeum_get_thumb_size(
				'classic' == $ozeum_blog_style[0]
						? ( strpos( ozeum_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $ozeum_columns > 2 ? 'big' : 'huge' )
								: ( $ozeum_columns > 2
									? ( $ozeum_expanded ? 'med' : 'small' )
									: ( $ozeum_expanded ? 'big' : 'med' )
									)
							)
						: ( strpos( ozeum_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $ozeum_columns > 2 ? 'masonry-big' : 'full' )
								: ( $ozeum_columns <= 2 && $ozeum_expanded ? 'masonry-big' : 'masonry' )
							)
			),
			'hover'      => $ozeum_hover,
			'no_links'   => ! empty( $ozeum_template_args['no_links'] ),
		)
	);

	if ( ! in_array( $ozeum_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
        if ( is_sticky() && ! is_paged()) {	?>
          <div class="post_wrapper"><?php
        }
        ?>
		<div class="post_header entry-header">
			<?php
			do_action( 'ozeum_action_before_post_title' );

			// Post title
			if ( empty( $ozeum_template_args['no_links'] ) ) {
				the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			} else {
				the_title( '<h4 class="post_title entry-title">', '</h4>' );
			}

			do_action( 'ozeum_action_before_post_meta' );

			// Post meta
			if ( ! empty( $ozeum_components ) && ! in_array( $ozeum_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
				ozeum_show_post_meta(
					apply_filters(
						'ozeum_filter_post_meta_args', array(
							'components' => $ozeum_components,
							'seo'        => false,
						), $ozeum_blog_style[0], $ozeum_columns
					)
				);
			}

			do_action( 'ozeum_action_after_post_meta' );
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content area
	ob_start();

	// Post content
	if ( empty( $ozeum_template_args['hide_excerpt'] ) && ozeum_get_theme_option( 'excerpt_length' ) > 0 ) {
		ozeum_show_post_content( $ozeum_template_args, '<div class="post_content_inner">', '</div>' );
	}

	// Post meta
	if ( in_array( $ozeum_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		if ( ! empty( $ozeum_components ) ) {
			ozeum_show_post_meta(
				apply_filters(
					'ozeum_filter_post_meta_args', array(
						'components' => $ozeum_components,
					), $ozeum_blog_style[0], $ozeum_columns
				)
			);
		}
	}
		
	// More button
	if ( empty( $ozeum_template_args['no_links'] ) && ! empty( $ozeum_template_args['more_text'] ) && ! in_array( $ozeum_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		ozeum_show_post_more_link( $ozeum_template_args, '<p>', '</p>' );
	}

	$ozeum_content = ob_get_contents();
	ob_end_clean();

	ozeum_show_layout( $ozeum_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->' );
    if ( is_sticky() && ! is_paged()) {	?>
        </div><?php
    }
    ?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
