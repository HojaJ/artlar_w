<?php
/**
 * The template for homepage posts with custom style
 *
 * @package OZEUM
 * @since OZEUM 1.0.50
 */

ozeum_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	$ozeum_blog_style = ozeum_get_theme_option( 'blog_style' );
	$ozeum_parts      = explode( '_', $ozeum_blog_style );
	$ozeum_columns    = ! empty( $ozeum_parts[1] ) ? max( 1, min( 6, (int) $ozeum_parts[1] ) ) : 1;
	$ozeum_blog_id    = ozeum_get_custom_blog_id( $ozeum_blog_style );
	$ozeum_blog_meta  = ozeum_get_custom_layout_meta( $ozeum_blog_id );
	if ( ! empty( $ozeum_blog_meta['margin'] ) ) {
		ozeum_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( ozeum_prepare_css_value( $ozeum_blog_meta['margin'] ) ) ) );
	}
	$ozeum_custom_style = ! empty( $ozeum_blog_meta['scripts_required'] ) ? $ozeum_blog_meta['scripts_required'] : 'none';

	ozeum_blog_archive_start();

	$ozeum_classes    = 'posts_container blog_custom_wrap' 
							. ( ! ozeum_is_off( $ozeum_custom_style )
								? sprintf( ' %s_wrap', $ozeum_custom_style )
								: ( $ozeum_columns > 1 
									? ' columns_wrap columns_padding_bottom' 
									: ''
									)
								);
	$ozeum_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$ozeum_sticky_out = ozeum_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $ozeum_stickies ) && count( $ozeum_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $ozeum_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $ozeum_sticky_out ) {
		if ( ozeum_get_theme_option( 'first_post_large' ) && ! is_paged() && ! in_array( ozeum_get_theme_option( 'body_style' ), array( 'fullwide', 'fullscreen' ) ) ) {
			the_post();
			get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'content', 'excerpt' ), 'excerpt' );
		}
		?>
		<div class="<?php echo esc_attr( $ozeum_classes ); ?>">
		<?php
	}
	while ( have_posts() ) {
		the_post();
		if ( $ozeum_sticky_out && ! is_sticky() ) {
			$ozeum_sticky_out = false;
			?>
			</div><div class="<?php echo esc_attr( $ozeum_classes ); ?>">
			<?php
		}
		$ozeum_part = $ozeum_sticky_out && is_sticky() ? 'sticky' : 'custom';
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'content', $ozeum_part ), $ozeum_part );
	}
	?>
	</div>
	<?php

	ozeum_show_pagination();

	ozeum_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
