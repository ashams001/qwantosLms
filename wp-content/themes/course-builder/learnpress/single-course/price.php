<?php
/**
 * Template for displaying the price of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 2.1.4.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course = LP()->global['course'];

$is_buy_through_membership = false;
if ( class_exists( 'LP_Addon_PMPRO' ) ) {
	$is_buy_through_membership = LP()->settings->get( 'buy_through_membership' ) == 'yes' ? true : false;
}
$is_course_in_membership = (bool) get_post_meta( $course->ID, '_lp_pmpro_levels', false );

if ( learn_press_is_enrolled_course() || ( $is_buy_through_membership && $is_course_in_membership ) ) {
	return;
}

if ( $price = $course->get_price_html() ) {

	$origin_price = $course->get_origin_price_html();
	if ( $course->get_sale_price() !== ''/* $price != $origin_price */ ) {
		echo '<span class="course-origin-price">' . $origin_price . '</span>';
	}

	$free_course = ( $price === 'Free' ) ? ' free' : '';
	echo '<span class="course-price' . $free_course . '">' . $price . '</span>';
}
