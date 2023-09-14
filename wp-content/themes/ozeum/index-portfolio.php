<?php
/**
 * The template for homepage posts with "Portfolio" style
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

	// Show filters
	$ozeum_cat          = ozeum_get_theme_option( 'parent_cat' );
	$ozeum_post_type    = ozeum_get_theme_option( 'post_type' );
	$ozeum_taxonomy     = ozeum_get_post_type_taxonomy( $ozeum_post_type );
	$ozeum_show_filters = ozeum_get_theme_option( 'show_filters' );
	$ozeum_tabs         = array();
	if ( ! ozeum_is_off( $ozeum_show_filters ) ) {
		$ozeum_args           = array(
			'type'         => $ozeum_post_type,
			'child_of'     => $ozeum_cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => $ozeum_taxonomy,
			'pad_counts'   => false,
		);
		$ozeum_portfolio_list = get_terms( $ozeum_args );
		if ( is_array( $ozeum_portfolio_list ) && count( $ozeum_portfolio_list ) > 0 ) {
			$ozeum_tabs[ $ozeum_cat ] = esc_html__( 'All', 'ozeum' );
			foreach ( $ozeum_portfolio_list as $ozeum_term ) {
				if ( isset( $ozeum_term->term_id ) ) {
					$ozeum_tabs[ $ozeum_term->term_id ] = $ozeum_term->name;
				}
			}
		}
	}
	if ( count( $ozeum_tabs ) > 0 ) {
		$ozeum_portfolio_filters_ajax   = true;
		$ozeum_portfolio_filters_active = $ozeum_cat;
		$ozeum_portfolio_filters_id     = 'portfolio_filters';
		?>
		<div class="portfolio_filters ozeum_tabs ozeum_tabs_ajax">
			<ul class="portfolio_titles ozeum_tabs_titles">
				<?php
				foreach ( $ozeum_tabs as $ozeum_id => $ozeum_title ) {
					?>
					<li><a href="<?php echo esc_url( ozeum_get_hash_link( sprintf( '#%s_%s_content', $ozeum_portfolio_filters_id, $ozeum_id ) ) ); ?>" data-tab="<?php echo esc_attr( $ozeum_id ); ?>"><?php echo esc_html( $ozeum_title ); ?></a></li>
					<?php
				}
				?>
			</ul>
			<?php
			$ozeum_ppp = ozeum_get_theme_option( 'posts_per_page' );
			if ( ozeum_is_inherit( $ozeum_ppp ) ) {
				$ozeum_ppp = '';
			}
			foreach ( $ozeum_tabs as $ozeum_id => $ozeum_title ) {
				$ozeum_portfolio_need_content = $ozeum_id == $ozeum_portfolio_filters_active || ! $ozeum_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr( sprintf( '%s_%s_content', $ozeum_portfolio_filters_id, $ozeum_id ) ); ?>"
					class="portfolio_content ozeum_tabs_content"
					data-blog-template="<?php echo esc_attr( ozeum_storage_get( 'blog_template' ) ); ?>"
					data-blog-style="<?php echo esc_attr( ozeum_get_theme_option( 'blog_style' ) ); ?>"
					data-posts-per-page="<?php echo esc_attr( $ozeum_ppp ); ?>"
					data-post-type="<?php echo esc_attr( $ozeum_post_type ); ?>"
					data-taxonomy="<?php echo esc_attr( $ozeum_taxonomy ); ?>"
					data-cat="<?php echo esc_attr( $ozeum_id ); ?>"
					data-parent-cat="<?php echo esc_attr( $ozeum_cat ); ?>"
					data-need-content="<?php echo ( false === $ozeum_portfolio_need_content ? 'true' : 'false' ); ?>"
				>
					<?php
					if ( $ozeum_portfolio_need_content ) {
						ozeum_show_portfolio_posts(
							array(
								'cat'        => $ozeum_id,
								'parent_cat' => $ozeum_cat,
								'taxonomy'   => $ozeum_taxonomy,
								'post_type'  => $ozeum_post_type,
								'page'       => 1,
								'sticky'     => $ozeum_sticky_out,
							)
						);
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		ozeum_show_portfolio_posts(
			array(
				'cat'        => $ozeum_cat,
				'parent_cat' => $ozeum_cat,
				'taxonomy'   => $ozeum_taxonomy,
				'post_type'  => $ozeum_post_type,
				'page'       => 1,
				'sticky'     => $ozeum_sticky_out,
			)
		);
	}

	ozeum_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
