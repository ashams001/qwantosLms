<?php
/**
 * @author        ThimPress
 * @package       LearnPress/Templates
 * @version       2.1.6
 */

defined( 'ABSPATH' ) || exit();

$user        = learn_press_get_current_user();
$course      = LP()->global['course'];
$course_item = $course->get_item( $item->ID );

$status      = $user->get_course_status( $course->id );
$item_status = $user->get_item_status( $item->ID );

$security = wp_create_nonce( sprintf( 'complete-item-%d-%d-%d', $user->id, $course->id, $item->ID ) );

$result     = $user->get_quiz_results( $item->ID );
$has_result = false;
if ( in_array( $item_status, array( 'completed', 'started' ) ) ) {
	$has_result = true;
}
?>
<div class="course-item-meta">
	<?php do_action( 'learn_press_before_item_meta', $item ); ?>
	<?php if ( $status != 'enrolled' && $item_status != 'completed' && $item_status != 'viewed' && $course_item->is_preview() && $course->is_required_enroll() ): ?>
		<span class="lp-label lp-label-preview"><?php esc_html_e( 'Preview', 'course-builder' ); ?></span>
	<?php endif; ?>
	<?php
	if ( $user->can_view_item( $item->ID, $course->id ) !== false ) {
		if ( $item->post_type == 'lp_quiz' ) {

			$passing_grade_type = get_post_meta( $item->ID, '_lp_passing_grade_type', true );
			if ( $result ) {
				$result_text = $passing_grade_type == 'point' ? sprintf( '%d/%d', $result->mark, $result->quiz_mark ) : $result->mark_percent . '%';
			} else {
				$result_text = '';
			}
			?>
			<span class="item-loop-meta-text item-result"><?php echo( $result_text ); ?></span>

			<?php
			if ( $course->is( 'final-quiz', $item->ID ) ) {
				?>
					<div class="wrap-label">
						<span class="lp-label item-loop-meta-text item-final"><?php esc_html_e( 'Final Quiz', 'course-builder' ); ?></span>
					</div>
				<?php
			}
			if ( $item_status == 'completed' ) {
				$grade = $user->get_quiz_graduation( $course_item->id, $course->id );
				if ( $grade === 'passed' ) {
					?>
						<span class="lp-icon item-status item-status-passed" title="<?php esc_attr_e( 'Passed', 'course-builder' ); ?>"></span>
					<?php
				} else {
					?>
						<span class="lp-icon item-status item-status-failed" title="<?php esc_attr_e( 'Failed', 'course-builder' ); ?>"></span>
					<?php
				}
			} elseif ( $item_status == 'viewed' ) {
				?>
					<span class="lp-icon item-status item-status-viewed" title="<?php esc_attr_e( 'Viewed', 'course-builder' ); ?>"></span>
				<?php
			} elseif ( $item_status == 'started' ) {
				?>
					<span class="lp-icon item-status item-status-started" title="<?php esc_attr_e( 'In Progress', 'course-builder' ); ?>"></span>
				<?php
			} else {
				echo '<span class="lp-icon item-status"></span>';
			}
		} else {
			if ( $item_status == 'completed' ) {
				?>
					<span class="lp-icon item-status item-status-completed" title="<?php esc_attr_e( 'Completed', 'course-builder' ); ?>"></span>
				<?php
			} elseif ( $item_status == 'started' ||  $item_status == 'viewed' ) {
			    ?>
					<div class="wrap-label">
						<span class="lp-label item-status-viewed"><?php esc_html_e( 'Viewed', 'course-builder' ); ?></span>
					</div>
					<span class="lp-icon item-status item-status-viewed"></span>
				<?php
			} else {
				echo '<span class="lp-icon item-status"></span>';
			}
		}
	}
	?>
	<?php do_action( 'learn_press_after_item_meta', $item ); ?>
</div>
