<div class="front_page_section front_page_section_woocommerce<?php
	$ozeum_scheme = ozeum_get_theme_option( 'front_page_woocommerce_scheme' );
	if ( ! empty( $ozeum_scheme ) && ! ozeum_is_inherit( $ozeum_scheme ) ) {
		echo ' scheme_' . esc_attr( $ozeum_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( ozeum_get_theme_option( 'front_page_woocommerce_paddings' ) );
	if ( ozeum_get_theme_option( 'front_page_woocommerce_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$ozeum_css      = '';
		$ozeum_bg_image = ozeum_get_theme_option( 'front_page_woocommerce_bg_image' );
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
	$ozeum_anchor_icon = ozeum_get_theme_option( 'front_page_woocommerce_anchor_icon' );
	$ozeum_anchor_text = ozeum_get_theme_option( 'front_page_woocommerce_anchor_text' );
if ( ( ! empty( $ozeum_anchor_icon ) || ! empty( $ozeum_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_woocommerce"'
									. ( ! empty( $ozeum_anchor_icon ) ? ' icon="' . esc_attr( $ozeum_anchor_icon ) . '"' : '' )
									. ( ! empty( $ozeum_anchor_text ) ? ' title="' . esc_attr( $ozeum_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner
	<?php
	if ( ozeum_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
		echo ' ozeum-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$ozeum_css      = '';
			$ozeum_bg_mask  = ozeum_get_theme_option( 'front_page_woocommerce_bg_mask' );
			$ozeum_bg_color_type = ozeum_get_theme_option( 'front_page_woocommerce_bg_color_type' );
			if ( 'custom' == $ozeum_bg_color_type ) {
				$ozeum_bg_color = ozeum_get_theme_option( 'front_page_woocommerce_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$ozeum_caption     = ozeum_get_theme_option( 'front_page_woocommerce_caption' );
			$ozeum_description = ozeum_get_theme_option( 'front_page_woocommerce_description' );
			if ( ! empty( $ozeum_caption ) || ! empty( $ozeum_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $ozeum_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $ozeum_caption ) ? 'filled' : 'empty'; ?>">
					<?php
                        echo wp_kses( $ozeum_caption, 'ozeum_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description (text)
				if ( ! empty( $ozeum_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $ozeum_description ) ? 'filled' : 'empty'; ?>">
					<?php
                        echo wp_kses( wpautop( $ozeum_description ), 'ozeum_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
			<?php
				$ozeum_woocommerce_sc = ozeum_get_theme_option( 'front_page_woocommerce_products' );
			if ( 'products' == $ozeum_woocommerce_sc ) {
				$ozeum_woocommerce_sc_ids      = ozeum_get_theme_option( 'front_page_woocommerce_products_per_page' );
				$ozeum_woocommerce_sc_per_page = count( explode( ',', $ozeum_woocommerce_sc_ids ) );
			} else {
				$ozeum_woocommerce_sc_per_page = max( 1, (int) ozeum_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
			}
				$ozeum_woocommerce_sc_columns = max( 1, min( $ozeum_woocommerce_sc_per_page, (int) ozeum_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
				echo do_shortcode(
					"[{$ozeum_woocommerce_sc}"
									. ( 'products' == $ozeum_woocommerce_sc
											? ' ids="' . esc_attr( $ozeum_woocommerce_sc_ids ) . '"'
											: '' )
									. ( 'product_category' == $ozeum_woocommerce_sc
											? ' category="' . esc_attr( ozeum_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
											: '' )
									. ( 'best_selling_products' != $ozeum_woocommerce_sc
											? ' orderby="' . esc_attr( ozeum_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
												. ' order="' . esc_attr( ozeum_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
											: '' )
									. ' per_page="' . esc_attr( $ozeum_woocommerce_sc_per_page ) . '"'
									. ' columns="' . esc_attr( $ozeum_woocommerce_sc_columns ) . '"'
					. ']'
				);
				?>
			</div>
		</div>
	</div>
</div>
