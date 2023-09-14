<?php
/**
 * Plugin support: LearnPress
 *
 * @package ThemeREX Addons
 * @since v1.6.62
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_learnpress' ) ) {
	function trx_addons_exists_learnpress() {
		return class_exists('LearnPress');
	}
}


// Change rewrite slug of internal courses to avoid conflicts with Learn Press
//----------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_learnpress_change_courses_slug' ) ) {
	add_filter('trx_addons_cpt_list', 'trx_addons_learnpress_change_courses_slug');
	function trx_addons_learnpress_change_courses_slug($list) {
		if ( ! empty($list['courses']['post_type_slug']) && $list['courses']['post_type_slug'] == 'courses' ) {
			$list['courses']['post_type_slug'] = 'cpt_courses';
		}
		return $list;
	}
}


// Additional meta fields to the course
//----------------------------------------------------------------------------

// Add video and additional info to the course meta box
if ( ! function_exists( 'trx_addons_learnpress_add_fields' ) ) {
	add_filter( 'learn_press_course_settings_meta_box_args', 'trx_addons_learnpress_add_fields' );
	function trx_addons_learnpress_add_fields( $meta_box ) {
		$meta_box['fields'][] = array(
			'name' => __( 'Intro video (local)', 'basekit' ),
			'desc' => __( 'Video-presentation of the course uploaded to your site.', 'learnpress' ),
			'id'   => '_lp_intro_video',
			'type' => 'video',
			'std'  => ''
		);
		$meta_box['fields'][] = array(
			'name' => __( 'Intro video (external)', 'basekit' ),
			'desc' => __( 'or specify url of the video-presentation from popular video hosting (like Youtube, Vimeo, etc.)', 'learnpress' ),
			'id'   => '_lp_intro_video_external',
			'type' => 'text',
			'std'  => ''
		);
		$meta_box['fields'][] = array(
			'name' => __( 'Includes', 'basekit' ),
			'desc' => __( 'List of includes of the course.', 'learnpress' ),
			'id'   => '_lp_course_includes',
			'type' => 'wysiwyg',
			'std'  => ''
		);
		return $meta_box;
	}
}


// Demo data install
//----------------------------------------------------------------------------

// One-click import support
if ( is_admin() ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_API . 'learnpress/learnpress-demo-importer.php';
}


// Widgets and shortcodes
//----------------------------------------------------------------------------
if ( ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_API . "learnpress/widget.course-info.php")) != '') { include_once $fdir; }
