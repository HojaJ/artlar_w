<div class="front_page_section front_page_section_googlemap<?php
	$ozeum_scheme = ozeum_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $ozeum_scheme ) && ! ozeum_is_inherit( $ozeum_scheme ) ) {
		echo ' scheme_' . esc_attr( $ozeum_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( ozeum_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( ozeum_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$ozeum_css      = '';
		$ozeum_bg_image = ozeum_get_theme_option( 'front_page_googlemap_bg_image' );
		if ( ! empty( $ozeum_bg_image ) ) {
			$ozeum_css .= 'background-image: url(' . esc_url( ozeum_get_attachment_url( $ozeum_bg_image ) ) . ');';
		}
		if ( ! empty( $ozeum_css ) ) {
			echo ' style="' . esc_attr( $ozeum_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$ozeum_anchor_icon = ozeum_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$ozeum_anchor_text = ozeum_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $ozeum_anchor_icon ) || ! empty( $ozeum_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $ozeum_anchor_icon ) ? ' icon="' . esc_attr( $ozeum_anchor_icon ) . '"' : '' )
									. ( ! empty( $ozeum_anchor_text ) ? ' title="' . esc_attr( $ozeum_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$ozeum_layout = ozeum_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $ozeum_layout );
		if ( ozeum_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' ozeum-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$ozeum_css      = '';
			$ozeum_bg_mask  = ozeum_get_theme_option( 'front_page_googlemap_bg_mask' );
			$ozeum_bg_color_type = ozeum_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $ozeum_bg_color_type ) {
				$ozeum_bg_color = ozeum_get_theme_option( 'front_page_googlemap_bg_color' );
			} elseif ( 'scheme_bg_color' == $ozeum_bg_color_type ) {
				$ozeum_bg_color = ozeum_get_scheme_color( 'bg_color', $ozeum_scheme );
			} else {
				$ozeum_bg_color = '';
			}
			if ( ! empty( $ozeum_bg_color ) && $ozeum_bg_mask > 0 ) {
				$ozeum_css .= 'background-color: ' . esc_attr(
					1 == $ozeum_bg_mask ? $ozeum_bg_color : ozeum_hex2rgba( $ozeum_bg_color, $ozeum_bg_mask )
				) . ';';
			}
			if ( ! empty( $ozeum_css ) ) {
				echo ' style="' . esc_attr( $ozeum_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $ozeum_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$ozeum_caption     = ozeum_get_theme_option( 'front_page_googlemap_caption' );
			$ozeum_description = ozeum_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $ozeum_caption ) || ! empty( $ozeum_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $ozeum_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $ozeum_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $ozeum_caption ) ? 'filled' : 'empty'; ?>">
					<?php
                    echo wp_kses( $ozeum_caption, 'ozeum_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $ozeum_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $ozeum_description ) ? 'filled' : 'empty'; ?>">
					<?php
                    echo wp_kses( wpautop( $ozeum_description ), 'ozeum_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $ozeum_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$ozeum_content = ozeum_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $ozeum_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $ozeum_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $ozeum_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $ozeum_content ) ? 'filled' : 'empty'; ?>">
				<?php
                echo wp_kses( $ozeum_content, 'ozeum_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $ozeum_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $ozeum_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
			<?php
			if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
				dynamic_sidebar( 'front_page_googlemap_widgets' );
			} elseif ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! ozeum_exists_trx_addons() ) {
					ozeum_customizer_need_trx_addons_message();
				} else {
					ozeum_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
				}
			}
			?>
			</div>
			<?php

			if ( 'columns' == $ozeum_layout && ( ! empty( $ozeum_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
