<?php
/**
 * The Front Page template file.
 *
 * @package OZEUM
 * @since OZEUM 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( ozeum_is_on( ozeum_get_theme_option( 'front_page_enabled' ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$ozeum_sections = ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'front_page_sections' ), 1, false );
		if ( is_array( $ozeum_sections ) ) {
			foreach ( $ozeum_sections as $ozeum_section ) {
				get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'front-page/section', $ozeum_section ), $ozeum_section );
			}
		}

		// Else if this page is blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'blog' ) );

		// Else - display native page content
	} else {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'page' ) );
	}

	// Else get index template to show posts
} else {
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'index' ) );
}

get_footer();
