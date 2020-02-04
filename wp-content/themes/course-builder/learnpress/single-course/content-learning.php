<?php
/**
 * Template for displaying content of learning course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$forum_id = get_post_meta( $course->ID, '_lp_course_forum', true );

$curriculum_heading = apply_filters( 'learn_press_curriculum_heading', 'Course Content' );
?>

<?php do_action( 'learn_press_before_content_learning' ); ?>


<div class="header-course">
	<div class="header-course-bg"></div>
	<div class="header-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<?php learn_press_get_template( 'single-course/thumbnail.php' ); ?>
				</div>
				<div class="col-md-6">
					<div class="header-info">
						<h1 class="course-title"><?php the_title(); ?></h1>
						<?php if ( get_the_excerpt() ) : ?>
							<p class="description">
								<?php echo wp_trim_words( get_the_excerpt(), 35 ); ?>
							</p>
						<?php endif; ?>
					</div>

					<?php learn_press_get_template( 'single-course/progress.php' ); ?>
					<?php if ( $forum_id && class_exists( 'bbPress' ) ): ?>
						<div class="forum-section">
							<span class="label"><?php esc_html_e( 'Visit Forum: ', 'course-builder' ); ?></span>
							<?php LP_Addon_BBPress_Course_Forum::instance()->forum_link(); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="course-learning-summary">
	<?php do_action( 'learn_press_content_learning_summary' ); ?>
</div>

<?php do_action( 'learn_press_after_content_learning' ); ?>
