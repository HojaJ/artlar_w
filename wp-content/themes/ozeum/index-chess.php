<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

ozeum_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	ozeum_blog_archive_start();

	$ozeum_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$ozeum_sticky_out = ozeum_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $ozeum_stickies ) && count( $ozeum_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $ozeum_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $ozeum_sticky_out ) {
		?>
		<div class="chess_wrap posts_container">
		<?php
	}
	
	while ( have_posts() ) {
		the_post();
		if ( $ozeum_sticky_out && ! is_sticky() ) {
			$ozeum_sticky_out = false;
			?>
			</div><div class="chess_wrap posts_container">
			<?php
		}
		$ozeum_part = $ozeum_sticky_out && is_sticky() ? 'sticky' : 'chess';
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
