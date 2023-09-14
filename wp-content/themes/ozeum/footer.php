<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */

							// Widgets area inside page content
							ozeum_create_widgets_area( 'widgets_below_content' );
							?>
						</div><!-- </.content> -->
					<?php

					// Show main sidebar
					get_sidebar();
					?>
					</div><!-- </.content_wrap> -->
					<?php

					// Widgets area below page content and related posts below page content
					$ozeum_body_style = ozeum_get_theme_option( 'body_style' );
					$ozeum_widgets_name = ozeum_get_theme_option( 'widgets_below_page' );
					$ozeum_show_widgets = ! ozeum_is_off( $ozeum_widgets_name ) && is_active_sidebar( $ozeum_widgets_name );
					$ozeum_show_related = is_single() && ozeum_get_theme_option( 'related_position' ) == 'below_page';
					if ( $ozeum_show_widgets || $ozeum_show_related ) {
						if ( 'fullscreen' != $ozeum_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $ozeum_show_related ) {
							do_action( 'ozeum_action_related_posts' );
						}

						// Widgets area below page content
						if ( $ozeum_show_widgets ) {
							ozeum_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $ozeum_body_style ) {
							?>
							</div><!-- </.content_wrap> -->
							<?php
						}
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Single posts banner before footer
			if ( is_singular( 'post' ) ) {
				ozeum_show_post_banner('footer');
			}

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! is_singular( 'post' ) && ! is_singular( 'attachment' ) ) || ! in_array ( ozeum_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="ozeum_skip_link_anchor" href="#"></a>
				<?php
				
				// Footer
				$ozeum_footer_type = ozeum_get_theme_option( 'footer_type' );
				if ( 'custom' == $ozeum_footer_type && ! ozeum_is_layouts_available() ) {
					$ozeum_footer_type = 'default';
				}
				get_template_part( apply_filters( 'ozeum_filter_get_template_part', "templates/footer-{$ozeum_footer_type}" ) );

			}
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>

</body>
</html>