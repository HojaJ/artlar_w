<?php
/**
 * ThemeREX Addons: Panel with installation wizard, Theme Options and Support info
 *
 * @package ThemeREX Addons
 * @since v1.6.48
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Define component's subfolder
if ( !defined('TRX_ADDONS_PLUGIN_THEME_PANEL') ) define('TRX_ADDONS_PLUGIN_THEME_PANEL', TRX_ADDONS_PLUGIN_COMPONENTS . 'theme-panel/');
if ( !defined('TRX_ADDONS_PLUGIN_IMPORTER') )    define('TRX_ADDONS_PLUGIN_IMPORTER', TRX_ADDONS_PLUGIN_THEME_PANEL . 'importer/');
if ( !defined('TRX_ADDONS_PLUGIN_INSTALLER') )   define('TRX_ADDONS_PLUGIN_INSTALLER', TRX_ADDONS_PLUGIN_THEME_PANEL . 'installer/');

// Add Admin menu item to show Theme panel
if (!function_exists('trx_addons_theme_panel_admin_menu')) {
	add_action( 'admin_menu', 'trx_addons_theme_panel_admin_menu' );
	function trx_addons_theme_panel_admin_menu() {
		$theme_info  = trx_addons_get_theme_info();
		if (empty($theme_info['theme_pro_key'])) {
			add_menu_page(
				esc_html__('ThemeREX Addons', 'trx_addons'),	//page_title
				esc_html__('ThemeREX Addons', 'trx_addons'),	//menu_title
				'manage_options',								//capability
				'trx_addons_options',							//menu_slug
				'trx_addons_options_page_builder',				//callback
				'dashicons-welcome-widgets-menus',				//icon
				'50'											//menu position (after Dashboard)
			);
		} else {
			add_menu_page(
				esc_html__('Theme Panel', 'trx_addons'),	//page_title
				esc_html__('Theme Panel', 'trx_addons'),	//menu_title
				'manage_options',							//capability
				'trx_addons_theme_panel',					//menu_slug
				'trx_addons_theme_panel_page_builder',		//callback
				'dashicons-welcome-widgets-menus',			//icon
				'4'											//menu position (after Dashboard)
			);
			$submenu = apply_filters('trx_addons_filter_add_theme_panel_pages', array(
				array(
					esc_html__('Theme Dashboard', 'trx_addons'),//page_title
					esc_html__('Theme Dashboard', 'trx_addons'),//menu_title
					'manage_options',							//capability
					'trx_addons_theme_panel',					//menu_slug
					'trx_addons_theme_panel_page_builder'		//callback
					)
				)
			);
			if (is_array($submenu)) {
				foreach($submenu as $item) {
					add_submenu_page(
						'trx_addons_theme_panel',			//parent menu slug
						$item[0],							//page_title
						$item[1],							//menu_title
						$item[2],							//capability
						$item[3],							//menu_slug
						$item[4]							//callback
					);
				}
			}
		}
	}
}


// Load scripts and styles
if (!function_exists('trx_addons_theme_panel_load_scripts')) {
	add_action("admin_enqueue_scripts", 'trx_addons_theme_panel_load_scripts');
	function trx_addons_theme_panel_load_scripts() {
		if (isset($_REQUEST['page']) && $_REQUEST['page']=='trx_addons_theme_panel') {
			wp_enqueue_style( 'trx_addons-msgbox', trx_addons_get_file_url('js/msgbox/msgbox.css'), array(), null );
			wp_enqueue_script( 'trx_addons-msgbox', trx_addons_get_file_url('js/msgbox/msgbox.js'), array('jquery'), null, true );
			wp_enqueue_style( 'trx_addons-options', trx_addons_get_file_url('css/trx_addons.options.css'), array(), null );
			wp_enqueue_style( 'trx_addons-theme_panel', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEME_PANEL . 'theme-panel.css'), array(), null );
			wp_enqueue_script( 'trx_addons-theme_panel', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_THEME_PANEL . 'theme-panel.js'), array('jquery'), null, true );
		}
	}
}

// Return true if current screen need to load options scripts and styles
if ( !function_exists( 'trx_addons_theme_panel_need_options' ) ) {
	add_filter('trx_addons_filter_need_options', 'trx_addons_theme_panel_need_options');
	function trx_addons_theme_panel_need_options($need = false) {
		if (!$need) {
			// If current screen is 'Theme Panel'
			$need = isset($_REQUEST['page']) && $_REQUEST['page']=='trx_addons_theme_panel';
		}
		return $need;
	}
}

// Check 'theme activated' status
if ( !function_exists( 'trx_addons_is_theme_activated' ) ) {
	function trx_addons_is_theme_activated() {
		return apply_filters( 'trx_addons_filter_is_theme_activated',
					get_option( sprintf( 'trx_addons_theme_%s_activated', get_option( 'template' ) ) ) == 1
					&& get_option( sprintf( 'purchase_code_%s', get_option( 'template' ) ) ) != ''
				);
	}
}

// Set 'theme activated' status
if ( !function_exists( 'trx_addons_set_theme_activated' ) ) {
	function trx_addons_set_theme_activated($code='', $pro_key='', $token='') {
		update_option( sprintf( 'trx_addons_theme_%s_activated', get_option( 'template' ) ), 1);
		if ( !empty($code) ) {
			update_option( sprintf( 'purchase_code_%s', get_option( 'template' ) ), $code );
			if ( !empty($token) ) {
				update_option( sprintf( 'access_token_%s', get_option( 'template' ) ), $token );
			}
			if ( substr($pro_key, 0, 4) == 'env_' ) {
				update_option( sprintf( 'envato_purchase_code_%s', get_option( 'template' ) ), $code );
				if ( !empty($token) ) {
					update_option( sprintf( 'envato_access_token_%s', get_option( 'template' ) ), $token );
				}
			}
		}
	}
}

// Return 'theme activated' status
if ( !function_exists( 'trx_addons_get_theme_activated_status' ) ) {
	function trx_addons_get_theme_activated_status() {
		return trx_addons_is_theme_activated() ? 'active' : 'inactive';
	}
}

// Return theme activation code
if ( !function_exists( 'trx_addons_get_theme_activation_code' ) ) {
	function trx_addons_get_theme_activation_code() {
		return get_option( sprintf( 'trx_addons_theme_%s_activated', get_option( 'template' ) ) ) == 1
				? get_option( sprintf( 'purchase_code_%s', get_option( 'template' ) ) )
				: '';
	}
}

// Activate theme
if ( !function_exists( 'trx_addons_theme_panel_activate_theme' ) ) {
	add_action('init', 'trx_addons_theme_panel_activate_theme', 9);
	function trx_addons_theme_panel_activate_theme() {
		if (is_admin() && isset($_REQUEST['page']) && $_REQUEST['page']=='trx_addons_theme_panel') {
			// If submit form with activation code
			$nonce = trx_addons_get_value_gp('trx_addons_nonce');
			$code  = trx_addons_get_value_gp('trx_addons_activate_theme_code');
			if ( !empty( $nonce ) ) {
				// Check nonce
				if ( !wp_verify_nonce( $nonce, admin_url() ) ) {
					trx_addons_set_admin_message(__('Security code is invalid! Theme is not activated!', 'trx_addons'), 'error');
				
				// Check user
				} else if (!current_user_can('manage_options')) {
					trx_addons_set_admin_message(__('Activation theme is denied for the current user!', 'trx_addons'), 'error');

				} else if ( empty( $code ) ) {
					trx_addons_set_admin_message(__('Please, specify the purchase code!', 'trx_addons'), 'error');

				// Check code
				} else {
					$theme_info  = trx_addons_get_theme_info(false);
					$upgrade_url = sprintf(
						'//upgrade.themerex.net/upgrade.php?key=%1$s&src=%2$s&theme_slug=%3$s&theme_name=%4$s&action=check',
						urlencode( $code ),
						urlencode( $theme_info['theme_pro_key'] ),
						urlencode( $theme_info['theme_slug'] ),
						urlencode( $theme_info['theme_name'] )
					);
					if ( (int) trx_addons_get_value_gp('trx_addons_user_agree') == 1 ) {
						$user_name = sanitize_text_field(trx_addons_get_value_gp('trx_addons_user_name'));
						$user_email = sanitize_email(trx_addons_get_value_gp('trx_addons_user_email'));
						if (!empty($user_name) && !empty($user_email)) {
							$upgrade_url .= '&user_name=' . urlencode($user_name) . '&user_email=' . urlencode($user_email);
						}
					}
					$result = trx_addons_fgc( $upgrade_url );
					if ( is_serialized( $result ) ) {
						try {
							$result = trx_addons_unserialize( $result );
						} catch ( Exception $e ) {
							$result = array(
								'error' => '',
								'data' => -1
							);
						}
						if ( $result['data'] === 1 ) {
							trx_addons_set_theme_activated($code, $theme_info['theme_pro_key']);
							trx_addons_set_admin_message(__('Congratulations! Your theme is activated successfully.', 'trx_addons'), 'success');
						} elseif ( $result['data'] === -1 ) {
							trx_addons_set_admin_message(__('Bad server answer! Theme is not activated!', 'trx_addons'), 'error');
						} else {
							trx_addons_set_admin_message(__("Your purchase code is invalid! Theme is not activated! Check your code - maybe it's from another theme", 'trx_addons'), 'error');
						}
						if ( !empty($result['error']) && substr($result['error'], 0, 3) == '>>>') {
							wp_redirect(substr($result['error'], 3));
						}
					}
				}
			}
		}
	}
}

// Build Theme panel page
if (!function_exists('trx_addons_theme_panel_page_builder')) {
	function trx_addons_theme_panel_page_builder() {
		$tabs   = apply_filters('trx_addons_filter_theme_panel_tabs', array(
								'general'       => esc_html__( 'General', 'trx_addons' ),
								'plugins'       => esc_html__( 'Plugins', 'trx_addons' ),
								'recent_themes' => esc_html__( 'Recent Themes', 'trx_addons' ),
								));
		?>
		<div id="trx_addons_theme_panel" class="trx_addons_theme_panel">

			<?php do_action( 'trx_addons_action_theme_panel_start' ); ?>

			<div class="trx_addons_result">
				<?php
				$result = trx_addons_get_admin_message();
				if (!empty($result['error'])) {
					?><div class="error"><p><?php echo wp_kses_data($result['error']); ?></p></div><?php
				} else if (!empty($result['success'])) {
					?><div class="updated"><p><?php echo wp_kses_data($result['success']); ?></p></div><?php
				}
				?>
			</div>

			<?php do_action( 'trx_addons_action_theme_panel_before_tabs' ); ?>

			<div class="trx_addons_tabs trx_addons_tabs_theme_panel">
				<ul>
					<?php
					foreach($tabs as $tab_id => $tab_title) {
						?><li><a href="#trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>"><?php echo esc_html( $tab_title ); ?></a></li><?php
					}
					?>
				</ul>
				<?php
					$theme_info = trx_addons_get_theme_info();
					foreach($tabs as $tab_id => $tab_title) {
						do_action('trx_addons_action_theme_panel_section', $tab_id, $theme_info);
					}
				?>
			</div>

			<?php do_action( 'trx_addons_action_theme_panel_after_tabs' ); ?>

			<?php do_action( 'trx_addons_action_theme_panel_end' ); ?>

		</div>
		<?php		
	}
}


// Display 'General' section
if ( !function_exists( 'trx_addons_theme_panel_section_general' ) ) {
	add_action('trx_addons_action_theme_panel_section', 'trx_addons_theme_panel_section_general', 10, 2);
	function trx_addons_theme_panel_section_general($tab_id, $theme_info) {
		if ($tab_id !== 'general') return;
		$theme_status = trx_addons_get_theme_activated_status();
		?>
		<div id="trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>" class="trx_addons_tabs_section">

			<?php do_action('trx_addons_action_theme_panel_section_start', $tab_id, $theme_info); ?>

			<div class="trx_addons_theme_panel_theme_<?php echo esc_attr($theme_status); ?>">

				<?php do_action('trx_addons_action_theme_panel_before_section_title', $tab_id, $theme_info); ?>
	
				<h1 class="trx_addons_theme_panel_section_title">
					<?php
					echo esc_html(
						sprintf(
							// Translators: Add theme name and version to the 'Welcome' message
							__( 'Welcome to %1$s v.%2$s', 'trx_addons' ),
							$theme_info['theme_name'],
							$theme_info['theme_version']
						)
					);
					?>
					<span class="trx_addons_theme_panel_section_title_label_<?php echo esc_attr($theme_status); ?>"><?php
						if ($theme_status == 'active') {
							esc_html_e('Activated', 'trx_addons');
						} else {
							esc_html_e('Not activated', 'trx_addons');
						}
					?></span>
				</h1><?php

				do_action('trx_addons_action_theme_panel_after_section_title', $tab_id, $theme_info);

				if ($theme_status == 'active') {
					// Theme is active
					?><div class="trx_addons_theme_panel_section_description">
						<p><?php esc_html_e('Thank you for choosing our theme! In order to get started, you need to select a demo, install recommended plugins and import the demo data. You can do all these steps manually, or follow our setup wizard by clicking the "Start Setup" button below:', 'trx_addons'); ?></p>
					</div>
					<?php

				} else {
					// Theme is not active
					?><div class="trx_addons_theme_panel_section_description">
						<p><?php esc_html_e('Thank you for choosing our theme! Please activate your copy of the theme in order to get access to plugins, demo content, support and updates.', 'trx_addons'); ?></p>
					</div><?php
					do_action('trx_addons_action_theme_panel_activation_form', $tab_id, $theme_info);
				}

				do_action('trx_addons_action_theme_panel_after_section_description', $tab_id, $theme_info);

				if ($theme_status == 'active') {
					?><div class="trx_addons_theme_panel_buttons"><a href="#" class="trx_addons_theme_panel_next_step trx_addons_button trx_addons_button_accent"><?php esc_html_e('Start Setup', 'trx_addons'); ?></a></div><?php
				}

			?></div><?php

			// Attention! This is inline-blocks and no spaces allow
			if ($theme_status == 'active') {
				trx_addons_theme_panel_featured_item($tab_id, $theme_info);
			}

			// Footer icons
			?>
			<div class="trx_addons_theme_panel_footer">
				<?php
				if (count($theme_info['theme_actions']) > 0) {
					?>
					<div class="trx_addons_theme_panel_links trx_addons_theme_panel_links_iconed">
						<?php
						foreach ($theme_info['theme_actions'] as $action=>$item) {
							if ( empty( $item['button'] ) ) {
								continue;
							}
							?><div class="trx_addons_iconed_block"><div class="trx_addons_iconed_block_inner">
								<?php
								if (!empty($item['icon']) && strpos($item['icon'], '//') !== false) {
									$item['image'] = $item['icon'];
									$item['icon'] = '';
								}
								if (!empty($item['icon'])) {
									?><span class="trx_addons_iconed_block_icon <?php echo esc_attr($item['icon']); ?>"><?php
								} else if (!empty($item['image'])) {
									?><img src="<?php echo esc_attr($item['image']); ?>" class="trx_addons_iconed_block_image"><?php
								}
								?>
								<h2 class="trx_addons_iconed_block_title"><?php echo esc_html($item['title']); ?></h2>
								<div class="trx_addons_iconed_block_description">
									<?php echo esc_html($item['description']); ?>
								</div>
								<?php
								$links = array(
									array(
										'link' => $item['link'],
										'button' => $item['button']
									)
								);
								if ( strpos( $item['link'], 'customize.php' ) !== false && function_exists('menu_page_url') ) {
									$links[] = array(
										'link' => menu_page_url( 'theme_options', false ),
										'button' => esc_html__( 'Theme Options', 'trx_addons' )
									);
								}
								$cnt = 0;
								foreach( $links as $link ) {
									$cnt++;
									if ($cnt > 1) {
										?><span class="trx_addons_iconed_block_link_delimiter"></span><?php
									}
									?>
									<a href="<?php echo esc_url( $link['link'] ); ?>" class="trx_addons_iconed_block_link"<?php
										if (strpos($link['link'], home_url()) === false) {
											echo ' target="_blank"';
										}
									?>>
										<?php echo esc_html($link['button']); ?>
									</a>
									<?php
								}
								?>
							</div></div><?php
						}
					?>
					</div>
					<?php
				}
				?>
			</div>
			<?php

			do_action('trx_addons_action_theme_panel_section_end', $tab_id, $theme_info);

		?></div><?php
	}
}


// Display featured item (theme) from our server
if ( !function_exists( 'trx_addons_theme_panel_featured_item' ) ) {
	function trx_addons_theme_panel_featured_item($tab_id, $theme_info) {
		$banners = get_transient( 'trx_addons_welcome_banners' );
		$banners_url = trailingslashit( dirname( esc_url( trx_addons_get_protocol() . ':' . apply_filters( 'trx_addons_filter_get_theme_data', '', 'theme_demofiles_url' ) ) ) ) . '_welcome/';
		if ( ! $banners ) {
			$txt = trx_addons_fgc( $banners_url . 'welcome.json' );
			if (!empty($txt) && substr($txt, 0, 1) == '[') {
				$banners = json_decode($txt, true);
				if ( is_array($banners) && count($banners) > 0 ) {
					set_transient('trx_addons_welcome_banners', $banners, 4*60*60);		//Save for 4 hours
				}
			}
		}
		$html = '';
		if ( is_array($banners) && count($banners) > 0 ) {
			$html .= '<div class="trx_addons_theme_panel_banners">';
			foreach ($banners as $banner) {
				// Prepare links
				if (!empty($banner['image']) && strpos($banner['image'], '//') === false) {
					$banner['image'] = $banners_url . trim($banner['image']);
				}
				if (!empty($banner['icon']) && strpos($banner['icon'], '//') === false && strpos($banner['icon'], 'dashicons') === false && strpos($banner['icon'], 'trx_addons_icon') === false) {
					$banner['icon'] = $banners_url . trim($banner['icon']);
				}
				if (!empty($banner['url']) && substr($banner['url'], 0, 1) === '#') {
					$banner['url'] = apply_filters( 'trx_addons_filter_get_theme_data', '', substr($banner['url'], 1) );
				}
				if (!empty($banner['link_url']) && substr($banner['link_url'], 0, 1) === '#') {
					$banner['link_url'] = apply_filters( 'trx_addons_filter_get_theme_data', '', substr($banner['link_url'], 1) );
				}
				// Build banner's layout
				$html .= '<div class="trx_addons_theme_panel_banners_item' . ( count( $banners ) > 1 ? ' trx_banners_item' : '' ) . '"'
							. (!empty($banner['duration'])
								? ' data-duration="' . esc_attr(max(1000, min(60000, $banner['duration']*($banner['duration']<1000 ? 1000 : 1)))) . '"'
								: ''
							)
						. '>';
				// Title
				if (!empty($banner['title'])) {
					$html .= '<div class="trx_addons_theme_panel_banners_item_header">'
								. ( ! empty($banner['link_url'])
										? '<a class="trx_addons_theme_panel_banners_item_link" href="' . esc_url($banner['link_url']) . '" target="_blank">' . wp_kses_post($banner['link_text']) . '</a>'
										: ''
									)
								. ( ! empty($banner['icon'])
										? ( strpos( $banner['icon'], '//' ) !== false
											? '<span class="trx_addons_theme_panel_banners_item_icon with_image"><img src="' . esc_url($banner['icon']) . '"></span>'
											: '<span class="trx_addons_theme_panel_banners_item_icon ' . esc_attr($banner['icon']) . '"></span>'
											)
										: ''
									)
								. '<h2 class="trx_addons_theme_panel_banners_item_title">' . esc_html($banner['title']) . '</h2>'
							. '</div>';
				}
				// Image
				if (!empty($banner['image'])) {
					$html .= '<div class="trx_addons_theme_panel_banners_item_image">'
									. ( !empty($banner['url'])
										? '<a href="' . esc_url($banner['url']) . '" target="_blank">'
										: ''
										)
									. '<img src="' . esc_url($banner['image']) . '">'
									. ( !empty($banner['url'])
										? '<span class="trx_addons_theme_panel_banners_item_image_mask">' . ( ! empty($banner['url_text']) ? $banner['url_text'] : esc_html__( 'Live Preview', 'trx_addons' ) ) . '</span></a>'
										: ''
										)
								. '</div>';
				}
				$html .= '</div>';
			}
			$html .= '</div>';
		}
		if ( ! empty( $html ) ) {
			?><div class="trx_addons_theme_panel_featured_item">
				<?php trx_addons_show_layout( $html ); ?>
			</div><?php
		}
	}
}


// Display the theme activation form
if ( !function_exists( 'trx_addons_theme_panel_activation_form' ) ) {
	add_action('trx_addons_action_theme_panel_activation_form', 'trx_addons_theme_panel_activation_form');
	function trx_addons_theme_panel_activation_form() {
		?>
		<div class="trx_addons_theme_panel_section_form_wrap">
			<form action="<?php echo esc_url(get_admin_url(null, 'admin.php?page=trx_addons_theme_panel')); ?>" class="trx_addons_theme_panel_section_form" name="trx_addons_theme_panel_activate_form" method="post">
				<input type="hidden" name="trx_addons_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
				<h3 class="trx_addons_theme_panel_section_form_title"><?php esc_html_e('Activate Your Theme and Support Account', 'trx_addons'); ?></h3>
				<p class="trx_addons_theme_panel_section_form_description">
					<?php
					echo esc_html__( "Can't find the purchase code?", 'trx_addons' )
								. ' '
								. '<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">'
									. esc_html__('Follow this guide.', 'trx_addons')
								. '</a>';
					?>
				</p>
				<div class="trx_addons_columns_wrap">
					<div class="trx_addons_column-1_2">
						<div class="trx_addons_theme_panel_section_form_field trx_addons_theme_panel_section_form_field_text">
							<label>
								<span class="trx_addons_theme_panel_section_form_field_label"><?php esc_attr_e('Name:', 'trx_addons'); ?></span>
								<input type="text" name="trx_addons_user_name" placeholder="<?php esc_attr_e('Your name', 'trx_addons'); ?>">
							</label>
						</div>
					</div><div class="trx_addons_column-1_2">
						<div class="trx_addons_theme_panel_section_form_field trx_addons_theme_panel_section_form_field_text">
							<label>
								<span class="trx_addons_theme_panel_section_form_field_label"><?php esc_attr_e('E-mail:', 'trx_addons'); ?></span>
								<input type="text" name="trx_addons_user_email" placeholder="<?php esc_attr_e('Your e-mail', 'trx_addons'); ?>">
							</label>
						</div>
					</div><div class="trx_addons_column-1_1">
						<div class="trx_addons_theme_panel_section_form_field trx_addons_theme_panel_section_form_field_text">
							<label>
								<span class="trx_addons_theme_panel_section_form_field_label"><?php esc_attr_e('Purchase code', 'trx_addons'); ?> <sup class="required">*</sup></span>
								<input type="text" name="trx_addons_activate_theme_code" placeholder="<?php esc_attr_e('Purchase code (required)', 'trx_addons'); ?>">
							</label>
						</div>
						<div class="trx_addons_theme_panel_section_form_field trx_addons_theme_panel_section_form_field_checkbox">
							<label>
								<input type="checkbox" name="trx_addons_user_agree" value="1">
								<?php
									echo sprintf( wp_kses_post('Your data is stored and processed in accordance with our %s.', 'trx_addons'),
												'<a href="' . apply_filters('trx_addons_filter_privacy_url', '//themerex.net/privacy-policy/') . '" target="_blank">' . esc_html__('Privacy Policy', 'trx_addons') . '</a>');
								?>
							</label>
						</div>
						<div class="trx_addons_theme_panel_section_form_field trx_addons_theme_panel_section_form_field_submit">
							<input type="submit" class="trx_addons_button trx_addons_button_large trx_addons_button_accent" value="<?php esc_attr_e('Submit', 'trx_addons'); ?>">
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php
	}
}


// Display 'Plugins' section
if ( !function_exists( 'trx_addons_theme_panel_section_plugins' ) ) {
	add_action('trx_addons_action_theme_panel_section', 'trx_addons_theme_panel_section_plugins', 10, 2);
	function trx_addons_theme_panel_section_plugins($tab_id, $theme_info) {
		if ($tab_id !== 'plugins') return;
		?>
		<div id="trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>" class="trx_addons_tabs_section">
			
			<?php
			do_action('trx_addons_action_theme_panel_section_start', $tab_id, $theme_info);

			if ( trx_addons_is_theme_activated() ) {
				?>
				<div class="trx_addons_theme_panel_plugins_installer">

					<?php do_action('trx_addons_action_theme_panel_before_section_title', $tab_id, $theme_info); ?>
		
					<h1 class="trx_addons_theme_panel_section_title">
						<?php esc_html_e( 'Plugins', 'trx_addons' ); ?>
					</h1>

					<?php do_action('trx_addons_action_theme_panel_after_section_title', $tab_id, $theme_info); ?>

					<div class="trx_addons_info_box">
						<p><?php echo wp_kses_data( __( "Install and activate theme-related plugins. Select only those plugins that you're planning to use.", 'trx_addons' ) ); ?></p>
						<p><?php echo wp_kses_data( __( 'You can also install plugins via "Appearance - Install Plugins"', 'trx_addons' ) ); ?></p>
						<p class="trx_addons_theme_panel_section_info_notice"><b><?php esc_html_e('Attention!', 'trx_addons'); ?></b> <?php echo wp_kses_data( __( "Sometimes, the activation of some plugins interferes with the process of other plugins' installation. If a plugin is still on the 'Activating' stage after 1 minute, just reload the page (by pressing F5) and then switch to the 'Plugins' tab; there you should check the required plugins that remained uninstalled and proceed with the installation ('Install & Activate' button below the list of plugins)", 'trx_addons' ) ); ?></p>
					</div>

					<?php do_action('trx_addons_action_theme_panel_before_section_buttons', $tab_id, $theme_info); ?>

					<div class="trx_addons_theme_panel_plugins_buttons">
						<a href="#" class="trx_addons_theme_panel_plugins_button_select trx_addons_button trx_addons_button_small"><?php esc_html_e('Select all', 'trx_addons'); ?></a>
						<a href="#" class="trx_addons_theme_panel_plugins_button_deselect trx_addons_button trx_addons_button_small"><?php esc_html_e('Deselect all', 'trx_addons'); ?></a>
					</div><?php

					do_action('trx_addons_action_theme_panel_before_list_items', $tab_id, $theme_info);

					// List of plugins
					?>
					<div class="trx_addons_theme_panel_plugins_list"><?php
						if ( is_array( $theme_info['theme_plugins'] ) ) {
							foreach ($theme_info['theme_plugins'] as $plugin_slug => $plugin_data) {
								if (isset($plugin_data['install']) && $plugin_data['install'] === false) {
									continue;
								}
								$plugin_state = trx_addons_plugins_installer_check_plugin_state( $plugin_slug );
								// Uncomment next line if you want to hide already activated plugins
								//if ($plugin_state == 'deactivate') continue;
								$plugin_link = trx_addons_plugins_installer_get_link( $plugin_slug, $plugin_state );
								$plugin_image = !empty($plugin_data['logo'])
														? ( strpos($plugin_data['logo'], '//') !== false
															? $plugin_data['logo']
															: trailingslashit( get_template_directory_uri() ) . 'plugins/' . sanitize_file_name($plugin_slug) . '/' . $plugin_data['logo']
															)
														: trx_addons_get_no_image();
								?><div class="trx_addons_theme_panel_plugins_list_item<?php
									if ( !empty($plugin_data['required']) && $plugin_state != 'deactivate' ) echo ' trx_addons_theme_panel_plugins_list_item_checked';
								?>">
									<a href="<?php echo esc_url($plugin_link); ?>"
											class="trx_addons_theme_panel_plugins_list_item_link"
											data-slug="<?php echo esc_attr( $plugin_slug ); ?>"
											data-name="<?php echo esc_attr( $plugin_slug ); ?>"
											data-required="<?php echo !empty($plugin_data['required']) ? '1' : '0'; ?>"
											data-state="<?php echo esc_attr( $plugin_state ); ?>"
											data-activate-nonce="<?php echo esc_url(trx_addons_plugins_installer_get_link( $plugin_slug, 'activate' )); ?>"
											data-install-progress="<?php esc_attr_e( 'Installing ...', 'trx_addons' ); ?>"
											data-activate-progress="<?php esc_attr_e( 'Activating ...', 'trx_addons' ); ?>"
											data-activate-label="<?php esc_attr_e( 'Not activated', 'trx_addons' ); ?>"
											data-deactivate-label="<?php esc_attr_e( 'Active', 'trx_addons' ); ?>"
											tabindex="<?php echo 'deactivate' == $plugin_state ? '-1' : '0'; ?>"
									><?php
										// Check and state
										?><span class="trx_addons_theme_panel_plugins_list_item_status">
											<span class="trx_addons_theme_panel_plugins_list_item_check"></span>
											<span class="trx_addons_theme_panel_plugins_list_item_state"><?php
												if ($plugin_state == 'install') {
													esc_html_e('Not installed', 'trx_addons');
												} elseif ($plugin_state == 'activate') {
													esc_html_e('Not activated', 'trx_addons');
												} else {
													esc_html_e('Active', 'trx_addons');
												}
											?></span>
										</span><?php
										// Plugin's logo
										?><span class="trx_addons_theme_panel_plugins_list_item_image" style="background-image: url(<?php echo esc_url($plugin_image); ?>)"></span><?php
										// Plugin's title
										?><span class="trx_addons_theme_panel_plugins_list_item_title"><?php echo esc_html( $plugin_data['title'] ); ?></span>
									</a>
								</div><?php
							}
						}
					?></div>

					<?php do_action('trx_addons_action_theme_panel_after_list_items', $tab_id, $theme_info); ?>

					<div class="trx_addons_theme_panel_plugins_buttons">
						<a href="#" class="trx_addons_theme_panel_plugins_install trx_addons_button trx_addons_button_accent" disabled="disabled" data-need-reload="0"><?php
							esc_html_e('Install & Activate', 'trx_addons');
						?></a>
						<div class="trx_addons_percent_loader">
							<div class="trx_addons_percent_loader_bg"></div>
							<div class="trx_addons_percent_loader_value">0%</div>
						</div>						
					</div>
					
				</div>

				<?php
				do_action('trx_addons_action_theme_panel_after_section_data', $tab_id, $theme_info);

			} else {
				?>
				<div class="trx_addons_info_box trx_addons_info_box_warning"><p>
					<?php esc_html_e( 'Activate your theme in order to be able to install additional plugins.', 'trx_addons' ); ?>
				</p></div>
				<?php
			}
			
			do_action('trx_addons_action_theme_panel_section_end', $tab_id, $theme_info);
			?>
		</div>
		<?php
	}
}


// Display 'Recent Themes' section
if ( !function_exists( 'trx_addons_theme_panel_section_recent_themes' ) ) {
	add_action('trx_addons_action_theme_panel_section', 'trx_addons_theme_panel_section_recent_themes', 10, 2);
	function trx_addons_theme_panel_section_recent_themes($tab_id, $theme_info) {

		if ($tab_id !== 'recent_themes') return;

		?>
		<div id="trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>" class="trx_addons_tabs_section">
				
			<?php
			do_action('trx_addons_action_theme_panel_section_start', $tab_id, $theme_info);

			if ( true || trx_addons_is_theme_activated() ) {	// true - always display recent themes, not only if theme is activated
				?>
				<div class="trx_addons_theme_panel_recent_themes">

					<?php do_action('trx_addons_action_theme_panel_before_section_title', $tab_id, $theme_info); ?>
		
					<h1 class="trx_addons_theme_panel_section_title">
						<?php esc_html_e( 'Recent Themes', 'trx_addons' ); ?>
					</h1>

					<?php do_action('trx_addons_action_theme_panel_after_section_title', $tab_id, $theme_info); ?>

					<?php
					$cats   = trx_addons_theme_panel_get_recent_themes_categories();
					$wp_cat = 0;
					if ( is_array( $cats ) ) {
						// Leave only WordPress categories
						$inside = false;
						foreach ( $cats as $k => $v ) {
							if ( ! $inside ) {
								if ( strtolower( substr( $v, 0, 9 ) ) != 'wordpress' ) {
									unset( $cats[$k] );
								} else {
									$inside = true;
									$wp_cat = $k;
								}
							} else if ( substr( $v, 0, 1 ) != '-' ) {
								$inside = false;
								unset( $cats[$k] );
							}
						}
						// Display category selector
						if ( count( $cats ) > 0 ) {
							?><div class="trx_addons_theme_panel_section_recent_themes_category_selector">
								<label><?php esc_html_e( 'Filter by:', 'trx_addons' ); ?>
									<select size="1"><?php
										foreach ( $cats as $k => $v ) {
											?><option value="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $v ); ?></option><?php
										}
									?></select>
								</label>
							</div><?php
						}
					}
					?>

					<div class="trx_addons_theme_panel_section_description">
						<p><?php echo wp_kses_post(
										sprintf(
											__( "Explore our selection of freshest, straight out of the oven WordPress themes, or go ahead and %s.", 'trx_addons' ),
											'<a href="' . esc_url( trx_addons_get_protocol() . ':' . apply_filters( 'trx_addons_filter_get_theme_data', '', 'portfolio_url' ) ) . '" target="_blank" tabindex="0">' . esc_html__( 'view our portfolio', 'trx_addons' ) . '</a>'
											)
										); ?></p>
					</div>

					<?php
					do_action('trx_addons_action_theme_panel_before_list_items', $tab_id, $theme_info);

					// List of themes
					?>
					<div class="trx_addons_theme_panel_themes_list trx_addons_image_block_wrap"><?php
						trx_addons_theme_panel_show_recent_themes($tab_id, $theme_info, array(
							'category' => $wp_cat
						));
					?></div>

					<?php do_action('trx_addons_action_theme_panel_after_list_items', $tab_id, $theme_info); ?>
					
				</div>

				<?php
				do_action('trx_addons_action_theme_panel_after_section_data', $tab_id, $theme_info);

			} else {

				?>
				<div class="trx_addons_theme_panel_section_info trx_addons_info_box trx_addons_info_box_warning"><p>
					<?php esc_html_e( 'Activate your theme in order to be able to install theme-specific plugins.', 'trx_addons' ); ?>
				</p></div>
				<?php
			}
				
			do_action('trx_addons_action_theme_panel_section_end', $tab_id, $theme_info);
			?>
		</div>
		<?php
	}
}


// Add 'Load more' button after the recent themes list
if ( !function_exists( 'trx_addons_theme_panel_add_load_more' ) ) {
	add_action('trx_addons_action_theme_panel_after_list_items', 'trx_addons_theme_panel_add_load_more', 10, 2);
	function trx_addons_theme_panel_add_load_more($tab_id, $theme_info) {
		if ( $tab_id == 'recent_themes' ) {
			?>
			<a href="#" class="trx_addons_theme_panel_themes_list_load_more" tabindex="0" data-next-page="2">
				<span class="trx_addons_icon-spin3"></span>
				<?php esc_html_e( 'Load more', 'trx_addons' ); ?>
			</a>
			<?php
		}
	}
}


// Get recent themes via AJAX
if ( !function_exists( 'trx_addons_theme_panel_show_recent_themes_from_category' ) ) {
	add_action('wp_ajax_trx_addons_get_recent_themes', 'trx_addons_theme_panel_show_recent_themes_from_category');
	function trx_addons_theme_panel_show_recent_themes_from_category() {
		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) ) {
			die();
		}
		$response = array(
			'error' => '',
			'data' => '',
			'next_page' => 0
		);
		if ( empty( $_REQUEST['category'] ) || empty( $_REQUEST['page'] ) ) {
			$response['error'] = esc_html__( 'Please, specify the category and the page to get themes from!', 'trx_addons' );
		} else {
			ob_start();
			$response['next_page'] = trx_addons_theme_panel_show_recent_themes( 'recent_themes', array(), array(
				'category' => max( 0, (int) $_REQUEST['category'] ),
				'page' => max( 1, (int) $_REQUEST['page'] ),
			));
			$response['data'] = ob_get_contents();
			ob_end_clean();
			if ( empty($response['data']) ) {
				$response['error'] = esc_html__( 'Selected category is empty!', 'trx_addons' );				
			} else {
				$response['data'] = '<style>' . trx_addons_get_inline_css() . '</style>' . $response['data'];
			}
		}
		echo json_encode($response);
		die();
	}
}


// Display recent themes
if (!function_exists('trx_addons_theme_panel_show_recent_themes')) {
	function trx_addons_theme_panel_show_recent_themes($tab_id, $theme_info, $args=array()) {
		$args = apply_filters( 'trx_addons_filter_recent_themes_args',
					array_merge(
						array(
							'category' => 0,
							'count' => 9,
							'page' => 1
						),
						$args
					)
				);
		$themes = trx_addons_theme_panel_get_recent_themes( $args );
		$next_page = 0;
		if ( is_array( $themes ) ) {
			if ( count( $themes ) == $args['count'] ) {
				$next_page = $args['page'] + 1;
			}
			foreach ($themes as $theme_slug => $data) {
				// No spaces allowed between items (blocks)
				?><div class="trx_addons_image_block">
					<div class="trx_addons_image_block_inner" tabindex="0">
						<div class="trx_addons_image_block_image <?php
							echo trx_addons_add_inline_css_class( 'background-image: url(' . esc_url( $data['featured'] ) . ');' );
						 ?>">
						 	<?php
							// Link to demo site
							if ( ! empty( $data['demo_url'] ) ) {
								?>
								<a href="<?php echo esc_url( $data['demo_url'] ); ?>" class="trx_addons_image_block_link trx_addons_image_block_link_view_demo" target="_blank" tabindex="-1">
									<?php
									esc_html_e( 'Live Preview', 'basekit' );
									?>
								</a>
								<?php
							}
							?>
					 	</div>
					 	<div class="trx_addons_image_block_footer">
							<?php
							// Price
							if ( !empty($data['price']) ) {
								$tmp = explode( '&nbsp;', strip_tags( $data['price'] ) );
								$data['price'] = count( $tmp ) == 1 ? $tmp[0] : $tmp[1];
								$val = trx_addons_parse_num( $data['price'] );
								$cur = str_replace( $val, '', $data['price']);
								?>
								<span class="trx_addons_image_block_price">
									<span class="trx_addons_image_block_price_currency"><?php echo wp_kses_data($cur); ?></span>
									<span class="trx_addons_image_block_price_value"><?php echo wp_kses_data($val); ?></span>
								</span>
								<?php
							}
							// Title
							if ( ! empty( $data['title'] ) ) {
								if ( ! empty( $data['terms'] ) && is_array( $data['terms'] ) ) {
									$terms = '';
									foreach( $data['terms'] as $term ) {
										$terms .= '<span class="trx_addons_image_block_term">' . esc_html($term['name']) . '</span>';
									}
									if ( !empty($terms) ) {
										?><h6 class="trx_addons_image_block_terms"><?php trx_addons_show_layout( $terms ); ?></h6><?php
									}
								}
								?>
								<h5 class="trx_addons_image_block_title" title="<?php echo esc_attr( $data['title'] ); ?>">
									<?php echo esc_html( $data['title'] ); ?>
								</h5>
								<?php
							}
							// Link to demo site
							if ( ! empty( $data['demo_url'] ) ) {
								?>
								<a href="<?php echo esc_url( $data['demo_url'] ); ?>" class="trx_addons_image_block_link trx_addons_image_block_link_view_demo" target="_blank" tabindex="-1"></a>
								<?php
							}
							?>
						</div>
					</div>
				</div><?php // No spaces allowed after this <div>, because it is an inline-block element
			}
		}
		return $next_page;
	}
}


// Retrieve list of categories
if (!function_exists('trx_addons_theme_panel_get_recent_themes_categories')) {
	function trx_addons_theme_panel_get_recent_themes_categories() {
		$list = get_transient( 'trx_addons_recent_themes_categories' );
		if ( ! is_array( $list ) ) {
			$response = trx_addons_fgc( 'https://themerex.net/wp-json/trx_addons/v1/categories/list' );
			if ( !empty($response) && substr($response, 0, 2) == '{"' ) {
				$response = json_decode($response, true);
			}
			if ( !empty($response['list']) ) {
				$list = $response['list'];
			}
			if ( is_array( $list ) && count( $list ) > 0 ) {
				set_transient( 'trx_addons_recent_themes_categories', $list, 24 * 60 * 60 );       // Store to the cache for 24 hours
			}
		}
		return $list;
	}
}

// Retrieve list of themes
if (!function_exists('trx_addons_theme_panel_get_recent_themes')) {
	function trx_addons_theme_panel_get_recent_themes( $args ) {
		$list = get_transient( 'trx_addons_recent_themes' );
		$hash = $args['category'].'_'.$args['count'].'_'.$args['page'];
		if ( ! is_array( $list ) ) {
			$list = array();
		}
		if ( ! isset( $list[ $hash ] ) ) {
			$response = trx_addons_fgc( trx_addons_add_to_url( 'https://themerex.net/wp-json/trx_addons/v1/themes/list', $args ) );
			if ( ! empty( $response ) && substr( $response, 0, 2 ) == '{"' ) {
				$response = json_decode($response, true);
			}
			$list[ $hash ] = ! empty( $response['list'] ) ? $response['list'] : array();
			set_transient( 'trx_addons_recent_themes', $list, 24 * 60 * 60 );       // Store to the cache for 24 hours
		}
		return $list[ $hash ];
	}
}



// Delete cache with themes and categories on save options
if (!function_exists('trx_addons_theme_panel_recent_themes_delete_cache')) {
	add_action('trx_addons_action_just_save_options', 'trx_addons_theme_panel_recent_themes_delete_cache');
	function trx_addons_theme_panel_recent_themes_delete_cache( $options=array() ) {
		delete_transient('trx_addons_recent_themes_categories');
		delete_transient('trx_addons_recent_themes');
	}
}


// Display buttons after the section's data
if (!function_exists('trx_addons_theme_panel_after_section_data')) {
	add_action('trx_addons_action_theme_panel_after_section_data', 'trx_addons_theme_panel_after_section_data', 10, 2);
	function trx_addons_theme_panel_after_section_data($tab_id, $theme_info) {
		?>
		<div class="trx_addons_theme_panel_buttons">
			<a href="<?php
				if ( $tab_id == 'qsetup' )
					echo esc_url(admin_url());
				else
					echo '#';
			?>" class="trx_addons_theme_panel_next_step<?php if ( $tab_id == 'qsetup' ) { echo ' trx_addons_theme_panel_last_step trx_addons_button_accent'; } ?> trx_addons_button"><?php
				if ( $tab_id == 'qsetup' )
					esc_html_e('Finish', 'trx_addons');
				else
					esc_html_e('Skip Step', 'trx_addons');
			?></a>
			<a href="#" class="trx_addons_theme_panel_prev_step trx_addons_button"><?php
				esc_html_e('Go Back', 'trx_addons');
			?></a>
		</div>
		<?php
	}
}


// Include parts
//----------------------------------------------------

// Import demo data
if (!function_exists('trx_addons_theme_panel_load_impoter')) {
	add_action( 'after_setup_theme', 'trx_addons_theme_panel_load_impoter' );
	function trx_addons_theme_panel_load_impoter() {
		if (is_admin() && current_user_can('import') && file_exists(TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_IMPORTER . 'class.importer.php')) {
			require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_IMPORTER . 'class.importer.php';
			new trx_addons_demo_data_importer();
		}
	}
}

// Plugins installer
require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_INSTALLER . 'installer.php';
