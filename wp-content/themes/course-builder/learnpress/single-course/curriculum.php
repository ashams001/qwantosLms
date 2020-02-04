<?php
/**
 * Template for displaying the curriculum of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course  = LP()->global['course'];

$lessons = is_array( $course->get_lessons() ) ? sizeof( $course->get_lessons() ) : 0;
$quizzes = is_array( $course->get_quizzes() ) ? sizeof( $course->get_quizzes() ) : 0;

$course_duration_text = thim_duration_time_calculator( $course->ID, 'lp_course' );
$course_duration_meta = get_post_meta( $course->ID, '_lp_duration', true );
$course_duration      = explode( ' ', $course_duration_meta );

?>

<div class="course-curriculum" id="learn-press-course-curriculum">

	<?php if ( $curriculum = $course->get_curriculum() ): ?>

		<div class="info-course <?php if ( empty( $course_duration[0] ) && $course_duration[0] == '0' ) {
			echo 'hide-time';
		} ?>">
			<h2 class="course-curriculum-title"><?php esc_html_e( 'Course Curriculum', 'course-builder' ); ?></h2>

			<?php
			if ( $lessons || $quizzes ) {
				echo '<span class="total-lessons">' . esc_html__( 'Total learning: ', 'course-builder' );
				if ( $lessons ) {
					echo '<span class="text">' . sprintf( _n( '%d lesson', '%d lessons', $lessons, 'course-builder' ), $lessons ) . '</span>';
				}

				if ( $quizzes ) {
					echo '<span class="text">' . sprintf( _n( ' / %d quiz', ' / %d quizzes', $quizzes, 'course-builder' ), $quizzes ) . '</span>';
				}
				echo '</span>';
			}

			if ( ! empty( $course_duration[0] ) && $course_duration[0] != '0' ) { ?>
				<span class="total-time"><?php esc_html_e( 'Time: ', 'course-builder' ); ?>
					<span class="text"><?php echo( $course_duration_text ); ?></span></span>
			<?php } ?>

		</div>

		<?php do_action( 'learn_press_before_single_course_curriculum' ); ?>

		<ul class="curriculum-sections">
			<?php foreach ( $curriculum as $lessons ) : ?>
				<?php learn_press_get_template( 'single-course/loop-section.php', array( 'section' => $lessons ) ); ?>
			<?php endforeach; ?>
		</ul>

	<?php else: ?>
		<p class="curriculum-empty">
			<?php echo apply_filters( 'learn_press_course_curriculum_empty', esc_attr__( 'Curriculum is empty', 'course-builder' ) ); ?>
		</p>
	<?php endif; ?>

	<?php do_action( 'learn_press_after_single_course_curriculum' ); ?>
</div>