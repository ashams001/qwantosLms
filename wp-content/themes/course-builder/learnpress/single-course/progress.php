<?php
/**
 * @author        ThimPress
 * @package       LearnPress/Templates
 * @version       2.1.6
 */

defined( 'ABSPATH' ) || exit();

$course = LP()->global['course'];
$user   = learn_press_get_current_user();
if ( ! $course ) {
	return;
}
$status = $user->get( 'course-status', $course->id );
if ( ( ! $status || $status == 'purchased' ) || ! $user->has_purchased_course( $course->id ) ) {
	return;
}
$force             = isset( $force ) ? $force : false;
$num_of_decimal    = 0;
$result            = $course->evaluate_course_results( null, $force );
$current           = absint( $result );
$passing_condition = round( $course->passing_condition, $num_of_decimal );
$passed            = $current >= $passing_condition;
$heading           = apply_filters( 'learn_press_course_progress_heading', $status == 'finished' ? esc_attr__( 'Your results', 'course-builder' ) : esc_attr__( 'Learning progress', 'course-builder' ) );
$course_items      = sizeof( $course->get_curriculum_items() );
$completed_items   = $course->count_completed_items();
$course_results    = $course->evaluate_course_results();


/**
 * Button continue
 * @author Khoapq
 */
$get_curriculum_items = $course->get_curriculum_items( array( 'field' => 'ID' ) );
$get_completed_items  = $course->get_completed_items();
$continue_curriculum  = array_diff( $get_curriculum_items, $get_completed_items );
if ( $continue_curriculum ) {
	$continue_id        = reset( $continue_curriculum );
	$continue_post_type = get_post_type( $continue_id );
	$item_link          = 'href="' . $course->get_item_link( $continue_id ) . '"';
}

?>

<div class="learn-press-course-results-progress">

	<?php if ( $continue_curriculum ) : ?>
		<button <?php learn_press_course_item_class( $continue_id ); ?> data-type="<?php echo esc_attr( $continue_post_type ); ?>">
			<a class="course-item-title button-load-item" target="_blank" <?php echo esc_attr( $item_link ); ?> data-id="<?php echo esc_attr( $continue_id ); ?>" data-complete-nonce="<?php echo wp_create_nonce( 'learn-press-complete-' . $continue_post_type . '-' . $continue_id ); ?>"><?php printf( __( 'Continue to lecture %d', 'course-builder' ), $completed_items + 1 ); ?></a>
		</button>
	<?php endif; ?>

	<?php
	if ( function_exists( 'thim_course_wishlist_button' ) ) {
		thim_course_wishlist_button( $course->id );
	}
	?>

	<div class="items-progress">
		<div class="lp-course-status">
			<?php if ( $grade = $user->get_course_grade( $course->id ) ) : ?>
				<span class="lp-grade <?php echo esc_attr( $grade ); ?>"> <?php learn_press_course_grade_html( $grade ); ?> </span>
			<?php endif; ?>
			(<span class="number"><?php printf( __( '%d of %d items', 'course-builder' ), $completed_items, $course_items ); ?></span>
			<span class="extra-text"><?php esc_html_e(' completed','course-builder') ?></span>)
		</div>
	</div>

	<div class="course-progress">
		<div class="lp-course-status">
			<span class="number"><?php echo $current; ?><span class="percentage-sign">%</span></span>
			<?php if ( $grade = $user->get_course_grade( $course->id ) ) { ?>
				<span class="grade <?php echo esc_attr( $grade ); ?>">
				<?php learn_press_course_grade_html( $grade ); ?>
				</span>
			<?php } ?>
		</div>

		<div class="lp-course-progress <?php echo esc_attr( $passed ? ' passed' : '' ); ?>" data-value="<?php echo esc_attr( $current ); ?>"
		     data-passing-condition="<?php echo esc_attr( $passing_condition ); ?>">
			<div class="lp-progress-bar">
				<div class="lp-progress-value" style="width: <?php echo esc_attr( $current ); ?>%;">
				</div>
			</div>
			<div class="lp-passing-conditional"
			     data-content="<?php printf( esc_html__( 'Passing condition: %s%%', 'course-builder' ), $passing_condition ); ?>"
			     style="left: <?php echo esc_attr( $passing_condition ); ?>%;">
			</div>
		</div>
	</div>
</div>