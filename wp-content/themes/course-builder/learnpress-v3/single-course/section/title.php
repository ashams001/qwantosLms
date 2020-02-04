<?php
/**
 * Template for displaying title of section in single course.
 *
 * @author   ThimPress
 * @package  CourseBuilder/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user        = learn_press_get_current_user();
$course      = learn_press_get_the_course();
$user_course = $user->get_course_data( get_the_ID() );

if ( ! isset( $section ) ) {
	return;
}

$section_name   = $section->get_title();
$completed_item = $user_course->get_completed_items( '', false, $section->get_id() );
$total_item     = $section->count_items( '', false );
?>

<h4 class="section-header">
    <span class="collapse"></span>
	<?php echo esc_attr( $section_name ); ?>&nbsp;

	<?php if ( $section_description = $section->get_description() ) { ?>
		<span class="section-description"><?php echo esc_attr( $section_description ); ?></span>
	<?php } ?>

	<span class="meta">
        <span class="step<?php if ( $completed_item === $total_item ) {
	        echo ' section-completed';
        } ?>">
		<?php printf( __( '%d/%d', 'course-builder' ), $completed_item, $total_item ); ?></span>
    </span>

</h4>
