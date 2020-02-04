<?php
/**
 * Template for displaying message for course content protected.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/content-protected.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$thim_login_url = add_query_arg( 'redirect_to', get_the_permalink(), thim_get_login_page_url() );

?>

<div class="message message-error learn-press-message error">

    <span class="icon"></span>

	<?php
	if( $can_view_item && $can_view_item == 'not-enrolled' ){
		echo apply_filters( 'learn_press_content_item_protected_message',
			__( '<p>This content is protected, please enroll course to view this content!</p>', 'course-builder' ) );
		learn_press_course_enroll_button();
	} else{
		echo apply_filters( 'learn_press_content_item_protected_message',
			sprintf( __( 'This content is protected, please <a href="%s">login</a> and enroll course to view this content!', 'course-builder' ), $thim_login_url ) );

	}
	?>

</div>