<?php
/**
 * The style "default" of the Widget "LP Course info"
 *
 * @package ThemeREX Addons
 * @since v1.6.62
 */

if ( ! is_single() || get_post_type() != LP_COURSE_CPT || ! ( $course = LP_Global::course() ) || ! ( $user = LP_Global::user() ) ) {
	return false;
}

$trx_addons_args = get_query_var('trx_addons_args_widget_lp_course_info');
extract($trx_addons_args);

// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
				
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);

$remaining_time = $user ? $user->get_course_remaining_time( $course->get_id() ) : false;

// Course is not enrolled
if ( ! $user->has_purchased_course( $course->get_id() ) ) {

	// Price
	learn_press_get_template( 'single-course/price.php' );

	// Includes
	$includes = get_post_meta( get_the_ID(), '_lp_course_includes', true );

	if ( ! empty( $includes ) ) {

		do_action( 'learn-press/before-course-includes' );

		?><div class="course-includes"><?php
			trx_addons_show_layout( $includes );
		?></div><?php

		do_action( 'learn-press/after-course-includes' );

	}

	// Buttons
	learn_press_get_template( 'single-course/buttons.php' );

// Course is enrolled
} else {
	learn_press_get_template( 'single-course/progress.php' );	
	learn_press_course_remaining_time();
}

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
