<?php
/**
 * Template for displaying content of landing course
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="landing-2">
	<?php do_action( 'learn_press_before_content_landing' ); ?>

	<div class="main-course">
		<?php learn_press_get_template( 'single-course/thumbnail.php' ); ?>

		<?php learn_press_get_template( 'single-course/course-info.php' ); ?>

		<div class="course-landing-summary">
			<div class="content-landing-2">
				<?php do_action( 'learn_press_content_landing_summary' ); ?>

				<?php //thim_related_courses(); ?>
			</div>
		</div>
	</div>

	<div class="wrapper-info-bar sticky-sidebar">
		<?php learn_press_get_template( 'single-course/infobar.php' ); ?>
	</div>

</div>

<?php do_action( 'learn_press_after_content_landing' ); ?>
