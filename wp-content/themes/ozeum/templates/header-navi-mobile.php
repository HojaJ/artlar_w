<?php
/**
 * The template to show mobile menu
 *
 * @package OZEUM
 * @since OZEUM 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( ozeum_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close theme_button_close"><span class="theme_button_close_icon"></span></a>
		<?php

		// Logo
		set_query_var( 'ozeum_logo_args', array( 'type' => 'mobile' ) );
		get_template_part( apply_filters( 'ozeum_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'ozeum_logo_args', array() );

		// Mobile menu
		$ozeum_menu_mobile = ozeum_get_nav_menu( 'menu_mobile' );
		if ( empty( $ozeum_menu_mobile ) ) {
			$ozeum_menu_mobile = apply_filters( 'ozeum_filter_get_mobile_menu', '' );
			if ( empty( $ozeum_menu_mobile ) ) {
				$ozeum_menu_mobile = ozeum_get_nav_menu( 'menu_main' );
				if ( empty( $ozeum_menu_mobile ) ) {
					$ozeum_menu_mobile = ozeum_get_nav_menu();
				}
			}
		}
		if ( ! empty( $ozeum_menu_mobile ) ) {
			$ozeum_menu_mobile = str_replace(
				array( 'menu_main',   'id="menu-',        'sc_layouts_menu_nav', 'sc_layouts_menu ', 'sc_layouts_hide_on_mobile', 'hide_on_mobile' ),
				array( 'menu_mobile', 'id="menu_mobile-', '',                    ' ',                '',                          '' ),
				$ozeum_menu_mobile
			);
			if ( strpos( $ozeum_menu_mobile, '<nav ' ) === false ) {
				$ozeum_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area" itemscope="itemscope" itemtype="' . esc_attr( ozeum_get_protocol( true ) ) . '//schema.org/SiteNavigationElement">%s</nav>', $ozeum_menu_mobile );
			}
			ozeum_show_layout( apply_filters( 'ozeum_filter_menu_mobile_layout', $ozeum_menu_mobile ) );
		}

		// Search field
		do_action(
			'ozeum_action_search',
			array(
				'style' => 'normal',
				'class' => 'search_mobile',
				'ajax'  => false
			)
		);

		// Social icons
		ozeum_show_layout( ozeum_get_socials_links(), '<div class="socials_mobile">', '</div>' );
		?>
	</div>
</div>
