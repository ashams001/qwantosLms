<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course_id     = get_the_ID();
$course_review = learn_press_get_course_review( $course_id );
if ( $course_review['total'] ) {
	$reviews = $course_review['reviews'];
	?>
	<div id="course-reviews">
		<ul class="course-reviews-list">
			<?php foreach ( $reviews as $review ) { ?>
				<?php
				learn_press_course_review_template( 'loop-review.php', array( 'review' => $review ) );
				?>
			<?php }
			if ( empty( $course_review['finish'] ) ) { ?>
				<li class="loading"><i class="fa fa-spinner fa-spin"></i></li>
			<?php }
			?>
		</ul>
		<?php if ( empty( $course_review['finish'] ) ) { ?>
			<button class="button" id="course-review-load-more" data-paged="<?php echo esc_attr( $course_review['paged'] ); ?>"><?php echo esc_attr_e( 'Load More', 'course-builder' ); ?></button>
		<?php } ?>
	</div>
	<?php
} ?>
