<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

$ozeum_template_args = get_query_var( 'ozeum_template_args' );
$ozeum_columns = 1;
if ( is_array( $ozeum_template_args ) ) {
	$ozeum_columns    = empty( $ozeum_template_args['columns'] ) ? 1 : max( 1, $ozeum_template_args['columns'] );
	$ozeum_blog_style = array( $ozeum_template_args['type'], $ozeum_columns );
	if ( ! empty( $ozeum_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $ozeum_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $ozeum_columns ); ?>">
		<?php
	}
}
$ozeum_expanded    = ! ozeum_sidebar_present() && ozeum_is_on( ozeum_get_theme_option( 'expand_content' ) );
$ozeum_post_format = get_post_format();
$ozeum_post_format = empty( $ozeum_post_format ) ? 'standard' : str_replace( 'post-format-', '', $ozeum_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_layout_excerpt post_format_' . esc_attr( $ozeum_post_format ) );
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
			'no_links'   => ! empty( $ozeum_template_args['no_links'] ),
			'hover'      => $ozeum_hover,
			'thumb_size' => ozeum_get_thumb_size( strpos( ozeum_get_theme_option( 'body_style' ), 'full' ) !== false ? 'full' : ( $ozeum_expanded ? 'huge' : 'big' ) ),
		)
	);

	// Title and post meta
	$ozeum_show_title = get_the_title() != '';
	$ozeum_components = ! empty( $ozeum_template_args['meta_parts'] )
							? ( is_array( $ozeum_template_args['meta_parts'] )
								? join( ',', $ozeum_template_args['meta_parts'] )
								: $ozeum_template_args['meta_parts']
								)
							: ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'meta_parts' ) );
	$ozeum_show_meta  = ! empty( $ozeum_components ) && ! in_array( $ozeum_hover, array( 'border', 'pull', 'slide', 'fade' ) );
	if ( $ozeum_show_title || $ozeum_show_meta ) {
	    if ( is_sticky() && ! is_paged()) {	?>
		    <div class="post_wrapper"><?php
        } ?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( $ozeum_show_title ) {
				do_action( 'ozeum_action_before_post_title' );
				if ( empty( $ozeum_template_args['no_links'] ) ) {
					the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				} else {
					the_title( '<h2 class="post_title entry-title">', '</h2>' );
				}
			}
			
			// Post meta
			if ( $ozeum_show_meta ) {
				do_action( 'ozeum_action_before_post_meta' );
				ozeum_show_post_meta(
					apply_filters(
						'ozeum_filter_post_meta_args', array(
							'components' => $ozeum_components,
							'seo'        => false,
						), 'excerpt', 1
					)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( empty( $ozeum_template_args['hide_excerpt'] ) && ozeum_get_theme_option( 'excerpt_length' ) > 0 ) {
		?>
		<div class="post_content entry-content">
			<?php
			if ( ozeum_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'ozeum_action_before_full_post_content' );
					the_content( '' );
					do_action( 'ozeum_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'ozeum' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'ozeum' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				ozeum_show_post_content( $ozeum_template_args, '<div class="post_content_inner">', '</div>' );
				// More button
				if ( empty( $ozeum_template_args['no_links'] ) && ! in_array( $ozeum_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
					ozeum_show_post_more_link( $ozeum_template_args, '<p>', '</p>' );
				}
			}
			?>
		</div><!-- .entry-content -->
		<?php
		if ( is_sticky() && ! is_paged()) {	?>
		    </div><?php
        }
	}
	?>
</article>
<?php

if ( is_array( $ozeum_template_args ) ) {
	if ( ! empty( $ozeum_template_args['slider'] ) || $ozeum_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
