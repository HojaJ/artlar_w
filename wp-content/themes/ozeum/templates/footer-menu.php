<?php
/**
 * The template to display menu in the footer
 *
 * @package OZEUM
 * @since OZEUM 1.0.10
 */

// Footer menu
$ozeum_menu_footer = ozeum_get_nav_menu( 'menu_footer' );
if ( ! empty( $ozeum_menu_footer ) ) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php
			ozeum_show_layout(
				$ozeum_menu_footer,
				'<nav class="menu_footer_nav_area sc_layouts_menu sc_layouts_menu_default"'
					. ' itemscope="itemscope" itemtype="' . esc_attr( ozeum_get_protocol( true ) ) . '//schema.org/SiteNavigationElement"'
					. '>',
				'</nav>'
			);
			?>
		</div>
	</div>
	<?php
}
