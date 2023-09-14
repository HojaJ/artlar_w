<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

// Page (category, tag, archive, author) title

if ( ozeum_need_page_title() ) {
	ozeum_sc_layouts_showed( 'title', true );
	ozeum_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								ozeum_show_post_meta(
									apply_filters(
										'ozeum_filter_post_meta_args', array(
											'components' => ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'meta_parts' ) ),
											'counters'   => ozeum_array_get_keys_by_value( ozeum_get_theme_option( 'counters' ) ),
											'seo'        => ozeum_is_on( ozeum_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$ozeum_blog_title           = ozeum_get_blog_title();
							$ozeum_blog_title_text      = '';
							$ozeum_blog_title_class     = '';
							$ozeum_blog_title_link      = '';
							$ozeum_blog_title_link_text = '';
							if ( is_array( $ozeum_blog_title ) ) {
								$ozeum_blog_title_text      = $ozeum_blog_title['text'];
								$ozeum_blog_title_class     = ! empty( $ozeum_blog_title['class'] ) ? ' ' . $ozeum_blog_title['class'] : '';
								$ozeum_blog_title_link      = ! empty( $ozeum_blog_title['link'] ) ? $ozeum_blog_title['link'] : '';
								$ozeum_blog_title_link_text = ! empty( $ozeum_blog_title['link_text'] ) ? $ozeum_blog_title['link_text'] : '';
							} else {
								$ozeum_blog_title_text = $ozeum_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $ozeum_blog_title_class ); ?>">
								<?php
								$ozeum_top_icon = ozeum_get_term_image_small();
								if ( ! empty( $ozeum_top_icon ) ) {
									$ozeum_attr = ozeum_getimagesize( $ozeum_top_icon );
									?>
									<img src="<?php echo esc_url( $ozeum_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'ozeum' ); ?>"
										<?php
										if ( ! empty( $ozeum_attr[3] ) ) {
											ozeum_show_layout( $ozeum_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_post( $ozeum_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $ozeum_blog_title_link ) && ! empty( $ozeum_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $ozeum_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $ozeum_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'ozeum_action_breadcrumbs' );
						$ozeum_breadcrumbs = ob_get_contents();
						ob_end_clean();
						ozeum_show_layout( $ozeum_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
