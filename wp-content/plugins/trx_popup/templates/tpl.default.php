<?php
// Template: Default
$pre = trx_popup_is_timer_end() ? 'timer-' : '';

$title = trx_popup_get_option($pre .'title-text');
$subtitle = trx_popup_get_option($pre .'subtitle-text');
$subtitle_pos = trx_popup_get_option('subtitle-pos', 'below');

$descr = trx_popup_get_option($pre .'descr-text');
$descr = ( !empty($descr) ? do_shortcode($descr) : '' );

$button = trx_popup_get_option($pre .'button-text');
$button_url = trx_popup_get_option($pre .'button-url');

$position = trx_popup_get_option('position', 'topleft');

$delay = trx_popup_get_option('animation-delay');
$delay  = ( !empty($delay) ? $delay : '1' );

$cache = trx_popup_get_option('cache');
$cache = ( !empty($cache)  ? 'has-cache' : '' );

$refresh_interval = trx_popup_get_option('refresh-interval');
$refresh_interval = ( !empty($refresh_interval) && !empty($cache) ? $refresh_interval : '' );

$publish = trx_popup_get_option('publish');
$publish = ( !empty($publish)  ? 'publish' : '' );

if ( !empty($title) || !empty($subtitle) || !empty($descr) || (!empty($button) && !empty($button_url)) ) {
	echo 	'<div class="trx_popup' 
				. ( !empty($cache) ? ' '. esc_attr($cache) : '' ) 
				. ( !empty($publish) ? ' '. esc_attr($publish) : '' ) 
				. ( !empty($position) ? ' '. esc_attr($position) : '' ) 		
				. ' ' . apply_filters('trx_popup_filter_classes', '')
				. '"'
				. ( !empty($delay) ? ' data-delay="' . esc_attr($delay) . '"' : '' ) 
				. ( !empty($refresh_interval) ? ' data-refresh-interval="' . esc_attr($refresh_interval) . '"' : '' ) .'>
	            <div class="trx_popup_close"></div>
				<div class="trx_popup_container">
					<div class="trx_popup_inner">'
						. ( !empty($subtitle) && $subtitle_pos == 'above' ? '<h6 class="trx_popup_subtitle">' . $subtitle . '</h6>' : '' ) 
						. ( !empty($title) ? 	'<div class="trx_popup_title">' . $title . '</div>' : '' ) 
						. ( !empty($subtitle) && $subtitle_pos == 'below'  ? '<h6 class="trx_popup_subtitle">' . $subtitle . '</h6>' : '' ) 
						. ( !empty($descr) ? 	'<p class="trx_popup_descr">' . $descr . '</p>' : '' ) 
						. ( !empty($button) && !empty($button_url) ? '<a href="' . esc_url($button_url) . '" class="trx_popup_button ' . apply_filters('trx_popup_filter_button_class', 'sc_button') . '" target="_blank">' . esc_html($button) . '</a>' : '' ) .'
					</div>
				</div>
			</div>';
}
