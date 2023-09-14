<div class="front_page_section front_page_section_about<?php
	$ozeum_scheme = ozeum_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $ozeum_scheme ) && ! ozeum_is_inherit( $ozeum_scheme ) ) {
		echo ' scheme_' . esc_attr( $ozeum_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( ozeum_get_theme_option( 'front_page_about_paddings' ) );
	if ( ozeum_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$ozeum_css      = '';
		$ozeum_bg_image = ozeum_get_theme_option( 'front_page_about_bg_image' );
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
	$ozeum_anchor_icon = ozeum_get_theme_option( 'front_page_about_anchor_icon' );
	$ozeum_anchor_text = ozeum_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $ozeum_anchor_icon ) || ! empty( $ozeum_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $ozeum_anchor_icon ) ? ' icon="' . esc_attr( $ozeum_anchor_icon ) . '"' : '' )
									. ( ! empty( $ozeum_anchor_text ) ? ' title="' . esc_attr( $ozeum_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( ozeum_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' ozeum-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$ozeum_css           = '';
			$ozeum_bg_mask       = ozeum_get_theme_option( 'front_page_about_bg_mask' );
			$ozeum_bg_color_type = ozeum_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $ozeum_bg_color_type ) {
				$ozeum_bg_color = ozeum_get_theme_option( 'front_page_about_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$ozeum_caption = ozeum_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $ozeum_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $ozeum_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $ozeum_caption, 'ozeum_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$ozeum_description = ozeum_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $ozeum_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $ozeum_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $ozeum_description ), 'ozeum_kses_content' ); ?></div>
				<?php
			}

			// Content
			$ozeum_content = ozeum_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $ozeum_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $ozeum_content ) ? 'filled' : 'empty'; ?>">
				<?php
					$ozeum_page_content_mask = '%%CONTENT%%';
				if ( strpos( $ozeum_content, $ozeum_page_content_mask ) !== false ) {
					$ozeum_content = preg_replace(
						'/(\<p\>\s*)?' . $ozeum_page_content_mask . '(\s*\<\/p\>)/i',
						sprintf(
							'<div class="front_page_section_about_source">%s</div>',
							apply_filters( 'the_content', get_the_content() )
						),
						$ozeum_content
					);
				}
					ozeum_show_layout( $ozeum_content );
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
