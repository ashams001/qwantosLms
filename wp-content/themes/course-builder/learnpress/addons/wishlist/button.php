<?php
/**
 * Template for displaying button to toggle course wishlist on/off
 *
 * @author ThimPress
 */
defined( 'ABSPATH' ) || exit();
printf(
	'<button class="button learn-press-course-wishlist learn-press-course-wishlist-button-%2$d %s" data-id="%s" data-nonce="%s" title="%s" data-text="%s">%s</button>',
	join( " ", $classes ),
	$course_id,
	wp_create_nonce( 'course-toggle-wishlist' ),
	$title,
	__( 'Processing', 'course-builder' ),
	$state == 'on' ? esc_html__( 'Remove from Wishlist', 'course-builder' ) : esc_html__( 'Add to Wishlist', 'course-builder' )
);