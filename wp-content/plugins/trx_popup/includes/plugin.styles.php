<?php
// Custom css 
if ( !function_exists( 'trx_popup_custom_css' ) ) {
    function trx_popup_custom_css() {
		$image = trx_popup_get_option('image');
		$image =  is_numeric( $image ) && (int) $image > 0 ? wp_get_attachment_image_url( $image, 'full' ) : $image;
		$appearance = trx_popup_get_option('appearance', 'fadeIn');
		$disappearance = trx_popup_get_option('disappearance', 'fadeOut');
		$custom_css = trx_popup_get_option('custom-css');
		$trx_popup_css = '
.trx_popup {
	-webkit-animation-name: '. $appearance .'_popup;
	animation-name: '. $appearance .'_popup;
}
.trx_popup.close {
	-webkit-animation-name: '. $disappearance .'_popup;
	animation-name: '. $disappearance .'_popup;
}'
. ( !empty($image) ?
'body .trx_popup .trx_popup_container {
	background-image: url('. $image .');
}' : '') . '
/* Custom styles
*******************************/
' . $custom_css;
		return $trx_popup_css;
    }
}

