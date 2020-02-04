<?php
/**
 * Template for displaying content of landing course
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$curriculum_heading = apply_filters( 'learn_press_curriculum_heading', 'Course Curriculum' );
?>
<div class="landing-1">

	<?php learn_press_get_template( 'single-course/course-info.php' ); ?>

	<?php learn_press_get_template( 'single-course/thumbnail.php' ); ?>

	<?php do_action( 'learn_press_before_content_landing' ); ?>

	<div class="course-landing-summary">
		<div class="share sticky-sidebar">
			<?php thim_social_share( 'learnpress_single_' ); ?>
		</div>
		<div class="content-landing-1">
			<?php do_action( 'learn_press_content_landing_summary' ); ?>
		</div>
	</div>
</div>

<?php do_action( 'learn_press_after_content_landing' ); ?>
