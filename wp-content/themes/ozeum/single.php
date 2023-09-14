<?php
/**
 * The template to display single post
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

// Full post loading
$full_post_loading        = ozeum_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading        = ozeum_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type   = ozeum_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$ozeum_related_position = ozeum_get_theme_option( 'related_position' );

// Type of the prev/next posts navigation
$ozeum_posts_navigation = ozeum_get_theme_option( 'posts_navigation' );
$ozeum_prev_post        = false;

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( ozeum_get_theme_option( 'single_style' ), array( 'in-above', 'in-below', 'in-over', 'in-sticky' ) )
) {
	ozeum_storage_set_array( 'options_meta', 'single_style', 'in-below' );
}

get_header();

while ( have_posts() ) {
	the_post();

	// Type of the prev/next posts navigation
	if ( 'scroll' == $ozeum_posts_navigation ) {
		$ozeum_prev_post = get_previous_post( true );         // Get post from same category
		if ( ! $ozeum_prev_post ) {
			$ozeum_prev_post = get_previous_post( false );    // Get post from any category
			if ( ! $ozeum_prev_post ) {
				$ozeum_posts_navigation = 'links';
			}
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $ozeum_prev_post ) ) {
		ozeum_sc_layouts_showed( 'featured', false );
		ozeum_sc_layouts_showed( 'title', false );
		ozeum_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $ozeum_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'content', 'single-' . ozeum_get_theme_option( 'single_style' ) ), 'single-' . ozeum_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $ozeum_related_position, 'inside' ) === 0 ) {
		$ozeum_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'ozeum_action_related_posts' );
		$ozeum_related_content = ob_get_contents();
		ob_end_clean();

		$ozeum_related_position_inside = max( 0, min( 9, ozeum_get_theme_option( 'related_position_inside' ) ) );
		if ( 0 == $ozeum_related_position_inside ) {
			$ozeum_related_position_inside = mt_rand( 1, 9 );
		}

		$ozeum_p_number = 0;
		$ozeum_related_inserted = false;
		for ( $i = 0; $i < strlen( $ozeum_content ) - 3; $i++ ) {
			if ( '<' == $ozeum_content[ $i ] && 'p' == $ozeum_content[ $i + 1 ] && in_array( $ozeum_content[ $i + 2 ], array( '>', ' ' ) ) ) {
				$ozeum_p_number++;
				if ( $ozeum_related_position_inside == $ozeum_p_number ) {
					$ozeum_related_inserted = true;
					$ozeum_content = ( $i > 0 ? substr( $ozeum_content, 0, $i ) : '' )
										. $ozeum_related_content
										. substr( $ozeum_content, $i );
				}
			}
		}
		if ( ! $ozeum_related_inserted ) {
			$ozeum_content .= $ozeum_related_content;
		}

		ozeum_show_layout( $ozeum_content );
	}

	// Author bio
	if ( ozeum_get_theme_option( 'show_author_info' ) == 1
		&& ! is_attachment()
		&& get_the_author_meta( 'description' )
		&& ( 'scroll' != $ozeum_posts_navigation || ozeum_get_theme_option( 'posts_navigation_scroll_hide_author' ) == 0 )
		&& ( ! $full_post_loading || ozeum_get_theme_option( 'open_full_post_hide_author' ) == 0 )
	) {
		do_action( 'ozeum_action_before_post_author' );
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/author-bio' ) );
		do_action( 'ozeum_action_after_post_author' );
	}

	// Previous/next post navigation.
	if ( 'links' == $ozeum_posts_navigation && ! $full_post_loading ) {
		do_action( 'ozeum_action_before_post_navigation' );
		?>
		<div class="nav-links-single<?php
			if ( ! ozeum_is_off( ozeum_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation(
				array(
					'next_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'ozeum' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'ozeum' ) . '</span> '
						. '<h6 class="post-title">%title</h6>'
						. '<span class="post_date">%date</span>',
				)
			);
			?>
		</div>
		<?php
		do_action( 'ozeum_action_after_post_navigation' );
	}

	// Related posts
	if ( 'below_content' == $ozeum_related_position
		&& ( 'scroll' != $ozeum_posts_navigation || ozeum_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || ozeum_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'ozeum_action_related_posts' );
	}

	// If comments are open or we have at least one comment, load up the comment template.
	$ozeum_comments_number = get_comments_number();
	if ( comments_open() || $ozeum_comments_number > 0 ) {
		if ( ozeum_get_value_gp( 'show_comments' ) == 1 || ( ! $full_post_loading && ( 'scroll' != $ozeum_posts_navigation || ozeum_get_theme_option( 'posts_navigation_scroll_hide_comments' ) == 0 || ozeum_check_url( '#comment' ) ) ) ) {
			do_action( 'ozeum_action_before_comments' );
			comments_template();
			do_action( 'ozeum_action_after_comments' );
		} else {
			?>
			<div class="show_comments_single">
				<a href="<?php echo esc_url( add_query_arg( array( 'show_comments' => 1 ), get_comments_link() ) ); ?>" class="theme_button show_comments_button">
					<?php
					if ( $ozeum_comments_number > 0 ) {
						echo sprintf( ($ozeum_comments_number === 1) ? esc_html__('Show comment', 'ozeum') :  esc_html__('Show comments ( %d )', 'ozeum'), $ozeum_comments_number );
					} else {
						esc_html_e( 'Leave a comment', 'ozeum' );
					}
					?>
				</a>
			</div>
			<?php
		}
	}

	if ( 'scroll' == $ozeum_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $ozeum_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $ozeum_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $ozeum_prev_post ) ); ?>">
		</div>
		<?php
	}
}

get_footer();
